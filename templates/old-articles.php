
<div class="container old-articles">
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
						<th class="article-status">Status</th>
						<th class="article-error">Error</th>
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
</div>