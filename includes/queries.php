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
if (isset($_POST["sc_settings"])) {
  //echo "imprime " . $_POST["allow_guest"]. ".";
  if (isset($_POST['allow_guest'])){ //true
    $sqlCommand ="UPDATE cryptofrcomments SET allow_guest=%s";
    $wpdb->query($wpdb->prepare($sqlCommand, $_POST['allow_guest'] ));
  }
  else {
    $sqlCommand ="UPDATE cryptofrcomments SET allow_guest=0";
    $wpdb->query($wpdb->prepare($sqlCommand));
  }
}

// -- INSERT DEFAULT AVATAR ROUTE ON CRYPTOFRCOMMENTS PLUGIN CONFIG WP

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  if(isset($_FILES['default_avatar'])){

    $target_dir = get_site_url()."/wp-content/uploads/";
    $target_file = $target_dir . basename($_FILES['default_avatar']['name']);
    //echo "File is an image - " . $target_file . ".";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["default_avatar"]["tmp_name"]);

      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }

    // Check file size
    // if ($_FILES["fileToUpload"]["size"] > 500000) {
    //   echo "Sorry, your file is too large.";
    //   $uploadOk = 0;
    // }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      $sqlCommand ="UPDATE `cryptofrcomments` SET default_avatar=%s";
      $wpdb->query($wpdb->prepare($sqlCommand, $target_file ));
    }
  }
  else {
    echo "File is empty ";
  }
}
//  END UPDATE DEFAULT AVATAR

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
