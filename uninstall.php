<?php
/**
 * Trigger this file on plugin uninstall
 * 
 * @package cryptofrcomments
 * 
 * 
 */
 

defined( 'WP_UNINSTALL_PLUGIN' ) or die( 'Nope, not accessing this' );


global $wpdb; 

$table_name = $wpdb->prefix . 'posts';


$sqlCommand = "IF EXISTS( 

SELECT NULL
FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = '".$table_name."'
AND table_schema = '".$wpdb->dbname."'
AND column_name = 'cryptofrcomments')  THEN

ALTER TABLE ".$table_name." DROP COLUMN cryptofrcomments;

END IF; ";

$wpdb->query($sqlCommand);