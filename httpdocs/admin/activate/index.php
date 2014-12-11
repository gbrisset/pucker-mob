<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if($adminController->user->getLoginStatus()) $adminController->redirectTo('');

	if(isset($_GET['c'])){
		if($_GET['c'] == "resend") $resend = $adminController->user->resendUserVerify();
		else {
			$activate = $adminController->user->doUserActivation($_GET['c']);
		}
	}else $adminController->redirectTo('login/');
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body class="background-blue">
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right background-blue" role="main">
		<section id="verify-cont" class="admin-logout-content admin-box mobile-12 small-12 large-4 auto-margin">
			
			<div class="admin-box mobile-12 small-12 auto-margin" id="login-cont">
			<?php
				if(isset($activate)){
			?>
				<h1>Activate</h1>
				<div class="white-box" id="activate-cont">					
					<p class="<?php echo ($activate['hasError'] == true) ? "error" : "success"; ?>"><?php echo $activate['message']; ?></p>
				</div>
			<?php
				}elseif(isset($resend)){
			?>
				<h1 style="font-size:2rem;">Resend Activation Email</h1>
				<div class="white-box" id="activate-cont">	
					<p class="<?php echo ($resend['hasError'] == true) ? "error" : "success"; ?>"><?php echo $resend['message']; ?></p>
				</div>
			<?php } ?>
			</div>
		</section>
	</main>
	<?php if(isset($activate['hasError']) && !$activate['hasError']){ ?>
		<?php $_SESSION['csrf'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time()); ?>
		<script>setTimeout(function(){window.location = "<?php echo $config['this_admin_url']; ?>"}, 2000);</script>
	<?php } ?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>