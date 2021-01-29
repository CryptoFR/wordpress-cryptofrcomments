<head>
  <title>CreacionSubstitucion...</title>
  <style>
    .tag_censored{
    color: #434a81;
    background: #8080802b;
    text-align: center;
    font-size: 15px;
    font-weight: 100;
    border-radius: 5px;
    font-family: sans-serif;
    padding: 5px;
    margin-right: 10px;
    }
  </style>
  <script>
    function add_tag(){

      let label_tag=document.createElement("label");
      let texto=document.createTextNode(document.getElementById("text_censored").value);

      label_tag.appendChild(texto);
      label_tag.setAttribute("class","tag_censored");

      let cont=document.getElementById("tags");

      let closetag=document.createElement("button");
      closetag.setAttribute("class","close");
      label_tag.appendChild(closetag);
      cont.appendChild(label_tag);

      $(document).on('click', '.tag_censored', function (event) {
        event.currentTarget.style.display = "none";
      });
    }
  </script>
</head>

<div class="container-back">
    <div class="container-medium" >
			<div  id="tabsModeration" class="column is-9">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#comments">Comments</a></li>
          <li><a data-toggle="tab" href="#rules">Rules</a></li>
        </ul>
      </div>
			<div class="container-panel">

        <div class="tab-pane fade in active" id="comments" style="display:block">

       </div>

       <div class="tab-pane fade" id="rules">
         <div class="row-moderation">
           <div class="column-2">
               <div id="forum-tab" class="column is-9">
                 <div class="form-check">
                   <label class="switch">
                     <input type="checkbox">
                     <span class="slider round"></span>
                   </label>
                   <label class="label-switch-rules" for="defaultCheck1">
                     Accept all comments except spam
                   </label>
                 </div>
                 <div class="form-check switch-margin">
                   <label class="switch">
                     <input type="checkbox">
                     <span class="slider round"></span>
                   </label>
                   <label class="label-switch-rules" for="defaultCheck1">
                     Moderate all guest comments
                   </label>
                 </div>
                 <div class="form-check switch-margin">
                   <label class="switch">
                     <input type="checkbox">
                     <span class="slider round"></span>
                   </label>
                   <label class="label-switch-rules" for="defaultCheck1">
                     Use keywords control
                   </label>
                 </div>
                 <div class="switch-margin">
                   <label class="label-censored">Censored keywords</label>
                   <input id="text_censored" type="text" class="censored"></input>
                   <div class="button_plus">
                    <a class="censored" href="#add_tag" onclick="add_tag()">
                      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                      </svg>
                    </a>
                  </div>

                    <div class="rules-margin" id="tags"></div>


                 </div>

                 <div class="col-sm-10">
                   <div class="rules-margin">
                     <label class="label2"> Case matching </label>
                   </div>
                    <div class="form-check">
                      <div class="radio">
                        <label class="labelradio"><input class="radio-case" type="radio" name="radioCase" checked>Case sensitive</label>
                      </div>
                      <div class="radio">
                        <label class="labelradio" ><input  class="radio-case" type="radio" name="radioCase">Case insesitive</label>
                        <spam class="recommended">(recommended)</spam>
                      </div>

                   </div>
               </div>

               <div class="col-sm-12">
                 <div class="rules-margin">
                   <label class="label2"> Word rendering </label>
                 </div>
                 <div class="radio">
                   <label class="labelradio"><input class="radio-case" type="radio" name="radioWord" checked>First letter retained</label>
                   <spam class="recommended">(dog=> d**)</spam>
                 </div>
                 <div class="radio">
                   <label class="labelradio" ><input  class="radio-case" type="radio" name="radioWord">All letters removed</label>
                   <spam class="recommended">(dog=> ***)</spam>
                 </div>
                 <div class="radio">
                   <label class="labelradio" ><input  class="radio-case" type="radio" name="radioWord">First/Last letter contained</label>
                   <spam class="recommended">(dog => d*g)</spam>
                 </div>
             </div>
             <div class="col-sm-10">
               <div class="rules-margin">
                 <label class="label2"> Filter character </label>
               </div>
           </div>
           <div class="col-sm-10">
             <select id="category-comments" class="category-comments">
                 <option value="">*</option>
             </select>
         </div>
           </div>
          </div>
          <div class="column-2">
            <div class="exp-rules1">
               <p class="exp-rules2"> When activated, all comments will be
                 accepted automatically except those that
                  contain a prohibited keyword.
                  If it is desactivated, all comments must base
                  moderated manually.
                </p>
              </div>

              <div class="exp-rules3">
                 <p class="exp-rules2"> 'Case insesitive' matching type  is better as it
                   capturess more words.
                  </p>
              </div>

              <div class="exp-rules4">
                 <p class="exp-rules2"> You can accepted comments with forbidden
                   words by replacing them totally or partially
                   with a especial character.
                  </p>
              </div>

          </div>
        </div>
      </div>
      </div>
        <div  class="column is-9">
          <button type="button" class="btn btn-sync">Save changes</button>
        </div>
  </div>
</div>
