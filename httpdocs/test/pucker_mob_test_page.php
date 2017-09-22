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


$con = new Connector($config);
       
function get_article_body($article_id){
global $con;
        $pdo = $con->openCon();
        
        $pageQueryString = "

 SELECT article_id, article_body, 
 CHAR_LENGTH(article_body) AS c_count,
 LENGTH(article_body) - LENGTH(REPLACE(article_body, '</', '1')) AS s_count,
  LENGTH(article_body) - LENGTH(REPLACE(article_body, '</p>', '123')) AS p_count,
  LENGTH(article_body) - LENGTH(REPLACE(article_body, '</li>', '1234')) AS l_count 
  FROM articles WHERE article_id = $article_id;

         "; 

            $q = $pdo->query($pageQueryString);
            if($q && $q->rowCount()){
                $q->setFetchMode(PDO::FETCH_ASSOC); 
                $row = $q->fetch();
                $r = $row;
                $q->closeCursor();
            }else $r = false;


            $con->closeCon();
        return $r;
}//end function
       
function get_adtag($article_id, $adslot_id){
global $con;
        $pdo = $con->openCon();
        
// Check if article is a test page and fetch test tag for this adslot
        $pageQueryString = "
            SELECT * FROM smf_ad_special_pages asp 
            INNER JOIN smf_ad_tags smf_at ON smf_at.at_id = asp.asp_ad_tag_id
            INNER JOIN smf_ad_slots smf_as ON smf_as.as_id = smf_at.at_ad_slot_id
            WHERE asp.asp_article_id = $article_id
            AND smf_as.as_live_display = 1
            AND smf_at.at_active_status = 2
         "; 

            $q = $pdo->query($pageQueryString);
            if($q && $q->rowCount()){
                $q->setFetchMode(PDO::FETCH_ASSOC); 
                $row = $q->fetch();
                $r = $row;
                $q->closeCursor();
            }else $r = false;

            if($r===false){
            // fetch regular tag for this adslot
                $pageQueryString = "
                    SELECT * FROM smf_ad_tags smf_at 
                    INNER JOIN smf_ad_slots smf_as ON smf_as.as_id = smf_at.at_ad_slot_id
                    WHERE smf_as.as_live_display = 1
                    AND smf_at.at_active_status = 1
                 "; 

                    $q = $pdo->query($pageQueryString);
                    if($q && $q->rowCount()){
                        $q->setFetchMode(PDO::FETCH_ASSOC); 
                        $row = $q->fetch();
                        $r = $row;
                        $q->closeCursor();
                    }else $r = false;



            }//end if($r===false)

            $con->closeCon();
        return $r;
}//end function

?>

</head>

<body style=" ">

<h1 style="color: #009900; ">PUCKER MOB&nbsp;&mdash;&nbsp;<?php echo $dev_status?>&nbsp;&mdash;&nbsp;TEST PAGE</h1>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php

// $article_id = 27328;
$article_id = 11111;
$adslot_id = 2;

$ad_to_display = get_adtag($article_id, $adslot_id);
echo "<pre>";
var_dump($ad_to_display);
echo "</pre>";

$sample_tag = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> <ins class="adsbygoogle"style="display:block; text-align:center;"data-ad-format="fluid"data-ad-layout="in-article"data-ad-client="ca-pub-8978874786792646"data-ad-slot="3693758426"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>';

$sample_tag = "<div style=\"height: 250px; width: 300px; margin:20px 0; text-align: center;\">" . $sample_tag . "</div>";
$sample_article = get_article_body($article_id);

$body_text = $sample_article['article_body'];
$max_pos = strlen($body_text);
//#ADTAG_01# is 10 chars long
//</p> is 4 chars long
//</li> is 5 chars long

$pos_p1 = 4 + strpos($body_text, '</p>', 500);
$pos_l1 = 5 + strpos($body_text, '</li>', 500);
$pos_1 = min(($pos_p1>4? $pos_p1:$max_pos), ($pos_l1>5? $pos_l1:$max_pos));

$pos_p2 = 4 + 10 + strpos($body_text, '</p>', 1300);
$pos_l2 = 5 + 10 + strpos($body_text, '</li>', 1300);
$pos_2 = min(($pos_p2>14? $pos_p2:$max_pos), ($pos_l2>15? $pos_l2:$max_pos));

$pos_p3 = 4 + 20 + strpos($body_text, '</p>', 2100);
$pos_l3 = 5 + 20 + strpos($body_text, '</li>', 2100);
$pos_3 = min(($pos_p3>24? $pos_p3:$max_pos), ($pos_l3>25? $pos_l3:$max_pos));

$pos_p4 = 4 + 30 + strpos($body_text, '</p>', 2900);
$pos_l4 = 5 + 30 + strpos($body_text, '</li>', 2900);
$pos_4 = min(($pos_p4>34? $pos_p4:$max_pos), ($pos_l4>35? $pos_l4:$max_pos));

$body_text = substr_replace($body_text, '#ADTAG_01#', $pos_1, 0);
$body_text = substr_replace($body_text, '#ADTAG_02#', $pos_2, 0);
$body_text = substr_replace($body_text, '#ADTAG_03#', $pos_3, 0);
$body_text = substr_replace($body_text, '#ADTAG_04#', $pos_4, 0);

$body_text = str_replace('#ADTAG_01#', $sample_tag, $body_text);
$body_text = str_replace('#ADTAG_02#', $sample_tag, $body_text);
$body_text = str_replace('#ADTAG_03#', $sample_tag, $body_text);
$body_text = str_replace('#ADTAG_04#', $sample_tag, $body_text);

 // $ddd = new debug("$body_text",3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow  
echo $body_text;
// echo "<pre>";
// var_dump($sample_article);
// echo "</pre>";

?>



<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


<p>Please check out our <b>sister site</b></p>
<p><a href="http://www.puckermom.com/">Pucker MOM</a> It's not just about the kids</p>

</body>
</html>