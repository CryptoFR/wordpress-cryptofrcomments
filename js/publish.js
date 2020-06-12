
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

 


function publish(data,nodeBBURL,publishURL,publishPHP,manualButton=null){ 

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

