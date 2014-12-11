<?php
require_once('../assets/php/config.php');

$omits = [];
$sortId = 1;
if(isset($_GET['sort'])){
	switch($_GET['sort']){
		case $_GET['sort'] == 'mp':
		$sortId = 2;
		break;
		case $_GET['sort'] == 'mv':
		$sortId = 3;
		break;
		case $_GET['sort'] == 'az':
		$sortId = 4;
		break;
		case $_GET['sort'] == 'za':
		$sortId = 5;
		break;
	}
}

$searchString = (isset($_POST['search']) && strlen($_POST['search'])) ? trim($_POST['search']) : false;

	if(!$searchString) $searchString = (isset($_GET['q']) && strlen($_GET['q'])) ? trim($_GET['q']) : false;


	if (empty( $searchString )) {
	    $searchString  = false;
	}
 
	// sanitize search term
	$searchString = htmlspecialchars(strip_tags($searchString));

if( $searchString ){
	$search = new Search( $config );

	$pageName = "Search Results For: ".$searchString.' | '.$mpArticle->data['article_page_name'];
	$searchString = filter_var($searchString, FILTER_SANITIZE_STRING, PDO::PARAM_STR);

	$articles = $search->getArticles( $searchString );

	$articlesPerPage = 24;
	$totalResults = $search->totalResults;
	
	$totalPages = ceil( $totalResults / $articlesPerPage);


	if($totalPages > 1){
		$currentPage = (isset($_GET['p'])) ? preg_replace('/[^0-9]/', '', $_GET['p']) : 1;
		
		if($currentPage > $totalPages) $currentPage = 1;
		$offset = ($currentPage - 1) * $articlesPerPage;
		$articles['articles'] = array_slice($articles['articles'], $offset, $articlesPerPage);

		$pagesArray['url'] = $config['this_url'].'search/?q='.$searchString;
		$pagesArray['pages'] = $mpHelpers->getPages($currentPage, $totalPages);
	}
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="search">
	<?php include_once($config['include_path'].'header.php');?>
	<?php include_once($config['include_path'].'header_ad.php');?>
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right small-11 columns translate-fix sidebar-main-left">
			<section id="search-intro" class="small-12 columns sidebar-right">
				<div class="row collapse">
					<div class="small-8 small-push-1 columns">
						<input id="notfound-search-contents" type="text" placeholder="Find Articles"<?php if(isset($searchString)){echo ' value="'.str_replace("+"," ",$searchString).'"';} ?>>
					</div>
					<div class="small-2 small-pull-1 columns">
						<button id="notfound-search-submit" class="button postfix alert"><i class="fa fa-search"></i>Search</button>
					</div>
				</div>

				<?php if(!isset($searchString) || !$searchString){ ?>
				<h1>Search</h1>
			</section>
			<section id="results" class="small-12 columns sidebar-right">
				<p>Looking for something? Just type it into the search box up there and you'll be on your way to the best content around!</p>
			</section>
			<?php }else if(!count($articles)){ ?>
			<h1>Search Results <small>(<?php 
				echo (isset($searchString) && $searchString) ?  $totalResults.' results for "'.$searchString.'"' : $mpArticle->data['article_page_visible_name'].' Search ';
				?>)</small></h1>
			</section>
			<section id="results" class="small-12 columns sidebar-right">
				<p>Sorry, we couldn't find anything matching that search phrase.</p>
			</section>

			<?php }else{ ?>
			<h1>Search Results <small>(<?php 
				echo (isset($searchString) && $searchString) ?  $totalResults.' results for "'.$searchString.'"' : $mpArticle->data['article_page_visible_name'].' Search ';
				?>)</small></h1>
			</section>
			<section id="results" class="small-12 columns sidebar-right">


				<?php 
				if(isset($articles) && $articles){

					$articleIndex = 1;
					foreach($articles['articles'] as $article){
						$articleDesc = $article['article_desc'];
						if (isset($article['parent_dir_name']) && $article['parent_dir_name'] != 'categories-root'){ 
							$link = $config['this_url'].$mpHelpers::linkToArticle($article['cat_dir_name'], $article['parent_dir_name']).$article['article_seo_title'];
						} else {
							$link = $config['this_url'].$mpHelpers::linkToArticle($article['cat_dir_name']).$article['article_seo_title'];
						}
						$date = date("M d, Y", strtotime($article['creation_date']));
						$linkToImage = $config['image_url'].'articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg';
						$linkToContributor = $config['this_url'].'contributors/'.$article['contributor_seo_name'];
						?>
						<article class="row" id="<?php echo 'article-'.$articleIndex;?>">

							<div class="columns mobile-12 small-12 medium-12 large-12 xlarge-12">
								<?php if ( $detect->isMobile() ) {  $articleIndex++;?>
								<a class="mobile-5 small-5 medium-5 large-5 xlarge-5 half-padding-right left" href="<?php echo $linkToArticle; ?>">
									<img src="<?php echo $linkToImage; ?>" alt=''>
								</a>
								<div class="mobile-7 small-7 medium-7 large-7 xlarge-7 half-padding-left mobile-vertical-center vertical-align-center">
									<p class="vertical-center">
										<span class="span-category"><?php echo $article['cat_name']?></span>
										<small><?php echo $date; ?></small>
									</p>
									<a href="<?php echo $link; ?>">
										<h5><?php echo $article['article_title']?></h5>
									</a>
									<p><small>By <a href="<?php echo $linkToContributor; ?>" ><?php echo $article['contributor_name']; ?></a></small></p>
								</div>
								<?php }else{
								$articleIndex++; ?>
								<a class="mobile-5 small-5 medium-5 large-6 xlarge-6 half-padding-right left" href="<?php echo $link; ?>">
									<img src="<?php echo $linkToImage; ?>" alt=''>
								</a>
								<div class="mobile-7 small-7 medium-7 large-6 xlarge-6 mobile-vertical-center vertical-align-center half-padding-left half-padding-right">
									<p class="uppercase">
										<span class="span-category"><?php echo $article['cat_name']?></span>
										<span class="span-date"><?php echo $date; ?></span>
									</p>
									<a href="<?php echo $link; ?>">
										<h1><?php echo $article['article_title']?></h1>
									</a>
									<p class="uppercase"><span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $article['contributor_name']; ?></a></span></p>
								</div>
								<?php } ?>
							</div>
						</div>
					</article>
					<hr />
					<?php }
				}?>
			</section>
			<?php } ?>

			<?php include_once($config['shared_include'].'pagination.php');?>
			<?php if (!$detect->isMobile()) { ?>
			<div id="medianet-ad" class="ad-unit hide-for-print padding-right show-for-xxlarge-only"></div>
			<?php include_once($config['include_path'].'fromourpartners.php'); ?>
			<?php include_once($config['include_path'].'aroundtheweb.php'); 
			}?>
	</section>
	<?php if (!$detect->isMobile()) { 
		include_once($config['include_path'].'rightsidebar.php');
	} ?>

</main>
<?php include_once($config['include_path'].'footer.php');?>
<?php include_once($config['include_path'].'bottomscripts.php');?>
</body>
</html>