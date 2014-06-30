<?php
	$admin = true;
	require_once('../../assets/php/config.php');
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();
	
	if(!$adminController->user->checkPermission('user_permission_show_view_contributors')) $adminController->redirectTo('noaccess/');

	$sortId = $mpShared->getSort(isset($_GET['sort']) ? $_GET['sort'] : '');
	
	// for the new Pagination class - we only need 3 bits of info...
	// 1. the current page number ($current_page)
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		
	// 2. records per page ($per_page)
		$per_page = 15;
		$order='';
		$limit=15;
		$category = '';
		$post_date = 'all';
		$visible = '';
		if (isset($_GET['category'])) {$category = $_GET['category'];}
		if (isset($_GET['post_date']) AND $_GET['post_date'] != "all" ) {$post_date = $_GET['post_date'];}				  
		if (isset($_GET['visible'])) {$visible = intval($_GET['visible']);}

	// 3. total record count ($total_count)	
		$total_count = $mpArticle->count_all_videos();
		$pagination = new Pagination($page, $per_page, $total_count);
	
		$offset = $pagination->offset();
		$videosInfo = $mpVideoShows->getAllVideos(['limit' => $limit, 'offset' => $offset]);
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
					foreach($videosInfo as $video){
						$vid = '<div class="admin-contributor">';
							if(!empty($video['syn_video_thumb_filename'])){
							//	$vid .= '<div class="contributor-image">';
									//$vid .= '<a href="'.$config['this_admin_url'].'media/edit/'.$video['syn_video_filename'].'">';
									//	$vid .= '<img src="';
									//	$vid .= $config['image_url'].'articlesites/simpledish/series/'.$video['syn_video_id'].'-video-wide.jpg" alt="'.$video['syn_video_title'].' Image" />';
							//		$vid .= '</a>';
							//	$vid .= '</div>';
							}
							
							$vid .= '<div class="contributor-info">';
								$vid .= '<h2><a href="'.$config['this_admin_url'].'media/edit/'.$video['syn_video_filename'].'">'.$video['syn_video_title'].'</a></h2>';
								$bio = utf8_encode(trim(strip_tags($video['syn_video_desc'])));
								$bio = (strlen($bio) > 500) ? substr($bio, 0, 500).'...' : $bio;
								$vid .= '<p>'.$bio.'</p>';
							$vid .= '</div>';

							$vid .= '<div class="btn-wrapper">';
								$vid .= '<a href="'.$config['this_admin_url'].'media/edit/'.$video['syn_video_filename'].'"><button type="submit">Edit</button></a>';
							$vid .= '</div>';
						$vid .= '</div>';
						echo $vid;
					}
				?>
			</section>

			<?php  include_once($config['include_path_admin'].'pages.php');?>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>