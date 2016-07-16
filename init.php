<?php
/*
Plugin Name: NCN Advertisement Widget
Plugin URI: http://facebook.com/truongvannam.ncn
Author: Nam NCN
Author URI: http://facebook.com/12a4.love.t
Version: 1.0.0
Description: This plugin can help you upload images on widget ease.
Tags: advertisement, widget...
Domain Path: /languages/
Text Domain: namncn
*/

define( 'NCNAW_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'NCNAW_DIR_URL', plugin_dir_url( __FILE__ ) );

load_theme_textdomain( 'namncn', NCNAW_DIR_PATH . '/languages' );


/**
 * Require file.
 */
function ncnaw_plugin_loader() {
	require_once NCNAW_DIR_PATH . '/inc/widget.php';
}
add_action( 'plugins_loaded', 'ncnaw_plugin_loader' );

function ncnaw_enqueue_script() {
	wp_enqueue_media();
	wp_enqueue_script( 'namncn-image-uploader', NCNAW_DIR_URL . '/js/image-uploader.js', array(), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'ncnaw_enqueue_script' );