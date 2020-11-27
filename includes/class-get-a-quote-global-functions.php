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
    public static function enabling_default_value( $option ) {
        switch ($option) {
            
            case 'enable':
                $result = 'on';
                break;

            case 'taxonomy':
                $result = array(
                    'select_for_services' => 'yes',
                    'select_for_status'   => 'yes',
                );
                break;
        }
        return $result;
    }
}
