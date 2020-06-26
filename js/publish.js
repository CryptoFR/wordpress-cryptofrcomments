
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

  // function encodedstring2(data) {    
  //   let str = '';
  //   str="cid="+data.cid+"&";    

  //   for(let i = 0; i < data.length; i++) {       
  //     str += `query[${i}][blogger]=${encodeURIComponent(data[i].blogger)}&query[${i}][id]=${encodeURIComponent(data[i].id)}`       
  //     if (i + 1 < data.length) {          
  //       str +="&"       
  //     }    

  //   } 
  //   return str;
  // }



  // POST REQUEST without encoding
  function newFetch2(path,data) {  
		return fetch(path, {
			method: 'POST',
			headers:{
				'Content-Type': 'application/json'
			  },
			credentials: 'include',
			body: JSON.stringify(data) 
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

 


function publish(data,nodeBBURL,publishURL,publishPHP,manualButton=null){ 


	data.markdown=data.markdown + "\n <b>Click <a href='"+data.url+"'>here</a> to see the full blog post</b>";
	
	console.log(data)

	// GET Request to get csrf Token
	newFetchGet(nodeBBURL+"/comments/token/")
	.then(res => {
		  status = res.status
		  return res
		})
	.then(res => res.json())
	.then(function(res){

		data._csrf=res.token;
		data.uid=res.uid; 

		newFetch(publishURL,data)
		.then(res => {
			  status = res.status
			  return res
			})
		.then(res => res.json())
		.then(function(res){

			console.log('status',status)
			console.log('res',res)

			if (status=='403'){
				status="Pending"
			}else{
				status="Published"
			}

			id=data.id;

			data={};
			data.status=status;
			data.id=id;

			console.log(publishPHP);

			newFetch(publishPHP,data)
			.then(function(){
				if (manualButton) {
					alert('Article has been manually Published to forum');
					location.reload();
				}
			})

		})

	}); 
}



function publishOldArticles(data,nodeBBURL,publishURL,publishPHP){ 
	
	console.log('data', data)
  
	newFetchGet(nodeBBURL+"/comments/token/")
	.then(res => {
		  status = res.status
		  return res
		})
	.then(res => res.json())
	.then(function(res){

		data._csrf=res.token;
		data.uid=res.uid; 

		newFetch2(publishURL,data)
		.then(res => {
			  status = res.status
			  return res
			})
		.then(res => res.json())
		.then(function(res){
 
			if (status!='200'){
				alert('Error publishing Old Articles to the Forum. Try Again Later');
				console.log(res);
				return;
			}

 
			newFetch2(publishPHP,res.ids)
			.then(res => res.json()) 
			.then(function(res){
				console.log(res) 
				if (res!=false){
					alert('Old Articles has been manually Published to the forum');
					location.reload();
				}else {
					alert('Error updating Wordpress Database');
				}
			})


		});

	});
}