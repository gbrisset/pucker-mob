<?php 
	$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());
	($adminController->user->data['contributor_seo_name']) ? $userLink = 'profile/edit/'.$adminController->user->data['contributor_seo_name'] : $userLink = 'noacess';
	($adminController->user->data['contributor_seo_name']) ? $userLinkPublic = 'profile/user/'.$adminController->user->data['contributor_seo_name'] : $userLinkPublic = 'noacess';
?>

<div id="nav-cont" class="columns small-3 large-1 no-padding sticky hide-for-print fixed-content padding-top">
	<nav id="nav-sidemenu">
		<ul class="small-12">

			<?php if($adminController->user->data['user_permission_show_add_article'] ){?>

			<li class="small-12 columns no-border-top search-in-menu">
				<form method="get" action="<?php echo $config['this_url']; ?>admin/search" id="serch-menu-form">
			    	<div class="small-12">
					  	<div class="small-10 columns no-padding ">
							<input class="no-border-right" tabindex="1" id="search-menu" name="search-menu" type="search" placeholder="Search..." autocomplete="off" />
					  	</div> 
						<div class="small-2 columns no-padding border-right border-bottom border-top" style=" background: #fff; height: 2rem; padding: 6px;">
							<span><i class="fa fa-search"></i></span>
						</div>
					</div>
			  	</form>
			</li>
			
			<li class="small-12 columns border-top border-bottom padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url']; ?>dashboard/">DASHBOARD</a>
			</li>

			<li class="small-12 columns border-bottom padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url']; ?>articles/newarticle/">New Article</a>
			</li>

			<?php }?>
			
			<?php if($adminController->user->data['user_permission_show_edit_article'] ){?>
			<li class="small-12 columns border-bottom padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url']; ?>articles/?page=1&artype=">View & Edit Articles</a>
			</li>
			<?php }?>

			<?php if($adminController->user->data['user_permission_show_other_contributors'] ){?>
			<li class="small-12 columns border-bottom padding-top padding-bottom approval-menu">
				<a href="<?php echo $config['this_admin_url']; ?>approval/"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Approval Required</a>
			</li>
			<?php }?>

			<?php if($adminController->user->data['user_permission_show_edit_article'] ){?>
			<li class="small-12 columns border-bottom padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url']; ?>earnings/<?php echo $adminController->user->data['contributor_seo_name']; ?>">Earnings & Analytics</a>
			</li>

			<li class="small-12 columns border-bottom padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url']; ?>ranking">Ranking & Incentives</a>
			</li>	
			<li class="small-12 columns border-bottom padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url']; ?>admatching">Ad Matching</a>
			</li>	

			<li class="parent small-12 columns border-bottom padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url'].$userLinkPublic; ?>">My Profile<i class="fa fa-chevron-down"></i></a>
			</li>
				<ul class="" style="opacity: 1; z-index: 1; display: none;">
					<li class="small-12 columns border-bottom border-top padding-top padding-bottom" id="edit_contributors">
						<a href="<?php echo $config['this_admin_url'].$userLink; ?>">SET UP</a>
					</li>
					<li class="small-12 columns  padding-top padding-bottom" id="new_contributor"><a href="<?php echo $config['this_admin_url'].$userLinkPublic; ?>">View Public</a>
					</li>
					<li class="small-12 columns  padding-top padding-bottom" id="billing"><a href="<?php echo $config['this_admin_url'].'billing'; ?>">Billing</a>
					</li>

				</ul>
			</li>

			<li class="small-12 columns border-bottom padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url'].'account'; ?>">My Account</a>
			</li>
			<?php }?>

			
			<!-- CONTRIBUTORS -->
			<?php  if($adminController->user->data['user_permission_show_other_contributors']){?>
			<li class=" small-12 columns  padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url']; ?>contributors/">contributors</a>
			</li>
			<?php }?>

			<!-- REPORTS -->
			<?php  if($adminController->user->data['user_permission_show_add_contributor']){?>
			<li class="parent small-12 columns border-top  padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url']; ?>reports/">Reports<i class="fa fa-chevron-down"></i></a></li>
				<ul class="" style="opacity: 1; z-index: 1; display: none;"><h2>Reports</h2>
					<li class="small-12 columns border-top border-bottom padding-top padding-bottom" id="bloggers_report"><a href="<?php echo $config['this_admin_url']; ?>reports/"> Bloggers Report</a></li>
					<li class="small-12 columns  padding-top padding-bottom" id="writers_report"><a href="<?php echo $config['this_admin_url']; ?>reports/writersreport.php">Writers Report</a></li>
				</ul>
			</li>

			
			<li class="parent small-12 columns border-top  padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url']; ?>admin_control_panel/">Admin Control Panel<i class="fa fa-chevron-down"></i></a></li>
				<ul class="" style="opacity: 1; z-index: 1; display: none;"><h2>Admin Control Panel</h2>
					<li class="small-12 columns border-top border-bottom padding-top padding-bottom">
						<a href="<?php echo $config['this_admin_url']; ?>library/">Library</a>
					</li>
					<li class="small-12 columns border-top border-bottom padding-top padding-bottom" id="bloggers_report">
						<a href="<?php echo $config['this_admin_url']; ?>cpanel/"> CPanel</a>
					</li>
					<li class="small-12 columns border-top border-bottom padding-top padding-bottom" id="bloggers_report">
						<a href="<?php echo $config['this_admin_url']; ?>cpanel/promote"> Promote</a>
					</li>
				</ul>
			</li>
			<?php }?>
			<!--<li class="small-12 columns border-top border-bottom padding-top padding-bottom">
				<a href="#" data-reveal-id="intro-modal" class="reveal-link"  data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal">Re-Watch Intro</a> 
			</li>-->
			<li class="small-12 columns border-top border-bottom padding-top padding-bottom">
				<a href="<?php echo $config['this_admin_url']; ?>contact/">Contact Us</a>
			</li>			

			<li class="small-12 columns border-bottom padding-top padding-bottom">
				 <a href="<?php echo $config['this_admin_url']; ?>/logout/">Log Out</a>
			</li>
			
		</ul>
			
			<a style="color: #555; font-family:OsloBold; margin-top:50%;" class="padding-top small-12 columns align-right" href="http://www.puckermob.com/policy/" target="_blank">Terms Of Service</a>
			<a style="color: #555; font-family:OsloBold;"  class="padding-top small-12 columns align-right" href="http://www.puckermob.com/privacy/" target="_blank">Privacy</a>
	
	</nav>
</div>

<!-- WELCOME MODAL -->
<?php 
	//include_once($config['include_path_admin'].'welcome_modal.php'); 
?>