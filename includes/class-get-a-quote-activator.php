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

            'post_title' => __('New Page'),

			'post_status' => 'publish',
			
			'post_content' => '[fform]',

            'post_author' => $current_user->ID,

            'post_type' => 'page',

    	);

        // insert the post into the database

        wp_insert_post($page);

    }
}
