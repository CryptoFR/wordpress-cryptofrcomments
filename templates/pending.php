
<body>
    <script>
        function openTab(evt, value) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab_content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("nav-link");
            for (i = 0; i < tabcontent.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(value).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>


<html>

    <div class="container-back">
        <div class="container-medium" >
            <!--Here is the begin of tabs forum and pendingSyncs-->
            <div  id="tabsModeration" class="column is-9">
                 <ul class="nav nav-tabs">
                     <li class="nav-item">
                         <a class="nav-link active" href="#pendingSyncs" onclick="openTab(event, 'forum')">
                            Forum
                         </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#forum" onclick="openTab(event, 'pendingSyncs')">
                            Pending syncs
                        </a>
                    </li>
                 </ul>
            </div><!--Here is the end of tab and forum pendingSyncs-->
           <div>
                <div class="container-panel-syn">

                    <div class="tab_content" id="pendingSyncs">
											<div class="form-check">
												<label class="label2">Posts</label>
													<button class="button-sync4"></button>
											</div>
												<div id="posts-container"></div>
												<div class="form-check">
												<label class="label2pending">Comments</label>
												<button class="button-sync5"></button>
											</div>
												<div id="comments-posts-container"></div>
												<button class="sync-all-buttom">Sync All</button>

                    </div>
                    <div class="tab_content" id="forum" style="display:block">
                        <!--All content about tab forum is here se-->
                        <br>
                        <div id="forum-division" class="row-moderation">
                            <div class="column-2 ">
                            <div>
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider round">
                                    </span>
                                </label>
																<label  class="label-switch-forum" for="defaultCheck1">
																	Automatically post all approved comments to the forum
																</label>
                            </div>
                            <br>
                            <div>
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider round">
                                    </span>
                                </label>
																<label  class="label-switch-forum" for="defaultCheck1">
																	 Allow obtaining forum comments
																 </label>
                            </div>
                            <br>
                            <div>
															<div class="sync-key">
                              <label class="label-sync">Sync key</label>
                                <input type="text" placeholder="Sync key" class="synckey">
															</div>
															<div class="sync-key2">
                                <p>
                                    You can run the Sync Wizard to add or remove categories that sync with the forum
                                </p>
															</div>
															<div  class="column is-9" >
			                                <button type="button" class="btn btn-sync">
			                                    Run Synchronization Wizard
			                                </button>
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
</html>
