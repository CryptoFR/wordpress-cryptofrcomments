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
     <script type="text/javascript">
                 var nodeBBURL = '<?php echo constant("NODEBB_URL"); ?>',
                     wordpressURL = '<?php echo get_site_url(); ?>',
                     articleID = '<?php echo the_ID(); ?>',
                     blogger = 'name', //OPTIONAL. Assign an blogger name to disdinguish different blogger. Omit it to fallback to 'default'
                     articleType = '<?php echo get_post_type() ?>',
                     categoryID = -1; // If -1, will use category in NodeBB ACP.  Put in a category number to force that category.

(function() {
    var jq = document.createElement('script'); 
    jq.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
    document.getElementsByTagName('head')[0].insertBefore(jq, document.getElementsByTagName('head')[0].firstChild);
    
    var nbb = document.createElement('script'); nbb.type = 'module'; nbb.async = true;
    nbb.src = nodeBBURL + '/plugins/nodebb-plugin-blog-comments-cryptofr/lib/main2.js';
    var nbb2 = document.createElement('script'); nbb2.type = 'module'; nbb2.async = true;
    nbb2.src = nodeBBURL + '/plugins/nodebb-plugin-blog-comments-cryptofr/lib/build.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(nbb);
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(nbb2);
})(); 
        function onSubmit(token) {
         document.getElementById("demo-form").submit();
        } 

</script>
<noscript>Please enable JavaScript to view comments</noscript> 


<!-- 
<div id="nodebb"></div> 

<script src="https://testforum.cryptofr.com/plugins/nodebb-plugin-cryptofr-commenting/nodebb.js" blogURL ='https://testblog.cryptofr.com' categoryID ="-1" articleID = '1' nodeBBURL = 'https://testforum.cryptofr.com' blogger="name"></script> 
-->