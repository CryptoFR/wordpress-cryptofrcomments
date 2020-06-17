// POST REQUEST
function newFetch(path, data ={}) {
    var encodedString = "";
    for (var prop in data) {
      if (data.hasOwnProperty(prop)) {
        if (encodedString.length > 0) {
          encodedString += "&";
        }
        encodedString +=
          encodeURIComponent(prop) + "=" + encodeURIComponent(data[prop]);
      }
    }
    return fetch(path, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      credentials: 'include',
      body: encodedString
    })
  }


// GET REQUEST
function newFetchGet(path) { 
    return fetch(path, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        credentials: 'include'
    })
} 

function encodedstring2(data) {    
  let str = '?';    
  for(let i = 0; i < data.length; i++) {       
    str += `query[${i}][blogger]=${encodeURIComponent(data[i].blogger)}&query[${i}][id]=${encodeURIComponent(data[i].id)}`       
    if (i + 1 < data.length) {          
      str +="&"       
    }    

  } 
  return str;
}

/*
http://localhost:4567/comments/post-count?query[0][blogger]=admin&query[0][id]=140&query[1][blogger]=admin&query[1][id]=131
*/ 


  function commentsCounter(NODEBB_URL,BLOG_URL){

    (async () =>{

      let paramsArray=[];


      if (document.querySelector('article.post')){
        const promises = [];


        console.log(document.querySelectorAll('article.post'));

        for (let article of document.querySelectorAll('article.post')){
          let id=article.getAttribute('id').split('-')[1];
          let blogger='';
          promises.push(newFetchGet(BLOG_URL+ "/wp-json/cryptofr-comments/getbloggerbypostid/"+id)
            .then(res => res.json())
            .then(function(res){
              blogger=res.blogger;

              paramsArray.push({id: id, blogger: blogger})
            }));
              
        }
       await Promise.all(promises);

       let encodedstring=encodedstring2(paramsArray);

       console.log('URL ENDPOINT->',NODEBB_URL+ "/comments/post-count"+encodedstring)
       // Aqui el resto de lo que vayas a hacer
        newFetchGet(NODEBB_URL+ "/comments/post-count"+encodedstring)
          .then(res => res.json())
          .then(function(res){
            console.log('res',res)
             
     
          });

      }
     
    })();

  }
