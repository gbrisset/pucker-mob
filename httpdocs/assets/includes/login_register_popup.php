 <div id="openModal" class="modalDialog">
	<div id="popup-content" class="login-register-content">
		<a href="#close" title="Close" class="close">X</a>
		<div class="small-12 modal-input" id="login-box">
        	<header>PUCKERMOB</header>
        	<section>
        		<h1>Follow this author</h1>
        		<p>Please login to follow this and other puckermob writers</p>
        		<div class="small-12">
        			<div id="left-content" class="left">
        				<h3>Login With E-mail:</h3>
        				<form id="login-form" method="POST" action="<?php echo $config['this_url']; ?>">
        					<input type="email" placeholder="EMAIL" id="email" name="email" />
        					<input type="password" placeholder="PASSWORD" id="password"  name="password" />
        					<button type="button" id="submit" name="submit">Login</button>
        				</form>
        			</div>
        			<div class="or left"><span>OR</span></div>
        			<div id="right-content" class="right">
        				<h3>Login with social:</h3>
        				<div class="fb-login-button">
							<img id="fb-login" src = "<?php echo $config['this_url'].'assets/img/fb_log_button_img.jpg'; ?>" alt="fb loggin button" />
						</div>
        				<p>NEW TO PUCKERMOB</p>
        				 <p style="padding-bottom: 2rem;"><a class="register-link" id="register-link" >REGISTER NOW!</a></p>
        			</div>
        		</div>
        	</section>
        </div>
        <div class="small-12 modal-input" id="register-box">
        	<header>PUCKERMOB</header>
        	<section>
        		<h1>Follow this author</h1>
        		<p>Please register to follow this and other puckermob writers</p>
        		<div class="small-12">
        			<div id="left-content" class="left">
        				<h3>Register With E-mail:</h3>
        				<form id="login-form" method="POST" action="<?php echo $config['this_url']; ?>">
        					<input type="email" placeholder="EMAIL" id="email" name="email" />
        					<input type="password" placeholder="PASSWORD" id="password"  name="password" />
        					<input type="text" placeholder="Your name" id="name" name="name" />
        					<!-- RECAPTCHA-->
        					<button type="button" id="submit" name="submit">Register</button>
        				</form>
        			</div>
        			<div class="or left"><span>OR</span></div>
        			<div id="right-content" class="right">
        				<h3>Register with social:</h3>
        				<div class="fb-login-button">
							<img id="fb-login" src = "<?php echo $config['this_url'].'assets/img/fb_log_button_img.jpg'; ?>" alt="fb loggin button" />
						</div>
							<p>Already registered?</p>
        				<p><a class="register-link" id="login-link">Log In!</a></p>
        			</div>
        		</div>
        	</section>
        </div>
    </diV>
</div>
		