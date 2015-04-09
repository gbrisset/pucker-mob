 <?php 
    if($adminController->user->getLoginStatus()) $adminController->redirectTo('');
    
    if(isset($_POST['submit'])) {
        $loginStatus = $adminController->user->handleLogin($_POST);

        if($loginStatus['hasError'] == true) {
            //  Failure
            $adminController->user->invalidateAllTokens();
        } else {
            //  Success
            $_SESSION['csrf'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());
            $redirectString = $adminController->user->redirectAfterLogin();
            
            echo $redirectString;
        }
    } 

    if( isset($articleInfoObj) &&  $articleInfoObj){
 ?>
 <div id="openModal" class="modalDialog">
	<div id="popup-content" class="login-register-content">
		<a href="#close" title="Close" class="close">X</a>
        <!-- LOGIN -->
		<div class="small-12 modal-input" id="login-box">
        	<header>PUCKERMOB</header>
        	<section>
        		<h1>Follow this author</h1>
        		<p>Please login to follow this and other puckermob writers</p>
        		<div class="small-12">
        			<div id="left-content" class="left">
        				<h3>Login With E-mail:</h3>
                        <input type="hidden" name="isreader" id="isreader" value="1" />
        				<form class="ajax-form" data-info-task="login-reader" id="login-form" name="login-form"  method="POST" action="<?php echo $config['this_url']; ?>">
        					<input type="hidden" name="author-id" id="author-id" value="<?php echo $articleInfoObj['contributor_id']; ?>" />
                            <input type="email" placeholder="EMAIL" id="email" name="user_login_input" value="<?php if(isset($loginStatus) && $loginStatus['hasError']) echo $_POST['user_login_input']; ?>"  required  autofocus  />
        					<input type="password" placeholder="PASSWORD" id="password"  name="password" required />
        					<button type="button" class="ajax-form-submit" name="submit">Login</button>
        				</form>
                        <p id="login-result"></p>
                        <div class="hsContentLink">
                                    <a target="blank" href="<?php echo $config['this_admin_url']; ?>forgot/" class="align-center">Forgot Password?</a>
                                </div>
        			</div>
        			<div class="or left"><span>OR</span></div>
        			<div id="right-content" class="right">
        				<h3>Login with social:</h3>
        				<div class="fb-login-button">
                            <input type="hidden" id="isReader" name="isReader" value="true"/>
							<img id="fb-login" src = "<?php echo $config['this_url'].'assets/img/fb_log_button_img.jpg'; ?>" alt="fb loggin button" />
						</div>
        				<p>NEW TO PUCKERMOB</p>
        				 <p style="padding-bottom: 2rem;"><a class="register-link" id="register-link" >REGISTER NOW!</a></p>
        			</div>
        		</div>
        	</section>
        </div>
        <!-- REGISTER -->
        <div class="small-12 modal-input" id="register-box">
        	<header>PUCKERMOB</header>
        	<section>
        		<h1>Follow this author</h1>
        		<p>Please register to follow this and other puckermob writers</p>
        		<div class="small-12">
        			<div id="left-content" class="left">
        				<h3>Register With E-mail:</h3>
                        <input type="hidden" name="isreader" id="isreader" value="1" />
        				<form class="ajax-form" id="register-form" name="register-form" method="POST" data-info-task="register-reader" action="<?php echo $config['this_url']; ?>">
                            <input type="hidden" name="author-id" id="author-id" value="<?php echo $articleInfoObj['contributor_id']; ?>" />

                            <input type="email" placeholder="EMAIL" id="email" name="user_email_1-e" required />
        					<input type="password" placeholder="PASSWORD" id="password"  name="user_password-s" required />
        					<input type="text" placeholder="Your name" id="name" name="name" required />
        					
                            <!-- RECAPTCHA-->
                            <div class="g-recaptcha" style="margin-left:-7px; " data-sitekey="<?php echo RECAPTCHAPUBLICKEY; ?>"></div>
                            <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>
                            
                            <button type="button" class="ajax-form-submit" name="submit">Register</button>
        				</form>
                        <p id="register-result"></p>
        			</div>
        			<div class="or left"><span>OR</span></div>
        			<div id="right-content" class="right">
        				<h3>Register with social:</h3>
        				<div class="fb-login-button">
                            <input type="hidden" id="isReader" name="isReader" value="true"/>
							<img id="fb-login" src = "<?php echo $config['this_url'].'assets/img/fb_log_button_img.jpg'; ?>" alt="fb loggin button" />
						</div>
							<p>Already registered?</p>
        				<p><a class="register-link" id="login-link">Log In!</a></p>
        			</div>
        		</div>
        	</section>
        </div>
    </div>
   
</div>
<?php }?>
		