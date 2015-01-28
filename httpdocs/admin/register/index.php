<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if($adminController->user->getLoginStatus()) $adminController->redirectTo('');
	
	if(isset($_POST['submit'])) {
		$registrationStatus = $adminController->user->doRegistration($_POST);
	}

	//FACEBOOK SETTINGS
	require_once('../fb/fbfunctions.php');
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<script>
   
//JQUERY FOR SLIDING NAVIGATION -->   
$(document).ready(function() {
  $('a[href*=#]').each(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
    && location.hostname == this.hostname
    && this.hash.replace(/#/,'') ) {
      var $targetId = $(this.hash), $targetAnchor = $('[name=' + this.hash.slice(1) +']');
      var $target = $targetId.length ? $targetId : $targetAnchor.length ? $targetAnchor : false;
       if ($target) {
         var targetOffset = $target.offset().top;

// JQUERY CLICK FUNCTION REMOVE AND ADD CLASS "ACTIVE" + SCROLL TO THE #DIV
         $(this).click(function() {
            $(".next-step h2 a").removeClass("active");
            $(this).addClass('active');
           $('html, body').animate({scrollTop: targetOffset}, 1000);
           return false;
         });
      }
    }
  });

});


</script>
<body id="registration_p1" class="">
	<?php // include_once($config['include_path_admin'].'header.php');?>
       	
    <main>
       	 <?php if( $detect->isMobile() ){?>

       	 	<section id="slide-1" class="homeSlide">
	        <div class="bcg">
		       	<div class="hsContainer">
		        	<h1>PUCKERMOB</h1>
				    <hr>
				    <img id="moblog-img" src = "<?php echo $config['this_url'].'assets/img/registration/MOBLOG.png'; ?>" alt="moglog" />
			    	<h2>Earn money by writing</h2>
			    	
			    	<div class="hsContent dark-bg">
						<p>Welcome to MOBlog by PuckerMob! We're happy that you're interested in joining the mob, and making money by writing a blog on our site. </p>

						<p>We're still working on the mobile version, which will be launched shortly. In the meantime, please register and get started writing on a desktop computer or laptop. Thanks!</p>
			    	</div>
			   
		        	<div class="next-step" style="margin-top:0.5rem; margin-bottom: 3rem;">
		        		<ul>
		        			<li><a href="http://www.puckermob.com">PUCKERMOB HOME</a></li>
		        		    <li><a href="http://www.puckermob.com/policy/"  target="blank">Terms of Service</a></li>
							<li><a href="http://www.puckermob.com/policy/#privacy"  target="blank">Privacy Policy</a></li>
		        		</ul>
		        	</div>
		        	<div class="full-width dark-bg next-step active">
		        		<h2><a href="#slide-2">What is MobLog?</a></h2>
		        	</div>
		        </div>
		        
		</section>
       	 <?php }else{?>
	    <section id="slide-1" class="homeSlide">
	        <div class="bcg">
		       	<div class="hsContainer">
		        	<h1>PUCKERMOB</h1>
				    <hr>
				    <img id="moblog-img" src = "<?php echo $config['this_url'].'assets/img/registration/MOBLOG.png'; ?>" alt="moglog" />
			    <?php if(isset($registrationStatus) && $registrationStatus['hasError'] == false){ ?>
					<h2>Almost Done!</h2>
					<div class="hsContent dark-bg">
						<div id="register-form-cont-new" class="admin-form-cont success-msg">
							<div class="row">
								<p class="">
									<?php echo $registrationStatus['message']; ?>
								</p>
							</div>
						</div>
					</div>
				<?php }else{ ?>
			    	<h2>Earn money by writing</h2>
			    	
			    	<div class="hsContent dark-bg">
						<form id="register-form" name="register-form" action="<?php echo $config['this_admin_url']; ?>register/" method="POST">
				    		<?php if(isset($registrationStatus) && $registrationStatus['hasError'] == true){ ?>
							<p class="<?php echo ($registrationStatus['hasError'] == true) ? 'error' : 'success'; ?>">
								<?php echo $registrationStatus['message']; ?>
							</p>
							<?php } ?>
							<input type="email" id="user_email_1-e" name="user_email_1-e" value="<?php if(isset($_POST['user_email_1-e'])) echo $_POST['user_email_1-e']; ?>" placeholder="email" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
							<input type="password" id="user_password-s" name="user_password-s" value="<?php if(isset($_POST['user_password-s'])) echo $_POST['user_password-s']; ?>" placeholder="password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />
				   			<input type="text" id="user_name-s" name="user_name-s" value="<?php if(isset($_POST['user_name-s'])) echo $_POST['user_name-s']; ?>" placeholder="username" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_name') echo 'autofocus'; ?> />
							<input type="text" id="user_first_name-s" name="user_first_name-s" value="<?php if(isset($_POST['user_first_name-s'])) echo $_POST['user_first_name-s']; ?>" placeholder="name" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_first_name') echo 'autofocus'; ?> />

				   			<p class="registration-akn">By registering, you acknowledge that you have read and agree with our Terms of Service.</p>
					   		<div class="">
							    <div class="">
									<?php if(isset($loginStatus)){ ?><p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p><?php } ?>
									<button type="submit" id="submit" name="submit" class="button left small-12">Register</button>
								</div>
								<div class="">
									<span class="or">or</span>
								</div>

								<div>
									<div class="fb-login-button">
										<img id="fb-login" src = "<?php echo $config['this_url'].'assets/img/fb_log_button_img.jpg'; ?>" alt="" />
									</div>
									<div class="margin-top facebook-txt">
										<p style="margin-bottom:0;">We'll never post anything to Facebook
										without your permission.</p>
									</div>
								</div>
							</div>
						</form>
			    	</div>
			    	<div class=" hsContentLink dark-bg ">
		        		<p>ALREADY REGISTERED?</p>
		        		<a href="http://www.puckermob.com/admin">CLICK HERE TO LOGIN</a>
		        	
		        	</div>
			    	<?php }?>
		        	<div class="next-step" style="margin-top:0.5rem; margin-bottom: 2.5rem;">
		        		<ul>
		        			<li><a href="http://www.puckermob.com">PUCKERMOB HOME</a></li>
		        		    <li><a href="http://www.puckermob.com/policy/"  target="blank">Terms of Service</a></li>
							<li><a href="http://www.puckermob.com/policy/#privacy"  target="blank">Privacy Policy</a></li>
		        		</ul>
		        	</div>
		        	<div class="full-width dark-bg next-step active">
		        		<h2><a href="#slide-2">What is MobLog?</a></h2>
		        	</div>
		        </div>
		        
		</section>
		    <?php } ?>
		<section id="slide-2" class="homeSlide">
		   	<div class="bcg">
			   	<div class="hsContainer in-slider-2">
			    	<h1 class="smaller-h1 move-left uppercase padding-bottom">Understanding your </h1>
				    <hr>
				    <div class="move-left">
				    <img id="moblog-img" src = "<?php echo $config['this_url'].'assets/img/registration/MOBLOG.png'; ?>" alt="moglog" />
			    
			    	<div class="hsContent">
				    	<p>It's pretty  simple: MOBlog is a tool that lets you make money by blogging on our site</p>
				    	<p>You can write what you want, when you want. </p>
				    	<p>Be creative.</p>
				    	<p>Express an opinion.</p>
				    	<p>Make people laugh.</p>
				    	<p>Teach people something new.</p>

				    	<p class="p-large margin-top margin-bottom">The Floor is Yours</p>

				    	<p>It's super easy - just sign up and start writing</p>
			    	</div>
			    </div>
			    	<div class="next-step " style="margin-top:1rem; margin-bottom: 3rem;">
		        		<ul>
		        			<li><a href="http://www.puckermob.com">PUCKERMOB HOME</a></li>
		        		    <li><a href="http://www.puckermob.com/policy/"  target="blank">Terms of Service</a></li>
							<li><a href="http://www.puckermob.com/policy/#privacy"  target="blank">Privacy Policy</a></li>
		        		</ul>
		        	</div>
		        	<div class="full-width dark-bg next-step">
		        		<h2><a href="#slide-3">How can i earn money?</a></h2>
		        	</div>
		        </div>
		    </div>
		</section>
		 
		<section id="slide-3" class="homeSlide">
			<div class="bcg">
		    		<div class="hsContainer in-slider-3">
			    	<h1 class="smaller-h1 move-right uppercase padding-bottom">Earning money with your</h1>
				    <hr>
			   		<div class="move-right">
			   		<img id="moblog-img" src = "<?php echo $config['this_url'].'assets/img/registration/MOBLOG.png'; ?>" alt="moglog" />
			    	<div class="hsContent">
				    	<p>This is also pretty easy: Write really good content and share it with your online networks.</p>
				    	<p>You get paid as more people share your work. </p>
				    	<p>It's simple as that. No need to apply with various ad networks or install confusing ad tags.</p>
				    	<p>The better your articles, the more people will share them.</p>
				    	
				    	<p class="p-large margin-top margin-bottom">The More people share it,<br> the more money you make.</p>

				    	<p>Pretty easy, right?</p>
				    	<p>So what are you waiting for?</p>
				    	<p>Getting started is quick and easy!</p>
			    	</div>
			    </div>
		    		<div class="next-step " style="margin-top:1rem; margin-bottom: 3rem;">
		        		<ul>
		        			<li><a href="http://www.puckermob.com">PUCKERMOB HOME</a></li>
		        		    <li><a href="http://www.puckermob.com/policy/"  target="blank">Terms of Service</a></li>
							<li><a href="http://www.puckermob.com/policy/#privacy"  target="blank">Privacy Policy</a></li>
		        		</ul>
		        	</div>
		        	<div class="full-width dark-bg next-step">
		        		<h2><a href="#slide-1">I'm ready to get started!</a></h2>
		        	</div>
			    </div>
			    	
			</div>
		</section>
		
	</main>
	<!--<main id="main-cont" class="row panel sidebar-on-right background-blue" role="main">
			<section id="register-cont" class="admin-logout-content admin-box mobile-12 small-12 large-9 auto-margin">
				<?php if(isset($registrationStatus) && $registrationStatus['hasError'] == false){ ?>
					<h1>Almost Done!</h1>
					<div id="register-form-cont" class="admin-form-cont success-msg">
						<div class="row margin-top">
							<p class="success">
								<?php echo $registrationStatus['message']; ?>
							</p>
						</div>
						<div class="row padding-top" style="text-align:center;">
							<a href="<?php echo $config['this_url']; ?>" class="a-green-link">Home</a>
						</div>
					</div>
				<?php }else{ ?>
				<section class="columns small-6">
					<h1 class="h1-smaller">MOBlog</h1>
					<div class="message-registration">
						<p class="right"><span class="large-registration-text light-blue">Like to Write?</span><span class="medium-registration-text light-blue">Earn money when you write for us!<span></p>
						<img class="reg-arrow" src="http://images.puckermob.com/articlesites/sharedimages/registration_arrow.jpg" alt="arrow">
						<a href="<?php echo $config['this_admin_url'].'howitworks.php'?>" target="blank"><span class="small-registration-text light-blue margin-top">Find out how</span>
						<span class="small-registration-text light-blue">and get started today!</span></a>
				
						<span class="medium-registration-text light-blue earning-money-txt padding-bottom">Earning money is easy:</span>
							<ul class="right">
								<li class="light-blue">Register and set up your account (it’s quick and painless)</li>
								<li>Start writing original content on practically any topic you’d like </li>
								<li>Share your articles with your social networks</li>
								<li>Get paid based on how often your content is shared</li>
							</ul>
						
						<span class="medium-registration-text light-blue earning-money-txt ">That’s all there is to it!</span>


					</div>
				</section>
				
   				<section class="columns small-6">
   				<div id="register-form-cont" class="admin-form-cont">
					<form id="register-form" name="register-form" action="<?php echo $config['this_admin_url']; ?>register/" method="POST">
					<?php if(isset($registrationStatus) && $registrationStatus['hasError'] == true){ ?>
					<p class="<?php echo ($registrationStatus['hasError'] == true) ? 'error' : 'success'; ?>">
						<?php echo $registrationStatus['message']; ?>
					</p>
					<?php } ?>
					
					<div class="row">
						<div class="large-12 columns">
						<h3>Register Now &amp; Get Started!</h3>
						</div>
					</div>
				<div class="input-wrapper">	
					<div class="row">
						<div class="large-12 columns">
							<input type="text" id="user_name-s" name="user_name-s" value="<?php if(isset($_POST['user_name-s'])) echo $_POST['user_name-s']; ?>" placeholder="user name" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_name') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="email" id="user_email_1-e" name="user_email_1-e" value="<?php if(isset($_POST['user_email_1-e'])) echo $_POST['user_email_1-e']; ?>" placeholder="email address" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="email" id="user_email_2-e" name="user_email_2-e" value="<?php if(isset($_POST['user_email_2-e'])) echo $_POST['user_email_2-e']; ?>" placeholder="re-enter email" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_email') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="password" id="user_password-s" name="user_password-s" value="<?php if(isset($_POST['user_password-s'])) echo $_POST['user_password-s']; ?>" placeholder="password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="password" id="user_password-s" name="user_password_2-s" value="<?php if(isset($_POST['user_password_2-s'])) echo $_POST['user_password_2-s']; ?>" placeholder="re-enter password" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'password') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="text" id="user_first_name-s" name="user_first_name-s" value="<?php if(isset($_POST['user_first_name-s'])) echo $_POST['user_first_name-s']; ?>" placeholder="name" required <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_first_name') echo 'autofocus'; ?> />
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<input type="text" id="user_last_name-s" name="user_last_name-s" value="<?php if(isset($_POST['user_last_name-s'])) echo $_POST['user_last_name-s']; ?>" placeholder="last name" <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'user_last_name') echo 'autofocus'; ?> />
						</div>
					</div>

					<div class="row">
						<div class="large-12 columns">
							<label class="checkbox-label"><input type="checkbox" id="tos_agreed-s" name="tos_agreed-s" value="1"  <?php if(isset($registrationStatus) && isset($registrationStatus['field']) && $registrationStatus['field'] == 'tos_agreed') echo 'autofocus'; ?> />
							I have read, understand and agree to the <a href="<?php echo $config['this_url']; ?>policy.php" target="_blank"> MOBlog terms and conditions</a></label>
						</div>
					</div>
				</div>
					<div class="row">
						    <div class="large-12 columns">
								<?php if(isset($loginStatus)){ ?><p class="<?php echo ($loginStatus['hasError'] == true) ? 'error' : 'success'; ?>"><?php echo $loginStatus['message']; ?></p><?php } ?>
								<button type="submit" id="submit" name="submit" class="button left a-green-link small-12">Register</button>

							</div>
							<div class="large-12 columns padding-top padding-bottom center">
								<span class="or">or</span>
							</div>
							<div class="large-12 columns">
								<div class="fb-login-button">
									<img id="fb-login" src = "<?php echo $config['this_url'].'assets/img/fb_log_button_img.jpg'; ?>" alt="" />
								</div>
								<div class="margin-top facebook-txt">
									<p class"padding-bottom">We'll never post anything to Facebook
									without your permission.</p>

									<p>By registering through Facebook, you acknowledge that 
									you have read and agree with our Terms of Service.</p>
								</div>
							</div>

						</div>
					
					</form>
					

				</div>
				<p class="login-link">Already registered?<a href="<?php echo $config['this_admin_url']; ?>login/">Click here to log in</a></p>
				</section>
				<?php }?>
			</section>
	</main>-->
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
 <!--<script src="<?php echo $config['this_url']; ?>assets/js/imagesloaded.js"></script>
 <script src="<?php echo $config['this_url']; ?>assets/js/skrollr.js"></script>
 <script src="<?php echo $config['this_url']; ?>assets/js/_main.js"></script>-->
</body>
</html>