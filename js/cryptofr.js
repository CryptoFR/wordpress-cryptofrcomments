	function setDataTable(table,data){
		table.innerHTML='<thead><th class="article-title">Article Title</th><th class="article-user">User</th><th class="article-comment">Comment</th><th class="article-date">Date</th><th class="article-votes">Votes</th><th class="article-actions">Actions</th><th class="article-children">Children</th><th class="article-expand"></th></tr></thead><tbody></tbody>';
		return $(table).DataTable( {  
            "bAutoWidth": false,
            // ajax: '../php/sites.php', 
            "order": [ 3, 'desc' ],
            "aaData": data,
            columns: [ 
		        {
	                "data": "topic.title",
	                "className": "article-title"
	            },{
	                "data": "user.username",
	                "className": "article-user"
	            },{
	                "data": "content",
	                "className": "article-comment", render: function(data){
	                	return singleGifComment(data);
	                }
	            },{
	                "data": "timestamp", render: function(data){
	                	return timeStamptoDate(data);
	                },
	                "className": "article-date"
	            },{
	                "data": "votes",
	                "className": "article-votes"
	            }, {
	                "data": null,
		            "defaultContent": '<button class="moderate">Delete</prueba>',
	                "className": "article-actions"

	            }, { "data": 'children', render: function ( data ) {
	                	if (data){
	                    	return data.length;
	                	}
	                	else return 0;
                	} ,
	                "className": "article-children"
            	},{
		            "className": 'details-control article-expand', 
		            "orderable": false,
		            "data": "pid",
		            "defaultContent": '' 
		        }],
                select: {
                    "style":    'os',
                    "selector": 'td:not(:first-child)'
                },
                createdRow: function ( row, data, index ) {
                	let pidCell=row.querySelector('.details-control')
		        	let pid=pidCell.innerText;
		        	pidCell.setAttribute('data-pid',pid);
		        	pidCell.innerText=""; 
                }
        } ); 
	}
 
	
	function clickTab(tab) {
	    let click = new MouseEvent('click', {
	        bubbles: true,
	        cancelable: true,
	        synthetic: true,
	        view: window
	    });
	    tab.dispatchEvent(click);
	}  

	
	function timeStamptoDate(timeStamp){  
	    // Create a new JavaScript Date object based on the timestamp
	    // multiplied by 1000 so that the argument is in milliseconds, not seconds.
	    var date_ob = new Date(timeStamp );
	    // adjust 0 before single digit date
	    let date = ("0" + date_ob.getDate()).slice(-2);
	    // current month
	    let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);
	    // current year
	    let year = date_ob.getFullYear();
	    // current hours
	    let hours = date_ob.getHours();
	    // current minutes
	    let minutes = date_ob.getMinutes(); 
	    // current seconds
	    let seconds = date_ob.getSeconds(); 

	    // prints date & time in YYYY-MM-DD HH:MM:SS format
	    return (year + "-" + month + "-" + date + " " + hours + ":" + minutes + ":" + seconds);
	} 

	function singleGifComment(comment) {
	  while (comment.indexOf("![")>=0){
	    let src=comment.substring(comment.indexOf("](")+2,comment.indexOf(".gif)")+4)
	    let imgTag="<img class='gif-post' src='"+src+"'></br>";

	    if (comment.substring(comment.indexOf("![]")-6,comment.indexOf("![]"))!="&gt;  " && comment.indexOf("![]") > 1){
	      imgTag="</br>"+imgTag;
	    }
	    comment=comment.substring(0,comment.indexOf("!["))+" "+imgTag+" "+comment.substring(comment.indexOf(".gif)")+5,comment.length);
	  }
	  return comment;
	}



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

	function newFetchGet(path) { 
	    return fetch(path, {
	      	method: 'GET',
	      	headers: {
	        	'Content-Type': 'application/x-www-form-urlencoded'
	      	},
	      	credentials: 'include'
	    })
	}

	function createChild ( row,cell ) {
	    // This is the table we'll convert into a DataTable
	    let table = document.createElement('table');
	    $(table).addClass('article-table').addClass('display').css('width','100%');
	    let tr= document.createElement('tr');
	    let td= document.createElement('td');
	    td.setAttribute('colspan','8');
	    tr.append(td);
	    td.append(table);

	    // Display it the child row
	    $( tr ).insertAfter( $(cell.closest('tr')) );
	 
	    // Initialise as a DataTable
	    let childrenData= data.posts.find(post => post.pid == cell.getAttribute('data-pid')).children
	    
	    var usersTable =  setDataTable(table,childrenData)

	}


	function destroyChild(row,cell) {
	    // var table = $("table", row.child()); 
	    var table = cell.parentNode.nextSibling.querySelector('table'); 
	    $(table).detach();
	    $(table).DataTable().destroy();
	 
	    // And then hide the row
	    $(cell.parentNode.nextSibling).remove() 
	}

	function removeNodes(nodes) {
	   var nodeList = nodes && nodes.length !== undefined ? nodes : [nodes];
	   var len = nodeList.length;
	   if (nodes) for (var i = 0; i < len; i++) {
	     var node = nodeList[i];
	     node.parentNode.removeChild(node);
	   }
	 }

	function setUSerData(){
		document.querySelector('.user-name').innerText=data.user.username;

	    if (data.user.picture) {
	    	document.querySelector('.user-image').setAttribute('src',data.user.picture)
	    	document.querySelector('.user-image').setAttribute('alt',data.user.username)
	    	document.querySelector('.user-image').setAttribute('title',data.user.username)
		    removeNodes(document.querySelector('.user-icon'));
	    } else {
	    	document.querySelector('.user-icon').setAttribute('title',data.user.username)
	    	document.querySelector('.user-icon').setAttribute('alt',data.user.username)
	    	document.querySelector('.user-icon').innerText=data.user["icon:text"]
	    	document.querySelector('.user-icon').style.backgroundColor=data.user["icon:bgColor"];
		    removeNodes(document.querySelector('.user-image'));
	    }
	}




	$(document).on('click', '#grid td.details-control', function () {
	    var tr = $(this).closest('tr'); 
	    var row = siteTable.row( tr );
	 
	    if ( $(tr).hasClass('shown') ) {
	        // This row is already open - close it
	        tr.removeClass('shown');
	        destroyChild(row,this);
	    }
	    else {
	        // Open this row
	        tr.addClass('shown');
	        createChild(row, this); // class is for background colour
	    }
	} );


	$(document).on('click', '.comments-tables h2', function () {
		let tableContainer=this.closest('.article-table-container');
		let dataTable=tableContainer.querySelector('.dataTables_wrapper')
		$(dataTable).toggle(500);

	} );

	$(document).on('click', '.comments-tables .moderate', function () {
		if (window.confirm("Do you really want to Delete this comment?")) { 
			let tr=this.closest('tr');
			let pidCell=tr.querySelector('.article-expand')
			let pid=pidCell.getAttribute('data-pid') 
	    	newFetch(nodeBBURL + "/comments/delete/" + pid, {}).then(function (){
	    		location.reload();
	    	});
		}
	} );





	var data=null;
	var siteTable=null;
	var articles={};



	newFetchGet(nodeBBURL+"/comments/bycid/"+cid)
	.then(res => res.json())
	.then(function(res){
		data=res; 
		console.log(data); 


		if (data.error){
			document.querySelector('#cryptofr-login').classList.add('in','active');
			document.querySelector('.cryptofr-login-tab').style.display="block";
			document.querySelector('.cryptofr-login-tab').classList.add('active');

			return;
		}
		document.querySelector('#cryptofr-comments').classList.add('in','active');
		document.querySelector('.cryptofr-comments-tab').style.display="block";
		document.querySelector('.cryptofr-comments-tab').classList.add('active');
		
		document.querySelector('.cryptofr-user-tab').style.display="block";

		for (const l of data.posts) {
	      if (!articles.hasOwnProperty(l.tid)) {
	        articles[l.tid] = {
	          topic: l.topic,
	          posts: []
	        }
	      }
	      articles[l.tid].posts.push(l);
	    }

	    articles=Object.entries(articles);


        siteTable=  setDataTable(document.querySelector('#grid'),data.posts);
 

		for (const article of articles){

			console.log(article)

			let table = document.createElement('table')
			$(table).addClass('article-table').addClass('display').attr('id',article[1].topic.tid).css('width','100%') 
			let div = document.createElement('div')
			$(div).addClass('article-table-container')
			let h2= document.createElement('h2')
			h2.innerText=article[1].topic.title;
			div.append(h2)
			div.append(table)
			document.querySelector('.comments-tables').append(div)

			let articleTable =  setDataTable(table,article[1].posts) 

		}

		setUSerData();
 
	});



