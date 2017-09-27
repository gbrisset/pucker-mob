<!DOCTYPE html>
<html>

<head>
    <!-- Google common tage used by UNDERTONE -->
    <script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
    <script>
      var googletag = googletag || {};
      googletag.cmd = googletag.cmd || [];
    </script>
	
<?php

// SELECT article_id, article_body, CHAR_LENGTH(article_body) AS c_count, LENGTH(article_body) - LENGTH(REPLACE(article_body, '</', '1')) AS s_count, LENGTH(article_body) - LENGTH(REPLACE(article_body, '</p>', '123')) AS p_count, LENGTH(article_body) - LENGTH(REPLACE(article_body, '</li>', '1234')) AS l_count FROM articles WHERE article_status=1 ORDER BY `articles`.`article_id` DESC;

  include ("../assets/php/config.php"); 


$dev_status = ($local)? "<span style=\"color: #000099;\">LOCAL</span>" : "<span style=\"color: #990000;\">LOCAL</span>" ;



   
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
		            AND smf_at.at_active_status = 2
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

		function get_all_adtags(){

				// Gets all tags, their adslots and their special pages
		        $pdo = $this->con->openCon();
		        $querystring = "
					SELECT * FROM smf_ad_tags smf_at
					INNER JOIN smf_ad_tag_to_ad_slot atas ON atas.atas_ad_tag_id = smf_at.at_id
					INNER JOIN smf_ad_slots smf_as ON smf_as.as_id = atas.atas_ad_slot_id
		         "; 
		         echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST echo "$querystring";//TEST 
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

?>

</head>

<body style=" ">

<h1 style="color: #009900; ">PUCKER MOB&nbsp;&mdash;&nbsp;<?php echo $dev_status?>&nbsp;&mdash;&nbsp;TEST PAGE</h1>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php


//CONFIG LEVEL
$smf_ad_manager = new smf_ad_manager($config);


// ARTICLE LEVEL
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


//ADMIN LEVEL


$all_adtags = $smf_ad_manager->get_all_adtags();

		$ddd = new debug($all_adtags,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

?>



<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


<p>Please check out our <b>sister site</b></p>
<p><a href="http://www.puckermom.com/">Pucker MOM</a> It's not just about the kids</p>

</body>
</html>