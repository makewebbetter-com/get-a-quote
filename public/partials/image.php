<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/public/partials
 */

session_start();
$text = rand( 1000000, 9999999 );
$_SESSION['vercode'] = $text;
$height = 25;
$width = 75;
$image_p = imagecreate( $width, $height );
$black = imagecolorallocate( $image_p, 0, 0, 0 );
$white = imagecolorallocate( $image_p, 255, 255, 255 );
$font_size = 14;
imagestring( $image_p, $font_size, 5, 5, $text, $white );
imagejpeg( $image_p, null, 80 );
