<?php 



	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');


//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
		// error_reporting(E_ALL); 	ini_set('display_errors', '1');

//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------

	//Verify if is a content provider user
	$content_provider = false;
	$staff = false;

	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 4){
		$content_provider = true;
	}

	if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');

	

?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>

<body id="reports">
	<!-- HEADER -->	
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<!-- MAIN CONTENT -->
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<!-- MENU -->
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="small-12 columns padding-bottom ">
				<h1>AD MANAGEMENT</h1>
			</div>

			<div class="columns small-12 margin-top">
				<form id="social-media-shares-form" method="post">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<div class="row">
					         	<div class="small-7 columns">
						       		qqqqqqqqqqqq

					       		</div>
						       	<div class="small-5 columns">
						       		<button type="submit" id="submit" name="submit" style="padding: 0.5rem 1rem;text-transform: uppercase; margin-right: 1rem;">Search</button>
						       	</div>
				    </div>

					
				</form>
			</div>
			


			<div id="reports-div" class="columns small-12">

<input type="checkbox" value="1" name="" >

<?php 

		// $ddd = new debug($smf_adManager->tag_list,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	


foreach ($smf_adManager->tag_list as $tag_item) {

	echo "<br/><b>Ad Slot:</b> " 
	echo "<br/><b>Ad Slot:</b> " . $tag_item['ad_slot'];
	echo "<br/><b>Ad Name:</b> " .  $tag_item['tag'];
	echo "<br/><b>Articles:</b><br/> " . implode("<br/>",$tag_item['show_on']);

	// $tag = $tag_item['tag'];

	// if(strpos($tag, 'image_tag')){
	// 	$fgc = "<img src=\"http://images.puckermob.com/articlesites/puckermob/large/$article_id"  . "_tall.jpg\" alt=\" $article_title Image\">";
	// }else{
	// 	$f = $config['include_path'] . "ads/$tag";
	// 	$fgc .= file_get_contents($f);
	// }//end if

	// echo "<div style=\"height: 100px; width: 100px;\" >$tag</div>";

	echo"<hr/>";
	
}//end foreach ($smf_adManager->tag_list as $tag_item)


?>



			</div>
		</div>
	</main>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>