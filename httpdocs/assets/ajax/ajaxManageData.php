<?php
require_once('../php/config.php');
require_once('../php/class.SocialMediaManage.php');

$socialMediaManage = new SocialMediaManage($config);
$url = $_GET['url'];

$total_shares = 0;
 try{
 	
 		/*FACEBOOK*/
 		$fbCounts = $socialMediaManage->getSocialMediaResult('facebook_shares', 'http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$url);
		$fbTotal = $socialMediaManage->formatSocialMediaResult('facebook_shares', $fbCounts);
 		
 		/*TWITTER*/
 		$tweetCounts = $socialMediaManage->getSocialMediaResult('twitter', 'http://cdn.api.twitter.com/1/urls/count.json?url='.$url);
 		$tweetsTotal = $socialMediaManage->formatSocialMediaResult('twitter', $tweetCounts);
 		
 		/*PINTEREST*/
 		$pinCounts = $socialMediaManage->getSocialMediaResult('pinterest', 'http://widgets.pinterest.com/v1/urls/count.json?source=6&url='.$url);
 		$pinterestTotal = $socialMediaManage->formatSocialMediaResult('pinterest', $pinCounts);
 		
 		/*GOOGLE PLUS*/
 		$googleCounts = $socialMediaManage->getSocialMediaResult('googleplus', $url);
 		$googleTotal = $socialMediaManage->formatSocialMediaResult('googleplus', $googleCounts);
 		
 		/*LINKEDIN*/
 		$linCounts = $socialMediaManage->getSocialMediaResult('linkedin', 'http://www.linkedin.com/countserv/count/share?url='.$url);
 		$linkedinTotal = $socialMediaManage->formatSocialMediaResult('linkedin', $linCounts);
 		
 		/*DELICIOUS*/
 		$delCounts = $socialMediaManage->getSocialMediaResult('delicious', 'http://feeds.delicious.com/v2/json/urlinfo/data?url='.$url);
		$deliciousTotal = $socialMediaManage->formatSocialMediaResult('delicious', $delCounts);
 		
 		/*STUMBLEUPON*/
 		$stCounts = $socialMediaManage->getSocialMediaResult('stumbleupon', 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url='.$url);
 		$stumbleuponTotal = $socialMediaManage->formatSocialMediaResult('stumbleupon', $stCounts);
 		
 		$total_shares = $fbTotal + $tweetsTotal + $pinterestTotal + $linkedinTotal + $deliciousTotal + $stumbleuponTotal + $googleTotal; 
 		echo $total_shares;
 		//var_dump($fbTotal, $tweetsTotal, $pinterestTotal, $linkedinTotal, $deliciousTotal, $stumbleuponTotal, $googleTotal, $total_shares );
 		

 }catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>