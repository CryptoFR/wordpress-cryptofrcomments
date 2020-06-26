<a id="nodebb-comments"></a> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/showdown@1.9.1/dist/showdown.min.js"></script>
 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo get_site_url(); ?>/wp-content/plugins/cryptofr-comments/css/admin.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap">



<h1>CryptoFR Comments</h1>
<p class="error-cryptofr-auth">You are not Authorized</p>

<ul class="nav nav-tabs cryptofrcomments-tabs">
  <li class="cryptofr-login-tab"><a data-toggle="tab" href="#cryptofr-login" id="a-login">Login</a></li>
  <li class="cryptofr-comments-tab"><a data-toggle="tab" href="#cryptofr-comments" id="a-comments">Comments</a></li>
  <li class="cryptofr-publish-tab"><a data-toggle="tab" href="#cryptofr-publish" id="a-publish">Pending</a></li>
  <li class="cryptofr-user-tab"><a data-toggle="tab" href="#cryptofr-user" id="a-user">User</a></li>
  <li class="logout-box">
    <a data-toggle="tab" href="">
      <svg class="svg-inline--fa fa-sign-out fa-w-16" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="sign-out" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M180 448H96a96 96 0 0 1-96-96V160a96 96 0 0 1 96-96h84a12 12 0 0 1 12 12v40a12 12 0 0 1-12 12H96a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h84a12 12 0 0 1 12 12v40a12 12 0 0 1-12 12z"></path><path class="fa-primary" fill="currentColor" d="M353 88.3l151.9 150.6a24 24 0 0 1 0 34.1l-152 150.8a24.08 24.08 0 0 1-33.9-.1l-21.9-21.9a24.07 24.07 0 0 1 .8-34.7l77.6-71.1H184a23.94 23.94 0 0 1-24-24v-32a23.94 23.94 0 0 1 24-24h191.5l-77.6-71.1a24 24 0 0 1-.7-34.6l21.9-21.9a24 24 0 0 1 33.9-.1z"></path></g></svg><!-- <i class="fad fa-sign-out"></i> -->
      <span> Disconnect</span>
    </a>
  </li>  
</ul>

<div class="tab-content">
  <div id="cryptofr-login" class="tab-pane fade ">
  	<?php 
		include (PLUGIN_PATH."/templates/login.php"); 
  	 ?>
  </div>
  <div id="cryptofr-comments" class="tab-pane fade">
  	<?php 
		include (PLUGIN_PATH."/templates/comments.php"); 
  	 ?>
  </div>
  <div id="cryptofr-publish" class="tab-pane fade">
    <?php 
    include (PLUGIN_PATH."/templates/pending.php"); 
     ?>
  </div>
  <div id="cryptofr-user" class="tab-pane fade">
    <?php 
    include (PLUGIN_PATH."/templates/user.php"); 
     ?>
  </div>
</div>



<?php  
	global $wpdb;
	$sqlCommand = "SELECT * from cryptofrcomments";
	$wpdb->query($sqlCommand);
	$config=$wpdb->last_result[0];


  $table_name = $wpdb->prefix . 'posts';    

  $sqlCommand = "SELECT * from ".$table_name." WHERE cryptofrcomments = 'Pending'";
  $wpdb->query($sqlCommand); 

  $markedArticles=json_encode($wpdb->last_result);


  $sqlCommand = "SELECT * from ".$table_name." WHERE cryptofrcomments = 'Published'";
  $wpdb->query($sqlCommand); 

  $publishedArticles=json_encode($wpdb->last_result);

  
  $sqlCommand="SELECT * FROM ".$table_name." WHERE `cryptofrcomments`='Disabled' AND post_type='post' AND post_status='publish'";
  $wpdb->query($sqlCommand); 

  $oldArticles=json_encode($wpdb->last_result);
?>


<script type="text/javascript">
	var cid= <?php echo $config->cid; ?>;

  var markedArticles= <?php echo $markedArticles; ?>;
  var publishedArticles= <?php echo $publishedArticles; ?>;
  var oldArticles= <?php echo $oldArticles; ?>;

  var nodeBBURL = '<?php echo constant("NODEBB_URL"); ?>';
  var siteURL = '<?php echo get_site_url(); ?>';

  var publishURL = nodeBBURL+'/comments/publish';  
  var publishURLArray = nodeBBURL+'/comments/publish-batch';  
  
  var publishPHP = siteURL+'/wp-json/cryptofr-comments/publishendpoint';  
  var publishPHPArray = siteURL+'/wp-json/cryptofr-comments/publishendpointarray';  
    
  var bloggerPHP = siteURL+'/wp-json/cryptofr-comments/getbloggerendpoint';
</script>

<script src="<?php echo get_site_url(); ?>/wp-content/plugins/cryptofr-comments/js/publish.js"></script>

<script src="<?php echo get_site_url(); ?>/wp-content/plugins/cryptofr-comments/js/cryptofr.js"></script>

