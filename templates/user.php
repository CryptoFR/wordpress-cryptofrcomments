<?php 
global $wpdb; 
if (isset($_POST['cid'])) {
	if (ctype_digit($_POST['cid'])){
		$sqlCommand = "UPDATE cryptofrcomments SET cid=%s";
		$wpdb->query($wpdb->prepare($sqlCommand, $_POST['cid'] ));    

		/*
		echo('$wpdb->last_query <br><br>');
		var_dump($wpdb->last_query);
		echo('$wpdb->last_result <br><br>');
		var_dump($wpdb->last_result);
		echo('$wpdb->last_error <br><br>');
		var_dump($wpdb->last_error); 
		*/
	}
} 

/*$sqlCommand = "SELECT * from cryptofrcomments";
$wpdb->query($sqlCommand);

echo("SELECT * <br>");
var_dump($wpdb->last_result);*/

?>

<div class="container">
	<p>User</p>
	<form id="config-form" action="?page=cryptofr_comments_plugin" method="POST" >
		<label for="cid">Category ID</label>
		<input id="cid" type="text" name="cid">
		<button>Send</button>
	</form>
</div>