<?php
/**
 * Provide a admin-facing view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 * @package    Get_a_quote
 * @subpackage Get_a_quote/admin/partials/meta-box
 */

$details      = $this->gaq_helper->detailed_post_array( get_the_ID() );
$countryarray = $this->gaq_helper->mwb_gaq_get_country_list();
if ( ! empty( $countryarray ) ) {
	foreach ( $countryarray as $key => $value ) {
		if ( isset( $details['Country'] ) && ! empty( $details['Country'] ) ) {
			if ( $details['Country'] === $key ) {
				$state = $this->gaq_country->country_states( $key );
				foreach ( $state as $skey => $svalue ) {
					if ( $details['State'] === $skey ) {
						$details['State'] = $svalue;
					}
				}
				$details['Country'] = $value;
			}
		}
	}
}

?>
<form action="<?php plugin_dir_url( __FILE__ ) . 'class-get-a-quote-admin.php'; ?>" method="POST" enctype="multipart/form-data">
	<?php wp_nonce_field( 'mwb_gaq_meta_box_nonce', 'mwb_gaq_meta_form' ); ?>
	<table class="mwb-table">
		<tr>
			<th style='font-size: 1.5em;color:#2196f3;
			;padding: 20px 8px;font-weight:600'>
				<div><?php esc_html_e( 'Attributes', 'get-a-quote' ); ?>
				</div>
			</th>
		</tr>
		<tr>
			<?php if ( ! empty( $details['taxo_service'] ) ) { ?>
				<th>
				<?php
				esc_html_e( 'Service', 'get-a-quote' );
				?>
			</th>
				<td><input id="fname" type="text" name="taxo_service" value="<?php echo esc_html( ! empty( $details['taxo_service'] ) ? $details['taxo_service'] : '' ); ?>
				"readonly>
				</td>
			<?php } ?>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'First Name', 'get-a-quote' );
			?>
			<span class="required">*</span></th>
			<td><input id="fname" type="text" name="firstname" required="required"
					value="<?php echo esc_html( ! empty( $details['firstname'] ) ? $details['firstname'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'City', 'get-a-quote' );
			?>
			</th>
			<td><input id="city" type="text" name="Cityname"
					value="<?php echo esc_html( ! empty( $details['Cityname'] ) ? $details['Cityname'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Zipcode', 'get-a-quote' );
			?>
			</th>
			<td><input id="code" type="text" name="Zipcode"
					value="<?php echo esc_html( ! empty( $details['Zipcode'] ) ? $details['Zipcode'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Email', 'get-a-quote' );
			?>
			</th>
			<td><input id="email" type="text" name="Email" value="<?php echo esc_html( ! empty( $details['Email'] ) ? $details['Email'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Country', 'get-a-quote' );
			?>
			</th>
			<td><input id="country" type="text" name="Country"
					value="<?php echo esc_html( ! empty( $details['Country'] ) ? $details['Country'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'State', 'get-a-quote' );
			?>
			</th>
			<td><input id="State" type="text" name="State"
					value="<?php echo esc_html( ! empty( $details['State'] ) ? $details['State'] : '' ); ?>">
			</td>
		</tr>
		<tr>
			<th>
			<?php
			esc_html_e( 'Phone', 'get-a-quote' );
			?>
			</th>
			<td><input id="phone" type="text" name="Phone"
					value="<?php echo esc_html( ! empty( $details['Phone'] ) ? $details['Phone'] : '' ); ?>">
			</td>
		</tr>
			<th>
			<?php
			esc_html_e( 'Additional Details', 'get-a-quote' );
			?>
			</th>
			<td><input id="add" type="text" name="Additional"
				value="<?php echo esc_html( ! empty( $details['Additional'] ) ? $details['Additional'] : '' ); ?>">
			</td>
		</tr>
		<?php if ( isset( $details['status'] ) && 'true' === $details['status'] ) { ?>
		<tr>
			<th>
			<?php
			esc_html_e( 'Attached File', 'get-a-quote' );
			?>
			</th>

			<td>
				<b><span>
					<?php
					$file = ! empty( $details['filename'] ) ? $details['filename'] : '';
					if ( ! empty( $file ) ) {
						?>
						<input type='hidden' name='filename' value='<?php echo esc_html( $details['status'] ); ?>'>
						<input type='hidden' name='filename' value='<?php echo esc_html( $details['filename'] ); ?>'>
						<input type='hidden' name='filelink' value='<?php echo esc_html( $details['filelink'] ); ?>'>
						<?php
						echo ( sprintf( '<a href="%s" target="_blank">%s</a>', esc_html( $details['filelink'] ), esc_html__( 'Open File', 'get-a-quote' ) ) );
					} else {
						esc_html_e( 'No File Selected', 'get-a-quote' );
					}
					?>
				</span></b>
			</td>
		</tr>
		<?php } ?>
	</table>
</form>
