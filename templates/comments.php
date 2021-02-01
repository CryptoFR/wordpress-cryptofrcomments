<!-- <div class="article-table-container allcomments">
    <h2>All Comments</h2>
  <table id="grid" class="table table-striped table-bordered dt-responsive nowrap">
  </table>
</div> -->

<div class="container-back">
      <div class="container-back" >
      <div class="column is-9">
        <div class="comments-margin">
        <select id="category-comments" class="category-comments">
            <option value="">Category</option>
        </select>
        <!-- <input type="text" class="search-comment" placeholder='Search'> -->
      </div>
      </div>
      <div class="column is-9">
          <table id="articles" class="table table-striped table-bordered" width="100%"></table>
          <!--All these element are for Modal-->
          <div class="modal" tabindex="-1" role="dialog" id="ModalComments">
           <div class="modal-dialog" role="document">
             <div class="modal-content" id="modalcontent">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <label id="ModalCommentTitle" class="blog-name"></label>
               </div>
               <div class="modal-body" id="ModalCommentContent">
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-modal">next</button>
               </div>
             </div><!-- /.modal-content -->
           </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
           <!--End of elements for modl-->
      </div>
    </div>

</div>
