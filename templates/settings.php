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
                              <label class="switch">
                                  <input type="checkbox">
                                  <span class="slider round">
                                  </span>
                              </label>
                              <label  class="label-switch-forum" for="defaultCheck1">
                                Allow Guest Comments
                              </label>
                          </div>

                          <div>
                            <div class="gridsetting"> <!-- section with user image -->
                            <div class="settings-top">
                            <label class="label-setting">Default avatar for guests</label>

                              <input type="file" id="labelsetting">
                              <div  class="column is-9" >
                                      <button type="button" class="btn btn-sync">
                                          Upload file
                                      </button>
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
