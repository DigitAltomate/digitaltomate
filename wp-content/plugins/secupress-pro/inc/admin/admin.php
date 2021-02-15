<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/** --------------------------------------------------------------------------------------------- */
/** MAIN OPTION ================================================================================= */
/** ----------------------------------------------------------------------------------------------*/

add_filter( 'all_plugins', 'secupress_pro_white_label' );
/**
 * White Label the plugin, if you need to
 *
 * @since 1.0
 *
 * @param (array) $all_plugins An array of plugins to display in the list table.
 *
 * @return (array)
 */
function secupress_pro_white_label( $all_plugins ) {
	if ( ! secupress_is_white_label() ) {
		return $all_plugins;
	}

	// We change the plugin's header.
	$plugin = plugin_basename( SECUPRESS_FILE );

	if ( isset( $all_plugins[ $plugin ] ) && is_array( $all_plugins[ $plugin ] ) ) {
		$all_plugins[ $plugin ] = array_merge( $all_plugins[ $plugin ], array(
			// Escape is done in `_get_plugin_data_markup_translate()`.
			'Name'        => secupress_get_option( 'wl_plugin_name' ),
			'PluginURI'   => secupress_get_option( 'wl_plugin_URI' ),
			'Description' => secupress_get_option( 'wl_description' ),
			'Author'      => secupress_get_option( 'wl_author' ),
			'AuthorURI'   => secupress_get_option( 'wl_author_URI' ),
		) );
	}

	return $all_plugins;
}

// Remove the sidebar+ads when whitelabel is activated.
add_filter( 'secupress.no_sidebar', 'secupress_is_white_label' );
