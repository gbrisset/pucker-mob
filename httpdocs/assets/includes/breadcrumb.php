<?php 
	if(!isset($uri)) $uri = $uriHelper->getURI($mpHelpers->curPageURL());
	if(!isset($mainCategoryArray)) $mainCategoryArray = $uriHelper::getMainCategoryArray($MPNavigation->mainCategories);
?>
<section id="breadcrumb">
	<div id="breadcrumb-cont">
		<a href="<?php echo $config['this_url']; ?>">Home</a>
		<a href="<?php echo ($hasParent) ? '' : $config['this_url'].$uri[0]; ?>"><?php echo str_replace("-", " ", $uri[0]); ?></a>
		<?php if(!empty($uri[1])){
			//if (!in_array($uri[0], $mainCategoryArray)) {?>
			<a href="<?php echo $config['this_url'].$uri[0].'/'.$uri[1]; ?>"><?php echo str_replace("-", " ", $uri[1]); ?></a>
		<?php //} 
		}?>
	</div>
</section>