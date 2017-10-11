<!DOCTYPE html>
<html>

<head>
    <!-- Google common tage used by UNDERTONE -->
    <script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
    <script>
      var googletag = googletag || {};
      googletag.cmd = googletag.cmd || [];
    </script>

</head>

<?php
 include ("../assets/php/config.php"); 
$dev_status = ($local)? "<span style=\"color: #000099;\">LOCAL</span>" : "<span style=\"color: #990000;\">LOCAL</span>" ;
?>
	

<body style=" ">

<h1 style="color: #009900; ">PUCKER MOB&nbsp;&mdash;&nbsp;<?php echo $dev_status?>&nbsp;&mdash;&nbsp;TEST PAGE</h1>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php
/* ********************************************************************************************************* */
/* ********************************************************************************************************* */
/* ******* CSS CSS CSS CSS CSS CSS CSS CSS CSS CSS CSS CSS CSS CSS CSS CSS CSS CSS  ************************ */
/* ********************************************************************************************************* */
/* ********************************************************************************************************* */
?>   
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
</style>

<?php


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */
/* ******* ARTICLE PAGE ARTICLE PAGE ARTICLE PAGE ARTICLE PAGE ARTICLE PAGE ARTICLE PAGE ******************* */
/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

// $article_id = 8560; //lelo
// $article_id = 27328;
// $article_id = 8541; //rubicon
// $article_id = 11111;		// $ddd = new debug("$s",0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	



// $adslot_name = 'dsk_banner';
// $adslot_name = 'dsk_below_image';
// $adslot_name = 'mbl_body_text_1';
// $adslot_name = 'mbl_body_text_2';
// $adslot_name = 'mbl_ad_stack_1';
// $adslot_name = 'mbl_ad_stack_2';

// Call for a specific ad slot
// $ad_to_display = $smf_admin_ad_manager->get_adtag($article_id, $adslot_name);

// Call For inline_ad_slots
// $body_text_with_ads = $smf_admin_ad_manager->get_article_body_with_ads($article_id,$target_device);
// echo $body_text_with_ads;


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */
/* ******* ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ************************************* */
/* ********************************************************************************************************* */
/* ********************************************************************************************************* */



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
	<fieldset  style=\"width: 500px; margin: 20px 0;\" ><legend  style=\"font-size: x-large; font-weight: bold; padding: 0 10px;\">Ad Slot: $as_name</legend>
	<table style=\"\">
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
					<tr><td>Provider: </td><td>$at_provider</td></tr>
					<tr><td>CPM: </td><td>$at_cpm_txt</td></tr>
					<tr><td>Est Fill: </td><td>$at_estimated_fill_txt</td></tr>
					<tr><td>Active Status: </td><td>$at_active_status_txt</td></tr>
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



/* ************ ADMIN CPANEL SPECIAL PAGES PAGE ************************************************************************* */




/* ************ ADMIN CPANEL TAG PAGE *********************************************************************************** */



?>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


<p>Please check out our <b>sister site</b></p>
<p><a href="http://www.puckermom.com/">Pucker MOM</a> It's not just about the kids</p>

</body>
</html>