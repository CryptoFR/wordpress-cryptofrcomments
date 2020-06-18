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

        newFetchGet(NODEBB_URL+ "/comments/post-count"+encodedstring)
          .then(res => res.json())
          .then(function(res){
            console.log('res commentsCounter',res)

            for (let counter of res){
              let article=document.querySelector('#post-'+counter.articleID)
              let counterSpan=document.createElement('span');
              counterSpan.classList.add('nodebb-comment-counter')
              let commentCount=counter.count===-1 ? 0: counter.count;
              counterSpan.innerHTML="<a href='?p="+counter.articleID+"'>Comments "+(commentCount-1)+"</a>"
              article.append(counterSpan)
            } 
     
          });

      }
     
    })();

  }
