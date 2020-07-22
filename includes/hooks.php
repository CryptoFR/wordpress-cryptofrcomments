<?php 

	// -- LOAD SCRIPTS TO THE FRONT. SHOW THE COMMENTS COUNTER FROM THE NODEBB PLUGIN	
	function front(){
		$frontCommand="commentsCounter('".NODEBB_URL."','".get_site_url()."');";

		wp_enqueue_script('front',"/wp-content/plugins/cryptofr-comments/js/front.js",'','',true);
		wp_add_inline_script( 'front', $frontCommand ); 
		wp_enqueue_style('main-styles', '/wp-content/plugins/cryptofr-comments/css/front.css', '', '', false);
	}

	
	// -- SHOW THE DASHBOARD BUTTON OF THE CRYPTOFR PLUGIN ON THE WORDPRESS ADMIN MENU SIDEBAR
	function add_admin_pages(){
		add_menu_page('Cryptofr','Cryptofrcomments','manage_options','cryptofr_comments_plugin',function (){ include (PLUGIN_PATH."/templates/dashboard.php"); 	} ,'dashicons-store',110);
	}


	// -- SEND THE PUBLISH REQUEST TO THE CRYPTOFR MAIN FORUM WITH THE MARKED ARTICLE JUST PUBLISHED ON THE WORDPRESS BLOG  
	function publish(){ 
	   	global $wpdb;  
	   	
		$table_name = $wpdb->prefix . 'posts'; 
		$publishURL = NODEBB_URL.'/comments/publish';  
		$publishPHP = get_site_url().'/wp-json/cryptofr-comments/publishendpoint';  

		$sqlCommand = "SELECT * from ".$table_name." WHERE cryptofrcomments='Marked' ORDER BY ID DESC ";
		$wpdb->query($sqlCommand);
 
		foreach ($wpdb->last_result as $post){
			// $sqlCommand = "UPDATE ".$table_name." SET cryptofrcomments='Published' WHERE ID=%s";
			// $wpdb->query($wpdb->prepare($sqlCommand, $post->ID ));  

			$escapedContent = escaped_content($post->post_content);
			$title = $post->post_title;
			$meta = get_the_author_meta('display_name', $post->post_author);
			$id = $post->ID;
			$url = $post->guid;
 
			$sqlCommand = "SELECT * from cryptofrcomments";
			$wpdb->query($sqlCommand);

			$cid= $wpdb->last_result[0]->cid;
 
			$data="{".
  				"markdown:  '$escapedContent',".
  				"title: '$title',".
  				"cid: $cid,".
  				"blogger: '$meta',".
  				"tags: '',".
  				"id: '$id',".
  				"url: '$url',".
  				"timestamp: Date.now(),".
  				"uid: '',".
  				"_csrf: ''".
			"}";

			// var_dump($data);

			$publishCommand='publish('.$data.',"'.NODEBB_URL.'","'.$publishURL.'","'.$publishPHP.'")'; 
 
			wp_enqueue_script('publish',"/wp-content/plugins/cryptofr-comments/js/publish.js",'','',true);
			wp_add_inline_script( 'publish', $publishCommand ); 

		}
	}

	
	// -- 
	function attachment(){ 
		global $wpdb;
		
		$attachmentURL = NODEBB_URL.'/comments/attachmment'; 
		$attachmentPHP = get_site_url().'/wp-json/cryptofr-comments/attachmentendpoint';  

		$table_name = 'cryptofrcomments';  

		$sqlCommand = "SELECT * from ".$table_name." WHERE attached='Pending'";
		$wpdb->query($sqlCommand);
		
		foreach ($wpdb->last_result as $attach){
			
			$sqlCommand = "UPDATE ".$table_name." SET attached='Processing'";
			$wpdb->query($sqlCommand); 

			// -- GET OLD ARTICLES
			$sqlCommand="SELECT * FROM ".$table_name." WHERE `cryptofrcomments`='Disabled' AND post_type='post' AND post_status='publish' ORDER BY post_date ASC";
			$wpdb->query($sqlCommand); 
			
			$oldArticles=json_encode($wpdb->last_result);
			
			$attachCommand='attachOldArticles('.$oldArticles.',"'.NODEBB_URL.'","'.$attachmentURL.'","'.$attachmentPHP.'")'; 
 
			wp_enqueue_script('publish',"/wp-content/plugins/cryptofr-comments/js/attachment.js",'','',true);
			wp_add_inline_script( 'attachOldArticles', $attachCommand );
			
		}

	}

?>