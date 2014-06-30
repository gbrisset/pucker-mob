<?php 
	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());
	($adminController->user->data['user_name']) ? $userLink = 'account/user/'.$adminController->user->data['user_name'] : $userLink = 'noacess';
?>
<header class="main-header"><a href="<?php echo $config['this_admin_url'].'articles/'?>">My Pucker Mob</a></header>
<div id="nav-cont">
	<nav id="nav-sidemenu">
		<ul>
			<?php
				/* Begin Manage Site Menu Generation */
				/*$siteNavItem = array(
					'link' => $config['this_admin_url'].'site/',
					'label' => 'Manage Site',
					'shown' => (isset($uri[0]) && $uri[0] == 'site') ? 'shown' : '',
					'childElements' => array()
				);

				if($adminController->user->checkPermission('user_permission_show_generic_settings')) $siteNavItem['childElements'][] = array(
					'childId' => 'site_generic',
					'childLink' => $config['this_admin_url'].'site/',
					'childLabel' => 'Generic Settings',
					'current' => (isset($uri[0]) && $uri[0] == 'site' && isset($uri[1]) && empty($uri[1])) ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_search_settings')) $siteNavItem['childElements'][] = array(
					'childId' => 'site_search',
					'childLink' => $config['this_admin_url'].'site/search/',
					'childLabel' => 'Search Settings',
					'current' => (isset($uri[0]) && $uri[0] == 'site' && isset($uri[1]) && $uri[1] == 'search') ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_player_settings')) $siteNavItem['childElements'][] = array(
					'childId' => 'site_player',
					'childLink' => $config['this_admin_url'].'site/player/',
					'childLabel' => 'Player Settings',
					'current' => (isset($uri[0]) && $uri[0] == 'site' && isset($uri[1]) && $uri[1] == 'player') ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_social_settings')) $siteNavItem['childElements'][] = array(
					'childId' => 'site_social',
					'childLink' => $config['this_admin_url'].'site/social/',
					'childLabel' => 'Social Network Settings',
					'current' => (isset($uri[0]) && $uri[0] == 'site' && isset($uri[1]) && $uri[1] == 'social') ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_ad_settings')) $siteNavItem['childElements'][] = array(
					'childId' => 'site_ads',
					'childLink' => $config['this_admin_url'].'site/ads/',
					'childLabel' => 'Ad Placement Settings',
					'current' => (isset($uri[0]) && $uri[0] == 'site' && isset($uri[1]) && $uri[1] == 'ads') ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_styling_settings')) $siteNavItem['childElements'][] = array(
					'childId' => 'site_styling',
					'childLink' => $config['this_admin_url'].'site/styling/',
					'childLabel' => 'Styling Settings',
					'current' => (isset($uri[0]) && $uri[0] == 'site' && isset($uri[1]) && $uri[1] == 'styling') ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_manage_site')) echo $adminController->makeNavItemGroup($siteNavItem);*/
				/* End Manage Site Menu Generation */

				/* Begin Manage SlideShow Menu Generation */
				/*$siteNavItem = array(
					'link' => $config['this_admin_url'].'slideshow/',
					'label' => 'Manage HP Slideshow',
					'shown' => (isset($uri[0]) && $uri[0] == 'slideshow') ? 'shown' : '',
					'childElements' => array(
						array(
							'childId' => 'edit_slideshow',
							'childLink' => $config['this_admin_url'].'slideshow/',
							'childLabel' => 'View / Edit SlideShow',
							'current' => (isset($uri[0]) && $uri[0] == 'slideshow' && isset($uri[1]) && (empty($uri[1]) || $uri[1] == 'edit')) ? 'current' : ''
						)
					)
				);

				if($adminController->user->checkPermission('user_permission_show_manage_site')) $siteNavItem['childElements'][] = array(
					'childId' => 'new_slideshow',
					'childLink' => $config['this_admin_url'].'slideshow/new',
					'childLabel' => 'Add New Slide',
					'current' => (isset($uri[0]) && $uri[0] == 'slideshow' && isset($uri[1]) && $uri[1] == 'new') ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_manage_site')) echo $adminController->makeNavItemGroup($siteNavItem);
				*/
				/* End Manage SlideShow Menu Generation */


				/* Begin Manage Categories Menu Generation */
				$siteNavItem = array(
					'link' => $config['this_admin_url'].'categories/',
					'label' => 'Manage Categories',
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

				if($adminController->user->checkPermission('user_permission_show_manage_categories')) echo $adminController->makeNavItemGroup($siteNavItem);
				/* End Manage Categories Menu Generation */

				/* Begin Manage Collections Menu Generation */
				/*
				$siteNavItem = array(
					'link' => $config['this_admin_url'].'recipe_collections/',
					'label' => 'Manage Collections',
					'shown' => (isset($uri[0]) && $uri[0] == 'recipe_collections') ? 'shown' : '',
					'childElements' => array(
						array(
							'childId' => 'edit_categories',
							'childLink' => $config['this_admin_url'].'recipe_collections/',
							'childLabel' => 'View/Edit Collections',
							'current' => (isset($uri[0]) && $uri[0] == 'recipe_collections' && isset($uri[1]) && (empty($uri[1]) || $uri[1] == 'edit')) ? 'current' : ''
						)
					)
				);

				if($adminController->user->checkPermission('user_permission_show_add_collection')) $siteNavItem['childElements'][] = array(
					'childId' => 'new_collection',
					'childLink' => $config['this_admin_url'].'recipe_collections/new/',
					'childLabel' => 'Add New Collection',
					'current' => (isset($uri[0]) && $uri[0] == 'recipe_collections' && isset($uri[1]) && $uri[1] == 'new') ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_manage_categories')) echo $adminController->makeNavItemGroup($siteNavItem);
	*/
				/* End Manage Collections Menu Generation */



				/* Begin Manage Articles Menu Generation */
				
				$siteNavItem = array(
					'link' => $config['this_admin_url'].'articles/',
					'label' => 'My Articles',
					'shown' => (isset($uri[0]) && $uri[0] == 'articles') ? 'shown' : '',
				);


				if($adminController->user->checkPermission('user_permission_show_add_article') ) $siteNavItem['childElements'][] = array(
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
				);

				if($adminController->user->checkPermission('user_permission_show_manage_articles')) echo $adminController->makeNavItemGroup($siteNavItem);
				/* End Manage Articles Menu Generation */




				/* Begin Manage Lists Menu Generation */
				$siteNavItem = array(
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

				if($adminController->user->checkPermission('user_permission_show_manage_lists')) echo $adminController->makeNavItemGroup($siteNavItem);
				/* End Manage Articles Menu Generation */




				/* Begin Manage Media Menu Generation */
				/*
				$siteNavItem = array(
					'link' => $config['this_admin_url'].'media/',
					'label' => 'Manage Media',
					'shown' => (isset($uri[0]) && $uri[0] == 'media') ? 'shown' : '',
					'childElements' => array(
						array(
							'childId' => 'edit_media',
							'childLink' => $config['this_admin_url'].'media/',
							'childLabel' => 'View/Edit Videos',
							'current' => (isset($uri[0]) && $uri[0] == 'media' && isset($uri[1]) && (empty($uri[1]) || $uri[1] == 'new')) ? 'current' : ''
						)
					)
				);

				if($adminController->user->checkPermission('user_permission_show_add_media')) $siteNavItem['childElements'][] = array(
					'childId' => 'add_media',
					'childLink' => $config['this_admin_url'].'media/new/',
					'childLabel' => 'Add Video',
					'current' => (isset($uri[0]) && $uri[0] == 'media' && isset($uri[1]) && $uri[1] == 'new') ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_add_media')) $siteNavItem['childElements'][] = array(
					'childId' => 'view_series',
					'childLink' => $config['this_admin_url'].'media/series/',
					'childLabel' => 'View/Edit Series',
					'current' => (isset($uri[0]) && $uri[0] == 'media' && isset($uri[1]) && $uri[1] == 'new') ? 'current' : ''
				);

				if($adminController->user->checkPermission('user_permission_show_add_media')) $siteNavItem['childElements'][] = array(
					'childId' => 'add_series',
					'childLink' => $config['this_admin_url'].'media/addseries/',
					'childLabel' => 'Add Series',
					'current' => (isset($uri[0]) && $uri[0] == 'media' && isset($uri[1]) && $uri[1] == 'new') ? 'current' : ''
				);	

				if($adminController->user->checkPermission('user_permission_show_manage_media')) echo $adminController->makeNavItemGroup($siteNavItem);
				*/
				/* End Manage Categories Menu Generation */

				/* Begin Manage Contributors Menu Generation */
				
				$label = 'Manage Contributors';
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


				/* Begin Global Settings Menu Generation */
				/*
				$siteNavItem = array(
					'link' => $config['this_admin_url'].'globals/users/',
					'label' => 'Global Settings',
					'shown' => (isset($uri[0]) && $uri[0] == 'globals') ? 'shown' : '',
					'childElements' => array(
						array(
							'childId' => 'edit_users',
							'childLink' => $config['this_admin_url'].'globals/users/',
							'childLabel' => 'Manage Users',
							'current' => (isset($uri[0]) && $uri[0] == 'globals' && isset($uri[1]) && $uri[1] == 'users') ? 'current' : ''
						),
						array(
							'childId' => 'new_site',
							'childLink' => $config['this_admin_url'].'globals/newsite/',
							'childLabel' => 'Add New Site',
							'current' => (isset($uri[0]) && $uri[0] == 'globals' && isset($uri[1]) && $uri[1] == 'newsite') ? 'current' : ''
						)
					)
				);

				if($adminController->user->checkPermission('user_permission_show_global_settings')) echo $adminController->makeNavItemGroup($siteNavItem);*/
				/* End Global Settings Menu Generation */
				echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].$userLink, 'label' => 'My Profile', 'current' => (isset($uri[1]) && $uri[1] == 'user') ? 'current' : ''));

				echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'contact/', 'label' => 'Contact Us', 'current' => (isset($uri[0]) && $uri[0] == 'contact') ? 'current' : '' ));

				// echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'bug/', 'label' => 'Report a Bug', 'current' => (isset($uri[0]) && $uri[0] == 'bug') ? 'current' : '' ));

				echo $adminController->makeSingleNavItem(array('link' => $config['this_admin_url'].'logout/', 'label' => 'Sign Out'));
			?>
		</ul>
	</nav>
</div>