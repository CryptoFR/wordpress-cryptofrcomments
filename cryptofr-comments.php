<?php
/**
 * @package cryptofrcomments
 */

/*
 Plugin Name: CryptoFR Comments
 Plugin URI: https://cryptofr.com
 Description: Plugin for installing CryptoFR Forum Comments Box
 Version: 1.0.0
 Author: CryptoFR
 Author URI: http://cryptofr.com
 License: --
 Text Domain: CryptoFR Comments-plugin
 */

if (!defined('ABSPATH')){
	die;
}

class cryptofrcomments{ 

	function __construct(){   
		define('NODEBB_URL', 'https://testforum.cryptofr.com'); 
		add_filter( 'comments_template', function ( $comment_template ) {
			$templatefile= dirname(__FILE__).'/public/comments.php'; 
		    return $templatefile;
		}); 
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