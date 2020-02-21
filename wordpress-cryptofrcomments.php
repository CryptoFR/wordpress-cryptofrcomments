<?php
/**
 * @package cryptofrcomments
 */

/*
 Plugin Name: wordpress-cryptofrcomments
 Plugin URI: https://cryptofr.com
 Description: Plugin for installing Cryptofr Forum Comments Box
 Version: 1.0.0
 Author: Cryptofr
 Author URI: http://cryptofr.com
 License: --
 Text Domain: cryptofrcomments-plugin
 */

if (!defined('ABSPATH')){
	die;
}

class cryptofrcomments{ 

	function __construct(){
		add_filter( 'comments_template', function ( $template ) {
		    return plugin_dir_path( dirname( __FILE__ ) ) . 'public/cryptofrcomments.php';
		});
		// apply_filters( 'comments_template', plugin_dir_path( dirname( __FILE__ ) ) . 'public/cryptofrcomments.php' );
		// add_filter( 'comments_template', function ( $template ) {
		//     return 'null';
		// });
		// apply_filters( 'comments_template', 'public/display-cryptofrcomments.php' );
	}
 

	function activate(){
	}

	function deactivate(){
	}

	function uninstall(){
	}
}


if (class_exists('cryptofrcomments')){
	$cryptofrcomments= new cryptofrcomments();
}


// Activation
register_activation_hook(__FILE__,array($cryptofrcomments,'activate'));


// Deactivation
register_deactivation_hook(__FILE__,array($cryptofrcomments,'deactivate'));


// Uninstall