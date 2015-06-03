<?php
	$new_visitor = false;
	$username = "";
	$admin = true;
	require_once('../assets/php/config.php');

	if(!$adminController->user->getLoginStatus()) {
		$adminController->redirectTo('login/');
		$somevar = 0;
	} else{
		$userData = $adminController->user->data = $adminController->user->getUserInfo();
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
		<h1 class="left">MOB LEVELS</h1>
	</div>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div id="following-header" class="following-header mobile-12 small-12 padding-bottom">
				<header>MOB LEVELS</header>
			</div>
			
			<section class="mob-levels-content">
				<h2>When you join the mob, you automatically begin at the entry level. Dedicated bloggers may be promoted to the pro level, with increased benefits:</h2>
				<table class="small-12 margin-top">
					<thead>
						<tr>
							<td class="small-8"></td>
							<td class="small-2 big-td">BASIC</td>
							<td class="small-2 big-td">PRO</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="small-8 align-right">WRITE AND PUBLISH BLOG POSTS</td>
							<td class="small-2">X</td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">MAINTAIN PUBLIC PROFILE</td>
							<td class="small-2">X</td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">LINK TO TWITTER, FB AND OTHER BLOG</td>
							<td class="small-2">X</td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">EARN MONEY (BASIC CPM RATE) FROM VIEWERS</td>
							<td class="small-2">X</td>
							<td class="small-2"></td>
						</tr>						
						<tr>
							<td class="small-8 align-right">POSTS APPEAR IN 'THE MOB' CATEGORY</td>
							<td class="small-2">X</td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">ACCESS IMAGE LIBRARY</td>
							<td class="small-2">X</td>
							<td class="small-2">X</td>
						</tr><tr>
							<td class="small-8 align-right">HAVE CHAT PRIVILEDGE WITH PUCKERMOB EDITOR</td>
							<td class="small-2">X</td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">ALLOW READERS TO "FOLLOW" AUTHOR</td>
							<td class="small-2">X</td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">PAYMENTS MADE IN NET 45</td>
							<td class="small-2">X</td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">$50 MINIMUM THRESHOLD FOR PAYMENTS</td>
							<td class="small-2">X</td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">NO MINIMUM THRESHHOLD FOR PAYMENTS</td>
							<td class="small-2"></td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">EARN MONEY (PREMIUM CPM RATE) FROM VIEWERS</td>
							<td class="small-2"></td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">ARTICLES MAY APPEAR ON HOME PAGE</td>
							<td class="small-2"></td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">ARTICLES MAY BE FEATURED ON HOME PAGE</td>
							<td class="small-2"></td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">ARTICLES MAY APPEAR IN "MOST POPULAR" LIST</td>
							<td class="small-2"></td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">REPUBLISH OLDER POSTS</td>
							<td class="small-2"></td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">ARTICLES (MAY APPEAR) ON FACEBOOK</td>
							<td class="small-2"></td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">ADVERTISING MATCHING PROGRAM</td>
							<td class="small-2"></td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">LISTED ON PUCKERMOB "CONTRIBUTORS" PAGE</td>
							<td class="small-2"></td>
							<td class="small-2">X</td>
						</tr>
						<tr>
							<td class="small-8 align-right">ABILITY TO PARTICIPATE IN LIVE MARKETING EVENTS</td>
							<td class="small-2"></td>
							<td class="small-2">X</td>
						</tr>
					</tbody>
				</table>
			</section>
			<section >
				<div class="how-do-pro-level small-12">
					<h2>HOW DO YOU GET TO PRO LEVEL? </h2>
				</div>
			</section>
		</div>
	</main>
 	
	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
	
</body>
</html>
