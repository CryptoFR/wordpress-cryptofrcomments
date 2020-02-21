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
		// add_filter( 'comments_template', function ( $template ) {
		//     return 'https://cryptofrtest.roisdigital.agency/wp-content/plugins/wordpress-cryptofrcomments/public/cryptofrcomments.php';
		// },100);
		// add_filter( "comments_template", "wpse_plugin_comment_template" );
		add_filter( "comments_template", "cryptofr",10000 );

		// apply_filters( 'comments_template', 'https://cryptofrtest.roisdigital.agency/wp-content/plugins/wordpress-cryptofrcomments/public/cryptofrcomments.php' );
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

	function cryptofr( $comment_template ) {
	     // global $post; 
        return 'https://cryptofrtest.roisdigital.agency/wp-content/plugins/wordpress-cryptofrcomments/public/cryptofrcomments.php';
        // return dirname(__FILE__) . '/review.php';
	     
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