<?php
	$new_visitor = false;
	$username = "";
	$admin = true;
	require_once('../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) {
		$adminController->redirectTo('login/');
	//	$somevar = 0;
	} else {
		$adminController->user->data = $adminController->user->getUserInfo();

		/*if($adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
			$adminController->redirectTo('articles/');
		}else{
			$username = $adminController->user->data['user_name'];
			$userLoginCount = $adminController->user->data['user_login_count'];
			$contributor_email = $adminController->user->data['user_email'];
			$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $contributor_email ])['contributors'];
		}*/

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

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<section id="dashboard" class="row">
				<h2>Contributor: Contributor Name</h2>
				<table>
				  <thead>
				    <tr>
				      <th>Article Title</th>
				      <th>Date Added</th>
				      <th>Article Rate</th>
				      <th>Shares</th>
				      <th>Share Rate</th>
				      <th>Share Rev</th>
				      <th>Total Rev</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <td>Article Title is ...</td>
				      <td>10/05/14</td>
				      <td>$10</td>
				      <td>15021</td>
				      <td>$.04</td>
				      <td>600.84</td>
				      <td>610.84</td>
				    </tr>
				     <tr>
				      <td>Article Title is ...</td>
				      <td>10/05/14</td>
				      <td>$10</td>
				      <td>15021</td>
				      <td>$.04</td>
				      <td>600.84</td>
				      <td>610.84</td>
				    </tr>
				    <tr>
				      <td>Article Title is ...</td>
				      <td>10/05/14</td>
				      <td>$10</td>
				      <td>15021</td>
				      <td>$.04</td>
				      <td>600.84</td>
				      <td>610.84</td>
				    </tr>
				    <tr class="total">
				      <td>Total</td>
				      <td></td>
				      <td></td>
				      <td></td>
				      <td></td>
				      <td></td>
				      <td>$691.74</td>
				    </tr>
				  </tbody>
				</table>
			</section>
			<section>
				<p class="notes">*All payments will be made via PayPal within 60 days of month's end.</p>
			</section>
		</div>
	</main>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
