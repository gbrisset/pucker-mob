
<?php

   
class smf_admin_ad_manager extends Connector{

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

}//end class smf_admin_ad_manager extends Connector

