<?php if(isset($mpArticle->data['featured_img']) && strlen($mpArticle->data['featured_img'])){ ?>
	<section id="featured-image" data-set="featured-image-append-around">
		<div id="featured-image-cont">
			<a href="<?php echo $mpArticle->data['featured_img_link']; ?>" target="_blank">
				<img src="<?php echo $config['image_url'].'articlesites/featured/'.$mpArticle->data['featured_img']; ?>" alt="<?php echo $mpArticle->data['article_page_visible_name'].' Feautred Image';?>"/>
			</a>
		</div>
	</section>
<?php } ?>