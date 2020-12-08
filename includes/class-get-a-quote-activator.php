<?php

/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/includes
 * @author     Make Web Better <plugins@makewebbetter.com>
 */
class Get_A_Quote_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        if (!current_user_can('activate_plugins')) {
            return;
        }
        $current_user = wp_get_current_user();

        $page = array(

            'post_title' => __('Quote Form'),

            'post_status' => 'publish',

            'post_content' => '[fform]',

            'post_author' => $current_user->ID,

            'post_type' => 'page',
        );
        wp_insert_term(
            'Service A', // the term
            'service', // the taxonomy
            array(
                'description' => 'A Type Service',
                'slug' => 'Service-A',
            )
        );
        wp_insert_term(
            'Service B', // the term
            'service', // the taxonomy
            array(
                'description' => 'B Type Service',
                'slug' => 'Service-B',
            )
        );
        wp_insert_term(
            'Service C', // the term
            'service', // the taxonomy
            array(
                'description' => 'C Type Service',
                'slug' => 'Service-C',
            )
        );
        // insert the post into the database
        $args = array(
            'post_type' => 'page',
            'post_title' => __('Quote Form'),
            'post_status' => 'publish',
        );
        
        $quote_page = get_posts($args);
        // echo '<pre>'; print_r( $quote_page ); echo '</pre>';
        // die();
        if (empty($quote_page)) {

            wp_insert_post($page);
        }
    }
}
