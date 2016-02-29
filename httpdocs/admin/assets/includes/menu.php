<?php 
	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());
	($adminController->user->data['user_name']) ? $userLink = 'account/user/'.$adminController->user->data['user_name'] : $userLink = 'noacess';

?>

<div id="nav-cont" class="columns small-3 large-1 no-padding sticky hide-for-print fixed-content padding-top">
	<nav id="nav-sidemenu">
		<ul>
			
			<?php if($adminController->user->checkPermission('user_permission_show_add_article') ){?>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'dashboard') ) ?  'current' :  '';?> margin-top">
				<a href="<?php echo $config['this_admin_url']; ?>dashboard/"> <i class="fa fa-bar-chart"></i>DASHBOARD</a>
			</li>
			<?php }?>
			
			<!-- SINGLE ARTICLES -->
			<?php if($adminController->user->checkPermission('user_permission_show_add_article') ){?>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'articles') && (isset($uri[1]) && $uri[1] == 'newarticle')) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>articles/newarticle/">New Article</a>
			</li>
			<?php }?>
			<?php if($adminController->user->checkPermission('user_permission_show_edit_article') ){?>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'articles') && (isset($uri[1]) && $uri[1] == '' || $uri[1] == 'edit')) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>articles/?page=1&sort=1&artype=">View Articles</a>
			</li>
			<?php }?>

			
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'account') ) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url'].$userLink; ?>">My Profile</a>
			</li>
			
			<?php if($adminController->user->checkPermission('user_permission_show_add_article') ){?>
			<li style=" border-bottom: 1px solid #999;" class="<?php echo ((isset($uri[0]) && $uri[0] == 'billing') ) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>billing/">billing information</a>
			</li>
			
			<!-- CONTRIBUTORS -->
			<?php  if($adminController->user->data['user_permission_show_other_contributors']){?>
			<li class="parent "><a href="<?php echo $config['this_admin_url']; ?>contributors/">Contributors<i class="fa fa-chevron-down"></i></a></li>
			<ul class="" style="opacity: 1; z-index: 1; display: none;"><h2>Contributors</h2>
				<li class="" id="edit_contributors"><a href="<?php echo $config['this_admin_url']; ?>contributors/">View Contributor</a></li>
				<li class="" id="new_contributor"><a href="<?php echo $config['this_admin_url']; ?>contributors/new/">New Contributor</a></li>
			</ul>
			<?php }?>

			<!-- REPORTS -->
			<?php  if($adminController->user->data['user_permission_show_add_contributor']){?>
			<li class="parent "><a href="<?php echo $config['this_admin_url']; ?>reports/">Reports<i class="fa fa-chevron-down"></i></a></li>
			<ul class="" style="opacity: 1; z-index: 1; display: none;"><h2>Reports</h2>
				<li class="" id="bloggers_report"><a href="<?php echo $config['this_admin_url']; ?>reports/"> Bloggers Report</a></li>
				<li class="" id="writers_report"><a href="<?php echo $config['this_admin_url']; ?>reports/writersreport.php">Writers Report</a></li>
			</ul>
			<?php }?>

			
			<?php if($adminController->user->checkPermission('user_permission_show_add_notifications')){?>
			<li style=" border-bottom: 1px solid #999;" class="<?php echo ((isset($uri[0]) && $uri[0] == 'notifications') ) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>notifications/"><i class="fa fa-bell-o"></i> Notifications</a>
			</li>
			<?php }?>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'faq') ) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>faq/" target="blank">FAQ</a>
			</li>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'faq') ) ?  'current' :  '';?>">
				<a href="mailto:fguzman@sequelmediagroup.com?subject= Report A Bug &body=If something's not working on PuckerMob  you can report it to us. Giving more detail (ex: adding a screenshot and description) helps us find the problem. We may contact you for more details as we investigate. We appreciate the time it takes to give us this information.  [Report a Feature problem here]" ><i class="fa fa-bug"></i> Report a Bug</a>
			</li>

			<li style=" border-bottom: 1px solid #999;" class="<?php echo ((isset($uri[0]) && $uri[0] == 'contact') ) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>contact/">Contact Us</a>
			</li>

			<?php }?>

			<li class="margin-top">
				<i class="fa fa-sign-out" style="color: #fff;"></i> <a href="<?php echo $config['this_admin_url']; ?>/logout/">Sign Out</a>
			</li>

			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'delete') ) ?  'current' :  '';?>">
				<a href="#" id="delete-account">Delete Account</a>
			</li>
		</ul>
	</nav>
</div>