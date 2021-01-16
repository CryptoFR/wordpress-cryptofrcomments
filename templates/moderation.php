
<div class="container-back">
    <div class="container-medium" >
			<div  id="tabsModeration" class="column is-9">
				<ul class="nav nav-tabs">
				  <li class="nav-item">
				    <a class="nav-link active" href="#tabComments" onclick="openTab(event,'tabComments')">Comments</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" href="#tabRules" onclick="openTab(event, 'tabRules')">Rules</a>
				  </li>
				</ul>
      </div>
			<div class="container-panel">

        <div class="tab_content" id="tabComments">
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
                   <label class="label1" for="defaultCheck1">
                     Accept all comments except spam
                   </label>
                 </div>
                 <div class="form-check">
                   <label class="switch">
                     <input type="checkbox">
                     <span class="slider round"></span>
                   </label>
                   <label class="label1" for="defaultCheck1">
                     Moderate all guest comments
                   </label>
                 </div>
                 <div class="form-check">
                   <label class="switch">
                     <input type="checkbox">
                     <span class="slider round"></span>
                   </label>
                   <label class="label1" for="defaultCheck1">
                     Use keywords control
                   </label>
                 </div>
                 <div>
                   <label class="label1">Censored keywords</label>
                   <input type="text" class="censored"></input>
                 </div>

                 <div class="col-sm-10">
                   <div class="rules-margin">
                     <label class="label2"> Case matching </label>
                   </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                      <label class="label1" for="gridRadios1">
                        Case sensitive
                      </label>
                    </div>
                    <div class="form-check">
                     <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                     <label class="label1" for="gridRadios2">
                       Case insesitive
                     </label>
                     <spam>(recommended)</spam>
                   </div>
               </div>

               <div class="col-sm-10">
                 <div class="rules-margin">
                   <label class="label2"> Word rendering </label>
                 </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                    <label class="label1" for="gridRadios1">
                      First letter retained
                    </label>
                  </div>
                  <div class="form-check">
                   <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                   <label class="label1" for="gridRadios2">
                     All letters removed
                   </label>
                   <spam>(recommended)</spam>
                 </div>
                 <div class="form-check">
                  <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                  <label class="label1" for="gridRadios2">
                    First/Last letter contained
                  </label>
                  <spam>(recommended)</spam>
                </div>
             </div>
             <div class="col-sm-10">
             <div class="rules-margin">
               <label class="label2"> Filter character </label>
             </div>
           </div>
           </div>
          </div>
          <div class="column-2">
               <p> esto es una  prueba  </p>
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
    var i, tabcontent, tablinks;
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
