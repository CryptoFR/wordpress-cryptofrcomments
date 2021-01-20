
<div class="container-back">
    <div class="container-medium" >
			<div  id="tabsModeration" class="column is-9">
				<ul class="nav nav-tabs">
				  <li class="nav-item">
				    <a class="nav-link  active" href="#tabComments" onclick="openTab(event,'tabComments')">Comments</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" href="#tabRules" onclick="openTab(event, 'tabRules')">Rules</a>
				  </li>
				</ul>
      </div>
			<div class="container-panel">

        <div class="tab_content" id="tabComments" style="display:block">
           <p>Table</p>
       </div>

       <div class="tab_content" id="tabRules">
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
                   <input type="text" class="censored"></input>
                    <a class="censored" href="#">
                      <span class="glyphicon glyphicon-plus-sign"></span>
                    </a>
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

               <div class="col-sm-10">
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
               <select>*</select>
             </div>
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


<script>
function openTab(evt, value) {
    let i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab_content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("nav-link");
    for (i = 0; i < tabcontent.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(value).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
