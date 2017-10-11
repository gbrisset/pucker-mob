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
			
<!-- PAGE TITLE -->
			<div class="small-12 columns padding-bottom ">
				<h1>AD MANAGEMENT</h1>
			</div>


<!-- TOP BAR - SEARCH ETC. -->
			<div class="columns small-12 margin-top">
				<form id="social-media-shares-form" method="post">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<div class="row">
					         	<div class="small-7 columns">
						       		New stuff

					       		</div>
						       	<div class="small-5 columns">
						       		<button type="submit" id="submit" name="submit" style="padding: 0.5rem 1rem;text-transform: uppercase; margin-right: 1rem;">Search</button>
						       	</div>
				    </div>

					
				</form>
			</div>
			


			<div id="reports-div" class="columns small-12">

				<input type="checkbox" value="1" name="" >

				<!-- ADMIN CONTENT BELOW -->

<style type="text/css">

.smf_scrollbox_container {
	overflow: auto; 
/*	background: #aa0; /* FOR TEST ONLY - TO BE REMOVED */
}	
.smf_scrollbox_list {
	float: left;           /* makes it shrink-wrap all the floating divs inside */
	margin-right: -30000px; /* allows the width expanding beyond parent edge to give adjacent space *//*N.B. the limit in Opera is a total scroll width of 32778px */
/*	background: #9f9;/* FOR TEST ONLY - TO BE REMOVED */
}
.smf_scrollbox_item {
	float: left;
	border: 1px solid #000;
	min-width: 200px;
	margin: 10px;
	padding: 10px;
}
.smf_scrollbox_item table{background-color: inherit; padding: 0; border:0; margin: 0;}
.smf_scrollbox_item table tr {background-color: inherit;}
.smf_scrollbox_item table tr td {background-color: inherit;    padding: .3em; line-height: 1;}
</style>

				<?php 
						// $ddd = new debug($smf_adManager->tag_list,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	



/* ************ ADMIN CPANEL SLOT PAGE - LIST OF AD SLOTS WITH TAGS ***************************************************** */


$all_adslots = $smf_admin_ad_manager->admin_get_all_adslots();

foreach ($all_adslots as $ad_slot) {
	$as_name = $ad_slot['as_name'];
	
	$as_inline_pos = $ad_slot['as_inline_pos'];
	$as_inline_pos_txt = ($as_inline_pos>0)? "After $as_inline_pos Chars":"None";

	$as_live_display = $ad_slot['as_live_display'];
	$as_live_display_txt = ($as_live_display==0)? "Off" : "Live";
	
	$as_target_device = $ad_slot['as_target_device'];	
	$as_target_device_txt = $smf_target_device[$as_target_device]['pretty_name'];

	$slot_adtags = $smf_admin_ad_manager->admin_get_slot_adtags($as_name);

	echo"
	<fieldset  style=\"width: 500px; margin: 20px 0; border: solid 1px #000;\" ><legend  style=\"width: auto;font-size: x-large; font-weight: bold; padding: 0 10px;\">Ad Slot: $as_name</legend>
	<table style=\"    border: solid 1px #000; margin:0;\">
	<tr><td>Target Device: </td><td>$as_target_device_txt</tr>
	<tr><td>Display Status: </td><td>$as_live_display_txt</tr>
	<tr><td>Body Text Position: </td><td>$as_inline_pos_txt</td></tr>
	</table>	";

	echo "<div class=\"smf_scrollbox_container \">";
	echo "<div class = \" smf_scrollbox_list  \">";

	if ($slot_adtags!==false) {

		foreach ($slot_adtags as $ad_tag) {
			$at_id = $ad_tag['at_id'];
			$at_name = $ad_tag['at_name'];
			$at_provider = $ad_tag['at_provider'];

			$at_cpm = $ad_tag['at_cpm'];
			$at_estimated_fill = $ad_tag['at_estimated_fill'];
			$at_active_status = $ad_tag['at_active_status'];
			$at_date_creation = $ad_tag['at_date_creation'];
			$at_date_expiration = $ad_tag['at_date_expiration'];		

			$at_cpm_txt = '$'. number_format($at_cpm,2);
			$at_estimated_fill_txt = number_format($at_estimated_fill,0) .'%';

			$at_active_status_txt = "Unknown";
			$at_active_status_txt = $smf_tag_active_status[$at_active_status]['name'];
			$at_active_status_bg = $smf_tag_active_status[$at_active_status]['bg_color'];

			$at_date_creation_txt = date('F d, Y ',strtotime($at_date_creation));
			$at_date_expiration_txt = date('F d, Y ',strtotime($at_date_expiration));
			$at_expiration_status_txt = (strtotime($at_date_expiration) > strtotime("now"))? 'Current' : 'Expired';
			$at_expiration_status_css = (strtotime($at_date_expiration) > strtotime("now"))? '' : 'background-color: #ff0000; color: #ffffff;';


			echo"<div class=\" smf_scrollbox_item\" style = \"background-color: $at_active_status_bg\" >";
				echo "<table style=\"\">
					
					<tr><td style = \"font-weight: bold;\">Tag Name: </td><td style = \"font-weight: bold;\">$at_name</td></tr>
					<tr><td style = \"font-weight: bold;\">Active Status: </td><td style = \"font-weight: bold;\">$at_active_status_txt</td></tr>
					<tr><td>Provider: </td><td>$at_provider</td></tr>
					<tr><td>CPM: </td><td>$at_cpm_txt</td></tr>
					<tr><td>Est Fill: </td><td>$at_estimated_fill_txt</td></tr>
					<tr><td>Creation: </td><td>$at_date_creation_txt</td></tr>
					<tr><td style = \"$at_expiration_status_css\">Expiration: </td><td style = \"$at_expiration_status_css\">$at_date_expiration_txt</td></tr>
					<tr><td style = \"$at_expiration_status_css\">Exp Status: </td><td style = \"$at_expiration_status_css\">$at_expiration_status_txt</td></tr>
					
				</table>	";
			echo"</div> ";

		}// end foreach ($slot_adtags as $ad_tag) 

	}else{
			echo"<div class=\" smf_scrollbox_item\" style = \"background-color: " . $smf_tag_active_status[0]['bg_color'] . "\" >";
			echo "No tag found for this ad slot.";
			echo"</div> ";
		
	}//end if ($slot_adtags!==false)
	
	echo "</div>";
	echo"</div> ";
	echo"</fieldset> ";

	 // $ddd = new debug($slot_adtags,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

}//end foreach ($all_adslots as $ad_slot)




				?>
				<!-- ADMIN CONTENT ABOVE -->

			</div> <!--<div id="reports-div" class="columns small-12"> -->
		</div>
	</main>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>