
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


	function newFetchGet(path) { 
	    return fetch(path, {
	      	method: 'GET',
	      	headers: {
	        	'Content-Type': 'application/x-www-form-urlencoded'
	      	},
	      	credentials: 'include'
	    })
	}


	var data=null;

	newFetchGet(nodeBBURL+"/comments/bycid/"+cid)
	.then(res => res.json())
	.then(function(res){
		data=res;
		console.log(data);
        // $('#grid').DataTable(data.posts);


        // $('#grid').dataTable({
        //     "bAutoWidth": false,
        //     "aaData": data.posts,
        //     "columns": [{
        //         "data": ""
        //     },{
        //         "data": "user.username"
        //     }, {
        //         "data": "content"
        //     }, {
        //         "data": "votes"
        //     }, {
        //         "data": ""
        //     }, {
        //         "data": "children"	
        //     }]
        // })

        var siteTable = $('#grid').DataTable( {  
            "bAutoWidth": false,
            // ajax: '../php/sites.php', 
            "aaData": data.posts,
            columns: [ 
		        {
	                "data": "topic.title"
	            },{
	                "data": "user.username"
	            },{
	                "data": "content" 
	            }, {
	                "data": "votes"
	            }, {
	                "data": null,
		            "defaultContent": ''
	            }, { "data": 'children', render: function ( data ) {
	                	if (data){
	                    	return data.length;
	                	}
	                	else return 0;
                	} 
            	},{
		            "className": 'details-control', 
		            "orderable": false,
		            "data": "pid",
		            "defaultContent": '',
		            "width": '10%'
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


        function createChild ( row,cell ) {
            // This is the table we'll convert into a DataTable
            let table = $('<table class="display" width="100%"/>');
            let tr= $('<tr></tr>')
            let td= $('<td colspan="7"></td>')
            tr.append(td)
            td.append(table)


         
            // Display it the child row
            // row.child( table ).show();
            $( tr ).insertAfter( $(cell.closest('tr')) );
         
            // Initialise as a DataTable
            let childrenData= data.posts.find(post => post.pid == cell.getAttribute('data-pid')).children
            
            var usersTable = table.DataTable({  
            "bAutoWidth": false,
            // ajax: '../php/sites.php', 
            "aaData": childrenData,
            columns: [ 
		        {
	                "data": "topic.title"
	            },{
	                "data": "user.username"
	            },{
	                "data": "content" 
	            }, {
	                "data": "votes"
	            }, {
	                "data": null,
		            "defaultContent": ''
	            }, { "data": 'children', render: function ( data ) {
	                	if (data){
	                    	return data.length;
	                	}
	                	else return 0;
                	} 
            	},{
		            "className": 'details-control',
		            "orderable": false,
		            "data": "pid",
		            "defaultContent": '',
		            "width": '10%'
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


        function destroyChild(row) {
            var table = $("table", row.child());
            table.detach();
            table.DataTable().destroy();
         
            // And then hide the row
            row.child.hide();
        }



        $(document).on('click', '#grid td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = siteTable.row( tr );
         
            if ( row.child.isShown() ) {
                // This row is already open - close it
                tr.removeClass('shown');
                destroyChild(row);
            }
            else {
                // Open this row
                tr.addClass('shown');
                createChild(row, this); // class is for background colour
            }
        } );



	});


 





