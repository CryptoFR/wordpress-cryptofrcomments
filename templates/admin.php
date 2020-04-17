<a id="nodebb-comments"></a> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
	var nodeBBURL = '', 
	wordpressURL = '',
	articleID = '',
	blogger = '', 
	articleType = '',
	articleTitle = '',
	content = "",
	categoryID = ''; 
</script>

<?php 
   	global $wpdb; 
	$table_name = $wpdb->prefix . 'posts'; 

	$sqlCommand = "SELECT * from $table_name WHERE cryptofrcomments='Published'  ";

	$posts = (array) $wpdb->get_results($sqlCommand);
	$timer=-1;

	foreach ($posts as $post){
		$timer++;
?>
		<script type="text/javascript">
			setTimeout(async function tick() { 
				nodeBBURL = '<?php echo constant("NODEBB_URL"); ?>'; 
				wordpressURL = '<?php echo get_site_url(); ?>';
				articleID = '<?php echo $post->ID; ?>';
				blogger = '<?php echo the_author_meta( 'display_name' , $post->post_author );  ?>'; 
				articleType = 'Post';
				articleTitle = '<?php echo $post->post_title;; ?>';
				content = "<?php echo escaped_content($post->post_content); ?>";
				categoryID = -1; 


				(function() { 
					var nbb = document.createElement('script'); nbb.type = 'module'; nbb.async = true;
					nbb.src = nodeBBURL + '/plugins/nodebb-plugin-blog-comments-cryptofr/lib/main.js';
					var nbb2 = document.createElement('script'); nbb2.type = 'module'; nbb2.async = true;
					nbb2.src = nodeBBURL + '/plugins/nodebb-plugin-blog-comments-cryptofr/lib/build.js';
					(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(nbb);
					(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(nbb2);
				})();
			}, <?php echo $timer*2000; ?>);  
		</script>
<?php
		// break;
	}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo get_site_url(); ?>/wp-content/plugins/cryptofr-comments/css/admin.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="<?php echo get_site_url(); ?>/wp-content/plugins/cryptofr-comments/js/cryptofr.js"></script>


<h1>CryptoFR Comments</h1>

<ul class="nav nav-tabs cryptofrcomments-tabs">
  <li class="active cryptofr-login-tab"><a data-toggle="tab" href="#cryptofr-login" id="a-login">Login</a></li>
  <li class="cryptofr-comments-tab"><a data-toggle="tab" href="#cryptofr-comments" id="a-comments">Comments</a></li>
  <li class="cryptofr-user-tab"><a data-toggle="tab" href="#cryptofr-user" id="a-user">User</a></li>
</ul>

<div class="tab-content">
  <div id="cryptofr-login" class="tab-pane fade in active">
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


