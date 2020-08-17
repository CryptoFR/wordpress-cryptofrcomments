<?php 
	// -- GET BLOGGER INFO FROM THE ARTICLE
	function getbloggerbypostid($data){
		global $wpdb;  
		return "false";
		if (!isset($data['post_id']) || !is_numeric($data['post_id'])) return "false"; 
	   	
		$table_name = $wpdb->prefix . 'posts';

		$sqlCommand = "SELECT * from ".$table_name." WHERE ID=%s";
		$wpdb->query($wpdb->prepare($sqlCommand,$data['post_id']));

		$post=$wpdb->last_result[0];

		return  array('blogger' => get_the_author_meta('display_name', $post->post_author));
	}

	// -- SET THE STATUS TO PUBLISH ON MULTIPLE ARTICLES FROM AN ARRAY
	function publishendpointarray($ids){
		global $wpdb;

		$ids=$ids->get_json_params(); 
		$idKeys="";

		if (count($ids)==0) return "false";

		foreach ($ids as $id) {
			if (!is_numeric($id)) return "false";
			$idKeys.= "%s, ";
		}  

		$idKeys=substr($idKeys, 0, -2);
		$table_name = $wpdb->prefix . 'posts';  
		$sqlCommand ="UPDATE ".$table_name." SET cryptofrcomments='Published' WHERE ID in (".$idKeys.")";
		$sqlCommand= $wpdb->prepare($sqlCommand,$ids); 
		$wpdb->query($sqlCommand);   

		$table_name = 'cryptofrcomments';		
		$sqlCommand = "UPDATE ".$table_name." SET attached='Done'"; 
		$wpdb->query($sqlCommand);  
	
		return "OK";
	}

	// -- SET THE STATUS TO PUBLISHED OR PENDING OF ONE ARTICLE
	function publishendpoint($data){
		global $wpdb; 

		if (!isset($data['status']) || !isset($data['id']) || !is_numeric($data['id']) || !is_string($data['status'])) return "false";

		$status=$data['status']; 
		$id=$data['id'];
		$table_name = $wpdb->prefix . 'posts';  

		$sqlCommand = "UPDATE ".$table_name." SET cryptofrcomments=%s WHERE ID=%s";
		$wpdb->query($wpdb->prepare($sqlCommand, $status, $id ));  

		return "OK";

	}

	// -- GET THE BLOGGER INFO FROM ITS ID
	function getbloggerendpoint($data){

		if (!isset($data['post_author']) || !is_numeric($data['post_author'])) return 'false';

		return  array('name' => get_the_author_meta('display_name', $data['post_author']));
	}


	function attachmentendpoint($data){ // Done - Pending
		global $wpdb;

		// if (!isset($data['status']) || !isset($data['id']) || !is_numeric($data['id']) || !is_string($data['status'])) return "false";

		$attachment=$data['attachment']; 


		$table_name = 'cryptofrcomments';
		
		$sqlCommand = "UPDATE ".$table_name." SET attached='Hola'"; 
		$wpdb->query($wpdb->prepare($sqlCommand,$attachment )); 

		if ($attachment=="Attached"){
			
			$table_name = $wpdb->prefix . 'posts';

			$attachedArticles=$data['attachedArticles'];
			$attachedIds=[];
			foreach ($attachedArticles as $article) {
				$attachedIds[]=$article->articleId;
			} 
			if ($count($attachedIds)>0){
				$sqlCommand="UPDATE ".$table_name." SET `cryptofrcomments`='Published'  WHERE `cryptofrcomments`='Disabled' AND post_type='post' AND post_status='publish' AND ID in (".$attachedIds.")";
				$wpdb->query($sqlCommand);
			}

			
			$conflictedArticles=$data['conflictedArticles'];
			$conflictedIds=[];
			foreach ($conflictedArticles as $article) {
				$conflictedIds[]=$article->articleId;
			} 
			if ($count($conflictedIds)>0){
				$sqlCommand="UPDATE ".$table_name." SET `cryptofrcomments`='Conflicted'  WHERE `cryptofrcomments`='Disabled' AND post_type='post' AND post_status='publish' AND ID in (".$conflictedIds.")";
				$wpdb->query($sqlCommand); 
			}

			
			$corruptedArticles=$data['corruptedArticles'];
			$corruptedIds=[];
			foreach ($corruptedArticles as $article) {
				$corruptedIds[]=$article->articleId;
			} 
			if ($count($corruptedIds)>0){
				$sqlCommand="UPDATE ".$table_name." SET `cryptofrcomments`='Pending'  WHERE `cryptofrcomments`='Disabled' AND post_type='post' AND post_status='publish' AND ID in (".$corruptedIds.")";
				$wpdb->query($sqlCommand); 
			}

		}
		return "OK";

	}
 

?>