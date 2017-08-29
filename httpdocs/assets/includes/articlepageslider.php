<?php if(isset($articleImages) && $articleImages){?>
<section id="slide-show-cont" class="article-slider" style="">
	<section id="article-gallery">
		<div id="article-slider" class="flexslider">
			<ul class="bx-slider slides">
				<li class="slide">
			  		<img src="<?php echo  $config['image_url'].'articlesites/puckermob/tall/'.$articleInfoObj['article_id'].'_tall.jpg'; ?>" alt="<?php echo $articleInfoObj['article_title']?> Image" />
			  	</li>
				<?php foreach($articleImages as $image){?>
					<li class="slide">
				  		<img src="<?php echo  $config['image_url'].'articlesites/puckermob/tall/'.$image['article_img_name']; ?>" alt="<?php echo $articleInfoObj['article_title']?> Image" />
				  	</li>  
			    <?php }?>
		   </ul>
		</div>
	</section>
	<section class="control-slider-nav">
		<span class="left">
			<p>
				<i class="icon-chevron-sign-left"></i>
				<label class="current-slider-number">1 OF 1</label>
				<i class="icon-chevron-sign-right"></i>
			</p>
		</span>
		<span class="right preview-close">
			<p>CLOSE<i id="preview-close" class="icon-remove-sign"></i></p>
		</span>
	</section>
</section>
<?php }?>