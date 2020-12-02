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
                    'select_for_fname_field' => 'yes',
                    'select_for_lname_field' => 'yes',
                    'select_for_address_field' => 'yes',
                    'select_for_city_field' => 'yes',
                    'select_for_zipcode_field' => 'yes',
                    'select_for_country_field' => 'yes',
                    'select_for_states_field' => 'yes',
                    'select_for_email_field' => 'yes',
                    'select_for_phone_field' => 'yes',
                    'select_for_budget_field' => 'yes',
                    'select_for_additional_field' => 'yes',
                    'select_for_fileup_field' => 'yes',
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

    public function detailed_post_array($post_id)
    {

        $post_details = get_post_meta($post_id, 'quotes_meta', true);
        $post_details = json_decode(json_encode($post_details), true);
        return $post_details;
    }

    public function recent_post_id()
    {
        $recent_posts = get_posts(array(
            'fields' => 'ids',
            'post_type' => 'quotes')
        );
        $recent_post_id = $recent_posts[0];

        return $recent_post_id;
    }

    public function email_sending($post_id)
    {
        $sender = get_bloginfo('admin_email');
        $details = Get_A_Quote_Helper::detailed_post_array($post_id);
        $message = "Thank for using our service we will be get back to you soon.";
        $headers = 'From: ' . $sender . "\r\n" .
            'Reply-To: ' . $sender . "\r\n";
        $subject = " Quotation Submitted ";
        $send_to = $details['fqemail'];
        // echo '<pre>'; print_r( $send_to ); echo '</pre>';
        // die();
        // $sent = wp_mail($send_to, $subject, strip_tags($message), $headers);
        // echo '<pre>'; print_r( $sent ); echo '</pre>';
        //if( $sent == 1 ) ? return 'Mail Sent' : return 'issue occured';
        $value = ($sent == 1) ? 'Mail Sent' : 'Mail not Send';
        return $value;
    }

    // End of class.
}
