<?php
/**
 * Markup which will replace the WordPress comments section on a given page.
 *
 * @link       https://cryptofr.com
 * @since      1.0
 *
 * @package    wordpress-cryptofrcomments
 * @subpackage wordpress-cryptofrcomments/public
 */

?>

<?php
if ( post_password_required() )
    return;  
?>

<a id="nodebb-comments"></a> 


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="<?php echo constant("NODEBB_URL"); ?>/plugins/nodebb-plugin-blog-comments-cryptofr/css/fontawesome/js/all.js"></script>
<script src="<?php echo constant("NODEBB_URL"); ?>/plugins/nodebb-plugin-blog-comments-cryptofr/js/config.js"></script>
<script src="<?php echo constant("NODEBB_URL"); ?>/plugins/nodebb-plugin-blog-comments-cryptofr/js/util.js"></script>
<script src="<?php echo constant("NODEBB_URL"); ?>/plugins/nodebb-plugin-blog-comments-cryptofr/js/jquery.emojiarea.js"></script>
<script src="<?php echo constant("NODEBB_URL"); ?>/plugins/nodebb-plugin-blog-comments-cryptofr/js/emoji-picker.js"></script>
<script src="<?php echo constant("NODEBB_URL"); ?>/plugins/nodebb-plugin-blog-comments-cryptofr/js/emoji-button-3.0.1.min.js"></script>

<script type="text/javascript">
    console.log('cargado')
    var nodeBBURL = '<?php echo constant("NODEBB_URL"); ?>', 
    wordpressURL = '<?php echo get_site_url(); ?>',
    // articleID = '1',
    articleID = '<?php echo the_ID(); ?>',
    blogger = '<?php echo get_the_author(); ?>', //OPTIONAL. Assign an blogger name to disdinguish different blogger. Omit it to fallback to 'default'
    articleType = '<?php echo get_post_type(); ?>',
    articleTitle = '<?php echo the_title_attribute(); ?>',
    content = "<?php echo escaped_content(get_the_content()); ?>",
    categoryID = -1; // If -1, will use category in NodeBB ACP.  Put in a category number to force that category.


    (function() { 
        var nbb = document.createElement('script'); nbb.async = true;
        nbb.src = nodeBBURL + '/plugins/nodebb-plugin-blog-comments-cryptofr/lib/main.js';
        // var nbb2 = document.createElement('script'); nbb2.type = 'module'; nbb2.async = true;
        // nbb2.src = nodeBBURL + '/plugins/nodebb-plugin-blog-comments-cryptofr/lib/build.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(nbb);
        // (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(nbb2);
    })();  

</script>
<noscript>Please enable JavaScript to view comments</noscript> 

 