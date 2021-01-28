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

// Encode and array with blogger id and article id for each article
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
 

  // Get the articles ID from the front and display a counter of its comments
  function commentsCounter(NODEBB_URL,BLOG_URL){

    (async () =>{
      
      if (!document.querySelector('article.post')) return false;

      let paramsArray=[];


      const promises = []; 

      // get each article blogger id from the ones displayed on front
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

     // Get the comments counter from the articles and display its counter;
      newFetchGet(NODEBB_URL+ "/comments/post-count"+encodedstring)
        .then(res => res.json())
        .then(function(res){
          console.log('res commentsCounter',res)

          for (let counter of res){
            let article=document.querySelector('#post-'+counter.articleID)
            let counterSpan=document.createElement('span');
            counterSpan.classList.add('nodebb-comment-counter')
            let commentCount=counter.count-1 <=0 ?0 : counter.count-1 ;
            counterSpan.innerHTML="<a href='/?p="+counter.articleID+"'>"+commentCount+" Comments</a>"
            article.append(counterSpan)
          } 
   
        });

    })();

  }
