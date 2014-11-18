<?php 
		// 1. the current page number ($current_page)
$page = !empty($_GET['p']) ? (int)$_GET['p'] : 1;
		// 2. records per page ($per_page)
$per_page = 1;

		// 3. total record count ($total_count)	
$total_count = PageListItem::count($articleInfoObj['page_list_id']);

$pagination = new Pagination($page, $per_page, $total_count);
$offset = $pagination->offset();
$page_list_items = PageListItem::get_current($articleInfoObj['page_list_id'], $offset);

$article_category = $articleInfoObj['cat_name'];
$date = date("M d, Y", strtotime($articleInfoObj['creation_date']));
$contributor_name = $articleInfoObj['contributor_name'];
$linkToContributor = $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name'];

?>
<article id="sectioned-article-content" class="small-12 column <?php if($detect->isMobile()) echo " no-padding "; ?>">
	<section class="small-12 column" id="article-summary">

		<h1 id="<?php echo $articleInfoObj['article_id']; ?>" style="margin-bottom: 0.5rem;"><?php echo $articleInfoObj['article_title']; ?></h1>

		<!-- SOCIAL DESKTOP -->
		<?php //if(!$detect->isMobile()){?>
		<div class="row social-media-container social-cont-1" style="margin-bottom: 0.5rem; display:block !important;">
				
				<a class="addthis_button_facebook">
					<img src="<?php echo $config['this_url'].'assets/img/FacebookIconCircle3.png'; ?>" alt="Facebook" />
				</a> 
				<a class="addthis_button_twitter">
					<img src="<?php echo $config['this_url'].'assets/img/TwitterIconCircle.png'; ?>" alt="Twitter" />
				</a> 
				<a href="#disqus-container" class="disqus_container">
					<img src="<?php echo $config['this_url'].'assets/img/CommentsIconCircle.png'; ?>" alt="Comments" />
				</a>
				
				<a class="addthis_button_compact show-on-medium-up"><span><i class="fa fa-plus"></i> More</span></a> 

			 	<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding" style="text-align: right;">
				
				<div class="addthis_jumbo_share  hide-for-print social-buttons-top"></div>
			</div>
		</div>
		<?php //} ?>

		<!-- Article SubTitle ( SLIDE ) 
		<?php //if ( $detect->isMobile() ) {  echo '<div class="row" style="margin-top: -1rem;">'; }
			  //else{ echo '<div class="row">'; }
		?> 
			<section id="article-caption" class="columns small-12 ">
				<h2 class=""><?php echo ((isset($page_list_items)) ? $page_list_items->page_list_item_title : ''); ?></h2>
			</section>
		</div>-->

		<!-- Article Content Image / Video -->
		<div class="row">
			<?php if($page_list_items->page_list_item_image != '' && $page_list_items->page_list_item_youtube_embed == ''){ ?>

			<section id="article-slide" class="columns small-12 half-padding-right-on-lg">
				<img class="wait-for-me" src="<?php echo $config['image_url'] ?>articlesites/puckermob/list/<?php echo (isset($page_list_items) ? $page_list_items->page_list_item_image : 'placeholder.png'); ?>" alt="<?php echo (isset($page_list_items) ? $page_list_items->page_list_item_title : ''); ?>">
				<?php } elseif($page_list_items->page_list_item_youtube_embed != '') { 
				//	YouTube Embed
					echo '<section id="article-slide" class="columns small-12"><div class="flex-video">';
					echo $page_list_items->page_list_item_youtube_embed;
					echo "</div>";
				} ?>
				<p style="display: none;" id="photo-credit-text"><?php echo ((isset($page_list_items) && !empty($page_list_items->page_list_item_image_source)) ? $page_list_items->page_list_item_image_source : '<br />'); ?></p>
			</section>
		</div>
		
		<!-- Category, Date And Author Information -->
		<div class="row">
			<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 padding-top half-padding-right-on-lg">
				<p class="left uppercase">
					<span class="span-category <?php echo $articleInfoObj['cat_dir_name']?>"><?php echo $article_category; ?></span>
					<span class="span-date"><?php echo $date; ?></span>
				</p>
				<p class="right uppercase"><span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $contributor_name; ?></a></span></p>
			</div>
		</div>

		

		<!-- Content Article And Next / Prev Articles -->
		<?php if ( $detect->isMobile() ) {  echo '<div class="row" style="margin-top: -1rem;">'; $h2style = '';}
			  else{ echo '<div class="row">'; $h2style  = 'color: white; background: none repeat scroll 0% 0% rgb(0, 0, 0); padding: 0.4rem 0.5rem;';}
		?> 
			<section id="article-caption" class="columns small-12 ">
				<h2 class="" style="<?php // echo $h2style; ?>">
					<?php echo ((isset($page_list_items)) ? $page_list_items->page_list_item_title : ''); ?>
				</h2>
				
				<?php if ( $detect->isMobile() ) { ?>
				<!-- GOOGLE AD UNIT MOBILE  

				<div class="hide-for-print row no-padding padding-top padding-bottom" style="margin-bottom: 0.2rem; text-align:center;">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					 PM-Mobile-320x50 
					<ins class="adsbygoogle"
					     style="display:inline-block;width:320px;height:50px"
					     data-ad-client="ca-pub-8978874786792646"
					     data-ad-slot="2412017386"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>-->
				<?php }else{ ?>
				
					<div class="hide-for-print row padding padding-top padding-bottom" style="margin-bottom: 0.2rem; margin-top: 1rem;">
						<div data-str-native-key="58ad4c02" style="display: none;"></div>
						<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
					</div>
				<?php } ?>

				<?php echo ((isset($page_list_items)) ? ($page_list_items->page_list_item_body) : ''); ?>
				
				<!-- SLIDE COMMENTS -->
				<section class="row">
					<p id="list_item_notes" class="columns small-12 " style="margin: 0.2rem 0 0.8rem 0;"><?php echo ((isset($page_list_items) && !empty($page_list_items->page_list_item_notes)) ? $page_list_items->page_list_item_notes : ''); ?></p>
				</section>

				<!-- SLIDE IMAGE SOURCE-->
				<section class="row">
					<p id="photo-credit-text" class="columns small-12 " style="margin: 0.2rem 0 0.8rem 0;"><?php echo ((isset($page_list_items) && !empty($page_list_items->page_list_item_image_source)) ? $page_list_items->page_list_item_image_source : ''); ?></p>
				</section>	

				<?php if ( $detect->isMobile() ) {?>
				<!-- SHARETHROUGH 2 ARTICLE MOBILE AD -->
				<div class="hide-for-print">
					<div data-str-native-key="81d7c1fc" style="display: none;"></div>
					<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
				</div>
				<br>
				<div class="hide-for-print row clear" style="margin-bottom: 0.2rem; text-align: center;">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- PM-Mobile-300x250 Bottom -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:300px;height:250px"
					     data-ad-client="ca-pub-8978874786792646"
					     data-ad-slot="6385741786"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>

				</div>
				<hr style="margin: 1rem 0 1rem !important">
				<?php }else{ ?>
				<?php if(!$promotedArticle ){?>
			     	<!-- Puckermob Instory Connatix -->
			     	<style>#connatix{ padding:0 !important;} #connatix #article-summary{ border-bottom: 0 !important;}</style>
					<script type='text/javascript' src='//cdn.connatix.com/min/connatix.renderer.infeed.min.js' data-connatix-token='1f15e94f-843f-4d31-8940-4eb181b32d73'></script>
				<?php } ?>

				<div class="row padding-top padding-bottom">

						<section class="columns small-12 padding-bottom">
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<!-- PM 637x90 Bottom -->
							<ins class="adsbygoogle"
							     style="display:inline-block;width:637px;height:90px"
							     data-ad-client="ca-pub-8978874786792646"
							     data-ad-slot="3114328182"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</section>
					</div>
				<?php }?>

				<!-- Like us on FB --> 
			<?php if(!$detect->isMobile()){?>
			<div class="row hide-for-print like-us-fb">
				<p class="columns mobile-4 small-4 medium-2" style="font-size:0.8rem !important;">Join the Mob!
					<div class="columns mobile-8 small-8 medium-10 right" >
						<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPuckerMob%2F1492027101033794&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=25&amp;appId=1473110846264937" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px; width: 100%;" allowTransparency="true"></iframe>	
					</div>	 
				</p>
			</div>	 
			<hr style="margin: 0.5rem 0 0.4rem !important">		
			<?php }?>
				
				<?php 
				$prevtext = "PREV PAGE";
				$nexttext = "NEXT PAGE";
				if($detect->isMobile() || $detect->isTablet()){
					$prevtext = "PREV";
					$nexttext = "NEXT";
				}?>
				<ul class="inline-centered vertical-centered">
					<?php 
				//	Get the next article, that is LIVE, that has a list attached
					$next_article = $mpArticle->get_next_with_list($articleInfoObj['article_id']); 
					?>
					<?php if($page > 1) { ?>
					<li class="arrow-box left"><a href="<?php echo $article_link.'?p='.($page - 1); ?>"><div class="arrow-left"><i class="fa fa-caret-left"></i><?php echo $prevtext;?></div></a></li>
					<li  class="num-page-margin-top "><span><?php echo $page; ?> of <?php echo $total_count; ?></span></li>

					<?php }else{ ?>
						<li  class="num-page-margin-top num-page-right-style"><span><?php echo $page; ?> of <?php echo $total_count; ?></span></li>
					
					<?php }?>
					<?php if($total_count > $page){ ?>
					<li  class="arrow-box right"><a href="<?php echo $article_link.'?p='.($page + 1); ?>"><div class="arrow-right"><?php echo $nexttext;?><i class="fa fa-caret-right"></i></div></a></li>
					<?php } else if($next_article){ ?>
					<li class="arrow-box right"><a href="<?php echo $config['this_url'].$next_article['cat_dir_name'] .'/'.$next_article['article_seo_title'] ?>"><div class="arrow-right"><?php echo $nexttext;?><i class="fa fa-caret-right"></i></div></a></li>

					<?php } ?>
				</ul>
				<hr style="margin: 0.7rem 0 1rem !important; border-top: 5px solid #000;" class="padding-bottom">
			</section>
		
				<?php //} ?>
		</div>
		<?php if(!$detect->isMobile()){?>
		
		<div class="row social-media-container" style="margin-bottom: 0.5rem;">
				
				<a class="addthis_button_facebook">
					<img src="<?php echo $config['this_url'].'assets/img/FacebookIconCircle3.png'; ?>" alt="Facebook" />
				</a> 
				<a class="addthis_button_twitter">
					<img src="<?php echo $config['this_url'].'assets/img/TwitterIconCircle.png'; ?>" alt="Twitter" />
				</a> 
				<a href="#disqus-container" class="disqus_container">
					<img src="<?php echo $config['this_url'].'assets/img/CommentsIconCircle.png'; ?>" alt="Comments" />
				</a>
				
				<a class="addthis_button_compact"><span><i class="fa fa-plus"></i> More</span></a> 

			 	<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding show-on-medium-up" style="text-align: right;">
				
				<div class="addthis_jumbo_share  hide-for-print social-buttons-top"></div>
			</div>
		</div>
		
		<?php }else{?>
		
		<?php } ?>
	</section>
</article>