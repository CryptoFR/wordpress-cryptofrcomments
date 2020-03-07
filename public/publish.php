<script type="text/javascript">
	var data={
		markdown: '<?php echo escaped_content($post->post_content); ?>',
		title: '<?php echo $post->post_title; ?>',
		cid: -1,
		blogger: '<?php echo the_author_meta( 'display_name' , $author_id ); ?>',
		tags: "",
		id: '<?php echo $post->ID; ?>',
		url: '<?php echo $post->guid; ?>',
		timestamp: Date.now(),
		uid: "",
		_csrf: ""
	}

	publish(data,'<?php echo $url; ?>');
</script>