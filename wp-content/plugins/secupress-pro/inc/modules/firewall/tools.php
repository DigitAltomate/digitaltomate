<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

add_filter( 'http_request_args', 'secupress_bypass_limit', 10, 2 );
/**
 * Used to bypass the limitation download since on shared host, multiple sites could share the same IP, we fake one.
 *
 * @param (array)  $r HTTP requests arguments.
 * @param (string) $url The requested URL.
 * @return (array) $r HTTP requests arguments
 * @since 1.4.6
 * @author Julio potier
 **/
function secupress_bypass_limit( $r, $url ) {
	if ( strpos( $url, 'http://software77.net/geo-ip/?DL=' ) === 0 ) {
		$r['headers']['X-Forwarded-For'] = long2ip( rand( 0, PHP_INT_MAX ) );
	}
	return $r;
}

/**
 * Update the 2 files for GeoIP database on demand
 *
 * @since 1.4.9
 * @author Julio Potier
 **/
function secupress_geoips_update_datafiles() {
	secupress_geoips_update_datafile( 'v4' );
	secupress_geoips_update_datafile( 'v6' );
}

/**
 * Update a v4/v6 file for the GeoIP database on demand
 *
 * @return (bool) True if new file has been updated
 * @since 1.4.9 $type param, see secupress_geoips_update_datafiles()
 * @since 1.4.6
 * @author Julio Potier
 * @param $type (string) Have to be 'v4' or 'v6'
 **/
function secupress_geoips_update_datafile( $type ) {

	$downloads = secupress_geoips_get_downloads();
	if ( ! isset( $downloads[ $type ] ) ) {
		return false;
	}
	$type_id   = $downloads[ $type ]['id'];
	$type_file = $downloads[ $type ]['file'];

	// SecuPress is actually donating to this site/service each month to permit the usage in the Pro version.
	if ( ! function_exists( 'download_url' ) ) {
		require( ABSPATH . 'wp-admin/includes/file.php' );
	}
	$zip = download_url( 'http://software77.net/geo-ip/?DL=' . $type_id );
	if ( is_wp_error( $zip ) ) {
		secupress_add_transient_notice( sprintf( __( 'GeoIP database has not been updated: %s', 'secupress-pro' ), __( 'Download Error', 'secupress-pro' ) ) );
		return false;
	}
	WP_Filesystem();
	$destination      = wp_upload_dir();
	$destination_path = $destination['path'];
	$unzipfile        = true;
	switch ( $type ) {
		case 'v4':
			$unzipfile = unzip_file( $zip, $destination_path );
		break;

		case 'v6':
			// https://stackoverflow.com/questions/3293121/how-can-i-unzip-a-gz-file-with-php

			// Raising this value may increase performance
			$buffer_size   = 1024*8; // read 8kb at a time
			$out_file_name = str_replace( '.tmp', '', $zip );

			// Open our files (in binary mode)
			$file     = gzopen( $zip, 'rb' );
			$out_file = fopen( $destination_path . '/' . $type_file, 'wb' );

			// Keep repeating until the end of the input file
			while ( ! gzeof( $file ) ) {
			    // Read buffer-size bytes
			    // Both fwrite and gzread and binary-safe
			    fwrite( $out_file, gzread( $file, $buffer_size ) );
			}

			// Files are done, close files
			fclose( $out_file );
			gzclose( $file );
		break;

		default: return false;
	}
	@unlink( $zip );
	if ( is_wp_error( $unzipfile ) ) {
		secupress_add_transient_notice( sprintf( __( 'GeoIP database has not been updated: %s', 'secupress-pro' ), __( 'Unzip Error.', 'secupress-pro' ) ) );
		return false;
	}
	if ( ! file_exists( $destination_path . $type_file ) ) {
		secupress_add_transient_notice( sprintf( __( 'GeoIP database has not been updated: %s', 'secupress-pro' ), __( 'Missing File.', 'secupress-pro' ) ) );
		return false;
	}
	$lines   = file( $destination_path . $type_file );
	@unlink( $destination_path . $type_file );
	$content = secupress_geoips_parse_file( $lines, $type_file );
	@unlink( SECUPRESS_PRO_INC_PATH . 'data/geoips' . $type . '.data' );
	file_put_contents( SECUPRESS_PRO_INC_PATH . 'data/geoips' . $type . '.data', $content );
	return true;
}

/**
 * Parse files content from software77.net
 *
 * @since 1.4.9
 * @author Julio Potier
 *
 * @param (array) $lines Each line contains the IP info
 * @param (string) $type_file Contains the filename, depeding on that, the parsing is different
 * @return
 **/
function secupress_geoips_parse_file( $lines, $type_file ) {
	$content = '';
	switch ( $type_file ) {
		case '/IpToCountry.csv':
			foreach ( $lines as $line ) {
				if ( '#' === $line[0] ) {
					continue;
				}
				$parts    = explode( ',', $line );
				$begin    = $parts[0];
				$code     = $parts[4];
				$content .= "$begin,$code\n";
			}
			break;

		case '/IpToCountry.6R.csv':
			foreach ( $lines as $line ) {
				if ( '#' === $line[0] ) {
					continue;
				}
				$parts    = explode( ',', $line );
				$temp     = explode( '::-', $parts[0] );
				$begin    = '"' . secupress_ipv6_numeric( $temp[0] . str_repeat( ':ffff', 7 - substr_count( $temp[0], ':' ) ) ) . '"';
				$code     = ! empty( trim( $parts[1] ) ) ? '"' . $parts[1] . '"' : '"KO"';
				$content .= "$begin,$code\n";
			}
			break;
	}
	return $content;
}

/**
 * Update the database GeoIPs content with the given $queries
 *
 * @param (string) $queries SQL queries to be updated.
 * @since 1.4.6
 * @author Julio Potier
 **/
function secupress_geoips_update_database( $queries ) {
	global $wpdb;

	$queries = explode( "\n", $queries );
	$queries = array_chunk( $queries, 1000 );
	foreach ( $queries as $query ) {
		array_pop( $query );
		$query = rtrim( rtrim( implode( "),\n(", $query ) ), ',' );
		$wpdb->query( "INSERT INTO {$wpdb->prefix}secupress_geoips (begin_ip, country_code) VALUES ($query)" ); // WPCS: unprepared SQL ok.
	}
}

/**
 * Update the file + database
 *
 * @return (bool) Bool if ok
 * @since 1.4.6
 * @author Julio Potier
 **/
function secupress_geoips_update_datas() {
	global $wpdb;
	$wpdb->query( "TRUNCATE TABLE {$wpdb->prefix}secupress_geoips" );

	$result = secupress_geoips_update_data( 'v4' );
	$result = $result && secupress_geoips_update_data( 'v6' );

	secupress_set_option( 'geoips_last_update', date_i18n( get_option( 'date_format', time() ) ) );

	return $result;
}

/**
 * Update the file + database
 *
 * @return (bool) Bool if ok
 * @since 1.4.6
 * @author Julio Potier
 **/
function secupress_geoips_update_data( $type ) {
	$downloads = secupress_geoips_get_downloads();
	if ( ! isset( $downloads[ $type ] ) ) {
		return false;
	}
	secupress_geoips_update_datafile( $type );
	$filename = SECUPRESS_PRO_INC_PATH . 'data/geoips' . $type . '.data';
	$queries  = file_exists( $filename ) ? file_get_contents( $filename ) : false;
	@unlink( $filename );
	if ( $queries ) {
		secupress_geoips_update_database( $queries );
		return true;
	}
	return false;
}

/**
 * Declare the ID and filename from software77.net
 *
 * @since 1.4.9
 * @author Julio Potier
 *
 * @return (array) The files needed to get the ipv4 and ipv6 content
 **/
function secupress_geoips_get_downloads() {
	return [ 'v4' => [ 'id' => 2, 'file' => '/IpToCountry.csv' ], 'v6' => [ 'id' => 7, 'file' => '/IpToCountry.6R.csv' ] ];
}
