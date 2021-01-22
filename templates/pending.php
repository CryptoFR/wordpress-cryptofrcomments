<!-- <div class="container marked-articles">
	<table id="marked-articles-table" class="table table-striped table-bordered dt-responsive nowrap">
		<thead>
			<tr>
				<th class="article-title">Article Title</th>
				<th class="article-date">Date</th>
				<th class="article-status">Status</th>
				<th class="article-error">Error</th>
				<th class="article-actions">Actions</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>

</div> -->
<!-- <div class="container old-articles">
	<?php
		if (count($oldArticlesArray)>0){
			echo '<p>';
	 		echo "You have  ".count($oldArticlesArray)." Old Articles that aren't published on the forum since  ".$oldArticlesArray[0]->post_date.".<br>";
			echo '<button id="publish-old-articles">Publish Old Articles</button>';
			echo '<br/>';
			echo '<button id="attach-old-articles">Attach Old Articles</button>';
			echo '</p>'
			?>
			<br/>
			<table id="conflicted-articles-table" class="table table-striped table-bordered dt-responsive nowrap">
				<thead>
					<tr>
						<th class="article-title">Article Title</th>
						<th class="article-date">Date</th>
						 <!-- <th class="article-status">Status</th>
						<th class="article-error">Error</th> -->
						<th class="article-actions">Actions</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>

			<?php
		}else{
			echo "<p>You have no Old Articles to publish.</p>";
		}
	?>
	<button id='export-comments'>Export Comments</button>
</div> -->
<body>
    <script>
        function openTab(evt, value) {
					console.log('entro en openTab Pending');
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
                <div class="container-panel">

                    <div class="tab_content" id="pendingSyncs">
                        <p>
                        PendingSyncs
                        </p>
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
