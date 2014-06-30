<?php  
$askTheChefObject = $askTheChef->get();
if (isset($askTheChefObject) && $askTheChefObject) {?>
<section  id="featured-article" data-set="featured-ask-append-around">
	<section class="featured-section" id="featured-ask-cont">
		<header>
			<h2><?php echo $askTheChefObject->ask_title; ?></h2>
		</header>
		<?php 
			$askthechefDesc = $askTheChefObject->article_desc;
					if ($askTheChefObject->parent_dir_name == $askTheChefObject->cat_dir_name){ 
						// category == parent
						$link = $config['this_url'].$askTheChefObject->cat_dir_name.'/'.$askTheChefObject->article_seo_title;
					} else {
						// category != parent
						$link = $config['this_url'].$askTheChefObject->parent_dir_name.'/'.$askTheChefObject->cat_dir_name.'/'.$askTheChefObject->article_seo_title;
					}
		?>
		<article class="featured-article-section" id="ask-the-chef">
			<div class="featured-image">
				<a href="<?php echo $link; ?>">
					<img src="<?php echo $config['image_url'].'articlesites/simpledish/tall/'.$askTheChefObject->article_id.'_tall.jpg'; ?>" alt="Ask the Chef Preview Image" />
				</a>	
			</div>
			<div class="featured-info" data-title="<?php echo $askTheChefObject->ask_question ?>" data-desc="<?php echo htmlspecialchars(trim(strip_tags($askthechefDesc))) ?>">
				<h2>
					<a href="<?php echo $link; ?>"><?php echo $askTheChefObject->ask_question ?></a>
					<label class="get-recipe"><a href="<?php echo $link; ?>">See Answer</a></label>
				</h2>
			</div>
			
		</article>
	</section>
</section>
<?php }?>