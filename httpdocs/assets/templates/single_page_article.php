<?php
// Initialize variables
if (isset($articleInfoObj)) {
	$article_title = $articleInfoObj['article_title'];;
	$article_id = $articleInfoObj['article_id'];
	$article_body = $articleInfoObj['article_body'];
	$article_category = $category['cat_dir_name'];
	$date = date("M d, Y", strtotime($articleInfoObj['creation_date']));
	$contributor_name = $articleInfoObj['contributor_name'];
	$linkToContributor = $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name'];
}
?>

<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>

<article id="article-<?php echo $article_id; ?>" class="columns small-12 <?php if($detect->isMobile()) echo " no-padding "; ?>">
	<section id="article-summary" class="small-12 column">
		<h1><?php echo $article_title; ?></h1>
		
		<!-- Social Media Icons 
		<div class="row">
			<div class="addthis_jumbo_share small-12 xxlarge-9 columns  hide-for-print social-buttons-top half-padding-right"></div>
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
		
		<!-- Article Image -->
		<div class="row">
			<div id="article-image" class="small-12 columns half-padding-right-on-lg">
				<meta property="" itemprop="photo" content="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article_id.'_tall.jpg'; ?>" />
				<img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Post Image">
			</div>
		</div>

		<!-- Category, Date And Author Information -->
		<div class="row">
			<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 padding-top half-padding-right-on-lg">
				<p class="left uppercase">
					<span class="span-category <?php echo $article_category; ?>"><?php echo $article_category; ?></span>
					<span class="span-date"><?php echo $date; ?></span>
				</p>
				<p class="right uppercase"><span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $contributor_name; ?></a></span></p>
			</div>
		</div>
		
		<!-- Article Content -->
		<div class="row">
			<section id="article-content" class="small-12 column">
				<p><?php echo $article_body; ?></p>
			</section>
		</div>

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
		
		<hr>

		<!-- SHARETHROUG ARTICLE AD MOBILE -->
		<?php if ( $detect->isMobile() ) { ?>
			<div class="row">
				<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 padding-top half-padding-right-on-lg">
					
					<div data-str-native-key="81d7c1fc" style="display: none;"></div>
				</div>
			</div>
		<?php } ?>
	</section>
</article>

