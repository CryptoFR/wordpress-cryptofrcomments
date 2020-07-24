<div class="container"> 
	<div class="form-group">
		<label>Name:</label>
		<span class="user-name"></span>
		<img src="" class="user-image">
		<div class="user-icon"></div>
	</div> 

	<form id="config-form" action="?page=cryptofr_comments_plugin" method="POST" >
		<label for="cid">Category ID</label>
		<input id="cid" type="text" name="cid" value="<?php echo $config->cid; ?>">
		<button>Send</button>
	</form>
</div>