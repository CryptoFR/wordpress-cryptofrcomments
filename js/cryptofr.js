
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

		let timerId = setTimeout(async function tick() {
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
			 
		}, 500); 


	    
	})();

