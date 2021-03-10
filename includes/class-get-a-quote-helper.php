<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/admin
 */

class Get_A_Quote_Helper {

	/**
	 * The single instance of the class.
	 *
	 * @since   1.0.0
	 * @var GAQCountryManager   The single instance of the GAQCountryManager
	 */
	protected static $instance = null;

	/**
	 * Main Get_A_Quote_Helper Instance.
	 *
	 * Ensures only one instance of Get_A_Quote_Helper is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Get_A_Quote_Helper - Main instance.
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Enabling_default_value
	 * Return default setting values.
	 *
	 * @param  array $option provides the list of the fields which accepts default values.
	 * @since 1.0.0
	 * @return array  $result selected options.
	 */
	public function enabling_default_value( $option ) {
		switch ( $option ) {

			case 'enable':
				$result = 'on';
				break;

			case 'taxonomy':
				$result = array(
					'select_for_services' => 'yes',
					'select_for_status'   => 'yes',
				);
				break;

			case 'form_fields':
				$result = array(
					'select_for_fname_field'      => 'yes',
					'select_for_lname_field'      => 'yes',
					'select_for_address_field'    => 'yes',
					'select_for_city_field'       => 'yes',
					'select_for_zipcode_field'    => 'yes',
					'select_for_country_field'    => 'yes',
					'select_for_State_field'     => 'yes',
					'select_for_email_field'      => 'yes',
					'select_for_phone_field'      => 'yes',
					'select_for_budget_field'     => 'yes',
					'select_for_additional_field' => 'yes',
					'select_for_fileup_field'     => 'yes',
				);
				break;
		}
		return $result;
	}

	/**
	 * Return helper tip html.
	 *
	 * @param  string $message provides the message to be displayed in helpertip.
	 * @since 1.0.0
	 */
	public function helpertip( $message = '' ) {
		if ( ! empty( $message ) ) {
			echo '<span class="wp-tooltiptext">' . esc_html( $message ) . '</span>';
		}
	}

	/**
	 * Create_attachment
	 *
	 * @param  string $file_add should be the path to a file in the upload directory.
	 * @param  string $p_id he ID of the post this attachment is for.
	 * @return void
	 */
	public function create_attachment( $p_id, $file_add ) {

		// Check the type of file. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( basename( $file_add ), null );

		// Get the path to the upload directory.
		$upload_dir = wp_upload_dir();

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $upload_dir['url'] . '/' . basename( $file_add ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_add ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $file_add, $p_id );

		// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file_add );

		wp_update_attachment_metadata( $attach_id, $attach_data );

		set_post_thumbnail( $p_id, $attach_id );
	}
	/**
	 * Return all quote saved data.
	 *
	 * @param string $post_id of the post to fetch meta data.
	 * @since 1.0.0
	 * @return array $post_details Submission data.
	 */
	public function detailed_post_array( $post_id ) {
		$post_details = get_post_meta( $post_id, 'quotes_meta', true );
		return $post_details;
	}

	/**
	 * Return all quote saved data.
	 *
	 * @since 1.0.0
	 * @return array  $recent_post_id Submission data.
	 */
	public function recent_post_id() {
		$recent_posts = get_posts(
			array(
				'fields'    => 'ids',
				'post_type' => 'quotes',
			)
		);
		if ( ! empty( $recent_posts ) ) {
			$recent_post_id = $recent_posts[0];
			return $recent_post_id;
		}
	}

	/**
	 * Validation
	 */
	public static function valiDation( $data ) {
		$err = array();
		$filtered = array();
		foreach ( $data as $key => $value ) {
			switch ( $key ) {
				case 'firstname':
					$name = $data['firstname'];
					$name = trim( $name, ' ' );
					$name = filter_var( $name, FILTER_SANITIZE_STRING );
					if ( $name == '' ) {
						$err[ $key ] = esc_html__( 'Name field is empty.', 'get-a-quote' );
						break;
					} elseif ( is_numeric( $name ) ) {
						$err[ $key ] = esc_html__( 'Name is to be character or alpha numeric.', 'get-a-quote' );
						break;
					} else {
						$filtered[ $key ] = $name;
						break;
					}
				case 'Additional':
					$add              = $data['Additional'];
					$filtered[ $key ] = $add;
					break;
				case 'Email':
					$email = $data['Email'];
					if ( $email == '' ) {
						$err[ $key ] = esc_html__( 'Email field is empty.', 'get-a-quote' );
						break;
					}
					if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
						$err[ $key ] = esc_html__( 'Invalid email format.' );
						break;
					} else {
						$filtered[ $key ] = $email;
						break;
					}
				case 'Phone':
					$phone = $data['Phone'];
					if ( $phone == '' ) {
						$err[ $key ] = esc_html__( 'Phone field is empty.', 'get-a-quote' );
						break;
					}
					$phone = trim( $phone, ' ' );
					$phone = trim( $phone, '-' );
					$string = preg_replace( '/[^a-z]/i', '', $phone );
					if ( ! empty( $string ) ) {
						$err[ $key ] = esc_html__( 'Enter only number in Phone field.', 'get-a-quote' );
						break;
					}
					$phone = filter_var( $phone, FILTER_SANITIZE_NUMBER_INT );
					if ( ctype_alpha( $phone ) ) {
						$err[ $key ] = esc_html__( 'Enter only number in Phone field.', 'get-a-quote' );
						break;
					} else {
						$filtered[ $key ] = $phone;
						break;
					}

				case 'Cityname':
					$city = $data['Cityname'];
					if ( is_numeric( $city ) ) {
						$err[ $key ] = esc_html__( 'Only characters are allowed in City field.', 'get-a-quote' );
						break;
					} else {
						$filtered[ $key ] = $city;
						break;
					}

				case 'Zipcode':
					$zcode = $data['Zipcode'];
					$zcode = trim( $zcode, '-' );
					$zcode = trim( $zcode, '.' );
					$zcode = preg_replace( '/[^A-Za-z0-9\-]/', '', $zcode );
					$zcode = preg_match( '#[0-9]{5}#', $zcode );
					if( ! empty ( $zcode ) ) {
						if ( strlen( $zcode ) > 7 || strlen( $zcode ) < 4 ) {
							$err[ $key ] = esc_html__( 'Zipcode length should be less than 7 and more then 4 digits.', 'get-a-quote' );
							break;
						} else {
							$filtered[ $key ] = $zcode;
							break;
						}
					}

				case 'State':
					$state = $data['State'];
					if ( is_numeric( $state ) ) {
						$err[ $key ] = esc_html__( 'Only numbers are not allowed in State.', 'get-a-quote' );
						break;
					} else {
						$filtered[ $key ] = $state;
						break;
					}

				case 'Country':
					$country = $data['Country'];
					if ( is_numeric( $country ) ) {
						$err[ $key ] = esc_html__( 'Only numbers are not allowed in Country.', 'get-a-quote' );
						break;
					} else {
						$filtered[ $key ] = $country;
						break;
					}
				case 'Budget':
					$bud              = abs( $data['Budget'] );
					$filtered[ $key ] = $bud;
					break;

				default:
					break;
			}
		}
		if ( ! empty( $err ) ) {
			$err['action'] = 'Error Found';
			return $err;
		} else {
			return $filtered;
		}
	}

	/**
	 * Set_taxonomy it sets the value of the taxo term.
	 *
	 * @param  string $id provides the id of the post.
	 * @since 1.0.0
	 */
	public function set_taxonomy( $id ) {
		$service = $this->detailed_post_array( $id );
		if ( ! empty( $service['taxo_service'] ) && isset( $service['taxo_service'] ) ) {
			$service_id = term_exists( $service['taxo_service'] );
			wp_set_object_terms( $id, intval( $service_id ), 'service' );
		}

		if ( ! empty( $service['status_taxo'] ) && ( isset( $service['status_taxo'] ) ) ) {
			$status_id = term_exists( $service['status_taxo'] );
			wp_set_object_terms( $id, intval( $status_id ), 'status' );
		}
	}

	/**
	 * Get_taxonomy it gets the value of the taxo term.
	 *
	 * @param  string $taxoname provides the name of the taxonomy.
	 * @since 1.0.0
	 */
	public function get_taxonomy( $taxoname ) {
		if ( isset( $_POST['tax_input'] ) ) {
			$term_id = '';
			$tax = $_POST['tax_input'];
			if ( isset( $tax[ $taxoname ] ) ) {
				foreach ( $tax[ $taxoname ] as $key => $value ) {
					if ( $value != 0 ) {
						$term_id = $value;
					}
				}
				$term = get_term_by( 'id', $term_id, $taxoname );
				if ( isset( $term->name ) ) {
					return $term->name;
				}
			}
		}
	}

	/**
	 * Email_sending
	 *
	 * @param string $post_id it provides the post id to send the mail.
	 * @since 1.0.0
	 * @return array  $post_detail Submission data.
	 */
	public function email_sending( $post_id ) {

		$options = get_option( 'mwb_gaq_email_fields_data' );
		$sender  = ! empty( $options['sender_email'] ) ? $options['sender_email'] : get_bloginfo( 'admin_email' );

		$details = $this->detailed_post_array( $post_id );

		$message = ! empty( $options['emailmess'] ) ? $options['emailmess'] : 'Thank for using our service we will be get back to you soon. ';

		$headers = 'From: ' . $sender . "\r\n" .
			'Reply-To: ' . $sender . "\r\n";

		$subject = ! empty( $options['email_subject'] ) ? $options['email_subject'] : 'Quotation Submitted';

		$send_to = $details['Email'];
		$sent    = wp_mail( $send_to, $subject, wp_strip_all_tags( $message ), wp_strip_all_tags( $headers ) );
		return ( $sent == 1 ) ? 'Mail Sent' : 'Mail not Send';
	}

	/**
	 * Add default Terms.
	 *
	 * @param  array  $args provides the agruments array for setting term.
	 * @param string $type provides the custom taxonomy name.
	 * @since    1.0.0
	 */
	public function insert_default_quote_taxonomies( $args = array(), $type = 'service' ) {

		if ( ! empty( $args ) && is_array( $args ) ) {
			foreach ( $args as $key => $value ) {
				try {
					$_terms =
					array(
						'description' => $value['description'],
					);
					wp_insert_term( $value['label'], $type, $_terms );
				} catch ( \Throwable $th ) {
					// Add issues to a logger class later.
					echo esc_html( $th->getMessage() );
				}
			}
		}
	}

	public function wc_help_tip( $tip, $allow_html = false ) {
		if ( $allow_html ) {
			$tip = wc_sanitize_tooltip( $tip );
		} else {
			$tip = esc_attr( $tip );
		}
		return sprintf( '<span class="woocommerce-help-tip" data-tip="%s"></span>', esc_html( $tip ) );
	}

	public static function mwb_gaq_get_country_list() {
		$countries = array(
			'' => 'Select Country',
			'US' => 'United States',
			'CA' => 'Canada',
			'GB' => 'United Kingdom',
			'AF' => 'Afghanistan',
			'AX' => '&#197;land Islands',
			'AL' => 'Albania',
			'DZ' => 'Algeria',
			'AS' => 'American Samoa',
			'AD' => 'Andorra',
			'AO' => 'Angola',
			'AI' => 'Anguilla',
			'AQ' => 'Antarctica',
			'AG' => 'Antigua and Barbuda',
			'AR' => 'Argentina',
			'AM' => 'Armenia',
			'AW' => 'Aruba',
			'AU' => 'Australia',
			'AT' => 'Austria',
			'AZ' => 'Azerbaijan',
			'BS' => 'Bahamas',
			'BH' => 'Bahrain',
			'BD' => 'Bangladesh',
			'BB' => 'Barbados',
			'BY' => 'Belarus',
			'BE' => 'Belgium',
			'BZ' => 'Belize',
			'BJ' => 'Benin',
			'BM' => 'Bermuda',
			'BT' => 'Bhutan',
			'BO' => 'Bolivia',
			'BQ' => 'Bonaire, Saint Eustatius and Saba',
			'BA' => 'Bosnia and Herzegovina',
			'BW' => 'Botswana',
			'BV' => 'Bouvet Island',
			'BR' => 'Brazil',
			'IO' => 'British Indian Ocean Territory',
			'BN' => 'Brunei Darrussalam',
			'BG' => 'Bulgaria',
			'BF' => 'Burkina Faso',
			'BI' => 'Burundi',
			'KH' => 'Cambodia',
			'CM' => 'Cameroon',
			'CV' => 'Cape Verde',
			'KY' => 'Cayman Islands',
			'CF' => 'Central African Republic',
			'TD' => 'Chad',
			'CL' => 'Chile',
			'CN' => 'China',
			'CX' => 'Christmas Island',
			'CC' => 'Cocos Islands',
			'CO' => 'Colombia',
			'KM' => 'Comoros',
			'CD' => 'Congo, Democratic People\'s Republic',
			'CG' => 'Congo, Republic of',
			'CK' => 'Cook Islands',
			'CR' => 'Costa Rica',
			'CI' => 'Cote d\'Ivoire',
			'HR' => 'Croatia/Hrvatska',
			'CU' => 'Cuba',
			'CW' => 'Cura&Ccedil;ao',
			'CY' => 'Cyprus',
			'CZ' => 'Czechia',
			'DK' => 'Denmark',
			'DJ' => 'Djibouti',
			'DM' => 'Dominica',
			'DO' => 'Dominican Republic',
			'TP' => 'East Timor',
			'EC' => 'Ecuador',
			'EG' => 'Egypt',
			'GQ' => 'Equatorial Guinea',
			'SV' => 'El Salvador',
			'ER' => 'Eritrea',
			'EE' => 'Estonia',
			'ET' => 'Ethiopia',
			'FK' => 'Falkland Islands',
			'FO' => 'Faroe Islands',
			'FJ' => 'Fiji',
			'FI' => 'Finland',
			'FR' => 'France',
			'GF' => 'French Guiana',
			'PF' => 'French Polynesia',
			'TF' => 'French Southern Territories',
			'GA' => 'Gabon',
			'GM' => 'Gambia',
			'GE' => 'Georgia',
			'DE' => 'Germany',
			'GR' => 'Greece',
			'GH' => 'Ghana',
			'GI' => 'Gibraltar',
			'GL' => 'Greenland',
			'GD' => 'Grenada',
			'GP' => 'Guadeloupe',
			'GU' => 'Guam',
			'GT' => 'Guatemala',
			'GG' => 'Guernsey',
			'GN' => 'Guinea',
			'GW' => 'Guinea-Bissau',
			'GY' => 'Guyana',
			'HT' => 'Haiti',
			'HM' => 'Heard and McDonald Islands',
			'VA' => 'Holy See (City Vatican State)',
			'HN' => 'Honduras',
			'HK' => 'Hong Kong',
			'HU' => 'Hungary',
			'IS' => 'Iceland',
			'IN' => 'India',
			'ID' => 'Indonesia',
			'IR' => 'Iran',
			'IQ' => 'Iraq',
			'IE' => 'Ireland',
			'IM' => 'Isle of Man',
			'IL' => 'Israel',
			'IT' => 'Italy',
			'JM' => 'Jamaica',
			'JP' => 'Japan',
			'JE' => 'Jersey',
			'JO' => 'Jordan',
			'KZ' => 'Kazakhstan',
			'KE' => 'Kenya',
			'KI' => 'Kiribati',
			'KW' => 'Kuwait',
			'KG' => 'Kyrgyzstan',
			'LA' => 'Lao People\'s Democratic Republic',
			'LV' => 'Latvia',
			'LB' => 'Lebanon',
			'LS' => 'Lesotho',
			'LR' => 'Liberia',
			'LY' => 'Libyan Arab Jamahiriya',
			'LI' => 'Liechtenstein',
			'LT' => 'Lithuania',
			'LU' => 'Luxembourg',
			'MO' => 'Macau',
			'MK' => 'Macedonia',
			'MG' => 'Madagascar',
			'MW' => 'Malawi',
			'MY' => 'Malaysia',
			'MV' => 'Maldives',
			'ML' => 'Mali',
			'MT' => 'Malta',
			'MH' => 'Marshall Islands',
			'MQ' => 'Martinique',
			'MR' => 'Mauritania',
			'MU' => 'Mauritius',
			'YT' => 'Mayotte',
			'MX' => 'Mexico',
			'FM' => 'Micronesia',
			'MD' => 'Moldova, Republic of',
			'MC' => 'Monaco',
			'MN' => 'Mongolia',
			'ME' => 'Montenegro',
			'MS' => 'Montserrat',
			'MA' => 'Morocco',
			'MZ' => 'Mozambique',
			'MM' => 'Myanmar',
			'NA' => 'Namibia',
			'NR' => 'Nauru',
			'NP' => 'Nepal',
			'NL' => 'Netherlands',
			'AN' => 'Netherlands Antilles',
			'NC' => 'New Caledonia',
			'NZ' => 'New Zealand',
			'NI' => 'Nicaragua',
			'NE' => 'Niger',
			'NG' => 'Nigeria',
			'NU' => 'Niue',
			'NF' => 'Norfolk Island',
			'KP' => 'North Korea',
			'MP' => 'Northern Mariana Islands',
			'NO' => 'Norway',
			'OM' => 'Oman',
			'PK' => 'Pakistan',
			'PW' => 'Palau',
			'PS' => 'Palestinian Territories',
			'PA' => 'Panama',
			'PG' => 'Papua New Guinea',
			'PY' => 'Paraguay',
			'PE' => 'Peru',
			'PH' => 'Philippines',
			'PN' => 'Pitcairn Island',
			'PL' => 'Poland',
			'PT' => 'Portugal',
			'PR' => 'Puerto Rico',
			'QA' => 'Qatar',
			'XK' => 'Republic of Kosovo',
			'RE' => 'Reunion Island',
			'RO' => 'Romania',
			'RU' => 'Russian Federation',
			'RW' => 'Rwanda',
			'BL' => 'Saint Barth&eacute;lemy',
			'SH' => 'Saint Helena',
			'KN' => 'Saint Kitts and Nevis',
			'LC' => 'Saint Lucia',
			'MF' => 'Saint Martin (French)',
			'SX' => 'Saint Martin (Dutch)',
			'PM' => 'Saint Pierre and Miquelon',
			'VC' => 'Saint Vincent and the Grenadines',
			'SM' => 'San Marino',
			'ST' => 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe',
			'SA' => 'Saudi Arabia',
			'SN' => 'Senegal',
			'RS' => 'Serbia',
			'SC' => 'Seychelles',
			'SL' => 'Sierra Leone',
			'SG' => 'Singapore',
			'SK' => 'Slovak Republic',
			'SI' => 'Slovenia',
			'SB' => 'Solomon Islands',
			'SO' => 'Somalia',
			'ZA' => 'South Africa',
			'GS' => 'South Georgia',
			'KR' => 'South Korea',
			'SS' => 'South Sudan',
			'ES' => 'Spain',
			'LK' => 'Sri Lanka',
			'SD' => 'Sudan',
			'SR' => 'Suriname',
			'SJ' => 'Svalbard and Jan Mayen Islands',
			'SZ' => 'Swaziland',
			'SE' => 'Sweden',
			'CH' => 'Switzerland',
			'SY' => 'Syrian Arab Republic',
			'TW' => 'Taiwan',
			'TJ' => 'Tajikistan',
			'TZ' => 'Tanzania',
			'TH' => 'Thailand',
			'TL' => 'Timor-Leste',
			'TG' => 'Togo',
			'TK' => 'Tokelau',
			'TO' => 'Tonga',
			'TT' => 'Trinidad and Tobago',
			'TN' => 'Tunisia',
			'TR' => 'Turkey',
			'TM' => 'Turkmenistan',
			'TC' => 'Turks and Caicos Islands',
			'TV' => 'Tuvalu',
			'UG' => 'Uganda',
			'UA' => 'Ukraine',
			'AE' => 'United Arab Emirates',
			'UY' => 'Uruguay',
			'UM' => 'US Minor Outlying Islands',
			'UZ' => 'Uzbekistan',
			'VU' => 'Vanuatu',
			'VE' => 'Venezuela',
			'VN' => 'Vietnam',
			'VG' => 'Virgin Islands (British)',
			'VI' => 'Virgin Islands (USA)',
			'WF' => 'Wallis and Futuna Islands',
			'EH' => 'Western Sahara',
			'WS' => 'Western Samoa',
			'YE' => 'Yemen',
			'ZM' => 'Zambia',
			'ZW' => 'Zimbabwe',
		);
		return $countries;
	}

	// End of class.
}
