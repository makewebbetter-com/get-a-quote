<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/admin
 * @author     Make Web Better <plugins@makewebbetter.com>
 */
class Get_A_Quote_Helper
{
    public static function enabling_default_value($option)
    {
        switch ($option) {

            case 'enable':
                $result = 'on';
                break;

            case 'taxonomy':
                $result = array(
                    'select_for_services' => 'yes',
                    'select_for_status' => 'yes',
                );
                break;

            case 'form_fields':
                $result = array(
                    'select_for_fname_field'	  => 'yes',
                    'select_for_lname_field' 	  => 'yes',
                    'select_for_address_field' 	  => 'yes',
                    'select_for_city_field' 	  => 'yes',
                    'select_for_zipcode_field' 	  => 'yes',
                    'select_for_country_field'	  => 'yes',
                    'select_for_states_field' 	  => 'yes',
                    'select_for_email_field' 	  => 'yes',
                    'select_for_phone_field'	  => 'yes',
                    'select_for_budget_field' 	  => 'yes',
                    'select_for_additional_field' => 'yes',
                    'select_for_fileup_field' 	  => 'yes',
                );
                break;
        }
        return $result;
    }

    public function helpertip($message = '')
    {
        if (!empty($message)) {
            echo '<span class="wp-tooltiptext">' . esc_html($message) . '</span>';
        }
    }

// End of class.
}
