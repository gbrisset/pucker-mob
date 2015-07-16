<?php  
$content ='';
$content .= '<article id="article-1" class="columns small-12">';
	$content .= '<section id="article-summary" class="small-12 column">';
		
		$content .= '<h1 style="margin-bottom: 0.5rem;">{{TITLE}}</h1>';
		
		$content .= '<div class="row social-media-container social-cont-1" style="margin-bottom: 0rem; display:block !important;">';
				
				$content .= '<a class="addthis_button_facebook">';
				$content .= '	<img src="http://www.puckermob.com/assets/img/FacebookIconCircle3.png"; alt="Facebook" />';
				$content .= '</a> ';
				$content .= '<a class="addthis_button_twitter">';
				$content .= '	<img src="http://www.puckermob.com/assets/img/TwitterIconCircle.png" alt="Twitter" />';
				$content .= '</a> ';
				$content .= '<a class="addthis_button_pinterest_share">';
				$content .= '	<img src="http://www.puckermob.com/assets/img/Pinterest-Icon-Circle.png" alt="Pinterest" />';
				$content .= '</a>';
				$content .= '<a href="#disqus-container" class="disqus_container">';
				$content .= '	<img src="http://www.puckermob.com/assets/img/CommentsIconCircle.png" alt="Comments" />';
				$content .= '</a>';
			
				$content .= '<a class="addthis_button_facebook_like show-on-large-up" fb:like:send="true"  fb:like:layout="button"></a>';
				$content .= '<a class="addthis_button_compact show-on-medium-up"><span><i class="fa fa-plus"></i> More</span></a>'; 

			 	$content .= '<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding" style="text-align: right; margin-top: 0rem;">';
				$content .= '	<div class="addthis_jumbo_share  hide-for-print social-buttons-top"></div>';
				$content .= '</div>';
		$content .= '</div>';

		$content .= '<div class="row">';
			$content .= '<div id="article-image" class="small-12 columns half-padding-right-on-lg padding-top">';
				$content .= '<img src="http://images.puckermob.com/articlesites/puckermob/large/4752_tall.jpg" alt="Article Image">';
			$content .= '</div>';
		$content .= '</div>';

		$content .= '<div class="row">';
			$content .= '<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 padding-top half-padding-right-on-lg">';
				$content .= '<p class="left uppercase">';
				$content .= '	<span class="span-category <?php echo $article_category; ?>">{{Category}}</span>';
				$content .= '	<span class="span-date">{{Date Created}}</span>';
				$content .= '</p>';
				$content .= '<p class="right uppercase"><span class="span-author">By <a href="" >{{Contributor Name}}</a></span></p>';
			$content .= '</div>';
		$content .= '</div>';
	
		$content .= '<div class="row">';
			$content .= '<section id="article-content" class="small-12 column sidebar-box">';
			$content .= '<p>{{ARTICLE BODY}}</p>';
	$content .= '</section>';
$content .= '</article>';

echo $content;
?>