<?php
/**
 * Prohibit direct script loading.
 *
 * @package Convert_Plus.
 */

// Add new input type "geo_target".
if ( function_exists( 'smile_add_input_type' ) ) {
	smile_add_input_type( 'geo_target', 'geo_target_settings_field' );
}

/**
 * Function Name:geo_target_settings_field Function to handle new input type "geo_target".
 *
 * @param  string $name     settings provided when using the input type "geo_target".
 * @param  string $settings holds the default / updated value.
 * @param  string $value    html output generated by the function.
 * @return string           html output generated by the function.
 */
function geo_target_settings_field( $name, $settings, $value ) {
	$input_name = $name;
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$class      = isset( $settings['class'] ) ? $settings['class'] : '';
	ob_start();
	?>
	<select name="<?php echo esc_attr( $input_name ); ?>" id="smile_<?php echo esc_attr( $input_name ); ?>" class="select2-geo_target-dropdown form-control smile-input <?php echo esc_attr( 'smile-' . $type . ' ' . $input_name . ' ' . $type . ' ' . $class ); ?>" multiple="multiple" style="width:260px;">
		<?php
		$selected = '';
		$val_arr  = explode( ',', $value );

		$geo_target = array(
			'AF' => __( 'Afghanistan', 'smile' ),
			'AX' => __( '&#197;land Islands', 'smile' ),
			'AL' => __( 'Albania', 'smile' ),
			'DZ' => __( 'Algeria', 'smile' ),
			'AS' => __( 'American Samoa', 'smile' ),
			'AD' => __( 'Andorra', 'smile' ),
			'AO' => __( 'Angola', 'smile' ),
			'AI' => __( 'Anguilla', 'smile' ),
			'AQ' => __( 'Antarctica', 'smile' ),
			'AG' => __( 'Antigua and Barbuda', 'smile' ),
			'AR' => __( 'Argentina', 'smile' ),
			'AM' => __( 'Armenia', 'smile' ),
			'AW' => __( 'Aruba', 'smile' ),
			'AU' => __( 'Australia', 'smile' ),
			'AT' => __( 'Austria', 'smile' ),
			'AZ' => __( 'Azerbaijan', 'smile' ),
			'BS' => __( 'Bahamas', 'smile' ),
			'BH' => __( 'Bahrain', 'smile' ),
			'BD' => __( 'Bangladesh', 'smile' ),
			'BB' => __( 'Barbados', 'smile' ),
			'BY' => __( 'Belarus', 'smile' ),
			'BE' => __( 'Belgium', 'smile' ),
			'PW' => __( 'Belau', 'smile' ),
			'BZ' => __( 'Belize', 'smile' ),
			'BJ' => __( 'Benin', 'smile' ),
			'BM' => __( 'Bermuda', 'smile' ),
			'BT' => __( 'Bhutan', 'smile' ),
			'BO' => __( 'Bolivia', 'smile' ),
			'BQ' => __( 'Bonaire, Saint Eustatius and Saba', 'smile' ),
			'BA' => __( 'Bosnia and Herzegovina', 'smile' ),
			'BW' => __( 'Botswana', 'smile' ),
			'BV' => __( 'Bouvet Island', 'smile' ),
			'BR' => __( 'Brazil', 'smile' ),
			'IO' => __( 'British Indian Ocean Territory', 'smile' ),
			'VG' => __( 'British Virgin Islands', 'smile' ),
			'BN' => __( 'Brunei', 'smile' ),
			'BG' => __( 'Bulgaria', 'smile' ),
			'BF' => __( 'Burkina Faso', 'smile' ),
			'BI' => __( 'Burundi', 'smile' ),
			'KH' => __( 'Cambodia', 'smile' ),
			'CM' => __( 'Cameroon', 'smile' ),
			'CA' => __( 'Canada', 'smile' ),
			'CV' => __( 'Cape Verde', 'smile' ),
			'KY' => __( 'Cayman Islands', 'smile' ),
			'CF' => __( 'Central African Republic', 'smile' ),
			'TD' => __( 'Chad', 'smile' ),
			'CL' => __( 'Chile', 'smile' ),
			'CN' => __( 'China', 'smile' ),
			'CX' => __( 'Christmas Island', 'smile' ),
			'CC' => __( 'Cocos (Keeling) Islands', 'smile' ),
			'CO' => __( 'Colombia', 'smile' ),
			'KM' => __( 'Comoros', 'smile' ),
			'CG' => __( 'Congo (Brazzaville)', 'smile' ),
			'CD' => __( 'Congo (Kinshasa)', 'smile' ),
			'CK' => __( 'Cook Islands', 'smile' ),
			'CR' => __( 'Costa Rica', 'smile' ),
			'HR' => __( 'Croatia', 'smile' ),
			'CU' => __( 'Cuba', 'smile' ),
			'CW' => __( 'Cura&ccedil;ao', 'smile' ),
			'CY' => __( 'Cyprus', 'smile' ),
			'CZ' => __( 'Czech Republic', 'smile' ),
			'DK' => __( 'Denmark', 'smile' ),
			'DJ' => __( 'Djibouti', 'smile' ),
			'DM' => __( 'Dominica', 'smile' ),
			'DO' => __( 'Dominican Republic', 'smile' ),
			'EC' => __( 'Ecuador', 'smile' ),
			'EG' => __( 'Egypt', 'smile' ),
			'SV' => __( 'El Salvador', 'smile' ),
			'GQ' => __( 'Equatorial Guinea', 'smile' ),
			'ER' => __( 'Eritrea', 'smile' ),
			'EE' => __( 'Estonia', 'smile' ),
			'ET' => __( 'Ethiopia', 'smile' ),
			'FK' => __( 'Falkland Islands', 'smile' ),
			'FO' => __( 'Faroe Islands', 'smile' ),
			'FJ' => __( 'Fiji', 'smile' ),
			'FI' => __( 'Finland', 'smile' ),
			'FR' => __( 'France', 'smile' ),
			'GF' => __( 'French Guiana', 'smile' ),
			'PF' => __( 'French Polynesia', 'smile' ),
			'TF' => __( 'French Southern Territories', 'smile' ),
			'GA' => __( 'Gabon', 'smile' ),
			'GM' => __( 'Gambia', 'smile' ),
			'GE' => __( 'Georgia', 'smile' ),
			'DE' => __( 'Germany', 'smile' ),
			'GH' => __( 'Ghana', 'smile' ),
			'GI' => __( 'Gibraltar', 'smile' ),
			'GR' => __( 'Greece', 'smile' ),
			'GL' => __( 'Greenland', 'smile' ),
			'GD' => __( 'Grenada', 'smile' ),
			'GP' => __( 'Guadeloupe', 'smile' ),
			'GU' => __( 'Guam', 'smile' ),
			'GT' => __( 'Guatemala', 'smile' ),
			'GG' => __( 'Guernsey', 'smile' ),
			'GN' => __( 'Guinea', 'smile' ),
			'GW' => __( 'Guinea-Bissau', 'smile' ),
			'GY' => __( 'Guyana', 'smile' ),
			'HT' => __( 'Haiti', 'smile' ),
			'HM' => __( 'Heard Island and McDonald Islands', 'smile' ),
			'HN' => __( 'Honduras', 'smile' ),
			'HK' => __( 'Hong Kong', 'smile' ),
			'HU' => __( 'Hungary', 'smile' ),
			'IS' => __( 'Iceland', 'smile' ),
			'IN' => __( 'India', 'smile' ),
			'ID' => __( 'Indonesia', 'smile' ),
			'IR' => __( 'Iran', 'smile' ),
			'IQ' => __( 'Iraq', 'smile' ),
			'IE' => __( 'Ireland', 'smile' ),
			'IM' => __( 'Isle of Man', 'smile' ),
			'IL' => __( 'Israel', 'smile' ),
			'IT' => __( 'Italy', 'smile' ),
			'CI' => __( 'Ivory Coast', 'smile' ),
			'JM' => __( 'Jamaica', 'smile' ),
			'JP' => __( 'Japan', 'smile' ),
			'JE' => __( 'Jersey', 'smile' ),
			'JO' => __( 'Jordan', 'smile' ),
			'KZ' => __( 'Kazakhstan', 'smile' ),
			'KE' => __( 'Kenya', 'smile' ),
			'KI' => __( 'Kiribati', 'smile' ),
			'KW' => __( 'Kuwait', 'smile' ),
			'KG' => __( 'Kyrgyzstan', 'smile' ),
			'LA' => __( 'Laos', 'smile' ),
			'LV' => __( 'Latvia', 'smile' ),
			'LB' => __( 'Lebanon', 'smile' ),
			'LS' => __( 'Lesotho', 'smile' ),
			'LR' => __( 'Liberia', 'smile' ),
			'LY' => __( 'Libya', 'smile' ),
			'LI' => __( 'Liechtenstein', 'smile' ),
			'LT' => __( 'Lithuania', 'smile' ),
			'LU' => __( 'Luxembourg', 'smile' ),
			'MO' => __( 'Macao S.A.R., China', 'smile' ),
			'MK' => __( 'Macedonia', 'smile' ),
			'MG' => __( 'Madagascar', 'smile' ),
			'MW' => __( 'Malawi', 'smile' ),
			'MY' => __( 'Malaysia', 'smile' ),
			'MV' => __( 'Maldives', 'smile' ),
			'ML' => __( 'Mali', 'smile' ),
			'MT' => __( 'Malta', 'smile' ),
			'MH' => __( 'Marshall Islands', 'smile' ),
			'MQ' => __( 'Martinique', 'smile' ),
			'MR' => __( 'Mauritania', 'smile' ),
			'MU' => __( 'Mauritius', 'smile' ),
			'YT' => __( 'Mayotte', 'smile' ),
			'MX' => __( 'Mexico', 'smile' ),
			'FM' => __( 'Micronesia', 'smile' ),
			'MD' => __( 'Moldova', 'smile' ),
			'MC' => __( 'Monaco', 'smile' ),
			'MN' => __( 'Mongolia', 'smile' ),
			'ME' => __( 'Montenegro', 'smile' ),
			'MS' => __( 'Montserrat', 'smile' ),
			'MA' => __( 'Morocco', 'smile' ),
			'MZ' => __( 'Mozambique', 'smile' ),
			'MM' => __( 'Myanmar', 'smile' ),
			'NA' => __( 'Namibia', 'smile' ),
			'NR' => __( 'Nauru', 'smile' ),
			'NP' => __( 'Nepal', 'smile' ),
			'NL' => __( 'Netherlands', 'smile' ),
			'NC' => __( 'New Caledonia', 'smile' ),
			'NZ' => __( 'New Zealand', 'smile' ),
			'NI' => __( 'Nicaragua', 'smile' ),
			'NE' => __( 'Niger', 'smile' ),
			'NG' => __( 'Nigeria', 'smile' ),
			'NU' => __( 'Niue', 'smile' ),
			'NF' => __( 'Norfolk Island', 'smile' ),
			'MP' => __( 'Northern Mariana Islands', 'smile' ),
			'KP' => __( 'North Korea', 'smile' ),
			'NO' => __( 'Norway', 'smile' ),
			'OM' => __( 'Oman', 'smile' ),
			'PK' => __( 'Pakistan', 'smile' ),
			'PS' => __( 'Palestinian Territory', 'smile' ),
			'PA' => __( 'Panama', 'smile' ),
			'PG' => __( 'Papua New Guinea', 'smile' ),
			'PY' => __( 'Paraguay', 'smile' ),
			'PE' => __( 'Peru', 'smile' ),
			'PH' => __( 'Philippines', 'smile' ),
			'PN' => __( 'Pitcairn', 'smile' ),
			'PL' => __( 'Poland', 'smile' ),
			'PT' => __( 'Portugal', 'smile' ),
			'PR' => __( 'Puerto Rico', 'smile' ),
			'QA' => __( 'Qatar', 'smile' ),
			'RE' => __( 'Reunion', 'smile' ),
			'RO' => __( 'Romania', 'smile' ),
			'RU' => __( 'Russia', 'smile' ),
			'RW' => __( 'Rwanda', 'smile' ),
			'BL' => __( 'Saint Barth&eacute;lemy', 'smile' ),
			'SH' => __( 'Saint Helena', 'smile' ),
			'KN' => __( 'Saint Kitts and Nevis', 'smile' ),
			'LC' => __( 'Saint Lucia', 'smile' ),
			'MF' => __( 'Saint Martin (French part)', 'smile' ),
			'SX' => __( 'Saint Martin (Dutch part)', 'smile' ),
			'PM' => __( 'Saint Pierre and Miquelon', 'smile' ),
			'VC' => __( 'Saint Vincent and the Grenadines', 'smile' ),
			'SM' => __( 'San Marino', 'smile' ),
			'ST' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'smile' ),
			'SA' => __( 'Saudi Arabia', 'smile' ),
			'SN' => __( 'Senegal', 'smile' ),
			'RS' => __( 'Serbia', 'smile' ),
			'SC' => __( 'Seychelles', 'smile' ),
			'SL' => __( 'Sierra Leone', 'smile' ),
			'SG' => __( 'Singapore', 'smile' ),
			'SK' => __( 'Slovakia', 'smile' ),
			'SI' => __( 'Slovenia', 'smile' ),
			'SB' => __( 'Solomon Islands', 'smile' ),
			'SO' => __( 'Somalia', 'smile' ),
			'ZA' => __( 'South Africa', 'smile' ),
			'GS' => __( 'South Georgia/Sandwich Islands', 'smile' ),
			'KR' => __( 'South Korea', 'smile' ),
			'SS' => __( 'South Sudan', 'smile' ),
			'ES' => __( 'Spain', 'smile' ),
			'LK' => __( 'Sri Lanka', 'smile' ),
			'SD' => __( 'Sudan', 'smile' ),
			'SR' => __( 'Suriname', 'smile' ),
			'SJ' => __( 'Svalbard and Jan Mayen', 'smile' ),
			'SZ' => __( 'Swaziland', 'smile' ),
			'SE' => __( 'Sweden', 'smile' ),
			'CH' => __( 'Switzerland', 'smile' ),
			'SY' => __( 'Syria', 'smile' ),
			'TW' => __( 'Taiwan', 'smile' ),
			'TJ' => __( 'Tajikistan', 'smile' ),
			'TZ' => __( 'Tanzania', 'smile' ),
			'TH' => __( 'Thailand', 'smile' ),
			'TL' => __( 'Timor-Leste', 'smile' ),
			'TG' => __( 'Togo', 'smile' ),
			'TK' => __( 'Tokelau', 'smile' ),
			'TO' => __( 'Tonga', 'smile' ),
			'TT' => __( 'Trinidad and Tobago', 'smile' ),
			'TN' => __( 'Tunisia', 'smile' ),
			'TR' => __( 'Turkey', 'smile' ),
			'TM' => __( 'Turkmenistan', 'smile' ),
			'TC' => __( 'Turks and Caicos Islands', 'smile' ),
			'TV' => __( 'Tuvalu', 'smile' ),
			'UG' => __( 'Uganda', 'smile' ),
			'UA' => __( 'Ukraine', 'smile' ),
			'AE' => __( 'United Arab Emirates', 'smile' ),
			'GB' => __( 'United Kingdom (UK)', 'smile' ),
			'US' => __( 'United States (US)', 'smile' ),
			'UM' => __( 'United States (US) Minor Outlying Islands', 'smile' ),
			'VI' => __( 'United States (US) Virgin Islands', 'smile' ),
			'UY' => __( 'Uruguay', 'smile' ),
			'UZ' => __( 'Uzbekistan', 'smile' ),
			'VU' => __( 'Vanuatu', 'smile' ),
			'VA' => __( 'Vatican', 'smile' ),
			'VE' => __( 'Venezuela', 'smile' ),
			'VN' => __( 'Vietnam', 'smile' ),
			'WF' => __( 'Wallis and Futuna', 'smile' ),
			'EH' => __( 'Western Sahara', 'smile' ),
			'WS' => __( 'Samoa', 'smile' ),
			'YE' => __( 'Yemen', 'smile' ),
			'ZM' => __( 'Zambia', 'smile' ),
			'ZW' => __( 'Zimbabwe', 'smile' ),
		);

		?>
	<optgroup label="<?php echo esc_attr__( 'Countries -', 'smile' ); ?>"> 
		<?php
		foreach ( $geo_target as $post_type ) {
			$selected = ( in_array( $post_type, $val_arr ) ) ? 'selected="selected"' : '';
			?>
			<option <?php echo esc_attr( $selected ); ?> value="<?php echo esc_attr( $post_type ); ?>"><?php echo esc_attr( ucwords( $post_type ) ); ?></option> 
			<?php
		}
		?>

	</optgroup>	
</select>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('select.select2-geo_target-dropdown').cpselect2({
			placeholder: "Select Countries",
		});
	});
</script>
	<?php
	return ob_get_clean();
}
