<?php 

function escaped_content($content){
    $content=str_replace("\n", "", $content);
    $content=str_replace("<!-- wp:paragraph -->", "", $content);
    $content=str_replace("<!-- /wp:paragraph -->", "", $content);
    return $content;
}  

?>
