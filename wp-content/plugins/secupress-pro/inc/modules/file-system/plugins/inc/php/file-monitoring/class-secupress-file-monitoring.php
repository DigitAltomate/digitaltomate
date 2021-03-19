<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );


/**
 * File Monitoring class.
 *
 * @package SecuPress
 * @since 1.0
 */
class SecuPress_File_Monitoring extends SecuPress_Singleton {

	const VERSION = '1.0';

	/**
	 * Singleton The reference to *Singleton* instance of this class.
	 *
	 * @var (object)
	 */
	protected static $_instance;

	/**
	 * SecuPress_Background_Process_File_Monitoring instance.
	 *
	 * @var (object)
	 */
	protected $background_process;


	/** Public methods ========================================================================== */

	/**
	 * Add tasks to the queue and dispatch.
	 *
	 * @since 1.0
	 *
	 * @return (bool) True on success. False if it was already running.
	 */
	public function do_file_scan() {
		global $wp_version, $wp_local_package;

		if ( $this->is_monitoring_running() ) {
			return false;
		}

		// Cleanup previous batches.
		$this->stop_file_scan();

		$wp_core_files_hashes = get_site_option( SECUPRESS_WP_CORE_FILES_HASHES );

		if ( false === $wp_core_files_hashes || empty( $wp_core_files_hashes[ $wp_version ] ) ) {
			$this->background_process->push_to_queue( 'get_wp_hashes' );
		}

		if ( isset( $wp_local_package, $wp_core_files_hashes['locale'] ) && $wp_core_files_hashes['locale'] !== $wp_local_package ) {
			$fix_dists = get_site_option( SECUPRESS_FIX_DISTS );

			if ( false === $fix_dists || ! isset( $fix_dists[ $wp_version ] ) ) {
				$this->background_process->push_to_queue( 'fix_dists' );
			}
		}

		$this->background_process->push_to_queue( 'scan_full_tree' )->save()->dispatch();
		return true;
	}


	/**
	 * Remove everything from the queue.
	 *
	 * @since 1.0
	 */
	public function stop_file_scan() {
		$this->background_process->delete_queue();
	}


	/**
	 * Is process running.
	 * Check whether the current process is already running in a background process.
	 *
	 * @since 1.0
	 *
	 * @return (bool)
	 */
	public function is_monitoring_running() {
		return $this->background_process->is_monitoring_running();
	}


	/** Private methods ========================================================================= */

	/**
	 * Class init.
	 *
	 * @since 1.0
	 */
	protected function _init() {
		secupress_require_class_async();

		require_once( SECUPRESS_PRO_MODULES_PATH . 'file-system/plugins/inc/php/file-monitoring/class-secupress-background-process-file-monitoring.php' );

		$this->background_process = new SecuPress_Background_Process_File_Monitoring;
	}
}
