
<div class="container-back">
    <div class="container-medium" >
			<div  id="tabsModeration" class="column is-9">
				<ul class="nav nav-tabs">
				  <li class="nav-item">
				    <a class="nav-link" href="#tabComments" onclick="openTab(event, 'tabRules')">>Comments</a>
				  </li><!--adentro de la funcion opentab-->
				  <li class="nav-item">
				    <a class="nav-link" href="#tabRules" onclick="openTab(event, 'tabComments')">Rules</a>
				  </li>
				</ul>
      </div>
			<div class="container-panel">
        <div class="tab_content" id="tabComments">
       <p>Tabla de comentarios</p>
   </div>
   <div class="tab_content" id="tabRules">
     <div id="forum-tab" class="column is-9">
       <div class="form-check">
         <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
         <label class="label1" for="defaultCheck1">
           Accept all comments except spam
         </label>
       </div>
       <div class="form-check">
         <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
         <label class="label1" for="defaultCheck1">
           Moderate all guest comments
         </label>
       </div>
       <div class="form-check">
         <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
         <label class="label1" for="defaultCheck1">
           Use keywords control
         </label>
       </div>
     </div>
			</div>
			<div  class="column is-9">
				<button type="button" class="btn btn-sync">Save changes</button>
			</div>
		</div>
</div>

<script>
function openTab(evt, valor) {
  console.log(valor);
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab_content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        console.log(tabcontent[i]);
    }
    tablinks = document.getElementsByClassName("nav-link");
    for (i = 0; i < tabcontent.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
        console.log(tablinks[i]);
    }
    document.getElementById(valor).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
