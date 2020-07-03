
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

	// GET Request to get csrf Token and UID of the CryptoFR forum
	newFetchGet(nodeBBURL+"/comments/token/")
	.then(res => {
		  status = res.status
		  return res
		})
	.then(res => res.json())
	.then(function(res){

		data._csrf=res.token;
		data.uid=res.uid; 

		// Publish the article to CryptoFR Forum
		newFetch(publishURL,data)
		.then(res => {
			  status = res.status
			  return res
			})
		.then(res => res.json())
		.then(function(res){

			console.log('status',status)
			console.log('res',res)

			if (status=='403'){ // Not published correctly
				status="Pending"
			}else{
				status="Published" // OK 
			}

			id=data.id;

			data={};
			data.status=status;
			data.id=id;

			console.log(publishPHP);

			// Set the cryptofrcommment status attribute of the article in the wp database to Published or Pending
			newFetch(publishPHP,data)
			.then(res => res.json())
			.then(function(res){
				if (res=="false"){
					console.log('Error during Wordpress Database store endpoint');
					return false;
				}
				if (manualButton) {
					alert('Article has been manually Published to forum');
					location.reload();
				}
			})

		})

	}); 
}


// 
function publishOldArticles(data,nodeBBURL,publishURL,publishPHP){ 
	
	console.log('data', data)
  
	// GET Request to get csrf Token and UID of the CryptoFR forum 
	newFetchGet(nodeBBURL+"/comments/token/")
	.then(res => {
		  status = res.status
		  return res
		})
	.then(res => res.json())
	.then(function(res){

		data._csrf=res.token;
		data.uid=res.uid; 


		// Publish all the articles to CryptoFR Forum
		newFetch2(publishURL,data)
		.then(res => {
			  status = res.status
			  return res
			})
		.then(res => res.json())
		.then(function(res){
 
			if (status!='200'){ // If there was an error publishing the articles in the CryptoFR forum
				alert('Error publishing Old Articles to the Forum. Try Again Later');
				console.log(res);
				return;
			}

			// Set the cryptofrcommment status attribute of all the articles in the wp database to Published
			newFetch2(publishPHP,res.ids)
			.then(res => res.json()) 
			.then(function(res){
				console.log(res) 
				if (res!='false'){
					alert('Old Articles has been manually Published to the forum');
					location.reload();
				}else {
					alert('Error updating Wordpress Database');
				}
			})


		});

	});
}