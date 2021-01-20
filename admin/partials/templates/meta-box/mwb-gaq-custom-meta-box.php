<?php
$details = $this->gaq_helper->detailed_post_array( get_the_ID() );
$country = $this->gaq_country_manager->get_country_list();
if ( ! empty( $details['fqcountry'] ) ) {
	foreach ( $country as $value => $key ) {
		if ( $value === $details['fqcountry'] ) {
			$details['fqcountry'] = $key;
		}
	}
}
?>
<form action="<?php plugin_dir_url( __FILE__ ) . 'class-get-a-quote-admin.php'; ?>" method="POST" enctype="multipart/form-data">
	<?php wp_nonce_field( 'gaq_meta_box_nonce', 'gaq_meta_nonce' ); ?>
	<table class="form-table">
		<tr>
			<th style=' text-align: Center; font-size: 1.5em;color:cadetblue;border-bottom: 1px dashed;padding-bottom: 10px;'
				colspan=2>
				<div><?php esc_html_e( 'Attributes', 'GAQ_TEXT_DOMAIN' ); ?>
				</div>
			</th>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Type of Service', 'GAQ_TEXT_DOMAIN' );
			?>
			<span class="required">*</span></th>
			<td><input id="service" type="text" name="service" required="required"
					value="<?php echo esc_html( ! empty( $details['taxonomy_for_service'] ) ? $details['taxonomy_for_service'] : '' ); ?>"
					<?php echo esc_html( ! empty( $details['taxonomy_for_service'] ) ? 'readonly' : '' ); ?>>
				<input id="Status" type="hidden" name="quote_status" 
					value="<?php echo esc_html( ! empty( $details['taxonomy_for_status'] ) ? $details['taxonomy_for_status'] : '' ); ?>"
					<?php echo esc_html( ! empty( $details['taxonomy_for_status'] ) ? 'readonly' : '' ); ?>>
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'First Name', 'GAQ_TEXT_DOMAIN' );
			?>
			<span class="required">*</span></th>
			<td><input id="fname" type="text" name="firstname" required="required"
					value="<?php echo esc_html( ! empty( $details['ffname'] ) ? $details['ffname'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Last Name', 'GAQ_TEXT_DOMAIN' );
			?>
			<span class="required">*</span></th>
			<td><input id="lname" type="text" name="lastname" required="required"
					value="<?php echo esc_html( ! empty( $details['fqlname'] ) ? $details['fqlname'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Address', 'GAQ_TEXT_DOMAIN' );
			?>
			</th>
			<td><input id="address" type="text" name="address"
					value="<?php echo esc_html( ! empty( $details['fqaddress'] ) ? $details['fqaddress'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'City', 'GAQ_TEXT_DOMAIN' );
			?>
			</th>
			<td><input id="city" type="text" name="city"
					value="<?php echo esc_html( ! empty( $details['fqcity'] ) ? $details['fqcity'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Zipcode', 'GAQ_TEXT_DOMAIN' );
			?>
			</th>
			<td><input id="code" type="text" name="zipcode"
					value="<?php echo esc_html( ! empty( $details['fqzipcode'] ) ? $details['fqzipcode'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Email', 'GAQ_TEXT_DOMAIN' );
			?>
			<span class="required">*</span></th>
			<td><input id="email" type="text" name="email" required="required"
					value="<?php echo esc_html( ! empty( $details['fqemail'] ) ? $details['fqemail'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Country', 'GAQ_TEXT_DOMAIN' );
			?>
			</th>
			<td><input id="country" type="text" name="country"
					value="<?php echo esc_html( ! empty( $details['fqcountry'] ) ? $details['fqcountry'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'States', 'GAQ_TEXT_DOMAIN' );
			?>
			</th>
			<td><input id="states" type="text" name="states"
					value="<?php echo esc_html( ! empty( $details['fqstates'] ) ? $details['fqstates'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Phone', 'GAQ_TEXT_DOMAIN' );
			?>
			</th>
			<td><input id="phone" type="text" name="phone"
					value="<?php echo esc_html( ! empty( $details['fqphone'] ) ? $details['fqphone'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Budget', 'GAQ_TEXT_DOMAIN' );
			?>
			</th>
			<td><input id="budget" type="text" name="budget"
					value="<?php echo esc_html( ! empty( $details['fqbudget'] ) ? $details['fqbudget'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Additional Details', 'GAQ_TEXT_DOMAIN' );
			?>
			</th>
			<td><input id="add" type="text" name="add"
					value="<?php echo esc_html( ! empty( $details['fqadd'] ) ? $details['fqadd'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Attached File', 'GAQ_TEXT_DOMAIN' );
				$log = ABSPATH . 'wp-content/uploads/quote-submission';
			?>
			</th>

			<td>
				<b><span>
					<?php $file = ! empty( $details['fqfilename'] ) ? $details['fqfilename'] : ''; ?>
					<?php
					if ( ! empty( $file ) ) {
						echo ( sprintf( '<a href="%s">%s</a>', esc_html( opendir( $log ) ), esc_html__( 'Open Folder Location', 'GAQ_TEXT_DOMAIN' ) ) );
					} else {
						?>
						<input type='file' name="fqfiles" id="fileToUpload">
						<?php
					}

					?>
				</span></b>
			</td>
		</tr>
	</table>
</form>
