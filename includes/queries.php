<?php

global $wpdb;

// -- UPDATE CID ON CRYPTOFRCOMMENTS PLUGIN CONFIG WP (DEFAULT POST CATEGORY)
if (isset($_POST['defaultCid'])) {
  if (ctype_digit($_POST['cid'])){
    $sqlCommand = "UPDATE cryptofrcomments SET cid=%s";
    $wpdb->query($wpdb->prepare($sqlCommand, $_POST['cid'] ));
    $sqlCommand ="DELETE FROM cryptofrcomments_cids WHERE cid=%s";
    $wpdb->query($wpdb->prepare($sqlCommand, $_POST['cid'] ));
  }
}

// -- INSERT OPTIONAL CID ON CRYPTOFRCOMMENTS PLUGIN CONFIG WP
if (isset($_POST['optionalCid'])) {
  if (ctype_digit($_POST['optionalCid'])){
    $sqlCommand ="INSERT INTO cryptofrcomments_cids (cid) VALUES (%s);";
    $wpdb->query($wpdb->prepare($sqlCommand, $_POST['optionalCid'] ));
  }
}

// -- DELETE OPTIONAL CID ON CRYPTOFRCOMMENTS PLUGIN CONFIG WP
if (isset($_POST['deleteCid'])) {
  if (isset($_POST['selectedCid'])){
    $sqlCommand ="DELETE FROM cryptofrcomments_cids WHERE cid=%s";
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
    $allow= 0;
    $sqlCommand ="UPDATE cryptofrcomments SET allow_guest=%s";
    $wpdb->query($wpdb->prepare($sqlCommand, $allow));
  }
}

// -- INSERT DEFAULT AVATAR ROUTE ON CRYPTOFRCOMMENTS PLUGIN CONFIG WP

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  if(isset($_FILES['default_avatar'])){

    $target_dir = get_site_url()."/wp-content/uploads/2021/03";
    $target_file = $target_dir . basename($_FILES['default_avatar']['name']);
    $img_name = basename($_FILES['default_avatar']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["default_avatar"]["tmp_name"]);

    $uploadedfile = $_FILES['default_avatar'];
    $upload_overrides = array( 'test_form' => false );

    $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
    //expresiónConValorBooleano ? expresión1 : expresión2;
    $check !== false ? $uploadOk = 1 : $uploadOk = 0;


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
      $sqlCommand ="UPDATE `cryptofrcomments` SET default_avatar=%s , avatar_name=%s ";
      $wpdb->query($wpdb->prepare($sqlCommand, $target_file, $img_name ));

    }
  }
  else {
    echo "File is empty ";
  }
}
//  END UPDATE DEFAULT AVATAR

//-- SAVE CHANGES IN RULES-MODERATION
if (isset($_POST["sc_rules"])) {
  //echo "imprime " . $_POST["allow_guest"]. ".";
  if (isset($_POST['accept_comments'])){ //true
    echo "entro en accept comments ";
    // $sqlCommand ="UPDATE cryptofrcomments SET allow_guest=%s";
    // $wpdb->query($wpdb->prepare($sqlCommand, $_POST['allow_guest'] ));
  }
  if(isset($_POST['moderate_guest'])){
    echo " entro en moderate_guest ";
    // $allow= 0;
    // $sqlCommand ="UPDATE cryptofrcomments SET allow_guest=%s";
    // $wpdb->query($wpdb->prepare($sqlCommand, $allow));
  }
  if(isset($_POST['use_keywords'])){
    echo " entro en use_keywords ";
    // $allow= 0;
    // $sqlCommand ="UPDATE cryptofrcomments SET allow_guest=%s";
    // $wpdb->query($wpdb->prepare($sqlCommand, $allow));
  }

  $case_sensitive = $_POST['case_sensitive'];
  if($case_sensitive == "sensitive"){
    echo " entro sensitive";
    //code
  }
  else{
  echo " entro insensitive";
  //code
  }

  $word_rendering= $_POST['word_rendering'];
  if($word_rendering== "first_letter"){
    echo " entro first_letter";
    //code
  }
  elseif($word_rendering=="all_letters"){
    echo " entro all_letters";
    //code
  }
  elseif ($word_rendering=="first_last") {
    echo " entro first_last";
    //code
  }
}

// WP_POST DEFAULT NAME
$table_name = $wpdb->prefix . 'posts';

// -- GET DEFAULT AVATAR
$sqlCommand = "SELECT avatar_name from cryptofrcomments";
$wpdb->query($sqlCommand);
$img_name=($wpdb->last_result);
$img=get_site_url()."/wp-content/uploads/2021/03/".$img_name[0]->avatar_name;

// -- GET CONFIG OF CRYPTOFRCOMMENTS WP PLUGIN
$sqlCommand = "SELECT * from cryptofrcomments ORDER BY ID DESC LIMIT 1";
$wpdb->query($sqlCommand);
$config=$wpdb->last_result[0];


// -- GET PENDING TO POST ARTICLES
$sqlCommand = "SELECT * from ".$table_name." WHERE cryptofrcomments = 'Pending'";
$wpdb->query($sqlCommand);
$markedArticles=json_encode($wpdb->last_result);


// -- GET PUBLISHED ARTICLES
$sqlCommand = "SELECT * from ".$table_name." WHERE 'cryptofrcomments' = 'Published'";
$wpdb->query($sqlCommand);

$publishedArticles=json_encode($wpdb->last_result);


// -- GET OLD ARTICLES
$sqlCommand= "SELECT * FROM ".$table_name." WHERE `cryptofrcomments`='Disabled' AND post_type='post' AND post_status='publish' ORDER BY post_date ASC";
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
