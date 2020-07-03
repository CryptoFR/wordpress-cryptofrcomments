<?php 
	

	// -- OVERWRITE WORDPRESS COMMENTS TEMPLATE
	function cryptofrCommentsTemplate ( $comment_template ) {
		$templatefile= PLUGIN_PATH.'/public/comments.php'; 
	    return $templatefile;
	}

 

	// OVERWRITE THE ACTION LINKS ON THE PLUGIN LIST 
	function settings_link($links){
		$settings_link= '<a href="admin.php?page=cryptofr_comments_plugin">Settings</a>';
		array_push($links, $settings_link);
		return $links;
	}


?>