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


	// Contructor and definitions of actions, hooks and filters
	function __construct(){

		$this->plugin_name= plugin_basename(__FILE__);
		define('PLUGIN_PATH', dirname(__FILE__));  // Definition of the base path of the plugin
		define('NODEBB_URL', 'https://testforum.cryptofr.com'); // Definition of the CryptoFr Main Forum URL


		include (PLUGIN_PATH."/includes/methods.php");

		//-- Hooks
		add_action('publish_post',array($this,'markPostOnPublish'),10,2 ); // When a post is published
		add_action('admin_enqueue_scripts', 'publish'); // When an admin page is loaded
		add_action('admin_menu','add_admin_pages'); // When the admin menu is loaded
		add_action( 'get_footer', 'front'); // When the footer on the front is loaded


		//-- Endpoints

		// Get the blogger info from its id
		add_action( 'rest_api_init', function () {
		  register_rest_route( 'cryptofr-comments', '/getbloggerendpoint/(?P<post_author>\d+)', array(
		    'methods' => 'GET',
		    'callback' => 'getbloggerendpoint'
		  ) );
		} );

		// Set the status to publish or pending of one article
		add_action( 'rest_api_init', function () {
		  register_rest_route( 'cryptofr-comments', '/publishendpoint', array(
		    'methods' => 'POST',
		    'callback' => 'publishendpoint'
		  ) );
		} );

		// Set the status to publish to multiple articles from an array
		add_action( 'rest_api_init', function () {
		  register_rest_route( 'cryptofr-comments', '/publishendpointarray', array(
		    'methods' => 'POST',
		    'callback' => 'publishendpointarray'
		  ) );
		} );

		// Get the blogg info from the article
		add_action( 'rest_api_init', function () {
		  register_rest_route( 'cryptofr-comments', '/getbloggerbypostid/(?P<post_id>\d+)', array(
		    'methods' => 'GET',
		    'callback' => 'getbloggerbypostid'
		  ) );
		} );


		// Set the status to publish or pending of one article
		add_action( 'rest_api_init', function () {
			register_rest_route( 'cryptofr-comments', '/attachmentendpoint', array(
			  'methods' => 'POST',
			  'callback' => 'attachmentendpoint'
			) );
		  } );


		// -- Filters

		// Overwrite wordpress comments template
		add_filter('comments_template', 'cryptofrCommentsTemplate',10,1);

		// Overwrite the action links on the plugin list
		add_filter("plugin_action_links_$this->plugin_name", 'settings_link');

	}



	// -- MARK AN ARTICLE ON THE WORDPRES DATABASE, READY TO BE PUBLISH TO THE CRYPTOFR MAIN FORUM
	function markPostOnPublish($ID, $post)  {

		global $wpdb;
		$table_name = $wpdb->prefix . 'posts';

		// if (!$ID || !$post) return false;

		$sqlCommand = "SELECT * FROM ".$table_name." WHERE ID=%s AND cryptofrcomments='Disabled'";
		$wpdb->query($wpdb->prepare($sqlCommand, $post->ID ));

		if ($wpdb->last_result){
			$sqlCommand = "UPDATE ".$table_name." SET cryptofrcomments='Marked' WHERE ID=%s";
			$wpdb->query($wpdb->prepare($sqlCommand, $post->ID ));
		}
	}



	// -- WHEN PLUGIN IS ACTIVATED CREATE/ALTER THE WORDPRESS DATABASE TO ADD FIELDS TO THE WP_POST TABLE AND A NEW TABLE CRYPTOFRCOMMENTS TO STORE THE CONFIG OF THE PLUGIN
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
			`allow_guest` char(1) NOT NULL,
			`default_avatar` VARCHAR(55) NOT NULL DEFAULT '',
			`attached` VARCHAR(55) NOT NULL DEFAULT 'Pending',
			PRIMARY KEY (`ID`)
		);";
		$wpdb->query($sqlCommand);


		// Create "cryptofrcomments_cids" table for saving optional cids
		$sqlCommand= "DROP TABLE IF EXISTS `cryptofrcomments_cids`";
		$wpdb->query($sqlCommand);
		$sqlCommand ="
			CREATE TABLE IF NOT EXISTS `cryptofrcomments_cids` (
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




	// -- DEACTIVATION OF THE WORDPRESS PLUGIN
	function deactivate(){

		flush_rewrite_rules();
	}

}


// Initialization of the plugin object
if (class_exists('cryptofrcomments')){
	$cryptofrcomments= new cryptofrcomments();
}


// Activation
register_activation_hook(__FILE__,array($cryptofrcomments,'activate'));


// Deactivation
register_deactivation_hook(__FILE__,array($cryptofrcomments,'deactivate'));
