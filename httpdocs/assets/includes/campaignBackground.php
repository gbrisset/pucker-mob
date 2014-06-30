<?php if(isset($categoryInfo) && $categoryInfo["cat_background_image"]){ ?>
<div id="bg">
	<img style="" src="<?php echo $config['image_url']; ?>articlesites/simpledish/campaign/<?php echo $categoryInfo['cat_background_image'];?>" alt="Category Background">
</div>
<?php }?>