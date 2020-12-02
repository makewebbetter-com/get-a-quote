<?php

$data = 
json_decode(json_encode($post), true);

$details = Get_A_Quote_Helper::detailed_post_array($data['ID']);

?>
<form action="" method="POST" enctype="multipart/form-data" >
	<table class="form-table">

		<tr>
			<th style=' text-align: Center; font-size: 1.5em;color:cadetblue;border-bottom: 1px dashed;padding-bottom: 10px;' colspan=2>
				<div><?php esc_html_e('Attributes', 'get-a-quote');?></div>
			</th>
		</tr>
		<tr>
			<th><?php esc_html_e('Type of Service', 'get-a-quote');?><span class="required">*</span></th>
			<td><input id="service" type="text" name="service" required="required" value="<?php echo esc_html(!empty($details['taxonomy_for_service']) ? $details['taxonomy_for_service'] : ''); ?>"<?php echo esc_html(!empty($details['taxonomy_for_service']) ? 'readonly' : ''); ?>></td>
		</tr>
		<tr>
			<th><?php esc_html_e('First Name', 'get-a-quote');?><span class="required">*</span></th>
			<td><input id="fname" type="text" name="firstname" required="required" value="<?php echo esc_html(!empty($details['ffname']) ? $details['ffname'] : ''); ?>"></td>
		</tr>
		<tr>
			<th><?php esc_html_e('Last Name', 'get-a-quote');?><span class="required">*</span></th>
			<td><input id="lname" type="text" name="lastname" required="required" value="<?php echo esc_html(!empty($details['fqlname']) ? $details['fqlname'] : ''); ?>"></td>
		</tr>
		<tr>
			<th><?php esc_html_e('Address', 'get-a-quote');?></th>
			<td><input id="address" type="text" name="address" value="<?php echo esc_html(!empty($details['fqaddress']) ? $details['fqaddress'] : ''); ?>"></td>
		</tr>
		<tr>
			<th><?php esc_html_e('City', 'get-a-quote');?></th>
			<td><input id="city" type="text" name="city" value="<?php echo esc_html(!empty($details['fqcity']) ? $details['fqcity'] : ''); ?>"></td>
		</tr>
		<tr>
			<th><?php esc_html_e('Zipcode', 'get-a-quote');?></th>
			<td><input id="code" type="text" name="zipcode" value="<?php echo esc_html(!empty($details['fqzipcode']) ? $details['fqzipcode'] : ''); ?>"></td>
		</tr>
		<tr>
			<th><?php esc_html_e('Email', 'get-a-quote');?><span class="required">*</span></th>
			<td><input id="email" type="text" name="email" required="required" value="<?php echo esc_html(!empty($details['fqemail']) ? $details['fqemail'] : ''); ?>"></td>
		</tr>
		<tr>
			<th><?php esc_html_e('Country', 'get-a-quote');?></th>
			<td><input id="country" type="text" name="country" value="<?php echo esc_html(!empty($details['fqcountry']) ? $details['fqcountry'] : ''); ?>"></td>
		</tr>
		<tr>
			<th><?php esc_html_e('States', 'get-a-quote');?></th>
			<td><input id="states" type="text" name="states" value="<?php echo esc_html(!empty($details['fqstates']) ? $details['fqstates'] : ''); ?>"></td>
		</tr>
		<tr>
			<th><?php esc_html_e('Phone', 'get-a-quote');?></th>
			<td><input id="phone" type="text" name="phone" value="<?php echo esc_html(!empty($details['fqphone']) ? $details['fqphone'] : ''); ?>"></td>
		</tr>
		<tr>
			<th><?php esc_html_e('Budget', 'get-a-quote');?></th>
			<td><input id="budget" type="text" name="budget" value="<?php echo esc_html(!empty($details['fqbudget']) ? $details['fqbudget'] : ''); ?>"></td>
		</tr>
		<tr>
			<th><?php esc_html_e('Additional Details', 'get-a-quote');?></th>
			<td><input id="add" type="text" name="add" value="<?php echo esc_html(!empty($details['fqadd']) ? $details['fqadd'] : ''); ?>"></td>
			<span><?php ?></span>
		</tr>
		<tr>
			<th><?php esc_html_e('Attached File', 'get-a-quote');?></th>
			<td><b><Span><?php echo esc_html(!empty($details['fqfilename']) ? $details['fqfilename'] : 'No File Attached'); ?></span></b></td>
		</tr>
	</table>
</form>
