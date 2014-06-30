<?php
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$adminController->user->data = $adminController->user->getUserInfo();
	
	if(!$adminController->user->checkPermission('user_permission_show_view_categories')) $adminController->redirectTo('noaccess/');
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
			<section id="categories-list">
				<header class="section-bar">
					<h2>Categories</h2>
				</header>

				<?php
				
					$cats = $MPNavigation->categories;
					foreach($cats as $subArray){
						if($subArray['cat_id'] != 23){
							$category = '<div class="admin-category">';
								$category .= '<h2><a href="'.$config['this_admin_url'].'categories/edit/'.$subArray['cat_dir_name'].'">'.$subArray['cat_name'].'</a></h2>';
								
								$category .= '<p>'.$subArray['cat_desc'].'</p>';
								
								$category .= '<div class="btn-wrapper">';
									$category .= '<a href="'.$config['this_admin_url'].'categories/edit/'.$subArray['cat_dir_name'].'"><button type="submit">Edit</button></a>';
								$category .= '</div>';
							$category .= '</div>';
							echo $category;
						}
					}
				?>
			</section>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>