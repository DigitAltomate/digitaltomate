<?php
/**
 * Module Name: Detect Bad Plugins
 * Description: Detect if a plugin you're using is known as vulnerable.
 * Main Module: plugins_themes
 * Author: SecuPress
 * Version: 1.0
 */

defined( 'SECUPRESS_VERSION' ) or die( 'Cheatin&#8217; uh?' );

add_action( 'after_plugin_row', 'secupress_detect_bad_plugins_after_plugin_row', 10, 3 );
/**
 * Add a red banner on each "bad" plugin on plugins page
 *
 * @since 1.0
 *
 * @param (string) $plugin_file Path to the plugin file.
 * @param (array)  $plugin_data Plufin data.
 * @param (string) $context     Context.
 */
function secupress_detect_bad_plugins_after_plugin_row( $plugin_file, $plugin_data, $context ) {
	if ( ( is_network_admin() || ! is_multisite() ) && ! current_user_can( 'update_plugins' ) && ! current_user_can( 'delete_plugins' ) && ! current_user_can( 'activate_plugins' ) ) { // Ie. Administrator.
		return;
	}

	$plugins = array(
		'vulns'      => secupress_get_vulnerable_plugins(),
		'removed'    => secupress_get_removed_plugins(),
		'notupdated' => secupress_get_notupdated_plugins(),
	);

	$plugin_name   = dirname( $plugin_file );
	$is_removed    = isset( $plugins['removed'][ $plugin_name ] );
	$is_notupdated = isset( $plugins['notupdated'][ $plugin_name ] );
	$is_vuln       = isset( $plugins['vulns'][ $plugin_name ] );
	$plugin_vuln   = $is_vuln ? $plugins['vulns'][ $plugin_name ] : false;

	if ( ! $is_removed && ! $is_vuln && ! $is_notupdated ) {
		return;
	}

	if ( $is_vuln && $plugin_vuln->fixed_in && version_compare( $plugin_data['Version'], $plugin_vuln->fixed_in ) >= 0 ) {
		return;
	}

	$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );
	$current       = get_site_transient( 'update_plugins' );
	$page          = get_query_var( 'paged' );
	$s             = isset( $_REQUEST['s'] ) ? esc_attr( stripslashes( $_REQUEST['s'] ) ) : '';
	$r             = isset( $current->response[ $plugin_file ] ) ? $current->response[ $plugin_file ] : null;
	// HTML output.
	?>
	<tr style="background-color: #f88;" class="sppc">
		<td colspan="<?php echo $wp_list_table->get_column_count(); ?>">
		<?php
		printf( '<em>' . __( 'SecuPress Information:', 'secupress-pro' ) . '</em> ' );

		if ( $is_vuln ) {
			$plugin_vuln->flaws = maybe_unserialize( $plugin_vuln->flaws );

			if ( 'UNKNOWN' !== $plugin_vuln->flaws[0] ) {
				printf(
					_n(
						'<strong>%1$s %2$s</strong> is known to contain this vulnerability: %3$s.',
						'<strong>%1$s %2$s</strong> is known to contain these vulnerabilities: %3$s.',
						count( $plugin_vuln->flaws ),
						'secupress-pro'
					),
					$plugin_data['Name'],
					$plugin_vuln->fixed_in ? sprintf( __( 'version %s (or lower)', 'secupress-pro' ), $plugin_vuln->fixed_in ) : __( 'all versions', 'secupress-pro' ),
					'<strong>' . esc_html( wp_sprintf( '%l', $plugin_vuln->flaws ) ) . '</strong>'
				);

				echo ' <a href="' . esc_url( $plugin_vuln->refs ) . '" target="_blank">' . __( 'More information', 'secupress-pro' ) . '</a>';
			} else {
				printf(
					__( '<strong>%1$s %2$s</strong> is known to contain a vulnerability. We don\'t have more information about it.', 'secupress-pro' ),
					$plugin_data['Name'],
					$plugin_vuln->fixed_in ? sprintf( __( 'version %s (or lower)', 'secupress-pro' ), $plugin_vuln->fixed_in ) : __( 'all versions', 'secupress-pro' )
				);
			}

			if ( ! empty( $plugin_vuln->fixed_in ) && current_user_can( 'update_plugins' ) ) {
				echo '<p>';

				if ( ! empty( $r->package ) ) {
					printf(
						'<span class="dashicons dashicons-update" aria-hidden="true"></span> ' . __( 'SecuPress invites you to <a href="%1$s">Update</a> this plugin to version %2$s.', 'secupress-pro' ),
						esc_url( wp_nonce_url( admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $plugin_file, 'upgrade-plugin_' . $plugin_file ) ),
						'<strong>' . esc_html( isset( $r->new_version ) ? $r->new_version : $plugin_vuln->fixed_in ) . '</strong>'
					);
				} elseif ( null !== $r ) { // To be tested ////.
					echo '<span class="dashicons dashicons-update" aria-hidden="true"></span> ' . __( 'SecuPress invites you to Update this plugin <em>(automatic update is unavailable for this plugin.)</em>.', 'secupress-pro' );
				} else {
					echo '<p><span class="dashicons dashicons-update" aria-hidden="true"></span> ' . __( 'Update is unavailable for this plugin.</em>.', 'secupress-pro' ) . '</p>';
				}

				echo '</p>';
			} else {
				echo '<p>';

				if ( is_plugin_active( $plugin_file ) && current_user_can( 'activate_plugins' ) ) {
					printf(
						'<span class="dashicons dashicons-admin-plugins" aria-hidden="true"></span> ' . __( 'SecuPress invites you to <a href="%s">deactivate</a> this plugin, then delete it.', 'secupress-pro' ),
						esc_url( wp_nonce_url( admin_url( 'plugins.php?action=deactivate&plugin=' . $plugin_file . '&plugin_status=' . $context . '&paged=' . $page . '&s=' . $s ), 'deactivate-plugin_' . $plugin_file ) )
					);
				}

				if ( ! is_plugin_active( $plugin_file ) && current_user_can( 'delete_plugins' ) ) {
					printf(
						'<span class="dashicons dashicons-trash" aria-hidden="true"></span> ' . __( 'SecuPress invites you to <a href="%s">delete</a> this plugin, no patch has been made by its author.', 'secupress-pro' ),
						esc_url( wp_nonce_url( admin_url( 'plugins.php?action=delete-selected&amp;checked[]=' . $plugin_file . '&amp;plugin_status=' . $context . '&amp;paged=' . $page . '&amp;s=' . $s ), 'bulk-plugins' ) )
					);
				}

				echo '</p>';
			}
		} elseif ( $is_notupdated ) {
			// Not updated.
			printf( __( '<strong>%s</strong> has not been updated on official repository for more than 2 years now. It can be dangerous.', 'secupress-pro' ), esc_html( $plugin_data['Name'] ) );
		} else {
			// Removed.
			printf( __( '<strong>%s</strong> has been removed from official repository for one of these reasons: Security Flaw, on Author\'s demand, Not GPL compatible, this plugin is under investigation.', 'secupress-pro' ), $plugin_data['Name'] );
		}

		if ( ! $is_vuln ) {
			echo '<p>';

			if ( is_plugin_active( $plugin_file ) && current_user_can( 'activate_plugins' ) ) {
				printf(
					'<span class="dashicons dashicons-admin-plugins" aria-hidden="true"></span> ' . __( 'SecuPress invites you to <a href="%s">deactivate</a> this plugin, then delete it.', 'secupress-pro' ),
					esc_url( wp_nonce_url( admin_url( 'plugins.php?action=deactivate&plugin=' . $plugin_file . '&plugin_status=' . $context . '&paged=' . $page . '&s=' . $s ), 'deactivate-plugin_' . $plugin_file ) )
				);
			}

			if ( ! is_plugin_active( $plugin_file ) && current_user_can( 'delete_plugins' ) ) {
				printf(
					'<span class="dashicons dashicons-trash" aria-hidden="true"></span> ' . __( 'SecuPress invites you to <a href="%s">delete</a> this plugin, no patch has been made by its author.', 'secupress-pro' ),
					esc_url( wp_nonce_url( admin_url( 'plugins.php?action=delete-selected&amp;checked[]=' . $plugin_file . '&amp;plugin_status=' . $context . '&amp;paged=' . $page . '&amp;s=' . $s ), 'bulk-plugins' ) )
				);
			}

			echo '</p>';
		}
		?>
		</td>
	</tr>
	<?php
}


add_action( 'admin_head', 'secupress_detect_bad_plugins_add_notices' );
/**
 * Add a notice if a plugin is considered as "bad"
 *
 * @since 1.0
 */
function secupress_detect_bad_plugins_add_notices() {
	global $pagenow;

	// Don't display the notice yet, next reload.
	if ( false === get_site_transient( 'secupress-detect-bad-plugins' ) || 'plugins.php' === $pagenow || ( is_network_admin() || ! is_multisite() ) && ! current_user_can( secupress_get_capability() ) ) {
		return;
	}

	$plugins = array(
		'vulns'      => secupress_get_vulnerable_plugins(),
		'removed'    => secupress_get_removed_plugins(),
		'notupdated' => secupress_get_notupdated_plugins(),
	);

	if ( $plugins['vulns'] || $plugins['removed'] || $plugins['notupdated'] ) {
		$counter = count( $plugins['vulns'] ) + count( $plugins['removed'] ) + count( $plugins['notupdated'] );
		$url     = esc_url( admin_url( 'plugins.php' ) );
		$message = sprintf(
			_n(
				'Your installation contains %1$s plugin considered as <em>bad</em>, check the details in <a href="%2$s">the plugins page</a>.',
				'Your installation contains %1$s plugins considered as <em>bad</em>, check the details in <a href="%2$s">the plugins page</a>.',
				$counter,
				'secupress-pro'
			),
			'<strong>' . $counter . '</strong>',
			$url
		);
		secupress_add_notice( $message, 'error', 'bad-plugins' );
	}
}
