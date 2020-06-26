
<div class="container old-articles">
	<p>
	<?php
		if (count($oldArticlesArray)>0){
	 		echo "You have  ".count($oldArticlesArray)." Old Articles that aren't published on the forum since  ".$oldArticlesArray[0]->post_date.".<br>";
			echo '<button id="publish-old-articles">Publish Old Articles</button>'; 
		}else{
			echo "You have no Old Articles to publish.";
		}
	?>  
	 </p> 
</div>