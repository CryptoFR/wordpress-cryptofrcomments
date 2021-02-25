
 <div class="container-panel-rules">
  <div class="row-moderation">
    <div class="column-2">
        <div id="forum-tab" class="column is-9">
          <div class="form-check">
            <label class="switch">
              <input type="checkbox">
              <span class="slider round"></span>
            </label>
            <label class="label-switch-forum" for="defaultCheck1">
              Accept all comments except spam
            </label>
          </div> <!-- form-check -->
          <div class="form-check switch-margin">
            <label class="switch">
              <input type="checkbox">
              <span class="slider round"></span>
            </label>
            <label class="label-switch-forum" for="defaultCheck1">
              Moderate all guest comments
            </label>
          </div>  <!--form-check switch-margin -->
          <div class="form-check switch-margin">
            <label class="switch">
              <input type="checkbox">
              <span class="slider round"></span>
            </label>
            <label class="label-switch-forum" for="defaultCheck1">
              Use keywords control
            </label>
          </div> <!--form-check switch-margin -->

          <div class="switch-margin">
            <label class="label-censored">Censored keywords</label>
          </div>  <!--switch-margin -->
          <div class="button_plus">
            <input id="text_censored" type="text" class="censored"></input>
             <a class="censored" href="#add_tag" onclick="add_tag()">
               <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                 <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
               </svg>
             </a>
           </div> <!--button_plus-->
          <div class="rules-margin" id="tags"></div>

        </div> <!--forum-tab -->

          <div class="col-sm-10">
            <div class="rules-margin">
              <label class="label2"> Case matching </label>
            </div> <!--rules-margin -->
             <div class="form-check">
               <div class="radio">
                 <label class="labelradio"><input class="radio-case" type="radio" name="radioCase" checked>Case sensitive</label>
               </div> <!-- radio -->
               <div class="radio">
                 <label class="labelradio" ><input  class="radio-case" type="radio" name="radioCase">Case insesitive</label>
                 <spam class="recommended">(recommended)</spam>
               </div> <!-- radio -->

            </div> <!-- form-check -->

          </div> <!-- col-sm-10 -->

        <div class="col-sm-12">
          <div class="rules-margin">
            <label class="label2"> Word rendering </label>
          </div> <!-- rules-margin -->
          <div class="radio">
            <label class="labelradio"><input class="radio-case" type="radio" name="radioWord" checked>First letter retained</label>
            <spam class="recommended">(dog=> d**)</spam>
          </div> <!-- radio -->
          <div class="radio">
            <label class="labelradio" ><input  class="radio-case" type="radio" name="radioWord">All letters removed</label>
            <spam class="recommended">(dog=> ***)</spam>
          </div>  <!-- radio -->
          <div class="radio">
            <label class="labelradio" ><input  class="radio-case" type="radio" name="radioWord">First/Last letter contained</label>
            <spam class="recommended">(dog => d*g)</spam>
          </div>  <!-- radio -->
        </div> <!-- col-sm-12 -->
      <div class="col-sm-10">
        <div class="rules-margin">
          <label class="label2"> Filter character </label>
        </div> <!--  rules-margin -->
      </div> <!-- col-sm-10 -->
      <div class="col-sm-10">
        <select id="category-comments" class="category-comments">
            <option value="">*</option>
        </select>
      </div> <!--class col-sm-10 -->
 </div> <!-- column-2 -->
       <div class="column-3">
         <div class="exp-rules1">
            <p class="exp-rules2"> When activated, all comments will be
              accepted automatically except those that
               contain a prohibited keyword.
               If it is desactivated, all comments must base
               moderated manually.
             </p>
         </div> <!--exp-rules1 -->

         <div class="exp-rules3">
           <p class="exp-rules2"> 'Case insesitive' matching type  is better as it
                capturess more words.
               </p>
         </div> <!--exp-rules3 -->

         <div class="exp-rules4">
              <p class="exp-rules2"> You can accepted comments with forbidden
                words by replacing them totally or partially
                with a especial character.
               </p>
           </div> <!--exp-rules4 -->
       </div>  <!--class column-2 -->


  </div> <!-- row-moderation -->
 </div> <!-- container-panel-rules -->
