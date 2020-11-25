<?php
// $post_id = 
//$meta = get_post_meta( $post['ID'], 'quotes_meta');
$data = json_decode(json_encode($post), true);
//print_r( $data['ID'] );
$details = array();
$details = get_post_meta( $data['ID'], 'quotes_meta', true );
$details = json_decode(json_encode($details['quotes_meta']), true);
// print_r( $details['ffname']);
?>
<table class="form-table">
	<p class"lead"></p>
	<tr>
		<th style='font-size: 1.1em;color:cadetblue;border-bottom: 1px dashed;padding-bottom: 10px;' colspan=2>
			<div><?php esc_html_e('Attributes', 'get-a-quote'); ?></div>
		</th>
	</tr>
	<tr>
		<th><?php esc_html_e('First Name', 'get-a-quote'); ?><span class="required">*</span></th>
		<td><input id="fname" type="text" name="firstname" required="required" value="<?php echo esc_html( ! empty( $details['ffname'] ) ?  $details['ffname'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Last Name', 'get-a-quote'); ?><span class="required">*</span></th>
		<td><input id="lname" type="text" name="lastname" required="required" value="<?php echo esc_html( ! empty( $details['fqlname'] ) ?  $details['fqlname'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Address', 'get-a-quote'); ?></th>
		<td><input id="address" type="text" name="address" value="<?php echo esc_html( ! empty( $details['fqaddress'] ) ?  $details['fqaddress'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('City', 'get-a-quote'); ?></th>
		<td><input id="city" type="text" name="city" value="<?php echo esc_html( ! empty( $details['fqcity'] ) ?  $details['fqcity'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Zipcode', 'get-a-quote'); ?></th>
		<td><input id="code" type="text" name="zipcode" value="<?php echo esc_html( ! empty( $details['fqzipcode'] ) ?  $details['fqzipcode'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Email', 'get-a-quote'); ?><span class="required">*</span></th>
		<td><input id="email" type="text" name="email" required="required" value="<?php echo esc_html( ! empty( $details['fqemail'] ) ?  $details['fqemail'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Country', 'get-a-quote'); ?></th>
		<td><input id="country" type="text" name="country" value="<?php echo esc_html( ! empty( $details['fqcountry'] ) ?  $details['fqcountry'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('States', 'get-a-quote'); ?></th>
		<td><input id="states" type="text" name="states" value="<?php echo esc_html( ! empty( $details['fqstates'] ) ?  $details['fqstates'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Phone', 'get-a-quote'); ?></th>
		<td><input id="phone" type="text" name="phone" value="<?php echo esc_html( ! empty( $details['fqphone'] ) ?  $details['fqphone'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Budget', 'get-a-quote'); ?></th>
		<td><input id="budget" type="text" name="budget" value="<?php echo esc_html( ! empty( $details['fqbudget'] ) ?  $details['fqbudget'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Additional Details', 'get-a-quote'); ?></th>
		<td><input id="add" type="text" name="add" value="<?php echo esc_html( ! empty( $details['fqadd'] ) ?  $details['fqadd'] : '' ); ?>"></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Attachments', 'get-a-quote'); ?></th>
		<td><input id="attachment" type="file" name="attachment" value="<?php echo esc_html( ! empty( $details['fqfilename'] ) ?  $details['fqfilename'] : '' ); ?>"></td>
	</tr>
</table>
