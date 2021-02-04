<div class="container-back">
    <div class="container-medium" >
			<div class="column is-9">
				<ul class="nav nav-tabs">
				  <li class="nav-item">
				    <a class="nav-link active" href="#" >Spam comments</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" href="#">Settings</a>
				  </li>
				</ul>
      </div>
      <div class="tab-content" id="tab_content_moderation">
        <div id="comments" class="tab-pane fade in active">
          <?php
          include (PLUGIN_PATH."/templates/spam_comments.php");
           ?>
        </div>

        <div id="rules" class="tab-pane fade ">
          <?php
          include (PLUGIN_PATH."/templates/spam_settings.php");
           ?>
        </div>
      </div>

			<div  class="column is-9">
				<button type="button" class="btn btn-sync">Save changes</button>
			</div>
		</div>
</div>
