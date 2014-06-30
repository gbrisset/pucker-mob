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
	?>
<article id="sectioned-article-content" class="small-12 column microsidebar-article">
<div class="border-on-large-up no-padding">
<div class="columns small-12">
		<h1 id="<?php echo $articleInfoObj['article_id']; ?>"><?php echo $articleInfoObj['article_title']; ?></h1>
</div>
		<section id="share-buttons" class="columns small-12 medium-8">
			<button id="facebook-button" class="button columns small-3 facebook">
              <i class="fa fa-facebook fa-fw"></i><div id="facebook-count" class="social-fade-in">0</div>
            </button>
            <button id="twitter-button" class="button columns small-3 twitter">
              <i class="fa fa-twitter fa-fw"></i><div id="twitter-count" class="social-fade-in">0</div>
            </button>
            <button id="pinterest-button" class="button columns small-3 pinterest">
              <i class="fa fa-pinterest fa-fw"></i><div id="pinterest-count" class="social-fade-in">0</div>
            </button>
            <button id="google-plus-button" class="button columns small-3 google-plus">                
              <i class="fa fa-google-plus fa-fw"></i><div id="google-plus-count" class="social-fade-in">0</div>
            </button>
        </section>
        <section id="top-nav-buttons" class="columns small-12 medium-4" style="padding-left: 0;">
        <ul class="vertical-centered">
        <?php if($page > 1) { ?>
				<li><a class="prefetch" href="<?php echo $article_link.'?p='.($page - 1); ?>"><i class="fa fa-angle-left fa-2x"></i></a></li>
			<?php } ?>
				<li><span><?php echo $page; ?> of <?php echo $total_count; ?></span></li>
			<?php if($total_count > $page){ ?>
				<li><a class="prefetch" href="<?php echo $article_link.'?p='.($page + 1); ?>"><i class="fa fa-angle-right fa-2x"></i></a></li>
			<?php } ?>
		</ul>
        </section>

			<?php if($page_list_items->page_list_item_image != '' && $page_list_items->page_list_item_youtube_embed == ''){ ?>
				<section id="article-slide" class="columns small-12 row"><img class="columns small-12 wait-for-me" src="<?php echo $config['image_url'] ?>articlesites/puckermob/list/<?php echo (isset($page_list_items) ? $page_list_items->page_list_item_image : 'placeholder.png'); ?>" alt="<?php echo (isset($page_list_items) ? $page_list_items->page_list_item_title : ''); ?>">
			<?php } elseif($page_list_items->page_list_item_youtube_embed != '') { 
				//	YouTube Embed
				echo '<section id="article-slide" class="columns small-12"><div class="flex-video">';
					echo $page_list_items->page_list_item_youtube_embed;
				echo "</div>";
			 } ?>
			<p style="display: none;" id="photo-credit-text"><?php echo ((isset($page_list_items) && !empty($page_list_items->page_list_item_image_source)) ? $page_list_items->page_list_item_image_source : '<br />'); ?></p>
		</section>

		<section id="article-caption" class="columns small-12">
			<h2 class="padding-top"><?php echo ((isset($page_list_items)) ? $page_list_items->page_list_item_title : ''); ?></h2>
			<?php echo ((isset($page_list_items)) ? ($page_list_items->page_list_item_body) : ''); ?>
			<ul class="inline-centered vertical-centered">
			<?php 
				//	Get the next article, that is LIVE, that has a list attached
				$next_article = $mpArticle->get_next_with_list($articleInfoObj['article_id']); 
			?>
			<?php if($page > 1) { ?>
				<li><a href="<?php echo $article_link.'?p='.($page - 1); ?>"><i class="fa fa-chevron-circle-left fa-2x"></i></a></li>
			<?php } ?>
				<li><span><?php echo $page; ?> of <?php echo $total_count; ?></span></li>
			<?php if($total_count > $page){ ?>
				<li><a href="<?php echo $article_link.'?p='.($page + 1); ?>"><i class="fa fa-chevron-circle-right fa-2x"></i></a></li>
			<?php } else if($next_article){ ?>
				<li><a href="<?php echo $config['this_url'].'articles/'.$next_article['article_seo_title'] ?>"><button class="article-next">NEXT LIST<i class="icon-caret-right"></i></button></a></li>

			<?php } ?>
			</ul>
		</section>
		</div>
		</article>