<head>
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

    .tag_close{
      float: right;
      padding: 7px;
      border: transparent;
      margin-left: 1.1px;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='%23434a81' class='bi bi-x-circle-fill' viewBox='0 0 16 16'%3E%3Cpath d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z'/%3E%3C/svg%3E");
    }
  </style>

  <script>
    function add_tag(){

      let label_tag=document.createElement("label");
      let texto=document.createTextNode(document.getElementById("text_censored").value);
      let tag_array=document.createElement("label");
      tag_array.setAttribute("name","tag_array");
        if(texto.length != 0){
          label_tag.appendChild(texto);
          label_tag.setAttribute("class","tag_censored");
          let cont=document.getElementById("tags");
          let close_tag=document.createElement("button");
          close_tag.setAttribute("class","tag_close");
          label_tag.appendChild(close_tag);
          cont.appendChild(label_tag);
          let input_censored= document.getElementById("text_censored");
          input_censored.value='';
          $(document).on('click', '.tag_censored', function (event) {
            event.currentTarget.style.display = "none";
          });

          tag_array= document.getElementsByClassName("tag_censored");
          let tags= [];
          for (let i=0 ; i< tag_array.length;i++){
            tags.push(tag_array[i].innerText);
          }
          let prueba = document.createElement("content");
          prueba.setAttribute("name","tag");
          prueba.setAttribute("values",tags);
      }
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
      <div class="tab-content" id="tab_content_moderation">
        <div id="comments" class="tab-pane fade in active">
          <?php
          include (PLUGIN_PATH."/templates/comments_moderation.php");
           ?>
        </div>

        <div id="rules" class="tab-pane fade ">
          <?php
          include (PLUGIN_PATH."/templates/rules_moderation.php");
           ?>
        </div>
      </div>

  </div> <!-- container-medium -->
</div> <!-- container-back -->
