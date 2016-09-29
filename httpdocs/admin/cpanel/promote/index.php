<?php 
	$admin = true;
	require_once('../../../assets/php/config.php');

	
	$ManageDashboard = new ManageAdminDashboard( $config );
	$helper = new Helpers();
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$userObj = new User( $userData['user_email'] ); 

	if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');

	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	if (isset($userData['user_permission_show_other_user_articles']) && $userData['user_permission_show_other_user_articles'] == 1){
		$userArticlesFilter = 'all';
	}
	//GET PROMOTED ARTICLES
	$promoteObj = new PromoteArticles();

	/********** PAGINATION ***********/
	// 1. the current page number ($current_page)
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$per_page = 25;
		$limit=25;

	//total record count ($total_count)	
	$articles = $promoteObj->getArticlesToPromote( " facebook_page_id != 7   ORDER BY date_updated ASC ");	
	
	$total_count = count($articles);
	$pagination = new Pagination($page, $per_page, $total_count);	
	$offset = $pagination->offset();
	$filters = " LIMIT $limit  OFFSET $offset ";
 	/********** END PAGINATION ***********/
	
	//Filter Articles 
	$allCurrent = 'current';
	$writersCurrent = $bloggersCurrent = '';

	$artType = isset($_GET["artype"]) ? $_GET["artype"] : '';
	$allCurrent = '';
	switch($artType){
		case 'bloggers':
			$articles = $promoteObj->getArticlesToPromote( " user_type IN (3, 8)  ORDER BY date_updated ASC ", $filters );
			$bloggersCurrent = 'current';
		break;

		case 'writers':
			$articles = $promoteObj->getArticlesToPromote( " user_type IN (1, 6, 7)  ORDER BY date_updated ASC ",  $filters);
			$writersCurrent = 'current';
		break;

		default:
			$articles = $promoteObj->getArticlesToPromote( " facebook_page_id != 7   ORDER BY date_updated ASC ",  $filters);
			$allCurrent = 'current';
			break;
	}

	//var_dump($articles); 
	
	$userType_URL = $config['this_admin_url'].'cpanel/promote?page=1';
	$order='';

	//Facebook Pages
	$facebook_pages = $promoteObj->getAllFacebookPages();
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="control-panel">
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="  mobile-12 small-12 columns padding-bottom ">
				<h1>PROMOTE</h1>
			</div>
			
			<!-- ARTICLES RESUME INFO --> 
			<?php include_once($config['include_path_admin'].'view_articles_resume.php'); ?>
			
			<div class="small-12 xxlarge-9 columns chart_wrapper_div">				
				<?php include_once($config['include_path_admin'].'articles_to_promote.php'); ?>

				<?php include_once($config['include_path_admin'].'pages.php'); ?>

			</div>

			<!-- Right Side -->
			<div class="small-12 xxlarge-3 right padding rightside-padding" style="padding: 0 15px !important;" >
				
					<?php include_once($config['include_path_admin'].'filter_by_usertype.php'); ?>

					<div class="small-12 columns show-for-large-up half-margin-top no-padding">
						<?php include_once($config['include_path_admin'].'facebook_pages.php'); ?>
					</div>				
			</div>

		</div>

	</main>

	<!-- INFO BADGE 
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php //include($config['include_path_admin'].'info-badge.php');?>
	</div>-->
	<?php //include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
