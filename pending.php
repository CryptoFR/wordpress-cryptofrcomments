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
			<div class="column is-9">
				<ul class="nav nav-tabs">
				  <li class="nav-item">
				    <a class="nav-link active" href="#">Forum</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" href="#">Pending Syncs</a>
				  </li>
				</ul>
      </div>
			<div class="container-panel">
				<div id="forum-tab" class="column is-9">
					<div class="form-check">
					  <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
					  <label class="form-check-label" for="defaultCheck1">
							Automatically post all approved
								comments to the forum
					  </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
						<label class="form-check-label" for="defaultCheck1">
							Allow obtaining forum comments
						</label>
					</div>
				</div>
			</div>
			<div  class="column is-9">
				<button type="button" class="btn btn-sync">Save changes</button>
			</div>
		</div>
</div>
