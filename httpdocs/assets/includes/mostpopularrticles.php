<?php 

if( isset( $articleInfoObj ) && isset( $articleInfoObj['article_id']) && $articleInfoObj['article_id']){
	$mostReadArticlesList = $mpArticle->getMostRecentArticleList( $articleInfoObj['article_id'] );

}else{
	$mostReadArticlesList = $mpArticle->getMostRecentArticleList();
}

if(isset($mostReadArticlesList) && $mostReadArticlesList){ ?>
	<section id="popular-articles" class="sidebar">
		<div class="h4-container"><h4>Most Popular</h4></div>
			<?php 
				$articleNumber = 0;
				$articleTotalNumber = 0;
				foreach($mostReadArticlesList as $article){
					$articleTotalNumber++;
				}
				foreach($mostReadArticlesList as $article){
						//$linkToCategory = $config['this_url'].$article['cat_dir_name'];
						//$articleUrl = $linkToCategory.'/'.$article['article_seo_title'];
						$articleUrl = 'http://www.puckermob.com'.$article['url'];
						//$linkToContributor = $config['this_url'].'/contributors/'.$article['contributor_seo_name'];
						//$date = date("M d, Y", strtotime($article['creation_date']));
				
						$articleNumber++;
						//$articleUrl = $config['this_url'].$article['cat_dir_name'].'/'.$article['article_seo_title'];
						$mostReadArticle = '';
						$mostReadArticle .= '<a id="article-'.$articleNumber.'" class="prefetch" href="'.$articleUrl.'">';
							$mostReadArticle .= '<div class="columns todays-favorites fade-in-out">';
								$mostReadArticle .= '<div class="row imageContainer" data-equalizer="">';
									$mostReadArticle .= '<div class="small-12 columns imageCenterer" data-equalizer-watch>';
										//$mostReadArticle .= '<img src="'.$config['image_url'].'articlesites/puckermob/large/'.$article['a_id'].'_tall.jpg" alt="'.$article['article_title'].'" />';
										$mostReadArticle .= '<img src="'.$config['image_url'].'articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg" alt="'.$article['title'].'" />';

									$mostReadArticle .= '</div>';
								$mostReadArticle .= '</div>';
								if($articleNumber === $articleTotalNumber) { $mostReadArticle .= '<div class="small-12 columns article-information" data-equalizer-watch style="padding:0 !important; border-bottom:none !important;">';}
								else{ $mostReadArticle .= '<div class="small-12 columns article-information" data-equalizer-watch style="padding:0 !important;">'; }
								//$mostReadArticle .= '<div class="small-12 columns article-information" data-equalizer-watch style="padding:0 !important;">';
									$mostReadArticle .= '<h5 class="left small-12 padding-top">'.$mpHelpers->truncate($article['title'], 80).'</h5>';
								$mostReadArticle .= '</div>';
							$mostReadArticle .= '</div>';
						$mostReadArticle .= '</a>';
						$mostReadArticle .= '';
						echo $mostReadArticle;

						if($articleNumber == 6 ){
							if($has_sponsored && $isHomepage ){ }else{
								echo '<script src="http://ib.3lift.com/ttj?inv_code=puckermob_main_right"></script>';
							
						?>
							<!-- NTENT ADS -->
							<div class="columns todays-favorites fade-in-out">
							<script type="text/javascript" language="JavaScript">
							var era_rc = {
							   Styles: '{"thumbnail":{"iw":240,"ww":300,"pa":20,"nr":1,"nc":1}}',
							   Scripts: 'thumbnail',
							   ERADomain: 'as.vs4entertainment.com',
							   PubID: 'puckermob',
							   Layout: 'large thumbnail',
							   MaxRelatedItems: '1',
							   BlockID: 'w300r1i240',
							   SearchWidgetPosition: '2',
							   ImageSize: 'large',
							   SearchBoxCaption: 'Find More ...',
							   HeaderText: ''
							};
							(function(){var v='ERA_AD_BLOCK';var i=1;while(document.getElementById(v)){if(i==25)break;v='ERA_AD_BLOCK'+i++;}document.write("<"+"div id='"+v+"'><"+"/div>");
							var sch=(location.protocol=='https:'?'https':'http');var host=sch=='http'?'as.ntent.com':'secure.ntent.com';var s=document.createElement('script');var src=sch+"://"+host+"/ERALinks/era_rl.aspx?elid="+v;for(var p in era_rc)
							{if(era_rc.hasOwnProperty(p)){src+=decodeURIComponent('%26')+p.toLowerCase()+"="+encodeURIComponent(era_rc[p]);}};s.src=src;document.getElementsByTagName("head")[0].appendChild(s);})();
							</script>
							<style>
								.era_ad_block.thumbnail.ERA_RC_w300r1i240 .vsw-ad-item .vsw-ad-image{border: none !important; width: 276px !important;}
								.era_ad_block.thumbnail.ERA_RC_w300r1i240 .vsw-ad-title{
									margin-top: 0.2rem !important;
									margin-bottom: 0.2rem !important;
									font-family: Oslo !important;
									font-size: 15px !important;
									line-height: 1.2 !important;
									color: #292929 !important;
									text-align: left !important;
									width: 280px !important;
								}
								.era_ad_block.thumbnail.ERA_RC_w300r1i240 .vsw-ad-item{margin:0 !important;}
								.era_ad_block.thumbnail div.vsw-ad-rc{border-bottom: 2px solid #232323;}
							</style>
							</div>
							<!-- END NTENT ADS -->
						<?php } }
					
				}
			?>

	</section>
<?php } ?>