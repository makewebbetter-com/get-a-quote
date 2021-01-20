<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/public/partials
 */

global $p_id;
$p_id = '';
if ( isset( $_POST['qsubmit'] ) ) {
	if ( isset( $_POST['gaq_public_form_nonce'] ) ) {
		check_admin_referer( 'gaq_public_form', 'gaq_public_form_nonce' );
		$mwb_gaq_form_fields_option = get_option( 'mwb_gaq_form_fields_options', $this->gaq_helper->enabling_default_value( 'form_fields' ) );

		unset( $_POST['qsubmit'] );

		$mwb_gaq_form_data = array();

		$mwb_gaq_form_data['ffname'] = isset( $_POST['ffname'] ) ? sanitize_text_field( wp_unslash( $_POST['ffname'] ) ) : '';

		$mwb_gaq_form_data['fqlname'] = isset( $_POST['fqlname'] ) ? sanitize_text_field( wp_unslash( $_POST['fqlname'] ) ) : '';

		$mwb_gaq_form_data['fqaddress'] = isset( $_POST['fqaddress'] ) ? sanitize_text_field( wp_unslash( $_POST['fqaddress'] ) ) : '';

		$mwb_gaq_form_data['fqcity'] = isset( $_POST['fqcity'] ) ? sanitize_text_field( wp_unslash( $_POST['fqcity'] ) ) : '';

		$mwb_gaq_form_data['fqzipcode'] = isset( $_POST['fqzipcode'] ) ? sanitize_text_field( wp_unslash( $_POST['fqzipcode'] ) ) : '';

		$mwb_gaq_form_data['fqcountry'] = isset( $_POST['fqcountry'] ) ? sanitize_text_field( wp_unslash( $_POST['fqcountry'] ) ) : '';

		$mwb_gaq_form_data['fqstates'] = isset( $_POST['fqstates'] ) ? sanitize_text_field( wp_unslash( $_POST['fqstates'] ) ) : '';

		$mwb_gaq_form_data['fqemail'] = isset( $_POST['fqemail'] ) ? sanitize_email( wp_unslash( $_POST['fqemail'] ) ) : '';

		$mwb_gaq_form_data['fqphone'] = isset( $_POST['fqphone'] ) ? sanitize_text_field( wp_unslash( $_POST['fqphone'] ) ) : '';

		$mwb_gaq_form_data['fqbudget'] = isset( $_POST['fqbudget'] ) ? sanitize_text_field( wp_unslash( $_POST['fqbudget'] ) ) : '';

		$mwb_gaq_form_data['fqadd'] = isset( $_POST['fqadd'] ) ? sanitize_textarea_field( wp_unslash( $_POST['fqadd'] ) ) : '';

		$mwb_gaq_form_data['taxonomy_for_service'] = isset( $_POST['taxonomy_for_service'] ) ? sanitize_text_field( wp_unslash( $_POST['taxonomy_for_service'] ) ) : '';

		$mwb_gaq_form_data['taxonomy_for_status'] = 'Pending';

		if ( ! empty( $mwb_gaq_form_data['ffname'] ) && ! empty( $mwb_gaq_form_data['taxonomy_for_service'] ) && ! empty( $mwb_gaq_form_data['fqlname'] ) && ! empty( $mwb_gaq_form_data['fqemail'] ) ) {
			$my_post_details = array(
				'post_title'  => $mwb_gaq_form_data['ffname'],
				'post_type'   => 'quotes',
				'post_status' => 'publish',
			);
			wp_insert_post( $my_post_details );
			$p_id = $this->gaq_helper->recent_post_id();
			if ( isset( $_FILES['fqfiles']['name'] ) ) {
				$err        = array();
				$file_name  = isset( $_FILES['fqfiles']['name'] ) ? sanitize_textarea_field( wp_unslash( $_FILES['fqfiles']['name'] ) ) : '';
				$file_tmp   = isset( $_FILES['fqfiles']['tmp_name'] ) ? sanitize_textarea_field( wp_unslash( $_FILES['fqfiles']['tmp_name'] ) ) : '';
				$file_type  = isset( $_FILES['fqfiles']['type'] ) ? sanitize_textarea_field( wp_unslash( $_FILES['fqfiles']['type'] ) ) : '';
				$file_ext   = wp_check_filetype( basename( $file_name ), null );
				$extensions = array( 'png', 'jpeg', 'jpg' );

				if ( ! empty( $file_ext['ext'] ) ) {
					if ( in_array( $file_ext, $extensions, true ) ) {
						$err[] = 'extension not allowed, please choose a pdf or docx file.';
					}
				}
				$log_dir = ABSPATH . 'wp-content/uploads/quote-submission';
				if ( ! is_dir( $log_dir ) ) {

					mkdir( $log_dir, 0755, true );
				}

				if ( empty( $err ) ) {

					$mwb_gaq_form_data['fqfilename'] = 'quote_' . $p_id . '.' . $file_ext['ext'];
					$file_add                        = $log_dir . '/' . $mwb_gaq_form_data['fqfilename'];
					move_uploaded_file( $file_tmp, $file_add );
					if ( ! empty( $file_add ) ) {
						$this->gaq_helper->create_attachment( $p_id, $file_add );
						esc_html_e( 'Success', 'GAQ_TEXT_DOMAIN' );
					}
				} else {
					$err = sprintf( '<div class="notice-fail is-dismissible"><p><strong>%s</strong></p></div>', $err );
					echo esc_html( $err );
				}
			}
			update_post_meta( $p_id, 'quotes_meta', $mwb_gaq_form_data );
			$this->gaq_helper->set_taxonomy( $p_id );

			if ( is_admin() ) {
				return;
			}
			$email_activator = get_option( 'mwb_gaq_activate_email' );
			if ( 'on' === $email_activator ) {
				$mail = $this->gaq_helper->email_sending( $p_id );
			}
			?>
			</ul>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'Thank you', 'GAQ_TEXT_DOMAIN' ); ?></strong></p>
			</div>
			<?php
		}
	} else {
		?>
		<div class="notice-fail is-dismissible">
			<p><strong><?php esc_html_e( 'Issue in required Fields', 'GAQ_TEXT_DOMAIN' ); ?></strong></p>
		</div>
		<?php
	}
}

$mwb_gaq_form_fields_option = get_option( 'mwb_gaq_form_fields_options', $this->gaq_helper->enabling_default_value( 'form_fields' ) );
$mwb_gaq_enable_form        = get_option( 'mwb_gaq_form_enable', 'on' );
if ( 'on' === $mwb_gaq_enable_form ) {
	$recent_id_post = $this->gaq_helper->recent_post_id();
			$fqfile = isset( $mwb_gaq_form_values['fqfile'] ) ? $mwb_gaq_form_values['fqfile'] : '';
	?>
	<br />
	<form action="" class="" method="POST" enctype="multipart/form-data">
	<?php
	wp_nonce_field( 'gaq_public_form', 'gaq_public_form_nonce' );
	if ( 'yes' === $mwb_gaq_form_fields_option['select_for_fname_field'] ) {
		?>
		<div class="custom-taxonomy-display">
			<label class="form_labels"><?php esc_html_e( 'Type Of Service', 'GAQ_TEXT_DOMAIN' ); ?><span class="required">*</span></label><br />
			<?php
			$taxonomies = get_terms(
				array(
					'taxonomy'   => 'service',
					'hide_empty' => false,
				)
			);
			if ( ! empty( $taxonomies ) ) {
				$taxonomies = json_decode( wp_json_encode( $taxonomies ), true );
				?>
				<select class="mwb_gaq_taxonomy_display" name="taxonomy_for_service">
					<?php
					$service_selected = isset( $mwb_gaq_form_values['service_selected'] ) ? $mwb_gaq_form_values['service_selected'] : '';
					foreach ( $taxonomies as $values => $key ) {
						$name = $key['name'];
						$slug = $key['slug'];
						?>
						<option value="<?php echo esc_html( $name ); ?>" <?php selected( $service_selected, $slug ); ?>> <?php echo esc_html( $name ); ?></option>
						<?php
					}
					?>
				</select>
				<?php
			}
			?>
		</div>

		<br />
		<p>

			<label class="form_labels"><?php esc_html_e( 'First Name', 'GAQ_TEXT_DOMAIN' ); ?><span class="required">*</span></label><br />

			<?php $ffname = isset( $mwb_gaq_form_values['ffname'] ) ? $mwb_gaq_form_values['ffname'] : ''; ?>

			<input type="text" name="ffname" pattern="[a-zA-Z0-9 ]+" required="required" value="<?php echo esc_html( wp_unslash( $ffname ) ); ?>" size="40" placeholder="First Name" />

		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_lname_field'] ) { ?>

		<p>

			<label class="form_labels"><?php esc_html_e( 'Last Name', 'GAQ_TEXT_DOMAIN' ); ?><span class="required">*</span></label><br />

			<?php $fqlname = isset( $mwb_gaq_form_values['fqlname'] ) ? $mwb_gaq_form_values['fqlname'] : ''; ?>

			<input type="text" name="fqlname" pattern="[a-zA-Z0-9 ]+" required="required" value="<?php echo esc_html( wp_unslash( $fqlname ) ); ?>" size="40" placeholder="Last Name" />

		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_address_field'] ) { ?>

		<p>

			<label class="form_labels"><?php esc_html_e( 'Address', 'GAQ_TEXT_DOMAIN' ); ?></label><br />

			<?php $fqaddress = isset( $mwb_gaq_form_values['fqaddress'] ) ? $mwb_gaq_form_values['fqaddress'] : ''; ?>

			<input type="text" name="fqaddress" value="<?php echo esc_html( wp_unslash( $fqaddress ) ); ?>" size="40" placeholder="Address" />

		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_city_field'] ) { ?>

		<p>
			<label class="form_labels"><?php esc_html_e( 'City', 'GAQ_TEXT_DOMAIN' ); ?></label><br />

			<?php $fqcity = isset( $mwb_gaq_form_values['fqcity'] ) ? $mwb_gaq_form_values['fqcity'] : ''; ?>

			<input type="text" name="fqcity" value="<?php echo esc_html( wp_unslash( $fqcity ) ); ?>" size="40" placeholder="City" />

		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_zipcode_field'] ) { ?>

		<p>

			<label class="form_labels"><?php esc_html_e( 'Zipcode', 'GAQ_TEXT_DOMAIN' ); ?></label><br />

			<?php $fqzipcode = isset( $mwb_gaq_form_values['fqzipcode'] ) ? $mwb_gaq_form_values['fqzipcode'] : ''; ?>

			<input type="text" name="fqzipcode" value="<?php echo esc_html( $fqzipcode ); ?>" size="40" placeholder="Zipcode" />

		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_country_field'] ) { ?>

		<p>
			<label class="form_labels"><?php esc_html_e( 'Country', 'GAQ_TEXT_DOMAIN' ); ?></label><br />
			<?php $country_list = GAQCountryManager::get_instance()->get_country_list(); ?>
			<select id="country_list_select" class="mwb_gaq_country_list_display" name="fqcountry">
				<?php
				$fqcountry = isset( $mwb_gaq_form_values['fqcountry'] ) ? $mwb_gaq_form_values['fqcountry'] : '';
				foreach ( $country_list as $value => $key ) {
					?>
					<option value= "<?php echo esc_html( $value ); ?>" <?php selected( $fqcountry, $key ); ?>><?php echo esc_html( $key ); ?></option>
					<?php
				}
				?>
			</select>
		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_states_field'] ) { ?>

		<p>

			<label class="form_labels_state"><?php esc_html_e( 'States', 'GAQ_TEXT_DOMAIN' ); ?></label><br />

			<select id="state_list" class="mwb_gaq_state_list_display" name="fqstates">
			</select>

		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_email_field'] ) { ?>

		<p>

			<label class="form_labels"><?php esc_html_e( 'Email', 'GAQ_TEXT_DOMAIN' ); ?><span class="required">*</span></label><br />

			<?php $fqemail = isset( $mwb_gaq_form_values['fqemail'] ) ? $mwb_gaq_form_values['fqemail'] : ''; ?>

			<input type="email" name="fqemail" required="required" value="<?php echo esc_html( wp_unslash( $fqemail ) ); ?>" size="40" placeholder="Email" />
		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_phone_field'] ) { ?>

		<p>

			<label class="form_labels"><?php esc_html_e( 'Phone', 'GAQ_TEXT_DOMAIN' ); ?></label><br />

			<?php $fqphone = isset( $mwb_gaq_form_values['fqphone'] ) ? $mwb_gaq_form_values['fqphone'] : ''; ?>

			<input type="text" name="fqphone" value="<?php echo esc_html( wp_unslash( $fqphone ) ); ?>" size="40" placeholder="Phone" />

		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_budget_field'] ) { ?>

		<p>
			<label class="form_labels"><?php esc_html_e( 'Budget', 'GAQ_TEXT_DOMAIN' ); ?></label><br />

			<?php $fqbudget = isset( $mwb_gaq_form_values['fqbudget'] ) ? $mwb_gaq_form_values['fqbudget'] : ''; ?>

			<input type="text" name="fqbudget" value="<?php echo esc_html( wp_unslash( $fqbudget ) ); ?>" size="40" placeholder="Budget" />

		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_additional_field'] ) { ?>

		<p>

			<label class="form_labels"><?php esc_html_e( 'Additional', 'GAQ_TEXT_DOMAIN' ); ?></label><br />

			<?php $fqadd = isset( $mwb_gaq_form_values['fqadd'] ) ? $mwb_gaq_form_values['fqadd'] : ''; ?>

			<textarea name="fqadd" rows="3" cols="50"><?php echo esc_html( wp_unslash( $fqadd ) ); ?></textarea>

		</p>

		<?php } ?>

		<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_fileup_field'] ) { ?>

		<p>

			<label class="form_labels"><?php esc_html_e( ' Max Size: 3MB ', 'GAQ_TEXT_DOMAIN' ); ?></label><br>

			<input type="file" name="fqfiles" id="fileToUpload">

		</p>

		<?php } ?>

		<input type="submit" name="qsubmit" value="Submit">

	</form>

	<?php
}
