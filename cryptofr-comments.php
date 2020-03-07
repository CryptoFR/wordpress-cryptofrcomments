<script type="text/javascript" src="<?php echo get_site_url().'/wp-content/plugins/cryptofr-comments/includes/api.js'; ?>" ></script>
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

defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );

class cryptofrcomments{ 

	function __construct(){   
		define('PLUGIN_PATH', dirname(__FILE__)); 
		define('NODEBB_URL', 'https://testforum.cryptofr.com'); 

		include (PLUGIN_PATH."/includes/util.php");

		add_filter('comments_template', array($this, 'cryptofrCommentsTemplate'),10,1);

		add_action('init', array($this, 'printTest')); 
		add_action('publish_post', array($this, 'publishTopicToCryptofr'),10,2);
	}
  

	function activate(){
		flush_rewrite_rules();
	}

	function deactivate(){
		flush_rewrite_rules();
	}

	function uninstall(){
	}

	function cryptofrCommentsTemplate ( $comment_template ) {
		$templatefile= PLUGIN_PATH.'/public/comments.php'; 
	    return $templatefile;
	}

	function printTest(){ 
		$url = NODEBB_URL.'/comments/publish';
		?>
		<script type="text/javascript"> 
			var data={
				markdown: 'this will work of course',
				title: 'cryptofr test',
				cid: -1,
				blogger: 'admin',
				tags: "",
				id: '98',
				url: 'https://testblog.cryptofr.com/2020/03/07/cryptofr-test/',
				timestamp: Date.now(),
				uid: "",
				_csrf: ""
			}
			console.log(JSON.stringify(data, null, 4));

			// publish(data,'<?php echo $url; ?>');
		</script>
		<?php

	}


	function publishTopicToCryptofr($ID, $post)  {
		$url = NODEBB_URL.'/comments/publish';  
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