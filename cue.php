﻿<?php
/**
 * Cue中文修改版
 *
 * @package Cue
 * @author Brady Vercher
 * @copyright Copyright (c) 2014, AudioTheme, LLC
 * @license GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Cue中文修改版
 * Plugin URI: https://www.wichie.com
 * Description: 创建漂亮的，完全响应的音频播放列表。
 * Version: 9.9.9
 * Author: Wichie，zhw-island,Audio theme
 * Author URI: https://www.wichie.com
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: Cue中文修改版
 * Domain Path: /languages
 */

if ( ! defined( 'CUE_DIR' ) ) {
	/**
	 * Path directory path.
	 *
	 * @since 1.0.0
	 * @type string CUE_DIR
	 */
	define( 'CUE_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'CUE_URL' ) ) {
	/**
	 * URL to the plugin's root directory.
	 *
	 * Includes trailing slash.
	 *
	 * @since 1.0.0
	 * @type string CUE_URL
	 */
	define( 'CUE_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Include functions and libraries.
 */
if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
	require( CUE_DIR . 'includes/vendor/class-gamajo-template-loader.php' );
}

require( CUE_DIR . 'includes/functions.php' );

/**
 * Include admin functions and libraries.
 */
if ( is_admin() ) {
	require( CUE_DIR . 'admin/includes/class-cue-admin.php' );
	require( CUE_DIR . 'admin/includes/ajax.php' );
}

/**
 * Autoloader callback.
 *
 * Converts a class name to a file path and requires it if it exists.
 *
 * @since 1.1.0
 *
 * @param string $class Class name.
 */
function cue_autoloader( $class ) {
	if ( 0 !== strpos( $class, 'Cue' ) ) {
		return;
	}

	$file  = dirname( __FILE__ );
	$file .= ( false === strpos( $class, 'Admin' ) ) ? '/includes/' : '/admin/includes/';
	$file .= 'class-' . strtolower( str_replace( '_', '-', $class ) ) . '.php';

	if ( file_exists( $file ) ) {
		require_once( $file );
	}
}
spl_autoload_register( 'cue_autoloader' );

// Instantiate and load the plugin.
global $cue;
$cue = new Cue();
add_action( 'plugins_loaded', array( $cue, 'load_plugin' ) );
