<?php 
	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());
	($adminController->user->data['user_name']) ? $userLink = 'account/user/'.$adminController->user->data['user_name'] : $userLink = 'noacess';
?>
<!--<h1 class="main-header"><a href="<?php // echo $config['this_admin_url'].'articles/'?>">My Pucker Mob</a></h1>-->
<div id="nav-cont" class="columns small-3 large-1 no-padding sticky hide-for-print fixed-content padding-top">
	<nav id="nav-sidemenu">

		<!-- 
			
		-->
		<ul>
			<?php
				
				/* Begin Manage Categories Menu Generation */
				/*$siteNavItem = array(
					'link' => $config['this_admin_url'].'categories/',
					'label' => 'Categories',
					'shown' => (isset($uri[0]) && $uri[0] == 'categories') ? 'shown' : '',
					'childElements' => array(
						array(
							'childId' => 'edit_categories',
							'childLink' => $config['this_admin_url'].'categories/',
							'childLabel' => 'View/Edit Categories',
							'current' => (isset($uri[0]) && $uri[0] == 'categories' && isset($uri[1]) && (empty($uri[1]) || $uri[1] == 'edit')) ? 'current' : ''
						)
					)
				);
				*/
				//if($adminController->user->checkPermission('user_permission_show_manage_categories')) 	echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'categories/', 'label' => 'Manage Categories', 'current' => (isset($uri[0]) && $uri[0] == 'categories' && isset($uri[1]) && (empty($uri[1]) || $uri[1] == 'edit')) ? 'current' : ''));

					//echo $adminController->makeNavItemGroup($siteNavItem);
				
				/* End Manage Categories Menu Generation */


				/* Begin Manage Articles Menu Generation */
				if($adminController->user->checkPermission('user_permission_show_add_article') ){
					echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'articles/newarticle/', 'label' => 'Add New Article', 'current' => (isset($uri[0]) && $uri[0] == 'articles' && isset($uri[1]) && $uri[1] == 'new') ? 'current' : ''));
				}
				if($adminController->user->checkPermission('user_permission_show_view_article') ){
					echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'articles/', 'label' => 'View/Edit Articles', 'current' => (isset($uri[0]) && $uri[0] == 'articles' && isset($uri[1]) && (empty($uri[1]) || $uri[1] == 'edit')) ? 'current' : ''));
				}
				/*
				$siteNavItem = array(
					'link' => $config['this_admin_url'].'articles/',
					'label' => 'My Articles',
					'shown' => (isset($uri[0]) && $uri[0] == 'articles') ? 'shown' : '',
				);*/


			/*	if($adminController->user->checkPermission('user_permission_show_add_article') ) $siteNavItem['childElements'][] = array(
					'childId' => 'new_article',
					'childLink' => $config['this_admin_url'].'articles/newarticle/',
					'childLabel' => 'Add New Article',
					'current' => (isset($uri[0]) && $uri[0] == 'articles' && isset($uri[1]) && $uri[1] == 'new') ? 'current' : ''
				);

				$siteNavItem['childElements'][] = array(
					'childId' => 'edit_articles',
					'childLink' => $config['this_admin_url'].'articles/',
					'childLabel' => 'View/Edit Articles',
					'current' => (isset($uri[0]) && $uri[0] == 'articles' && isset($uri[1]) && (empty($uri[1]) || $uri[1] == 'edit')) ? 'current' : ''
				);*/

				//if($adminController->user->checkPermission('user_permission_show_manage_articles')) echo $adminController->makeNavItemGroup($siteNavItem);
				/* End Manage Articles Menu Generation */




				/* Begin Manage Lists Menu Generation */
				
				if($adminController->user->checkPermission('user_permission_show_manage_lists') ){
					echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'lists/new/', 'label' => 'Add New List', 'current' => (isset($uri[0]) && $uri[0] == 'lists' && isset($uri[1]) && $uri[1] == 'new') ? 'current' : ''));
					echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'lists/', 'label' => 'View/Edit Lists', 'current' => (isset($uri[0]) && $uri[0] == 'lists' && isset($uri[1]) && (empty($uri[1]) || $uri[1] == 'edit')) ? 'current' : ''));

				}


				/*$siteNavItem = array(
					'link' => $config['this_admin_url'].'lists/',
					'label' => 'Manage Lists',
					'shown' => (isset($uri[0]) && $uri[0] == 'lists') ? 'shown' : '',
					'childElements' => array(
						array(
							'childId' => 'edit_lists',
							'childLink' => $config['this_admin_url'].'lists/',
							'childLabel' => 'View/Edit Lists',
							'current' => (isset($uri[0]) && $uri[0] == 'articles' && isset($uri[1]) && (empty($uri[1]) || $uri[1] == 'edit')) ? 'current' : ''
						)
					)
				);

				if($adminController->user->checkPermission('user_permission_show_manage_lists')) echo $adminController->makeNavItemGroup($siteNavItem);*/
				/* End Manage Articles Menu Generation */

				$label = 'Contributors';
				$link = $config['this_admin_url'].'contributors/';
				$childeditLabel = 'View/Edit Contributors';
				if(!$adminController->user->data['user_permission_show_other_contributors']){
					if(!isset($contributorInfoObj)) {

						$contributorInfoObj = $mpArticle->getContributors(['contributorEmail' =>  $adminController->user->data['user_email']])['contributors'];
						$contributorInfoObj = $contributorInfoObj[0];
					}
					$link = $config['this_admin_url'].'contributors/edit/'.$contributorInfoObj['contributor_seo_name'];
					$label = 'Manage Contributor';
					$childeditLabel = 'View/Edit your information';
				}
				$siteNavItem = array(
					'link' => $link,
					'label' => $label,
					'shown' => (isset($uri[0]) && $uri[0] == 'contributors') ? 'shown' : '',
					'childElements' => array(
						array(
							'childId' => 'edit_contributors',
							'childLink' => $link,
							'childLabel' => $childeditLabel,
							'current' => (isset($uri[0]) && $uri[0] == 'contributors' && isset($uri[1]) && (empty($uri[1]) || $uri[1] == 'edit')) ? 'current' : ''
						)
					)
				);

				if($adminController->user->checkPermission('user_permission_show_add_contributor') ) $siteNavItem['childElements'][] = array(
					'childId' => 'new_contributor',
					'childLink' => $config['this_admin_url'].'contributors/new/',
					'childLabel' => 'Add New Contributor',
					'current' => (isset($uri[0]) && $uri[0] == 'contributors' && isset($uri[1]) && $uri[1] == 'new') ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_manage_contributors')) echo $adminController->makeNavItemGroup($siteNavItem);
				/* End Manage Contributors Menu Generation */
				if($adminController->user->checkPermission('user_permission_show_add_article') ){
					echo '<li class="empty-li"></li>';
				}
				
				echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'dashboard/', 'label' => 'My Dashboard', 'current' => (isset($uri[1]) && $uri[1] == 'dashboard') ? 'current' : ''));
	
				echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].$userLink, 'label' => 'My Profile', 'current' => (isset($uri[1]) && $uri[1] == 'user') ? 'current' : ''));

				echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'contact/', 'label' => 'Contact Us', 'current' => (isset($uri[0]) && $uri[0] == 'contact') ? 'current' : '' ));

				echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'logout/', 'label' => 'Sign Out'));
			?>
		</ul>
	</nav>
</div>