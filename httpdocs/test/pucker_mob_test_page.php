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
/* ******* OOP CLASS OOP CLASS OOP CLASS OOP CLASS OOP CLASS OOP CLASS OOP CLASS OOP CLASS OOP CLASS  ****** */
/* ********************************************************************************************************* */
/* ********************************************************************************************************* */


// SELECT article_id, article_body, CHAR_LENGTH(article_body) AS c_count, LENGTH(article_body) - LENGTH(REPLACE(article_body, '</', '1')) AS s_count, LENGTH(article_body) - LENGTH(REPLACE(article_body, '</p>', '123')) AS p_count, LENGTH(article_body) - LENGTH(REPLACE(article_body, '</li>', '1234')) AS l_count FROM articles WHERE article_status=1 ORDER BY `articles`.`article_id` DESC;
   
class smf_ad_manager extends Connector{

	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
	    
	}//end function ------------------------------------------------------------------------------


		function get_article_body($article_id){
			$pdo = $this->con->openCon();        
		        $querystring = "SELECT article_body FROM articles WHERE article_id = $article_id; ";
		            $q = $pdo->query($querystring);
		            if($q && $q->rowCount()){
		                $q->setFetchMode(PDO::FETCH_ASSOC); 
		                $row = $q->fetch();
		                $r = $row;
		                $q->closeCursor();
		            }else $r = false;

		            $this->closeCon();
		        return $r;
		}//end function ------------------------------------------------------------------------------
		       
		function get_article_body_with_ads($article_id,$target_device){

			//body text data
			$article_data = $this->get_article_body($article_id);
			$body_text = $article_data['article_body'];
			$max_pos = strlen($body_text);

			//html tags structuring the body text
			$searched_html_tags[] = array('tag' => '</p>', 'length' => 4 );
			$searched_html_tags[] = array('tag' => '</li>', 'length' => 5 );
			
			// Ad slots available
			$inline_ad_slots = $this->get_inline_ad_slots($max_pos, $target_device);

			//Part One - Insertion of the placeholders
			// ------------------------------------------
			foreach ($inline_ad_slots as $key => $inline_ad_slot) {
				$ad_tag_placeholder[$key] = '<!-- #ADTAG_' . $key . '# -->';// placeholders must stay hidden if no ad if found for a given slot
				$as_inline_pos = $inline_ad_slot['as_inline_pos'];
				$ad_tag_pos[$key] = $max_pos;

				//search for the closest html tag after the desired inline position (assumption is made that THERE ARE <p> or <li> tags structuring the body text)
				foreach ($searched_html_tags as $html_tag) {
					$temp_pos = $html_tag['length'] + strpos($body_text, $html_tag['tag'], $as_inline_pos);
					 if($temp_pos > $html_tag['length'] ) $ad_tag_pos[$key] = $temp_pos; 
				}//end foreach ($searched_html_tags

				$body_text = substr_replace($body_text, $ad_tag_placeholder[$key], $ad_tag_pos[$key], 0);

			}//end foreach ($inline_ad_slots ...

			//Part Two - Insertion of the ad tags
			// ------------------------------------------
			reset($inline_ad_slots);
			foreach ($inline_ad_slots as $key => $inline_ad_slot) {

				$inline_ad_tag = $this->get_adtag($article_id, $inline_ad_slot['as_name']);
				$body_text = str_replace($ad_tag_placeholder[$key], $inline_ad_tag['at_script'], $body_text);

			}//end foreach ($inline_ad_slots ...

			return $body_text;

		}//end function ------------------------------------------------------------------------------
		       
		function get_inline_ad_slots($max_pos, $target_device){
			$pdo = $this->con->openCon();        

		        $querystring = "SELECT * FROM `smf_ad_slots` WHERE as_inline_pos >0 AND as_inline_pos < $max_pos AND as_target_device = $target_device;  ";
		            $q = $pdo->query($querystring);
		            if($q && $q->rowCount()){
		                $q->setFetchMode(PDO::FETCH_ASSOC); 
		                $row = $q->fetchAll();
		                $r = $row;
		                $q->closeCursor();
		            }else $r = false;

		            $this->closeCon();
		        return $r;
		}//end function ------------------------------------------------------------------------------
		       
		function get_adtag($article_id, $adslot_name){

		        $pdo = $this->con->openCon();
				// Check if article is a test page and fetch test tag for this adslot
		        $querystring = "
		            SELECT * FROM smf_ad_special_pages asp 
					INNER JOIN smf_ad_tag_to_special_pages atsp ON asp.asp_id = atsp.atsp_ad_special_page_id
					INNER JOIN smf_ad_tags smf_at ON smf_at.at_id = atsp.atsp_ad_tag_id
					INNER JOIN smf_ad_tag_to_ad_slot atas ON atas.atas_ad_tag_id = smf_at.at_id
					INNER JOIN smf_ad_slots smf_as ON smf_as.as_id = atas.atas_ad_slot_id
		            WHERE smf_as.as_name = '$adslot_name'
		            AND smf_as.as_live_display = 1
		            AND smf_at.at_active_status > 1
		            AND smf_at.at_date_expiration > NOW()
		            AND asp.asp_article_id = $article_id
		         "; 
		            $q = $pdo->query($querystring);
		            if($q && $q->rowCount()){
		                $q->setFetchMode(PDO::FETCH_ASSOC); 
		                $row = $q->fetch();
		                $r = $row;
		                $q->closeCursor();
		            }else $r = false;

		            if($r===false){
		            // fetch regular tag for this adslot
		                $querystring = "
		                    SELECT * FROM smf_ad_tags smf_at 
		        			INNER JOIN smf_ad_tag_to_ad_slot atas ON atas.atas_ad_tag_id = smf_at.at_id
							INNER JOIN smf_ad_slots smf_as ON smf_as.as_id = atas.atas_ad_slot_id
				            WHERE smf_as.as_name = '$adslot_name'
		                    AND smf_as.as_live_display = 1
				            AND smf_at.at_active_status = 1
           		            AND smf_at.at_date_expiration > NOW()

		                 "; 

		                    $q = $pdo->query($querystring);
		                    if($q && $q->rowCount()){
		                        $q->setFetchMode(PDO::FETCH_ASSOC); 
		                        $row = $q->fetch();
		                        $r = $row;
		                        $q->closeCursor();
		                    }else $r = false;

		            }//end if($r===false)

		            $this->closeCon();
		        return $r;
		}//end function ------------------------------------------------------------------------------

		function admin_get_slot_adtags( $adslot_name){

// SELECT * FROM smf_ad_tags smf_at
// LEFT JOIN smf_ad_tag_to_ad_slot atas ON atas.atas_ad_tag_id = smf_at.at_id
// LEFT JOIN smf_ad_slots smf_as ON smf_as.as_id = atas.atas_ad_slot_id
// LEFT JOIN smf_ad_tag_to_special_pages atsp ON smf_at.at_id = atsp.atsp_ad_special_page_id
// LEFT JOIN smf_ad_special_pages asp  ON  asp.asp_id = atsp.atsp_ad_tag_id
// WHERE smf_as.as_name = '$adslot_name'

		        $pdo = $this->con->openCon();
		        $querystring = "
		            SELECT smf_at.* FROM smf_ad_tags smf_at
					LEFT JOIN smf_ad_tag_to_ad_slot atas ON atas.atas_ad_tag_id = smf_at.at_id
					LEFT JOIN smf_ad_slots smf_as ON smf_as.as_id = atas.atas_ad_slot_id
		            WHERE smf_as.as_name = '$adslot_name'
			        ORDER BY at_active_status DESC, at_date_creation DESC;
		         "; 
		         // echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST 
		            $q = $pdo->query($querystring);
		            if($q && $q->rowCount()){
		                $q->setFetchMode(PDO::FETCH_ASSOC); 
		                $row = $q->fetchAll();
		                $r = $row;
		                $q->closeCursor();
		            }else $r = false;

		            $this->closeCon();
		        return $r;
		}//end function ------------------------------------------------------------------------------

		function admin_get_all_adslots(){

		        $pdo = $this->con->openCon();
		        $querystring = "
					SELECT * FROM `smf_ad_slots`  
					ORDER BY 
					`smf_ad_slots`.`as_target_device` ASC,
					`as_admin_display_order` ASC;		         "; 
		            $q = $pdo->query($querystring);
		            if($q && $q->rowCount()){
		                $q->setFetchMode(PDO::FETCH_ASSOC); 
		                $row = $q->fetchAll();
		                $r = $row;
		                $q->closeCursor();
		            }else $r = false;

		            $this->closeCon();
		        return $r;
		}//end function ------------------------------------------------------------------------------

}//end class smf_ad_manager extends Connector


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */
/* ******* CONFIG CONFIG CONFIG CONFIG CONFIG CONFIG CONFIG CONFIG CONFIG CONFIG *************************** */
/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

$smf_ad_manager = new smf_ad_manager($config);

$smf_target_device[0]['prefix'] = 'dsk_';
$smf_target_device[0]['pretty_name'] = 'Desktop';
$smf_target_device[0]['short_name'] = 'DSK';

$smf_target_device[1]['prefix'] = 'mbl_';
$smf_target_device[1]['pretty_name'] = 'Mobile';
$smf_target_device[1]['short_name'] = 'MBL';

$smf_tag_active_status[0] = array('name' => 'Inactive','bg_color' =>'#ff6666;');
$smf_tag_active_status[3] = array('name' => 'Test','bg_color' =>'#ff9933;');
$smf_tag_active_status[6] = array('name' => 'Sponsored Content','bg_color' =>'#99ccff;');
$smf_tag_active_status[9] = array('name' => 'Active','bg_color' =>'#66cc66;');


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */
/* ******* ARTICLE PAGE ARTICLE PAGE ARTICLE PAGE ARTICLE PAGE ARTICLE PAGE ARTICLE PAGE ******************* */
/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

// $article_id = 8560; //lelo
// $article_id = 27328;
// $article_id = 8541; //rubicon
// $article_id = 11111;		// $ddd = new debug("$s",0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	


$target_device = 1; //0 = dsk, 1 = mbl

// $adslot_name = 'dsk_banner';
// $adslot_name = 'dsk_below_image';
// $adslot_name = 'mbl_body_text_1';
// $adslot_name = 'mbl_body_text_2';
// $adslot_name = 'mbl_ad_stack_1';
// $adslot_name = 'mbl_ad_stack_2';

// Call for a specific ad slot
// $ad_to_display = $smf_ad_manager->get_adtag($article_id, $adslot_name);

// Call For inline_ad_slots
// $body_text_with_ads = $smf_ad_manager->get_article_body_with_ads($article_id,$target_device);
// echo $body_text_with_ads;


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */
/* ******* ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ************************************* */
/* ********************************************************************************************************* */
/* ********************************************************************************************************* */



/* ************ ADMIN CPANEL SLOT PAGE - LIST OF AD SLOTS WITH TAGS ***************************************************** */


$all_adslots = $smf_ad_manager->admin_get_all_adslots();

foreach ($all_adslots as $ad_slot) {
	$as_name = $ad_slot['as_name'];
	
	$as_inline_pos = $ad_slot['as_inline_pos'];
	$as_inline_pos_txt = ($as_inline_pos>0)? "After $as_inline_pos Chars":"None";

	$as_live_display = $ad_slot['as_live_display'];
	$as_live_display_txt = ($as_live_display==0)? "Off" : "Live";
	
	$as_target_device = $ad_slot['as_target_device'];	
	$as_target_device_txt = $smf_target_device[$as_target_device]['pretty_name'];

	$slot_adtags = $smf_ad_manager->admin_get_slot_adtags($as_name);

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