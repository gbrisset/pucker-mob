	<?php
$bio = htmlspecialchars(trim(strip_tags($userInfo["contributor_bio"])));
$name = htmlspecialchars(trim(strip_tags($userInfo["contributor_name"])));

$preview_profile = "<section id='about-the-author' class=''>";
	$preview_profile .= "<section class='header'>";
		$preview_profile .= "<h2>About ".$name."</h2>";
	$preview_profile .= "</section>";

	$preview_profile .= "<div class='author-content contributor'>";
		$preview_profile .= "<div class='contribtuor-info'>";
			$preview_profile .= "<div id='author-img'>";
				$preview_profile .= "<a href='#'>";
					if($contImageExists){
						$preview_profile .= "<img src='".$contImageUrl."' alt='".$name." Image"."' />";
				 	} else {
						$preview_profile .= "<img src='".$config['image_url']."articlesites/sharedimages/default_profile_contributor.png' alt='Contributor Image' style='width: 143px; height: 140px;' />";
					} 
				$preview_profile .= "</a>";
			$preview_profile .= "</div>";
			$preview_profile .= "<div id='author-desc'>";
				$preview_profile .= "<h3><a href='#'>".htmlspecialchars($name)."</a></h3>";

				$preview_profile .= "<p>";
					if(strlen($bio) > 330) {
						$preview_profile .= $mpHelpers->truncate($bio, 330);
					} else {
						$preview_profile .= $bio."<br />";
					}
				$preview_profile .= "</p>";
				$preview_profile .= "<a href='#' >MORE</a>";

			$preview_profile .= "</div>";
 			$preview_profile .= "<div class='social-buttons'>";

				if(isset($userInfo['contributor_facebook_link']) && strlen($userInfo['contributor_facebook_link'])){
					$preview_profile .= "<a href='".$userInfo['contributor_facebook_link']."'>";
						$preview_profile .= "<i class='icon-facebook-sign'></i>";
					$preview_profile .= "</a>";
				}
				if(isset($userInfo['contributor_twitter_handle']) && strlen($userInfo['contributor_twitter_handle'])){ 
					$preview_profile .= "<a href='http://www.twitter.com/".$userInfo['contributor_twitter_handle']."' target='_blank'>";
						$preview_profile .= "<i class='icon-twitter-sign'></i>";
					$preview_profile .= "</a>";
				}
				if(isset($userInfo['contributor_blog_link']) && strlen($userInfo['contributor_blog_link'])){ 
					$preview_profile .= "<a href='".$userInfo['contributor_blog_link']."' target='_blank'>";
						$preview_profile .= "<i class='icon-external-link'></i> Visit ".explode(' ', $userInfo['contributor_name'])[0]."'s website";
					$preview_profile .= "</a>";
				}
			$preview_profile .= "</div>";
		$preview_profile .= "</div>";
	$preview_profile .= "</div>";

$preview_profile .= "</section>";
?>
