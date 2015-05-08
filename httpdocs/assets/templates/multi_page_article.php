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

if($articleInfoObj['date_updated'] == "0000-00-00 00:00:00") $date = date("M d, Y", strtotime($articleInfoObj['creation_date']));
else $date = date("M d, Y", strtotime($articleInfoObj['date_updated']));

$contributor_name = '';
if(isset($articleInfoObj['contributor_name']) && $articleInfoObj['contributor_name']) $contributor_name = $articleInfoObj['contributor_name'];

$contributor_id = 0;
if(isset($articleInfoObj['contributor_id']) && $articleInfoObj['contributor_id']) $contributor_id = $articleInfoObj['contributor_id'];
$linkToContributor = $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name'];

?>
<article id="sectioned-article-content" class="small-12 column <?php if($detect->isMobile()) echo " no-padding "; ?>">
	<section class="small-12 column" id="article-summary">
		<?php if(!$detect->isMobile()){?>
		<h1 id="<?php echo $articleInfoObj['article_id']; ?>" style="margin-bottom: 0.5rem;"><?php echo $articleInfoObj['article_title']; ?></h1>

		<!-- SOCIAL DESKTOP -->
		<div class="row social-media-container social-cont-1" style="margin-bottom: 0rem; display:block !important;">
				
				<a class="addthis_button_facebook">
					<img src="<?php echo $config['this_url'].'assets/img/FacebookIconCircle3.png'; ?>" alt="Facebook" />
				</a> 
				<a class="addthis_button_twitter">
					<img src="<?php echo $config['this_url'].'assets/img/TwitterIconCircle.png'; ?>" alt="Twitter" />
				</a> 
				<a class="addthis_button_pinterest_share">
					<img src="<?php echo $config['this_url'].'assets/img/Pinterest-Icon-Circle.png'; ?>" alt="Pinterest" />
				</a>
				<a href="#disqus-container" class="disqus_container">
					<img src="<?php echo $config['this_url'].'assets/img/CommentsIconCircle.png'; ?>" alt="Comments" />
				</a>
			
				<a class="addthis_button_facebook_like show-on-large-up" fb:like:send="true"  fb:like:layout="button"></a>

				<a class="addthis_button_compact show-on-medium-up"><span><i class="fa fa-plus"></i> More</span></a> 

			 	<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding" style="text-align: right; margin-top: 0rem;">
				
				<div class="addthis_jumbo_share  hide-for-print social-buttons-top"></div>
			</div>
		</div>
		<div class="padding-bottom" style=""></div>
		
		<!-- Article Content Image / Video -->
		<div class="row padding-top">
			<?php if($page_list_items->page_list_item_image != '' && $page_list_items->page_list_item_youtube_embed == ''){ ?>

			<section id="article-slide" class="columns small-12 half-padding-right-on-lg">
				<img class="wait-for-me" src="<?php echo $config['image_url'] ?>articlesites/puckermob/list/<?php echo (isset($page_list_items) ? $page_list_items->page_list_item_image : 'placeholder.png'); ?>" alt="<?php echo (isset($page_list_items) ? $page_list_items->page_list_item_title : ''); ?>">
				<?php } elseif($page_list_items->page_list_item_youtube_embed != '') { 
				//	YouTube Embed
					echo '<section id="article-slide" class="columns small-12"><div class="flex-video">';
					echo $page_list_items->page_list_item_youtube_embed;
					echo "</div>";
				} ?>
			</section>
		</div>
		<?php }else{?>
			<!-- Article Image -->
		<div class="row no-margin-with-tap">
			<!-- SMARTIES -->
			<?php if($promotedArticle){ 
				if($detect->isMobile()) $smartiesImagestyle = 'width:98%;'; else $smartiesImagestyle='';
			?>
				<div id="smarties-image" class="small-12 columns">
					<span style="position: absolute; right: 0.45rem; z-index: 999;" >
						<img style="<?php echo $smartiesImagestyle; ?>" src="http://www.puckermob.com/assets/img/sponsoredby-smarties.png">
					</span>
				</div>
			<?php } ?>
			<?php if($page_list_items->page_list_item_image != '' && $page_list_items->page_list_item_youtube_embed == ''){ ?>
			<section id="article-image" class="small-12 columns no-padding">
			<!--<section id="article-slide" class="columns small-12 half-padding-right-on-lg">-->
				<img class="wait-for-me" src="<?php echo $config['image_url'] ?>articlesites/puckermob/list/<?php echo (isset($page_list_items) ? $page_list_items->page_list_item_image : 'placeholder.png'); ?>" alt="<?php echo (isset($page_list_items) ? $page_list_items->page_list_item_title : ''); ?>">
				<?php } elseif($page_list_items->page_list_item_youtube_embed != '') { 
				//	YouTube Embed
					echo '<section id="article-slide" class="columns small-12"><div class="flex-video">';
					echo $page_list_items->page_list_item_youtube_embed;
					echo "</div>";
				} ?>
			<!--</section>-->
			</div>
			
		</div>
		
		<!-- TITLE -->
		<h1 style="margin: 0.5rem 0;"><?php echo $article_title; ?></h1>
		
		<!-- SOCIAL DESKTOP -->
		<section id="article-content-2">
			<!-- Social Media Icons -->
			<div class="row social-media-container  padding-bottom" style=" display:block !important;">
				<a class="addthis_button_facebook small-4 left">
					<label class="label-social-button-2-mobile left" ><i class="fa fa-facebook-square" ></i>SHARE</label>
				</a> 
				<a class="addthis_button_twitter  small-2 left">
					<label class="label-social-button-2-mobile left"><i class="fa fa-twitter"></i></label>
				</a> 
				<div class="addthis_jumbo_share  small-4 right hide-for-print social-buttons-top" style="height: 2.2rem !important;"></div>
			</div>
		<?php }?>
		
		<!-- ABOUT THE AUTHOR -->
		<?php include_once($config['include_path'].'abouttheauthor.php'); ?>

		<!-- Category, Date And Author Information -->
		<?php if($detect->isMobile()){ ?>
		<div class="row">
			<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 ">
				<p class="left uppercase">
					<span class="span-date" style="margin-left:0 !important;"><?php echo $date; ?></span>
				</p>
			</div>
		</div>
		<?php }else{?>
		<div class="row">
			<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 half-padding-right-on-lg padding-bottom">
				<p class="left uppercase">
					<span class="span-category <?php echo $articleInfoObj['cat_dir_name']?>"><?php echo $article_category; ?></span>
					<span class="span-date"><?php echo $date; ?></span>
				</p>
				<!--<p class="right uppercase"><span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $contributor_name; ?></a></span></p>-->
			</div>
		</div>
		<?php }?>
		
		<?php //if($detect->isMobile()){ ?>
		<!--<div class="row clear">
		
			<div class="columns hide-for-print like-us-fb">
				<p style ="color:#777" class="small-12 padding-top padding-bottom">LIKE US ON FACEBOOK
					<div class="columns small-12 " style="margin-left:0 !important;">
						<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPuckerMob%2F1492027101033794&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=25&amp;appId=1473110846264937" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px; width: 100%;" allowTransparency="true"></iframe>	
					</div>	 
				</p>
			</div>	
		<hr style="margin: 0 0.9rem !important; border-bottom:1px solid #ddd !important; padding:0.4rem !important;">
		</div>	--> 	
		<?php //}?>
		
		<!-- Content Article And Next / Prev Articles -->
		<?php if ( $detect->isMobile() ) {  echo '<div class="row" style="margin-top: -0.2rem;">'; $h2style = '';}
			  else{ echo '<div class="row clear">'; $h2style  = 'color: white; background: none repeat scroll 0% 0% rgb(0, 0, 0); padding: 0.4rem 0.5rem;';}
		?> 
			<section id="article-caption" class="columns small-12 clear">
				<h2 class="">
					<?php echo ((isset($page_list_items)) ? $page_list_items->page_list_item_title : ''); ?>
				</h2>
				
				<?php if ( !$detect->isMobile() ) { ?>
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- PM Desktop 637x90 Mid Article -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:637px;height:90px"
					     data-ad-client="ca-pub-8978874786792646"
					     data-ad-slot="5892997788"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				<!--	<div class="hide-for-print row padding padding-top padding-bottom" style="margin-bottom: 0.2rem; margin-top: 1rem;">
						<div data-str-native-key="58ad4c02" style="display: none;"></div>
						<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
					</div> -->
				<?php }else{ 
					if($articleInfoObj['article_id'] != 5050 ){
				?>
					<!-- GOOGLE AD 300x150 -->
					<div class="hide-for-print row padding padding-bottom" style="margin-bottom: 0.2rem; margin-top: 1rem;">

					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- PM Mobile 300x150 -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:300px;height:150px"
					     data-ad-client="ca-pub-8978874786792646"
					     data-ad-slot="6986976583"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
					</div>
					<?php } 
				}?>

				<?php echo ((isset($page_list_items)) ? ($page_list_items->page_list_item_body) : ''); ?>
				
				<?php if($detect->isMobile()){?>
				<!-- GOOGLE AD 300x150 -->
				<div class="hide-for-print row padding padding-top padding-bottom" style="margin-bottom: 0.2rem; margin-top: 1rem;">

				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- PM Mobile 300x150 -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:300px;height:150px"
				     data-ad-client="ca-pub-8978874786792646"
				     data-ad-slot="6986976583"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
				</div>
				<?php }else{?>
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


			<hr style="margin: 0.5rem 0 0.4rem !important">	
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
				<hr style="margin: 0.7rem 0 0 !important;" class="">
				
			<!-- Social Media Icons -->
				
			<!-- Social Media Icons -->
		<!-- DESKTOP ONLY -->
		<?php if(!$detect->isMobile()){
			//include($config['include_path'].'socialbuttonsarticles.php');
		?>
		<div class="row social-media-container social-cont-1" style="margin-bottom: 0rem; display:block !important;">
				
				<a class="addthis_button_facebook">
					<img src="<?php echo $config['this_url'].'assets/img/FacebookIconCircle3.png'; ?>" alt="Facebook" />
				</a> 
				<a class="addthis_button_twitter">
					<img src="<?php echo $config['this_url'].'assets/img/TwitterIconCircle.png'; ?>" alt="Twitter" />
				</a> 
				<a class="addthis_button_pinterest_share">
					<img src="<?php echo $config['this_url'].'assets/img/Pinterest-Icon-Circle.png'; ?>" alt="Pinterest" />
				</a>
				<a href="#disqus-container" class="disqus_container">
					<img src="<?php echo $config['this_url'].'assets/img/CommentsIconCircle.png'; ?>" alt="Comments" />
				</a>
			
				<a class="addthis_button_facebook_like show-on-large-up" fb:like:send="true"  fb:like:layout="button"></a>

				<a class="addthis_button_compact show-on-medium-up"><span><i class="fa fa-plus"></i> More</span></a> 

			 	<div id ="email-comment" class="small-4 xxlarge-4 columns hide-for-print no-padding" style="text-align: right; margin-top: 0rem !important;">
				
				<div class="addthis_jumbo_share  hide-for-print social-buttons-top" style="padding-top: 0rem !important;"></div>
			</div>
		</div>

		<?php }else{
			//include($config['include_path'].'socialbuttonsmobile.php');
		?>
			<!--<div class="row social-media-container  padding-bottom" style="margin-bottom: 1rem; display:block !important;">
				<a class="addthis_button_facebook">
					<label class="label-social-button-2-mobile"><i class="fa fa-facebook-square" ></i>SHARE</label>
				</a> 
				<a class="addthis_button_twitter">
					<label class="label-social-button-2-mobile"><i class="fa fa-twitter"></i>TWEET</label>
				</a> 
			</div>--><?php }
		?>

			<?php if(!$detect->isMobile()){?>
			<div id='__kx_ad_821'></div>
			<script type="text/javascript" language="javascript">
			var __kx_ad_slots = __kx_ad_slots || [];

			(function () {
				var slot = 821;
				var h = false;
				__kx_ad_slots.push(slot);
				if (typeof __kx_ad_start == 'function') {
					__kx_ad_start();
				} else {
					var s = document.createElement('script');
					s.type = 'text/javascript';
					s.async = true;
					s.src = 'http://cdn.kixer.com/ad/load.js';
					s.onload = s.onreadystatechange = function(){
						if (!h && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
							h = true;
							s.onload = s.onreadystatechange = null;
							__kx_ad_start();
						}
					};
					var x = document.getElementsByTagName('script')[0];
					x.parentNode.insertBefore(s, x);
				}
			})();
			</script>
			<!-- End Below Article -->
		<?php }?>
		
		<hr>

		<?php if(!$detect->isMobile()){?>
		<!-- ADBLADE-->
			<section id="content-ad-around-the-web" class="sidebar-right small-12 columns hide-for-print no-padding">
				<ins class="adbladeads" data-cid="6669-1650351935" data-host="web.adblade.com" data-tag-type="2" style="display:none"></ins>
				<script async src="http://web.adblade.com/js/ads/async/show.js" type="text/javascript"></script>
			</section>
			
		
			<?php if(!$promotedArticle ){?>
				<div data-str-native-key="53caed05" style="display: none;"></div>
				<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
			<?php } ?>
			
			<!-- COMMENTS BOX -->
			<?php include_once($config['include_path'].'disqus.php'); ?>

		<?php } ?>

		<?php if ( $detect->isMobile() ) {?>
				<!-- SHARETHROUGH 2 ARTICLE MOBILE AD -->
				<div class="hide-for-print">
					<div data-str-native-key="81d7c1fc" style="display: none;"></div>
					<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
				</div>
			<?php include_once($config['include_path'].'fromaroundthewebmobile.php'); ?>
			
				<hr style="margin: 1rem 0 1rem !important">
				<!-- COMMENTS BOX -->
				<?php include_once($config['include_path'].'disqus.php'); ?>

		<?php }?>

				<!-- SLIDE IMAGE SOURCE-->
				<?php if(isset($page_list_items) && !empty($page_list_items->page_list_item_image_source)){?>
				<section class="row">
					<p id="photo-credit-text" class="columns small-12 image-source"><?php echo ((isset($page_list_items) && !empty($page_list_items->page_list_item_image_source)) ? $page_list_items->page_list_item_image_source : ''); ?></p>
				</section>
				<?php }?>

				<!-- SLIDE COMMENTS -->
				<?php if(isset($page_list_items) && !empty($page_list_items->page_list_item_notes)){?>
				<section class="row">
					<p id="list_item_notes" class="columns small-12 " style="margin: 0.2rem 0 0.8rem 0;"><?php echo ((isset($page_list_items) && !empty($page_list_items->page_list_item_notes)) ? $page_list_items->page_list_item_notes : ''); ?></p>
				</section>
				<?php }?>

			<!-- Like us on FB --> 
			<?php if(!$detect->isMobile()){?>
			<div class="row hide-for-print like-us-fb padding-top">
				<p class="columns mobile-4 small-4 medium-2" style="font-size:0.8rem !important;">Join the Mob!
					<div class="columns mobile-8 small-8 medium-10 right" >
						<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPuckerMob%2F1492027101033794&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=25&amp;appId=1473110846264937" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px; width: 100%;" allowTransparency="true"></iframe>	
					</div>	 
				</p>
			</div>	 
				
			<?php }?>
				
			
			</section>
		
				<?php //} ?>
		</div>
		
	</section>
</article>
