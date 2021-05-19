<!-- <div class="space1"></div> -->
  <div class="container-panel-rules">
    <label class="label2">There are new comments pending moderation in 3 entries</label>
  <table id="table_moderation" class="table table-striped table-bordered" width="100%"></table>
  <!--All these element are for Modal-->
  <div class="modal" tabindex="-1" role="dialog" id="ModalModeration">
   <div class="modal-dialog" role="document">
     <div class="modal-content" id="modalcontentmod">
       <div class="modal-header">
         <button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <label  class="blog-name"></label>
       </div>
       <div class="modal-body">
       </div>
       <div id="modalFooterModeration" class="modal-footer">
        <div class="paginationdiv">
         <button class='buttonsnextprev' onclick='previousPage()'><</button>
       </div>
         <!-- <div id="wrapper" class="paginationdiv"></div> -->
           <div  class="paginationdiv">
             <button class='buttonsnextprev' onclick='nextPage()'>></button>
           </div>
       </div>
     </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
   <!--End of elements for modl-->
  </div>
