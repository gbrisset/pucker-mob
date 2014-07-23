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

<article id="article-<?php echo $article_id; ?>" class="columns small-12 <?php if($detect->isMobile()) echo " no-padding "; ?>">

	<section id="article-summary" class="small-12 column">
		<h1><?php echo $article_title; ?></h1>
		<div class="row">
			<section id="social-buttons" class="small-12 xxlarge-9 columns  hide-for-print social-buttons-top half-padding-right">
				<!-- Social  Buttons From AddThis.com -->
				<!-- Go to www.addthis.com/dashboard to customize your tools -->
				<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
					<a class="addthis_counter_facebook"></a>
					<a class="addthis_counter_twitter"></a>
					<a class="addthis_button_pinterest_share  show-on-large-up"></a>
					<a class="addthis_button_google_plusone_share  show-on-large-up"></a>
					<a class="addthis_button_linkedin  show-on-large-up"></a>
					<a class="addthis_button_stumbleupon  show-on-large-up"></a>
					<a class="addthis_button_email   show-on-large-up"></a>
					<a class="addthis_button_facebook_like"></a>
				</div>

			</section>
			<div id ="email-comment" class="small-3 xxlarge-3 columns hide-for-print no-padding show-for-large-up" style="text-align: right;">
				
				<a href="#disqus_thread">0 Comments</a>
				<a href="#disqus-container" >
					<i class="fa fa-comments-o fa-2x no-margin"></i>
				</a>
				<!-- Disqus Comments Configuration -->
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
		<div class="row">
			<div id="article-image" class="small-12 columns half-padding-right-on-lg">
				<meta property="" itemprop="photo" content="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article_id.'_tall.jpg'; ?>" />
				<img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Post Image">
			</div>
		</div>
		<div class="row">
			<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 padding-top half-padding-right-on-lg">
				<p class="left uppercase">
					<span class="span-category <?php echo $article_category; ?>"><?php echo $article_category; ?></span>
					<span class="span-date"><?php echo $date; ?></span>
				</p>
				<p class="right uppercase"><span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $contributor_name; ?></a></span></p>
			</div>
		</div>
		<div class="row">
			<section id="article-content" class="small-12 column">
				<p><?php echo $article_body; ?></p>
			</section>
		</div>

	</section>
</article>

