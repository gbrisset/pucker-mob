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
				foreach($mostReadArticlesList as $article){	$articleTotalNumber++;}
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
										$mostReadArticle .= '<img src="http://images.puckermob.com/articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg" alt="'.$article_title.'" />';

									$mostReadArticle .= '</div>';
								$mostReadArticle .= '</div>';
					
								$mostReadArticle .= '<div class="small-7 columns article-information valign-middle" data-equalizer-watch style="padding:0 !important;">'; 
									$mostReadArticle .= '<h5 class="columns padding-top">'.$mpHelpers->truncate($article_title, 80).'</h5>';
								$mostReadArticle .= '</div>';
							$mostReadArticle .= '</div>';
						$mostReadArticle .= '</a>';
						$mostReadArticle .= '';
						echo $mostReadArticle;

						if($articleNumber == 6){ ?>
						<div class="columns todays-favorites fade-in-out">

						<?php //echo $smf_adManager->display_tags("dsk_sidebar_3", $article_id); ?>
<!-- 						
							<img height='0' width='0' alt='' src='//pixel.watch/936x' style='display:block;' /> 
							<script data-cfasync="false" class="carambola_InContent" type="text/javascript" cbola_wid="2">  
							(function (i,d,s,o,m,r,c,l,w,q,y,h,g) {  
							var e=d.getElementById(r);if(e===null){  
							var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n); 
							var dt=new Date().getTime();  
							try{i[l][w+y](h,i[l][q+y](h)+'&'+dt);}catch(er){i[h]=dt;}  
							} else if(typeof i[c]!=='undefined'){i[c]++}  
							else{i[c]=1;}  
							})(window, document, 'InContent', 'script', 'mediaType', 'carambola_proxy','Cbola_IC','localStorage','set','get','Item','cbolaDt','//route.carambo.la/inimage/getlayer?pid=spdsh12&did=110233&wid=2')  
							</script>
 -->
 							</div>
						<?php }//end if($articleNumber == 6)
						?>
						
						<?php 	
				}//end foreach($mostReadArticlesList as $article
			?>

	</section>
<?php } ?>