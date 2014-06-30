<?php
	$admin = true;
	require_once('../../assets/php/config.php');
    
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();
	
	if(!$adminController->user->checkPermission('user_permission_show_add_media')) $adminController->redirectTo('noaccess/');

	$sortId = $mpShared->getSort(isset($_GET['sort']) ? $_GET['sort'] : '');
	
	$seriesInfo = $mpVideoShows->series;

	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<?php include_once($config['include_path_admin'].'header.php');?>

	<div id="main-cont">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content">
			<section id="contributors-list">
				<header class="section-bar">
					<h2 class="left">Videos</h2>
				</header>

				<?php
					foreach($seriesInfo as $series){
						//var_dump($series);
						$vid = '<div class="admin-contributor">';
							$vid .= '<div class="contributor-info">';
								$vid .= '<h2><a href="'.$config['this_admin_url'].'media/editseries/'.$series['article_page_series_seo'].'">'.$series['article_page_series_title'].'</a></h2>';
								$bio = utf8_encode(trim(strip_tags($series['article_page_series_desc'])));
								$bio = (strlen($bio) > 500) ? substr($bio, 0, 500).'...' : $bio;
								$vid .= '<p>'.$bio.'</p>';
							$vid .= '</div>';

							$vid .= '<div class="btn-wrapper">';
								$vid .= '<a href="'.$config['this_admin_url'].'media/editseries/'.$series['article_page_series_seo'].'"><button type="submit">Edit</button></a>';
							$vid .= '</div>';
						$vid .= '</div>';
						echo $vid;
					}
				?>
			</section>

			<?php // include_once($config['include_path_admin'].'pages.php');?>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>