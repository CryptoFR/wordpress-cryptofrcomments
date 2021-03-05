<div class="container-back">
    <div class="container-medium" >

       <div>
            <div class="container-panel">

                <div style="display:block">
                    <!--All content about tab forum is here se-->
                    <br>
                    <div class="row-moderation">
                        <div class="column-2 ">
                          <div>
                            <form id="allow-guest" action="?page=cryptofr_comments_plugin" method="POST" >
                              <label class="switch">
                                  <input id="allow_guest" type="checkbox" value="0">
                                  <span class="slider round">
                                  </span>
                              </label>
                              <label  class="label-switch-forum" for="defaultCheck1">
                                Allow Guest Comments
                              </label>
                            </form>
                          </div>

                          <div>
                            <div class="gridsetting"> <!-- section with user image -->

                            <div class="settings-top">
                            <form id="default-avatar-settings" action="?page=cryptofr_comments_plugin" method="POST" >
                            <label class="label-setting">Default avatar for guests</label>
                              <input type="file" class="default_avatar" name="default_avatar">
                              <div  class="column is-9" >
                                <input type='submit' class="btn btn-sync" name="submit" value='Upload file'>
                              </div>
                            </div>

                            <div class="usersetting"></div>

                          </div>
                                <div class="sync-key2">

                                </div>
                                <form id="config-form" action="?page=cryptofr_comments_plugin" method="POST" >
                                  <label class="label-setting" for="cid">Default post category for the forum</label>
                                  <select class="optionalCid" id="cid">
                                    <?php
                                    echo "<option value=".$config->cid.">".$config->cid."</option>";
                                    foreach ($optionalCidsArray as $cid) {
                                      echo "<option value=".$cid->cid.">".$cid->cid."</option>";
                                    }
                                    ?>
                                  </select>
                                  <button class="btn btn-setting">Send</button>
                                </form>

                                <div class="settings-top">
                                  <form id="config-form-optional-cids" action="?page=cryptofr_comments_plugin" method="POST" >
                                    <label class="label-setting" for="cid">Delete optional category</label>
                                    <select class="optionalCid" id="selectedCid">
                                      <?php
                                				foreach ($optionalCidsArray as $cid) {
                                          echo "<option value=".$cid->cid.">".$cid->cid."</option>";
                                				}
                                			?>
                                		</select>
                                		<button type="button" class="btn btn-setting">Delete</button>
                                	</form>
                                </div>
                                <div class="settings-top">
                                  <form id="config-form-optional-cids-delete" action="?page=cryptofr_comments_plugin" method="POST">
                                		<label class="label-setting" for="optionalCid">Optional CategoryID</label>
                                		<input class="insertcategory" id="optionalCid" name="optionalCid" value="0">
                                		<button class="btn btn-setting">Insert</button>
                                	</form>
                                </div>
                          </div>
                        </div>
                    <div class="column-2 ">
                        <p></p>
                    </div>
                  </div>

                </div>
            </div>
        </div>

     <!--  </div> -->

    <div  class="column is-9">
        <button type="button" class="btn btn-sync">
            Save changes
        </button>
    </div>
  </div>
</div>
