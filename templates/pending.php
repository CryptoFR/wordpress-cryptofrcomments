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

<div class="container-back">
    <div class="container-medium" >
			<div id="tabSync" class="column is-9">
				<ul class="nav nav-tabs">
				  <li class="nav-item">
				    <a class="nav-link active" href="#tabForum" onclick="openTab(event,'tabForum')">Forum</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" href="#tabPending"  onclick="openTab(event,'tabPending')">Pending Syncs</a>
				  </li>
				</ul>
      </div>
			<div class="container-panel">
				<div id="tabForum" class="tab_content">
					<div class="custom-control custom-switch">
						<label class="switch">
						  <input type="checkbox">
						  <span class="slider round"></span>
						</label>
						<label class="label1" for="defaultCheck1">
							Automatically post all approved
								comments to the forum
					  </label>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
						<label class="label1" for="defaultCheck1">
							Allow obtaining forum comments
						</label>
					</div>
				</div>
				<div id="tabPending" class="tab_content">
					<p> Pending Section</p>
				</div>
			</div>
			<div  class="column is-9">
				<button type="button" class="btn btn-sync">Save changes</button>
			</div>
		</div>
</div>

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
