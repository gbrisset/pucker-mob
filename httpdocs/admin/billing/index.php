<?php
	
	$admin = true;
	require_once('../../assets/php/config.php');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();

?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
<?php include_once($config['include_path_admin'].'header.php');?>
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">Billing INFORMATION</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up">
			<h1 class="left">Billing INFORMATION</h1>	
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<section id="articles" class="padding-top">

				<div class="skip-step">
						<p class="small-12"><a href="" class="a-buttons">SKIP THIS STEP</a>
						NOTE: you must return to this page later and complete billing info in order to be paid.</p>
				</div>
				<section class="billing-cont">
					<h2>W2 Tax Forms</h2>
					<div class="small-12 billing-form-box">

						<img class="small-2 left" src="http://www.puckermob.com/assets/img/Download-Form.png" alt="Upload W2 Form" />
						<div class="small-10 left image-wrapper">
							<div>
								<a href="http://www.puckermob.com/assets/download/fw2.pdf" class="b-upload" download>Download Form</a>
								<div class="small-12 instructions">
									<label>Instructions</label>
									<ul>
										<li>instruction to note number 1</li>
										<li>instruction to note number 1</li>
										<li>instruction to note number 1</li>
									</ul>
								</div>
							</div>
							<div>
								<span class="and">and</span>
							</div>
							<div>
								<a href="Upload-form-link" class="b-upload" id="upload-form-file">Upload Completed Form</a>
								<input type="file" class="hidden" id="upload-form" name="upload-form" />
									<div class="small-12 instructions">
									<label>Instructions</label>
									<ul>
										<li>instruction to note number 1</li>
										<li>instruction to note number 1</li>
										<li>instruction to note number 1</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</section>
				<section class="paypal-info">
					<h2>Paypal Information</h2>
					<div>
						<form method="" action="" class="small-7" id="paypal-form">
							<label>Paypal Email Address</label>
							<input type="email" required id="paypal-email" name="paypal-email" placeholder="example@email.com">
							<div class="align-left buttons-container">
								<button  type="submit">UPDATE</button>
							</div>
						</form>
					</div>
				</section>
			</section>
		</div>
	</main>
</body>
</html>