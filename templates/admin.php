<a id="nodebb-comments"></a> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>
 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo get_site_url(); ?>/wp-content/plugins/cryptofr-comments/css/admin.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">



<h1>CryptoFR Comments</h1>

<ul class="nav nav-tabs cryptofrcomments-tabs">
  <li class="active cryptofr-login-tab"><a data-toggle="tab" href="#cryptofr-login" id="a-login">Login</a></li>
  <li class="cryptofr-comments-tab"><a data-toggle="tab" href="#cryptofr-comments" id="a-comments">Comments</a></li>
  <li class="cryptofr-user-tab"><a data-toggle="tab" href="#cryptofr-user" id="a-user">User</a></li>
</ul>

<div class="tab-content">
  <div id="cryptofr-login" class="tab-pane fade  in active">
  	<?php 
		include (PLUGIN_PATH."/templates/login.php"); 
  	 ?>
  </div>
  <div id="cryptofr-comments" class="tab-pane fade">
  	<?php 
		include (PLUGIN_PATH."/templates/comments.php"); 
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
?>


<script type="text/javascript">
	var cid= <?php echo $config->cid; ?>;
    var nodeBBURL = '<?php echo constant("NODEBB_URL"); ?>';
</script>
<script src="<?php echo get_site_url(); ?>/wp-content/plugins/cryptofr-comments/js/cryptofr.js"></script>

