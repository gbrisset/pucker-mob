<?php 
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	//Verify if is a content provider user
	$content_provider = false;


	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$admin_user = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
		$admin_user = true;
	}

	if(!$adminController->user->checkPermission('user_permission_show_add_notifications')) $adminController->redirectTo('noaccess/');

	$ManageDashboard = new ManageAdminDashboard( $config );
	$warnings = $ManageDashboard->getWarningsMessages(); 
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!

			$updateStatus = $ManageDashboard->saveWarningsMessages($_POST);
			$updateStatus['arrayId'] = 'article-warnings-form';

			$warnings = $ManageDashboard->getWarningsMessages(); 
		

			if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
		}else $adminController->redirectTo('logout/');
	}

	$annoucements = $ManageDashboard->getAnnouncements(); 

	if(isset($_POST['submit-announcement'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			
			$updateStatus = $ManageDashboard->saveAnnouncements($_POST);
			$updateStatus['arrayId'] = 'article-announcements-form';

			$annoucements = $ManageDashboard->getAnnouncements(); 

			if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
		}else $adminController->redirectTo('logout/');
	}
	
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
		<h1 class="left">Notification Center</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up  hide">
			<h1 class="left">Notification Center</h1>
			
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<section id="articles">
				<form  id="article-warnings-form" name="article-warnings-form" action="<?php echo $config['this_admin_url']; ?>notifications/" method="POST" novalidate>
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<!-- WARNING CONTENT -->
					<div class="row padding-bottom">
						  <div class="columns">
						<h2 class="small-12 large-12 left uppercase margin-top">Warnings </h2>
						</div>
					    <div class="columns">
							<textarea  class="editor" name="notification_msg" id="notification_msg" rows="5" placeholder="START WRITING HERE." ><?php if(isset($warnings[0]['notification_msg'])) echo $warnings[0]['notification_msg']; ?></textarea>
						</div>
					</div>

					<!-- WARNING STATUS  -->
					<?php if($admin_user){?>
					<div class="row">
					    <div class="columns">
							<label class="small-12 large-3 left uppercase">Status: </label>
							
							<input type="radio" name="notification_live" id="show" data-info="1"  value="1" <?php if($warnings[0]['notification_live'] == 1) echo "checked"; ?> />
							<label for="" class="radio-label">Show</label>
									
							<input type="radio" name="notification_live" data-info="0" id="hide" value="0" <?php if($warnings[0]['notification_live'] == 0) echo "checked"; ?> />
							<label for="" class="radio-label">Hide</label>
						</div>
					</div>
					<?php }?>
					<div class="row buttons-container">
						<button type="submit" id="submit" name="submit" class="">SAVE</button>	
					</div>
				</form>
				
				<hr>
				
				<!-- ANNOUNCEMENTS -->
				<form  id="article-announcements-form" name="article-announcements-form" action="<?php echo $config['this_admin_url']; ?>notifications/" method="POST" novalidate>
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<!-- ANNOUNCEMENTS CONTENT -->
					<div class="row padding-bottom">
						  <div class="columns">
						<h2 class="small-12 large-12 left uppercase">ANNOUNCEMENTS </h2>
						</div>
					    <div class="columns">
							<textarea  class="editor" name="notification_annoucement_msg editor" id="notification_annoucement_msg" rows="5" placeholder="START WRITING HERE." ><?php if(isset($annoucements[0]['notification_msg'])) echo $annoucements[0]['notification_msg']; ?></textarea>
						</div>
					</div>

					<!-- ANNOUNCEMENTS STATUS  -->
					<?php if($admin_user){?>
					<div class="row">
					    <div class="columns">
							<label class="small-12 large-3 left uppercase">Status: </label>
							
							<input type="radio" name="notification_annoucement_live" id="show" data-info="1"  value="1" <?php if($annoucements[0]['notification_live'] == 1) echo "checked"; ?> />
							<label for="" class="radio-label">Show</label>
									
							<input type="radio" name="notification_annoucement_live" data-info="0" id="hide" value="0"  <?php if($annoucements[0]['notification_live'] == 0) echo "checked"; ?> />
							<label for="" class="radio-label">Hide</label>
						</div>
					</div>
					<?php }?>
					<div class="row buttons-container">
						<button type="submit" id="submit-announcement" name="submit-announcement" class="">SAVE</button>	
					</div>
				</form>
			</section>
		</div>	
	</main>
	<?php include_once($config['include_path_admin'].'footer.php');?>

	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>