<?php
namespace LiteSpeed;
defined( 'WPINC' ) || exit;

global $wp_roles;
if ( !isset( $wp_roles ) ) {
	$wp_roles = new \WP_Roles();
}

$roles = array();
foreach ( $wp_roles->roles as $k => $v ) {
	$roles[ $k ] = $v[ 'name' ];
}
ksort( $roles );

?>
<h3 class="litespeed-title-short">
	<?php echo __( 'Tuning Settings', 'litespeed-cache' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/pageopt/#tuning-settings-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table"><tbody>
	<tr>
		<th>
			<?php $id = Base::O_OPTM_CSS_EXC; ?>
			<?php $this->title( $id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $id ); ?>
			<div class="litespeed-desc">
				<?php echo __( 'Listed CSS files or inline CSS code will not be minified/combined.', 'litespeed-cache' ); ?>
				<?php Doc::full_or_partial_url(); ?>
				<?php Doc::one_per_line(); ?>
				<br /><font class="litespeed-success">
					<?php echo __( 'API', 'litespeed-cache' ); ?>:
					<?php echo sprintf( __( 'Filter %s is supported.', 'litespeed-cache' ), '<code>litespeed_optimize_css_excludes</code>' ); ?>
					<?php echo sprintf( __( 'Elements with attribute %s in html code will be excluded.', 'litespeed-cache' ), '<code>data-no-optimize="1"</code>' ); ?>
					<br /><?php echo __( 'Predefined list will also be combined w/ the above settings', 'litespeed-cache' ); ?>: <a href="https://github.com/litespeedtech/lscache_wp/blob/master/data/css_excludes.txt" target="_blank">https://github.com/litespeedtech/lscache_wp/blob/master/data/css_excludes.txt</a>
				</font>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $id = Base::O_OPTM_JS_EXC; ?>
			<?php $this->title( $id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $id ); ?>
			<div class="litespeed-desc">
				<?php echo __( 'Listed JS files or inline JS code will not be minified/combined.', 'litespeed-cache' ); ?>
				<?php Doc::full_or_partial_url(); ?>
				<?php Doc::one_per_line(); ?>
				<br /><font class="litespeed-success">
					<?php echo __( 'API', 'litespeed-cache' ); ?>:
					<?php echo sprintf( __( 'Filter %s is supported.', 'litespeed-cache' ), '<code>litespeed_optimize_js_excludes</code>' ); ?>
					<?php echo sprintf( __( 'Elements with attribute %s in html code will be excluded.', 'litespeed-cache' ), '<code>data-no-optimize="1"</code>' ); ?>
					<br /><?php echo __( 'Predefined list will also be combined w/ the above settings', 'litespeed-cache' ); ?>: <a href="https://github.com/litespeedtech/lscache_wp/blob/master/data/js_excludes.txt" target="_blank">https://github.com/litespeedtech/lscache_wp/blob/master/data/js_excludes.txt</a>
				</font>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $id = Base::O_OPTM_CCSS_CON; ?>
			<?php $this->title( $id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $id ); ?>
			<div class="litespeed-desc">
				<?php echo sprintf( __( 'Specify critical CSS rules for above-the-fold content when enabling %s.', 'litespeed-cache' ), __( 'Load CSS Asynchronously', 'litespeed-cache' ) ); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $id = Base::O_OPTM_JS_DEFER_EXC; ?>
			<?php $this->title( $id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $id ); ?>
			<div class="litespeed-desc">
				<?php echo __( 'Listed JS files or inline JS code will not be deferred.', 'litespeed-cache' ); ?>
				<?php Doc::full_or_partial_url(); ?>
				<?php Doc::one_per_line(); ?>
				<br /><span class="litespeed-success">
					<?php echo __( 'API', 'litespeed-cache' ); ?>:
					<?php echo sprintf( __( 'Filter %s is supported.', 'litespeed-cache' ), '<code>litespeed_optm_js_defer_exc</code>' ); ?>
					<?php echo sprintf( __( 'Elements with attribute %s in html code will be excluded.', 'litespeed-cache' ), '<code>data-no-defer="1"</code>' ); ?>
					<br /><?php echo __( 'Predefined list will also be combined w/ the above settings', 'litespeed-cache' ); ?>: <a href="https://github.com/litespeedtech/lscache_wp/blob/master/data/js_defer_excludes.txt" target="_blank">https://github.com/litespeedtech/lscache_wp/blob/master/data/js_defer_excludes.txt</a>
				</span>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $id = Base::O_OPTM_EXC; ?>
			<?php $this->title( $id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $id ); ?>
			<div class="litespeed-desc">
				<?php echo __( 'Prevent any optimization of listed pages.', 'litespeed-cache' ); ?>
				<?php $this->_uri_usage_example(); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $id = Base::O_OPTM_EXC_ROLES; ?>
			<?php $this->title( $id ); ?>
		</th>
		<td>
			<div class="litespeed-desc">
				<?php echo __( 'Selected roles will be excluded from all optimizations.', 'litespeed-cache' ); ?>
			</div>
			<div class="litespeed-tick-list">
				<?php foreach ( $roles as $role => $title ): ?>
					<?php $this->build_checkbox( $id . '[]', $title, $this->__cfg->in_optm_exc_roles( $role ), $role ); ?>
				<?php endforeach; ?>
			</div>

		</td>
	</tr>

</tbody></table>
