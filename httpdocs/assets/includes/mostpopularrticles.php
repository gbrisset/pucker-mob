<?php 
$label = "THE MOB";
$new_layout = true;
if( isset( $articleInfoObj ) && isset( $articleInfoObj['article_id']) && $articleInfoObj['article_id']){
	$mostReadArticlesList = $mpArticle->getMoBlogsArticles( $articleInfoObj['article_id'] );//$mpArticle->getMostRecentArticleList( $articleInfoObj['article_id'] );
}else{
	if(isset($categoryInfo) && $categoryInfo['cat_id'] == 9 ){
		$mostReadArticlesList = $mpArticle->getMostRecentArticleList();	
		$new_layout = false;
		$label = "MOST POPULAR";
	}else{
		$mostReadArticlesList = $mpArticle->getMoBlogsArticles( );
	}
} 

if(isset($mostReadArticlesList) && $mostReadArticlesList){ ?>
	<section id="popular-articles" class="sidebar catcher">
		<div class="h4-container"><h4><?php echo $label; ?></h4></div>
			<?php 
				$articleNumber = 0;
				$articleTotalNumber = 0;
				foreach($mostReadArticlesList as $article){
					$articleTotalNumber++;
				}
				foreach($mostReadArticlesList as $article){

						if($new_layout){
							$articleUrl = 'http://www.puckermob.com/moblog/'.$article['article_seo_title'];
							$article_title = $article['article_title'];
						}else{
							$articleUrl = 'http://www.puckermob.com'.$article['url'];
							$article_title = $article['title'];
						}

						$articleNumber++;
						$mostReadArticle = '';
						$mostReadArticle .= '<a id="article-'.$articleNumber.'" class="prefetch" href="'.$articleUrl.'">';
							$mostReadArticle .= '<div class="columns todays-favorites fade-in-out">';
								$mostReadArticle .= '<div class="row imageContainer" data-equalizer="">';
									$mostReadArticle .= '<div class="small-12 columns imageCenterer" data-equalizer-watch>';
										$mostReadArticle .= '<img src="http://cdn.puckermob.com/articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg" alt="'.$article_title.'" />';

									$mostReadArticle .= '</div>';
								$mostReadArticle .= '</div>';
								if($articleNumber === $articleTotalNumber) { $mostReadArticle .= '<div class="small-12 columns article-information" data-equalizer-watch style="padding:0 !important; border-bottom:none !important;">';}
								else{ $mostReadArticle .= '<div class="small-12 columns article-information" data-equalizer-watch style="padding:0 !important;">'; }
									$mostReadArticle .= '<h5 class="left small-12 padding-top">'.$mpHelpers->truncate($article_title, 80).'</h5>';
								$mostReadArticle .= '</div>';
							$mostReadArticle .= '</div>';
						$mostReadArticle .= '</a>';
						$mostReadArticle .= '';
						echo $mostReadArticle;

						//Replace 2nd article with Adblade
						if($articleNumber == 3 ){?>
							<?php if( !$has_sponsored && !$sponsored_aricle ){ ?>
							<?php if( $articleInfoObj['article_id'] != 14472 ){ ?>
							<div class="columns todays-favorites fade-in-out">
								<!-- BEGIN JS TAG - puckermob.com Desktop 300x250 < - DO NOT MODIFY -->
								<SCRIPT SRC="http://ib.adnxs.com/ttj?id=5975094&cb=[CACHEBUSTER]" TYPE="text/javascript"></SCRIPT>
								<!-- END TAG -->
							</div>
							<?php } ?>
						<?php }
							continue;
						}

						//Replace 6th article ntent ad
						if($articleNumber == 6 ){
							if(!$has_sponsored && (isset($isHomepage) && !$isHomepage ) && !$sponsored_aricle  && $article['article_id'] != 14472 ){ ?>
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
						<?php } 
					}
					
				}
			?>

	</section>
<?php } ?>