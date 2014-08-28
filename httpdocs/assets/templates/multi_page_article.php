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
<section id="article-top-bar" ><header>Puckermob exclusive slide show</header></section>

<article id="sectioned-article-content" class="small-12 column <?php if($detect->isMobile()) echo " no-padding "; ?>">
	<section class="small-12 column" id="article-summary">

		<h1 id="<?php echo $articleInfoObj['article_id']; ?>"><?php echo $articleInfoObj['article_title']; ?></h1>

		<!-- Social Media Icons 
		<div class="row">
			<div class="addthis_jumbo_share small-12 xxlarge-9 columns  hide-for-print social-buttons-top half-padding-right">
			</div>
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
		</div>-->
		<!-- Social Media Icons -->
		<div class="row">
			<section id="social-buttons" class="small-12 xlarge-8 columns hide-for-print">
				<div class="pw-widget">
					<a class="pw-button-facebook">
						<button id="facebook-button" class="columns small-16P button small facebook">
							<i class="fa fa-facebook fa-fw"></i><div id="facebook-count" class="social-fade-in"></div>
						</button>
					</a>
					<a class="pw-button-twitter">
						<button id="twitter-button" class="columns small-16P button small twitter">
							<i class="fa fa-twitter fa-fw"></i><div id="twitter-count" class="social-fade-in"></div>
						</button>
					</a>
					<a class="pw-button-pinterest">
						<button id="pinterest-button" class="columns small-16P button small pinterest">
							<i class="fa fa-pinterest fa-fw"></i><div id="pinterest-count" class="social-fade-in"></div>
						</button>
					</a>
					<a class="pw-button-googleplus">
						<button id="google-plus-button" class="columns small-16P button small google-plus">                
							<i class="fa fa-google-plus fa-fw"></i><div id="google-plus-count" class="social-fade-in"></div>
						</button>
					</a>
					<a class="pw-button-stumbleupon">
						<button id="stumble-upon-button" class="columns small-16P button small stumble-upon">                
							<i class="fa fa-stumbleupon fa-fw"></i><div id="stumble-upon-count" class="social-fade-in"></div>
						</button>
					</a>
					<a class="pw-button-linkedin">
						<button id="linkedin-button" class="columns small-16P button small linkedin">                
							<i class="fa fa-linkedin fa-fw"></i><div id="linkedin-count" class="social-fade-in"></div>
						</button>
					</a>
				</div>
			</section>
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
		<div class="row">
			<section id="article-caption" class="columns small-12 ">
				<h2 class="padding-top"><?php echo ((isset($page_list_items)) ? $page_list_items->page_list_item_title : ''); ?></h2>
				<?php echo ((isset($page_list_items)) ? ($page_list_items->page_list_item_body) : ''); ?>
				<ul class="inline-centered vertical-centered">
					<?php 
				//	Get the next article, that is LIVE, that has a list attached
					$next_article = $mpArticle->get_next_with_list($articleInfoObj['article_id']); 
					?>
					<?php if($page > 1) { ?>
					<li><a href="<?php echo $article_link.'?p='.($page - 1); ?>"><div class="arrow-left"></div></a></li>
					<?php } ?>
					<li><span><?php echo $page; ?> of <?php echo $total_count; ?></span></li>
					<?php if($total_count > $page){ ?>
					<li><a href="<?php echo $article_link.'?p='.($page + 1); ?>"><div class="arrow-right"></div></a></li>
					<?php } else if($next_article){ ?>
					<li><a href="<?php echo $config['this_url'].$next_article['cat_dir_name'] .'/'.$next_article['article_seo_title'] ?>"><div class="arrow-right"></div></a></li>

					<?php } ?>
				</ul>
				<br>
			</section>
		</div>
		<hr>
		<!-- Social Media Icons -->
		<div class="row">
			<section id="social-buttons" class="small-12 xlarge-8 columns hide-for-print">
				<div class="pw-widget">
					<a class="pw-button-facebook">
						<button id="facebook-button" class="columns small-16P button small facebook">
							<i class="fa fa-facebook fa-fw"></i><div id="facebook-count" class="social-fade-in"></div>
						</button>
					</a>
					<a class="pw-button-twitter">
						<button id="twitter-button" class="columns small-16P button small twitter">
							<i class="fa fa-twitter fa-fw"></i><div id="twitter-count" class="social-fade-in"></div>
						</button>
					</a>
					<a class="pw-button-pinterest">
						<button id="pinterest-button" class="columns small-16P button small pinterest">
							<i class="fa fa-pinterest fa-fw"></i><div id="pinterest-count" class="social-fade-in"></div>
						</button>
					</a>
					<a class="pw-button-googleplus">
						<button id="google-plus-button" class="columns small-16P button small google-plus">                
							<i class="fa fa-google-plus fa-fw"></i><div id="google-plus-count" class="social-fade-in"></div>
						</button>
					</a>
					<a class="pw-button-stumbleupon">
						<button id="stumble-upon-button" class="columns small-16P button small stumble-upon">                
							<i class="fa fa-stumbleupon fa-fw"></i><div id="stumble-upon-count" class="social-fade-in"></div>
						</button>
					</a>
					<a class="pw-button-linkedin">
						<button id="linkedin-button" class="columns small-16P button small linkedin">                
							<i class="fa fa-linkedin fa-fw"></i><div id="linkedin-count" class="social-fade-in"></div>
						</button>
					</a>
				</div>
			</section>
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
		
		<!-- SHARETHROUG ARTICLE AD MOBILE -->
		<?php if ( $detect->isMobile() ) { ?>
		<div class="row">
			<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 padding-top half-padding-right-on-lg">
				<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
				<div data-str-native-key="536c62e7" style="display: none;"></div>
			</div>
		</div>
		<?php } ?>
	</section>
</article>

<section class="small-12 column padding-bottom padding-top">
  <div id="atfleft-ad" class="ad-unit ad300 show-on-large-up left"></div>
  <div id="atfright-ad" class="ad-unit ad300 show-on-large-up right"></div>
</section>