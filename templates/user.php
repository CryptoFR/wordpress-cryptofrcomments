<div class="container"> 
	<div class="form-group">
		<label>Name:</label>
		<span class="user-name"></span>
		<img src="" class="user-image">
		<div class="user-icon"></div>
	</div> 

	<form id="config-form" action="?page=cryptofr_comments_plugin" method="POST" >
		<label for="cid">Default CategoryID</label>
		<input id="cid" type="text" name="cid" value="<?php echo $config->cid; ?>">
		<button>Send</button>
	</form>
  
	<form id="config-form-optional-cids" action="?page=cryptofr_comments_plugin" method="POST" >
		<select name="selectedCid" id="selectedCid">
			<?php 
				foreach ($optionalCidsArray as $cid) {
					echo "<option value=".$cid->cid.">".$cid->cid."</option>";
				} 
			?> 
		</select>
		<button>Delete CategoryID</button>

	</form>
	<form id="config-form-optional-cids-delete" action="?page=cryptofr_comments_plugin" method="POST">
		<label for="optionalCid">Optional CategoryID</label>
		<input id="optionalCid" type="text" name="optionalCid" value="0">
		<button>Insert Optional CategoryID</button>
	</form>
</div>