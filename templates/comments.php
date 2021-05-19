<!-- <div class="arrow-left2"></div>
<div class="space2"></div> -->
<!-- <div class="article-table-container allcomments">
    <h2>All Comments</h2>
  <table id="grid" class="table table-striped table-bordered dt-responsive nowrap">
  </table>
</div> -->

<div class="container-back">
      <div class="container-comment" >
      <div class="column is-9">
        <div class="comments-margin">
          <form>
            <select id="categoryCommentss" class="category-comments" onchange="selectCategoryId()">
              <option>Category</option>
              <?php
              echo "<option value=".$config->cid.">".$config->cid."</option>";
              foreach ($optionalCidsArray as $cid) {
                echo "<option value=".$cid->cid.">".$cid->cid."</option>";
              }
              ?>
            </select>
            <!-- <button type="button" onclick="selectCategoryId()" class="btn btn-setting">Send</button> -->
      </form>

        <!-- <input type="text" class="search-comment" placeholder='Search'> -->
      </div>
      </div>
      <div id="div_articles" class="column is-9">
          <table id="articles" class="table table-striped table-bordered" width="100%"></table>
          <!--All these element are for Modal-->
          <div class="modal" tabindex="-1" role="dialog" id="ModalComments">
           <div class="modal-dialog" role="document">
             <div class="modal-content" id="modalcontent">
               <div class="modal-header">
                 <button id="buttonCloseModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <label id="ModalCommentTitle" class="blog-name"></label>
               </div>
               <div class="modal-body" id="ModalCommentContent">
               </div>
               <div id="modalFooterComments" class="modal-footer">
                <div class="paginationdiv">
                 <button class='buttonsnextprev' onclick='previousPage()'><</button>
               </div>
                 <div id="wrapper" class="paginationdiv"></div>
                   <div  class="paginationdiv">
                     <button class='buttonsnextprev' onclick='nextPage()'>></button>
                   </div>
               </div>
             </div><!-- /.modal-content -->
           </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
           <!--End of elements for modl-->
      </div>
    </div>

</div>

<body>

<script>
    function clickButtonView(evt){
      let parent = evt.parentNode;

      if (evt.className === 'buttonview'){
        evt.className = "buttonViewOrange";
        console.log(parent.children);
        parent.children[5].className = "buttonTrash";
        parent.children[6].className = "buttonWarning";
      }
      else if (evt.className === 'buttonViewOrange' | evt.className === 'buttonviewGray'){
        evt.className = "buttonview";
        parent.children[5].className = "buttonTrash";
        parent.children[6].className = "buttonWarning";
      }

      if (evt.className === 'buttonTrash'){
        console.log(parent.children);
        evt.className = "buttonTrashRed";
        parent.children[4].className= "buttonviewGray";
        parent.children[6].className = "buttonWarning";

      }
      else if (evt.className === 'buttonTrashRed'){
        console.log(parent.children);
        evt.className = "buttonTrash";
        parent.children[4].className= "buttonview";
        parent.children[6].className = "buttonWarning";

      }

      if (evt.className === 'buttonWarning'){
        console.log(parent.children);
        evt.className = "buttonWarningOrange";
        parent.children[4].className= "buttonviewGray";
        parent.children[5].className = "buttonTrash";

      }

    }

    function clickReadMore(evt){
      if( evt.value === "Read Less" ){
        evt.value="Read More";
        var parent = event.target.parentElement;
        var child = parent.getElementsByClassName('comment-user2')[0];
        child.className = "comment-user";
      }
      else{
        evt.value="Read Less";
        var parent = event.target.parentElement;
        var child = parent.getElementsByClassName('comment-user')[0];
        child.className = "comment-user2";
      }
    }

</script>
</body>
