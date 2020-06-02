
	(function() {  




		function clickTab(tab) {
		    let click = new MouseEvent('click', {
		        bubbles: true,
		        cancelable: true,
		        synthetic: true,
		        view: window
		    });
		    tab.dispatchEvent(click);
		}

		/*let timerId = setTimeout(async function tick() {
				if ($("#nodebb #login-modal").length){
					if ($("#nodebb > .topic-profile-pic").length ){
						$(".cryptofr-login-tab, #cryptofr-login").hide()
						$(".cryptofrcomments-tabs .cryptofr-comments-tab,.cryptofrcomments-tabs .cryptofr-user-tab, #cryptofr-comments, #cryptofr-user").show()

						if ($("#cryptofr-login").hasClass("active"))
							clickTab(document.getElementById("a-comments"))
					}else{
						$(".cryptofrcomments-tabs .cryptofr-comments-tab,.cryptofrcomments-tasbc .cryptofr-user-tab, #cryptofr-comments, #cryptofr-user").hide()
						$(".cryptofrcomments-tabs .cryptofr-login-tab,#cryptofr-login").show()
						
						if ($("#cryptofr-comments").hasClass("active") || $("#cryptofr-user").hasClass("active"))
							clickTab(document.getElementById("a-login"))
						
						if (!$("#cryptofr-login .container #login-modal").length)  					
							$("#cryptofr-login .container").append($("#nodebb #login-modal")[0])
					} 
				}
			
			timerId = setTimeout(tick, 500);	
			 
		}, 500);*/  

		$('#config-form').submit(function(event){
			// // event.preventDefault();
		}) 
	    
	})();

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


	function setDataTable(element,data){
		return $(element).DataTable( {  
            "bAutoWidth": false,
            // ajax: '../php/sites.php', 
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
	                "className": "article-comment"
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
		            "defaultContent": '',
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
                }  ,
                createdRow: function ( row, data, index ) {
                	let pidCell=row.querySelector('.details-control')
		        	let pid=pidCell.innerText;
		        	pidCell.setAttribute('data-pid',pid);
		        	pidCell.innerText=""; 
                }
        } ); 
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
	    let table = $('<table class="display" width="100%"/>');
	    let tr= $('<tr></tr>')
	    let td= $('<td colspan="8"></td>')
	    tr.append(td)
	    td.append(table)


	 
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


	var data=null;
	var siteTable=null;
	var articles={};

	newFetchGet(nodeBBURL+"/comments/bycid/"+cid)
	.then(res => res.json())
	.then(function(res){
		data=res; 
		console.log(data); 

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

		console.log(articles) 

        siteTable=  setDataTable(document.querySelector('#grid'),data.posts);
 
		for (const article of articles){

			console.log(article)

			let table = document.createElement('table')
			$(table).addClass('article-table').addClass('display').attr('id',article[1].topic.tid).css('width','100%')
			table.innerHTML='<thead><th class="article-title">Article Title</th><th class="article-user">User</th><th class="article-comment">Comment</th><th class="article-date">Date</th><th class="article-votes">Votes</th><th class="article-actions">Actions</th><th class="article-children">Children</th><th class="article-expand"></th></tr></thead><tbody></tbody>';
			let div = document.createElement('div')
			$(div).addClass('article-table-container')
			let h2= document.createElement('h2')
			h2.innerText=article[1].topic.title;
			div.append(h2)
			div.append(table)
			document.querySelector('.comments-tables').append(div)

			let articleTable =  setDataTable(table,article[1].posts) 

		}


 
	});


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


 





