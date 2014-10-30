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

		<h1 id="<?php echo $articleInfoObj['article_id']; ?>"><?php echo $articleInfoObj['article_title']; ?></h1>

		<div class="row">
			<div class="addthis_jumbo_share small-12 xxlarge-9 columns hide-for-print social-buttons-top half-padding-right"></div>
 			<a class="addthis_button_facebook_like show-for-large-up hide-for-medium hide-for-large hide-for-xlarge-down" fb:like:send="true"></a>
			
			<div id ="email-comment" class="small-3 xxlarge-3 columns hide-for-print no-padding show-for-large-up" style="text-align: right;">
				<a href="#disqus_thread">0 Comments</a>
				<a href="#disqus-container" >
					<i class="fa fa-comments-o fa-2x no-margin"></i>
				</a>
				<script type="text/javascript">
					/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
					var disqus_shortname = 'puckermob'; // required: replace example with your forum shortname

					/* * * DON'T EDIT BELOW THIS LINE * * */
					(function () {
						var s = document.createElement('script'); s.async = true;
						s.type = 'text/javascript';
						s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
						(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
					}());
				</script>
			</div>
		</div>

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
				<h2 class="" style="<?php // echo $h2style; ?>"><?php echo ((isset($page_list_items)) ? $page_list_items->page_list_item_title : ''); ?></h2>
			
				<?php if ( $detect->isMobile() ) { ?>
				<!-- GOOGLE AD UNIT MOBILE --> 

				<div class="hide-for-print row no-padding padding-top padding-bottom" style="margin-bottom: 0.2rem; ">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- PM-Mobile-320x50 -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:320px;height:50px"
					     data-ad-client="ca-pub-8978874786792646"
					     data-ad-slot="2412017386"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>
				<?php }else{ ?>
				
					<div class="hide-for-print row half-padding padding-top padding-bottom" style="margin-bottom: 0.2rem; margin-top: 1rem;">
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<ins class="adsbygoogle" style="display:inline-block;width:637px;height:90px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="5892997788"></ins>
						<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
					</div>
				<?php } ?>

				<?php echo ((isset($page_list_items)) ? ($page_list_items->page_list_item_body) : ''); ?>
				<?php if ( $detect->isMobile() ) {?>
				<section class="columns half-padding padding-bottom" style="margin-bottom:1.2rem;">
					<hr style="border-top: 1px solid #ddd;">
				</section>
				<div class="hide-for-print columns no-padding " style="margin-bottom: 0.2rem;">
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

				<!-- SLIDE COMMENTS -->
				<section class="row">
					<p id="list_item_notes" class="columns small-12 " style="margin: 0.2rem 0 0.8rem 0;"><?php echo ((isset($page_list_items) && !empty($page_list_items->page_list_item_notes)) ? $page_list_items->page_list_item_notes : ''); ?></p>
				</section>

				<!-- SLIDE IMAGE SOURCE-->
				<section class="row">
					<p id="photo-credit-text" class="columns small-12 " style="margin: 0.2rem 0 0.8rem 0;"><?php echo ((isset($page_list_items) && !empty($page_list_items->page_list_item_image_source)) ? $page_list_items->page_list_item_image_source : ''); ?></p>
				</section>	

				<!-- Like us on FB --> 
			
			<div class="row hide-for-print like-us-fb">
				<p class="columns mobile-4 small-4 medium-2">Join the Mob!
					<div class="columns mobile-8 small-8 medium-10 right" >
						<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPuckerMob%2F1492027101033794&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=25&amp;appId=1473110846264937" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px; width: 100%;" allowTransparency="true"></iframe>	
					</div>	 
				</p>
			</div>	 
					

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
				<hr style="margin: 0.7rem 0 1rem !important; border-top:1px solid #ddd;" class="padding-bottom">
			</section>
		
				<?php //} ?>
		</div>
		<?php if(!$detect->isMobile()){?>
		
		<!-- Social Media Icons -->
		<div class="row">
			<div class="addthis_jumbo_share small-12 xxlarge-9 columns hide-for-print social-buttons-top half-padding-right"></div>
 			<a class="addthis_button_facebook_like show-for-large-up hide-for-medium hide-for-large hide-for-xlarge-down" fb:like:send="true"></a>
 			
			<div id ="email-comment" class="small-3 xxlarge-3 columns hide-for-print no-padding show-for-large-up" style="text-align: right;">
				<a href="#disqus_thread">0 Comments</a>
				<a href="#disqus-container" >
					<i class="fa fa-comments-o fa-2x no-margin"></i>
				</a>
				<script type="text/javascript">
					/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
					var disqus_shortname = 'puckermob'; // required: replace example with your forum shortname

					/* * * DON'T EDIT BELOW THIS LINE * * */
					(function () {
						var s = document.createElement('script'); s.async = true;
						s.type = 'text/javascript';
						s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
						(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
					}());
				</script>
			</div>
		</div>

		
		<?php }else{?>
		<!-- SHARETHROUGH 2 ARTICLE MOBILE AD -->
			<div class="hide-for-print">
				<div data-str-native-key="81d7c1fc" style="display: none;"></div>
				<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
			</div>
		<?php } ?>
	</section>
</article>