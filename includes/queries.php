<?php

global $wpdb;

// -- UPDATE CID ON CRYPTOFRCOMMENTS PLUGIN CONFIG WP
if (isset($_POST['cid'])) {
  if (ctype_digit($_POST['cid'])){
    $sqlCommand = "UPDATE cryptofrcomments SET cid=%s";
    $wpdb->query($wpdb->prepare($sqlCommand, $_POST['cid'] ));
  }
}

// -- INSERT OPTIONAL CID ON CRYPTOFRCOMMENTS PLUGIN CONFIG WP
if (isset($_POST['optionalCid'])) {
  if (ctype_digit($_POST['optionalCid'])){
    $sqlCommand ="INSERT INTO `cryptofrcomments_cids` (cid) VALUES (%s);";
    $wpdb->query($wpdb->prepare($sqlCommand, $_POST['optionalCid'] ));
  }
}

// -- DELETE OPTIONAL CID ON CRYPTOFRCOMMENTS PLUGIN CONFIG WP
if (isset($_POST['selectedCid'])) {
  if (ctype_digit($_POST['selectedCid'])){
    $sqlCommand ="DELETE FROM `cryptofrcomments_cids` WHERE cid=%s";
    $wpdb->query($wpdb->prepare($sqlCommand, $_POST['selectedCid'] ));
  }
}

// -- INSERT FLAG ALLOW GUEST ON CRYPTOFRCOMMENTS PLUGIN CONFIG WP
if (isset($_POST['allow_guest'])) {
  if (ctype_digit($_POST['allow_guest'])){
    $sqlCommand ="INSERT INTO `cryptofrcomments` (allow_guest) VALUES (%s);";
    $wpdb->query($wpdb->prepare($sqlCommand, $_POST['allow_guest'] ));
  }
}

// -- INSERT DEFAULT AVATAR ROUTE ON CRYPTOFRCOMMENTS PLUGIN CONFIG WP
if (isset($_POST['labelsetting'])) {
  if (ctype_digit($_POST['labelsetting'])){
    $sqlCommand ="INSERT INTO `cryptofrcomments` (default_avatar) VALUES (%s);";
    $wpdb->query($wpdb->prepare($sqlCommand, $_POST['labelsetting'] ));
  }
}

// WP_POST DEFAULT NAME
$table_name = $wpdb->prefix . 'posts';


// -- GET CONFIG OF CRYPTOFRCOMMENTS WP PLUGIN
$sqlCommand = "SELECT * from cryptofrcomments ORDER BY ID DESC LIMIT 1";
$wpdb->query($sqlCommand);
$config=$wpdb->last_result[0];


// -- GET PENDING TO POST ARTICLES
$sqlCommand = "SELECT * from ".$table_name." WHERE cryptofrcomments = 'Pending'";
$wpdb->query($sqlCommand);
$markedArticles=json_encode($wpdb->last_result);


// -- GET PUBLISHED ARTICLES
$sqlCommand = "SELECT * from ".$table_name." WHERE cryptofrcomments = 'Published'";
$wpdb->query($sqlCommand);

$publishedArticles=json_encode($wpdb->last_result);


// -- GET OLD ARTICLES
$sqlCommand="SELECT * FROM ".$table_name." WHERE `cryptofrcomments`='Disabled' AND post_type='post' AND post_status='publish' ORDER BY post_date ASC";
$wpdb->query($sqlCommand);

$oldArticlesArray=$wpdb->last_result;

$oldArticles=json_encode($wpdb->last_result);


// -- GET CONFLICTED ARTICLES
$sqlCommand="SELECT * FROM ".$table_name." WHERE `cryptofrcomments`='Conflicted' AND post_type='post' AND post_status='publish' ORDER BY post_date ASC";
$wpdb->query($sqlCommand);


$conflictedArticles=json_encode($wpdb->last_result);


// -- GET COMMENTS
$table_name = $wpdb->prefix . 'comments';

$sqlCommand="SELECT * FROM ".$table_name;
$wpdb->query($sqlCommand);

$wpComments=json_encode($wpdb->last_result);


// -- GET COMMENTS
$table_name = 'cryptofrcomments_cids';
$sqlCommand="SELECT cid FROM ".$table_name;
$wpdb->query($sqlCommand);
$optionalCidsArray=$wpdb->last_result;
$optionalCids=json_encode($wpdb->last_result);


?>
