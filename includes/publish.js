var getXHR = new XMLHttpRequest();
var postXHR = new XMLHttpRequest();
var postData = {};
var postURL = "";

function encodeStringData(data){
	var encodedString = "";
	for (var prop in postData) {
	  if (data.hasOwnProperty(prop)) {
	    if (encodedString.length > 0) {
	      encodedString += "&";
	    }
	    encodedString +=
	      encodeURIComponent(prop) + "=" + encodeURIComponent(data[prop]);
	  }
	}
	return encodedString;
}

getXHR.onload = function(){
	if (getXHR.status >= 200 && getXHR.status < 400) {
		var responseData = JSON.parse(getXHR.responseText);

		if (responseData.postCount>=0) {
			return null;
		}
		
		postData._csrf=responseData.token;
		postData.uid=responseData.user.uid;

		encodedString=encodeStringData(postData);

		postXHR.open("POST", postURL, true);
		postXHR.withCredentials = true;
		postXHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		postXHR.send(encodedString);

	}
}


function publish(data,url){
	postData=data;
	postURL=url;
	getXHR.open("GET","https://testforum.cryptofr.com/comments/get/"+postData.blogger+"/"+postData.id+"/0/newest",true);
	getXHR.withCredentials = true;
	getXHR.send(); 
}