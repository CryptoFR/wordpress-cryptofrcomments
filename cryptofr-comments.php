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
 Author URI: https://cryptofr.com
 License: --
 Text Domain: CryptoFR Comments-plugin
 */

defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );

class cryptofrcomments{ 

	public $plugin_name;

	function __construct(){ 
		$this->plugin_name= plugin_basename(__FILE__);

		define('PLUGIN_PATH', dirname(__FILE__)); 
		define('NODEBB_URL', 'https://testforum.cryptofr.com'); 

		include (PLUGIN_PATH."/includes/util.php");

		// Hooks
		add_action('publish_post', array($this, 'markPostOnPublish'),10,2);
		add_action('admin_enqueue_scripts', array($this,'publish'));
		add_action('admin_menu',array($this,'add_admin_pages'));

		// Overwrite wordpress functions or templates
		add_filter('comments_template', array($this, 'cryptofrCommentsTemplate'),10,1);
		add_filter("plugin_action_links_$this->plugin_name", array($this, 'settings_link'));
	}
 

	function add_admin_pages(){
		add_menu_page('Cryptofr','Cryptofrcomments','manage_options','cryptofr_comments_plugin',array($this,'admin_index'),'dashicons-store',110);
	}

	function admin_index(){
		include (PLUGIN_PATH."/templates/admin.php"); 
	}

	function settings_link($links){
		$settings_link= '<a href="admin.php?page=cryptofr_comments_plugin">Settings</a>';
		array_push($links, $settings_link);
		return $links;
	}


	function activate(){	
		ob_start();

	   	global $wpdb; 

	   	// Altering post table for cryptofrcomments attribute  

		$table_name = $wpdb->prefix . 'posts'; 

		$check_column = (array) $wpdb->get_results(  "SELECT count(cryptofrcomments) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME = '{$table_name}' AND COLUMN_NAME = 'cryptofrcomments'"  )[0];

		$check_column = (int) array_shift($check_column);
		if($check_column == 0) {
			$wpdb->query(
			"ALTER TABLE $table_name
			ADD COLUMN `cryptofrcomments` VARCHAR(55) NOT NULL DEFAULT 'Disabled'
			");
		} 
		


		// Create "cryptofrcomments" table for saving config if not exists 


		$sqlCommand= "DROP TABLE IF EXISTS `cryptofrcomments`";

		$wpdb->query($sqlCommand);


		$sqlCommand ="
			CREATE TABLE IF NOT EXISTS `cryptofrcomments` (
			  `ID` int(11) NOT NULL AUTO_INCREMENT,
			  `cid` int (11) NOT NULL,
			  PRIMARY KEY (`ID`)
			);";

		$wpdb->query($sqlCommand); 


		$sqlCommand ="
			INSERT INTO `cryptofrcomments` (cid)
			VALUES (0);
			";

		$wpdb->query($sqlCommand);  

		flush_rewrite_rules();
	} 


	function deactivate(){
		flush_rewrite_rules();
	}
 
	function cryptofrCommentsTemplate ( $comment_template ) {
		$templatefile= PLUGIN_PATH.'/public/comments.php'; 
	    return $templatefile;
	}

	function publish(){ 
	   	global $wpdb; 
	   	$sqlCommand = "UPDATE ".$table_name." SET cryptofrcomments='Published' WHERE ID=%s";
	   	$wpdb->query($wpdb->prepare($sqlCommand, $post->ID ));    

		$table_name = $wpdb->prefix . 'posts'; 
		$publishURL = NODEBB_URL.'/comments/publish';  

		$sqlCommand = "SELECT * from ".$table_name." WHERE cryptofrcomments='Marked' ORDER BY ID DESC ";
		$wpdb->query($sqlCommand);
 
		foreach ($wpdb->last_result as $post){
			$sqlCommand = "UPDATE ".$table_name." SET cryptofrcomments='Published' WHERE ID=%s";
			$wpdb->query($wpdb->prepare($sqlCommand, $post->ID ));  

			$escapedContent = escaped_content($post->post_content);
			$title = $post->post_title;
			$meta = get_the_author_meta('display_name', $post->post_author);
			$id = $post->ID;
			$url = $post->guid;


			$data="{".
  				"markdown:  '$escapedContent',".
  				"title: '$title',".
  				"cid: -1,".
  				"blogger: '$meta',".
  				"tags: '',".
  				"id: '$id',".
  				"url: '$url',".
  				"timestamp: Date.now(),".
  				"uid: '',".
  				"_csrf: ''".
			"}";

			var_dump($data);

			$publishCommand='publish('.$data.',"'.NODEBB_URL.'","'.$publishURL.'")'; 


			wp_enqueue_script('publish',"/wp-content/plugins/cryptofr-comments/js/publish.js",'','',true);
			wp_add_inline_script( 'publish', 'console.log("'.$meta.'")' ); 
			wp_add_inline_script( 'publish', $publishCommand ); 

		}		
	}


	function markPostOnPublish($ID, $post)  {

		global $wpdb;
		$table_name = $wpdb->prefix . 'posts';
 
		$sqlCommand = "SELECT * FROM ".$table_name." WHERE ID=%s AND cryptofrcomments='Disabled'";
		$wpdb->query($wpdb->prepare($sqlCommand, $post->ID ));

		if ($wpdb->last_result){
			$sqlCommand = "UPDATE ".$table_name." SET cryptofrcomments='Marked' WHERE ID=%s";
			$wpdb->query($wpdb->prepare($sqlCommand, $post->ID ));
		}  
	} 
}


if (class_exists('cryptofrcomments')){
	$cryptofrcomments= new cryptofrcomments();
}


// Activation
register_activation_hook(__FILE__,array($cryptofrcomments,'activate'));


// Deactivation
register_deactivation_hook(__FILE__,array($cryptofrcomments,'deactivate'));
 