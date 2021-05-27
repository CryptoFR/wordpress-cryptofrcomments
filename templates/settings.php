<?php
// define variables and set to empty values
$allow_guest = 1;
?>
<!-- <div class="arrow-left5"></div>
<div class="space5"></div> -->
<div class="container-back">
    <div class="container-medium" >

       <div>
            <div class="container-panel-settings">

                <div style="display:block">
                    <!--All content about tab forum is here se-->
                    <br>
                    <div class="row-moderation">
                    <form id="allow-guest" action="?page=cryptofr_comments_plugin" method="POST" enctype="multipart/form-data" >
                        <div class="column-2 ">
                          <div>

                        <input id="allow_guest" name="allow_guest" type="checkbox" value="1" />
                        <label for="allow_guest" id="round">Toggle</label>

                              <label  class="label-switch-forum" for="defaultCheck1">
                                Allow Guest Comments
                              </label>
                              <div  class="column is-9">
                            <!-- <input type='submit' class="btn btn-sc_settings" name="sc_settings" value='Save changes'> -->
                            </div>
                            <!-- </form> -->
                          </div>

                          <div>
                            <!-- <div class="gridsetting"> <!-- section with user image -->
                            <!-- <div class="settings-top"> -->
                            <form id="default-avatar-settings" action="?page=cryptofr_comments_plugin" method="POST" enctype="multipart/form-data">
                            <div class= "grid-settings" >
                              <div>
                                <label class="label-setting">Default avatar for guests</label>
                                <input type="file" class="default_avatar" name="default_avatar">
                                <div  class="column is-9" >
                                  <input type='submit' class="btn btn-sync" name="submit" value='Upload file'>
                                </div>

                              </div>
                              <div class="avatar-moderator">
                                <img class="avatar" src="<?php echo $img; ?>">
                              </div>

                            <!-- </div> -->
                            <!-- <div class="usersetting"></div> -->
                          </div>
                          </form>
                         </div>
                                <!-- <div class="sync-key2"></div> -->
                                <!-- <form id="config-form" action="?page=cryptofr_comments_plugin" method="POST" > -->
                                  <label class="label-setting" for="cid">Default post category for the forum</label>
                                  <select class="optionalCid" name="cid" id="selectSetting">
                                  </select>
                                  	<input type='submit' class="btn btn-setting" name="defaultCid" value='Send'>
                                <!-- </form> -->



                                <div class="settings-top">
                                  <!-- <form id="config-form-optional-cids" action="?page=cryptofr_comments_plugin" method="POST" > -->
                                    <label class="label-setting" for="cid">Delete optional category</label>
                                    <select class="optionalCid" name="selectedCid">
                                      <?php
                                				foreach ($optionalCidsArray as $cid) {
                                          echo "<option value=".$cid->cid.">".$cid->cid."</option>";
                                				}
                                			?>
                                		</select>
                                		<input type='submit' class="btn btn-setting" name="deleteCid" value='Delete'>
                                	<!-- </form> -->
                                </div>
                                <div class="settings-top">
                                  <!-- <form id="config-form-optional-cids-delete" action="?page=cryptofr_comments_plugin" method="POST"> -->
                                		<label class="label-setting" for="optionalCid">Optional CategoryID</label>
                                		<input class="insertcategory" id="optionalCid" name="optionalCid">
                                		<button class="btn btn-setting">Insert</button>
                                	<!-- </form> -->
                                </div>
                          </div>
                        </div>
                    <div class="column-2 ">
                        <p></p>
                    </div>
                  </div>

                </div>
            </div>
            <div  class="column is-9">
              <input type='submit' class="btn btn-sync" name="sc_settings" value='Save changes'>
            </div>
        </div>

     <!--  </div>-->


  <!-- End of the form -->
</form>
  </div>
</div>
