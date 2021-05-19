<div class="container-back">
    <div class="container-medium" >

      <div  id="tabsModeration" class="column is-9">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#spam_comments">Comments</a></li>
          <!-- <li><a data-toggle="tab" href="#spam_settings">Settings</a></li> -->
        </ul>
      </div>
      <!-- <div class="tab-content" id="tab_content_moderation"> -->
        <div id="spam_comments" class="tab-pane fade in active">
          <?php
          include (PLUGIN_PATH."/templates/spam_comments.php");
           ?>
        </div>

        <!-- <div id="spam_settings" class="tab-pane fade ">
          <?php
          //include (PLUGIN_PATH."/templates/spam_settings.php");
           ?>
        </div> -->
      <!-- </div> -->

			<div  class="column is-9">
				<button type="button" class="btn btn-sync">Save changes</button>
			</div>
		</div>
</div>
