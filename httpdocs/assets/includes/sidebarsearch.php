<section id="search-cont" class="search-header-section" data-set="search-cont-append-around">
	<div id="search-header-cont">
		<form class="search-form" id="header-search" action="<?php echo $config['this_url'];?>search/" method="POST">
			<div id="search-bg">
				<input type="text" id="search" class="search-input-field" name="search"  placeholder="Search all of Simple Dish" <?php if(isset($searchString)){echo 'value="'.str_replace("+"," ",$searchString).'"';} ?> />
			</div>
			<div class="search-button">
                 <i class="icon-search"></i>
			</div>
			<div class="close-search">
                 <p>X</p>
			</div>
		</form>
	</div>
</section>