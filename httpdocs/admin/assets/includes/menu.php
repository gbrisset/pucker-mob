<?php 
	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());
	($adminController->user->data['user_name']) ? $userLink = 'account/user/'.$adminController->user->data['user_name'] : $userLink = 'noacess';
?>

<div id="nav-cont" class="columns small-3 large-1 no-padding sticky hide-for-print fixed-content padding-top">
	<nav id="nav-sidemenu">
		<ul>
			<!-- SINGLE ARTICLES -->
			<?php if($adminController->user->checkPermission('user_permission_show_add_article') ){?>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'articles') && (isset($uri[1]) && $uri[1] == 'newarticle')) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>articles/newarticle/">Add New Article</a>
				<i class="fa fa-caret-left"></i>
			</li>
			<?php }?>
			<?php if($adminController->user->checkPermission('user_permission_show_edit_article') ){?>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'articles') && (isset($uri[1]) && $uri[1] == '' || $uri[1] == 'edit')) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>articles/">View/Edit Articles</a>
				<i class="fa fa-caret-left"></i>
			</li>
			<?php }?>

			<!-- MULTIPAGE ARTICLES -->
			<?php if($adminController->user->checkPermission('user_permission_show_manage_lists') ){?>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'lists') &&  (isset($uri[1]) && $uri[1] == 'new')) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>lists/new/">Add New List</a>
				<i class="fa fa-caret-left"></i>
			</li>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'lists') &&  (isset($uri[1]) && $uri[1] == '' || $uri[1] == 'edit')) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>lists/">View/Edit Lists</a>
				<i class="fa fa-caret-left"></i>
			</li>
			<?php }?>
			
			<!-- CONTRIBUTORS -->
			<?php  if($adminController->user->data['user_permission_show_other_contributors']){?>
			<li class="parent "><a href="<?php echo $config['this_admin_url']; ?>contributors/">Contributors</a></li>
			<ul class="" style="opacity: 1; z-index: 1; display: none;"><h2>Contributors</h2>
				<li class="" id="edit_contributors"><a href="<?php echo $config['this_admin_url']; ?>contributors/">View/Edit Contributors</a></li>
				<li class="" id="new_contributor"><a href="<?php echo $config['this_admin_url']; ?>contributors/new/">Add New Contributor</a></li>
			</ul>
			<?php }?>

			<li class="empty-li"></li>

			<?php if($adminController->user->checkPermission('user_permission_show_add_notifications')){?>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'notifications') ) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>notifications/">Notifications</a>
				<i class="fa fa-caret-left"></i>
			</li>
			<?php }?>

			<?php if($adminController->user->checkPermission('user_permission_show_add_contributor')){?>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'reports') ) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>reports/">Get Report</a>
				<i class="fa fa-caret-left"></i>
			</li>
			<?php }?>

			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'dashboard') ) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>dashboard/">View earnings</a>
				<i class="fa fa-caret-left"></i>
			</li>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'account') ) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url'].$userLink; ?>">My Profile</a>
				<i class="fa fa-caret-left"></i>
			</li>
			<li class="<?php echo ((isset($uri[0]) && $uri[0] == 'contact') ) ?  'current' :  '';?>">
				<a href="<?php echo $config['this_admin_url']; ?>contact/">Contact Us</a>
				<i class="fa fa-caret-left"></i>
			</li>
		</ul>
	</nav>
</div>