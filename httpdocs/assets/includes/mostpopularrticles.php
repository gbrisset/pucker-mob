<?php 
$label = "MORE ARTICLES";
$new_layout = true;
if( isset( $articleInfoObj ) && isset( $articleInfoObj['article_id']) && $articleInfoObj['article_id']){
	$mostReadArticlesList = $mpArticle->getMoBlogsArticles( $articleInfoObj['article_id'] );
}else{
	$mostReadArticlesList = $mpArticle->getMoBlogsArticles( );
} 

if(isset($mostReadArticlesList) && $mostReadArticlesList){ ?>
	<section id="popular-articles" class="sidebar  margin-bottom">
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
								$mostReadArticle .= '<div class="small-5 columns imageContainer" >';
									$mostReadArticle .= '<div class="small-12 columns imageCenterer" >';
										$mostReadArticle .= '<img src="http://cdn.puckermob.com/articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg" alt="'.$article_title.'" />';

									$mostReadArticle .= '</div>';
								$mostReadArticle .= '</div>';
					
								$mostReadArticle .= '<div class="small-7 columns article-information valign-middle" data-equalizer-watch style="padding:0 !important;">'; 
									$mostReadArticle .= '<h5 class="columns padding-top">'.$mpHelpers->truncate($article_title, 80).'</h5>';
								$mostReadArticle .= '</div>';
							$mostReadArticle .= '</div>';
						$mostReadArticle .= '</a>';
						$mostReadArticle .= '';
						echo $mostReadArticle;

						?>
						
						<?php
							
						//Replace 6th article ntent ad
						if($articleNumber == 6 ){ ?> 
							</section>
							<?php if( isset($articleInfoObj) ){ ?>
								<!-- LELO -->
							    <?php if(isset($articleInfoObj['article_id']) &&   $articleInfoObj['article_id'] != 17425  && $articleInfoObj['article_id'] != 16562 && $articleInfoObj['article_id'] != 14479 && $articleInfoObj['article_id'] != 14576 && $articleInfoObj['article_id'] != 15109 && $articleInfoObj['article_id'] != 15271 &&   $articleInfoObj['article_id']  != 17286){?>
							      <?php if($articleInfoObj['article_id'] != 8560 &&  $articleInfoObj['article_id'] != 14613){ ?>
							        <?php if(  $articleInfoObj['article_id'] != 15284  && $articleInfoObj['article_id'] != 15488){?>
							            <div id="btf1-ad" class="ad-unit ad300" style="height:auto;     margin-left: -15px;">
							            <?php //if( isset($articleInfoObj) && $articleInfoObj['article_id'] == 19295){?>
							                 <!-- MEME GLOBAL
										   	<iframe id='m_iframe' src="http://growfoodsmart.com/sas/player/iframe.php?dPath=PuckerMob&sPlatform=Direct&playerSetup=PuckerMob&width=300&height=250&brandId=41&sCampaignID=10703&sSeller=178&creativeID=123&cb=12345&sDomain=www.puckermob.com" style="width:300px;height:250px;border:0;padding:0;margin:0;overflow:hidden;" scrolling="no" padding="0" border="0"></iframe> -->
										   <!--	<SCRIPT SRC="http://ib.adnxs.com/ttj?id=5975094&cb=[CACHEBUSTER]" TYPE="text/javascript"></SCRIPT>-->
							           <?php //} ?>
							            </div>
							        <?php } ?>
							      <?php } ?>
							    <?php }else{ ?>
							      <div id="btf1-ad" class="ad-unit ad300" style="height:auto;     margin-left: -15px;">
							          <a href="https://www.lelo.com/hex-condoms-original?utm_source=publisher_puckermob.com&utm_medium=banner&utm_content=&utm_campaign=hex_display" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>
							      </div>
							    <?php } ?>
						<?php }else{ ?>
							 <div id="btf1-ad" class="ad-unit ad300 show-on-large-up" style="height: auto;">
							      <!-- MEME GLOBAL -->
								   	<iframe id='m_iframe' src="http://growfoodsmart.com/sas/player/iframe.php?dPath=PuckerMob&sPlatform=Direct&playerSetup=PuckerMob&width=300&height=250&brandId=41&sCampaignID=10703&sSeller=178&creativeID=123&cb=12345&sDomain=www.puckermob.com" style="width:300px;height:250px;border:0;padding:0;margin:0;overflow:hidden;" scrolling="no" padding="0" border="0"></iframe>
						    </div>
						<?php } ?>
						<section class="sidebar  margin-bottom">
					<?php }
					
				}
			?>

	</section>
<?php } ?>