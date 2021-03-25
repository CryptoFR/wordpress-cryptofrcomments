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
            <select id="categoryCommentss" class="category-comments">
              <option>Category</option>
              <?php
              echo "<option value=".$config->cid.">".$config->cid."</option>";
              foreach ($optionalCidsArray as $cid) {
                echo "<option value=".$cid->cid.">".$cid->cid."</option>";
              }
              ?>
            </select>
            <button type="button" onclick="selectCategoryId()" class="btn btn-setting">Send</button>
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
  <style>
  .buttonViewOrange{
    position: relative;
    left: 39em;
    top: -36px;
    padding: 10px;
    border: #FC4850;
    background: #FE9532;
    background-repeat: no-repeat;
    background-position-x: center;
    background-position-y: center;
    border-radius: 11px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' class='bi bi-eye-slash' viewBox='0 0 16 16'%3E%3Cpath d='M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z'/%3E%3Cpath d='M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z'/%3E%3Cpath d='M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884l-12-12 .708-.708 12 12-.708.708z'/%3E%3C/svg%3E");
  }

  .buttonTrashRed{
    position: relative;
    left: 42em;
    top: -36px;
    padding: 10px;
    border: #FC4850;
    background-color: #FC4850;
    background-repeat: no-repeat;
    background-position-x: center;
    background-position-y: center;
    border-radius: 11px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' class='bi bi-trash' viewBox='0 0 16 16'%3E%3Cpath d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/%3E%3Cpath fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/%3E%3C/svg%3E");
    }
  </style>
<script>
    function clickButtonView(evt){
      let parent = evt.parentNode;

      if (evt.className === 'buttonview'){
        evt.className = "buttonViewOrange";
        parent.children[3].className = "buttonTrash";
      }
      else if (evt.className === 'buttonViewOrange' | evt.className === 'buttonviewGray'){
        evt.className = "buttonview";
        parent.children[3].className = "buttonTrash";
      }

      if (evt.className === 'buttonTrash'){
        evt.className = "buttonTrashRed";
        parent.children[4].className= "buttonviewGray";

      }
      else if (evt.className === 'buttonTrashRed'){
        evt.className = "buttonTrash";
        parent.children[4].className= "buttonview";
      }

    }
</script>
</body>
