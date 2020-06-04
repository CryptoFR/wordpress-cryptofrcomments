<div class="container">
	<div id="login-modal" class="modal" data-closed="0" style="display: block;">
	  <!-- Modal content -->
	  <div class="modal-content">
	    <div class="modal-body clearfix">
	      <div class="modal-login-form">
	        <h4 class="modal-subtitle">Se connecter à CryptoFR</h4>
	        <form action="https://testforum.cryptofr.com/login" id="login-form" method="POST">
	          <div class="email-input">
	            <svg class="svg-inline--fa fa-user fa-w-14" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M352 128A128 128 0 1 1 224 0a128 128 0 0 1 128 128z"></path><path class="fa-primary" fill="currentColor" d="M313.6 288h-16.7a174.1 174.1 0 0 1-145.8 0h-16.7A134.43 134.43 0 0 0 0 422.4V464a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48v-41.6A134.43 134.43 0 0 0 313.6 288z"></path></g></svg><!-- <i class="fad fa-user"></i> -->
	            <input class="modal-input" name="email" type="text" value="" placeholder="Email ou Pseudonyme">
	          </div>
	          <div class="password-input">
	            <svg class="svg-inline--fa fa-key fa-w-16" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="key" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M303.06 348.91l.1.09-24 27a24 24 0 0 1-17.94 8H224v40a24 24 0 0 1-24 24h-40v40a24 24 0 0 1-24 24H24a24 24 0 0 1-24-24v-78a24 24 0 0 1 7-17l161.83-161.83-.11-.35a176.24 176.24 0 0 0 134.34 118.09z"></path><path class="fa-primary" fill="currentColor" d="M336 0a176 176 0 1 0 176 176A176 176 0 0 0 336 0zm48 176a48 48 0 1 1 48-48 48 48 0 0 1-48 48z"></path></g></svg><!-- <i class="fad fa-key"></i> -->
	            <input class="modal-input" name="password" type="password" value="" placeholder="Mot de passe">
	          </div>
	          <button class="login-button modal-button" type="submit">
	            <span>Connexion</span>
	            <svg class="svg-inline--fa fa-circle-notch fa-w-16 fa-spin" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="circle-notch" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M504 257.28v.23C503.42 394 392.44 504.24 256 504v-64a184.09 184.09 0 0 0 177.16-134.42c27.44-97.84-29.63-199.41-127.47-226.85A24 24 0 0 1 288 55.66V39a24 24 0 0 1 30-23.22c107.4 27.65 186.61 125.38 186 241.5z"></path><path class="fa-primary" fill="currentColor" d="M256 439.93v64C119.56 504.24 8.58 394 8 257.51v-.23C7.39 141.16 86.6 43.43 194 15.78A24 24 0 0 1 224 39v16.66a24 24 0 0 1-17.69 23.07c-97.84 27.44-154.91 129-127.47 226.85A184.07 184.07 0 0 0 256 439.93z"></path></g></svg><!-- <i class="fad fa-circle-notch fa-spin"></i> -->
	          </button>
	          <div class="nodebb-error"></div>
	        </form>
	        <a href="#" class="modal-forgot-password"> Mot de passe oublié?</a>
	      </div>
	      <div class="modal-separator">
	        <span>
	          ou
	        </span>
	      </div>
	      <div class="modal-login-alternative">  
	        <ul class="alt-logins">
	          <li class="google">
	            <a rel="nofollow noopener noreferrer alt-login" target="_top" data-link="https://testforum.cryptofr.com/auth/google" href="#" data-network="Google">
	              <svg class="svg-inline--fa fa-google fa-w-16" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" data-fa-i2svg=""><path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path></svg><!-- <i class="fab fa-google"></i> -->
	            </a>
	          </li>
	          <li class="facebook">
	            <a rel="nofollow noopener noreferrer alt-login" target="_top" data-link="https://testforum.cryptofr.com/auth/facebook" href="#" data-network="Facebook">
	              <svg class="svg-inline--fa fa-facebook-f fa-w-10" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg><!-- <i class="fab fa-facebook-f"></i> -->
	            </a>
	          </li>
	          <li class="twitter">
	            <a rel="nofollow noopener noreferrer alt-login" target="_top" data-link="https://testforum.cryptofr.com/auth/twitter" href="#" data-network="Twitter">
	              <svg class="svg-inline--fa fa-twitter fa-w-16" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg><!-- <i class="fab fa-twitter"></i> -->
	            </a>
	          </li>
	          <li class="github">
	            <a rel="nofollow noopener noreferrer alt-login" target="_top" data-link="https://testforum.cryptofr.com/auth/github" href="#" data-network="Github">
	              <svg class="svg-inline--fa fa-github fa-w-16" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="github" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" data-fa-i2svg=""><path fill="currentColor" d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"></path></svg><!-- <i class="fab fa-github"></i> -->
	            </a>
	          </li>
	        </ul>
	      </div>
	    </div>
	    <div class="modal-footer">
	      <div class="register-link">
	        Vous n'avez pas encore de compte? <a href="https://testforum.cryptofr.com/register" class="register-modal-open">S'inscrire</a>
	      </div>
	      <div class="logo">
	        <img src="https://testforum.cryptofr.com/plugins/nodebb-plugin-blog-comments-cryptofr/icons/cryptofr-comments.svg" alt="add emojis" class="icon">
	      </div>
	    </div>
	  </div>
	</div> 
</div>