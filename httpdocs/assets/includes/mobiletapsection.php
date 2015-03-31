<?php 
	//GET ARTICLES TO SHOW
	//Newest
	if(!isset($articlesList)){
		$articlesList = $mpArticle->getArticles(['count' => 20, 'omit' => [ 0 ]]);
	}

	//MOST POPULAR
	$mostReadArticlesList = $mpArticle->getMostRecentArticleList();

	//var_dump($mostReadArticlesList ); die;
	//BLOGS

	$moblog_articles = $mpArticle->getMoBlogsArticles( $articleInfoObj['article_id'] );
	
?>
<style>
	/* general style for all menus */
nav.menu{
    position: fixed;
    z-index: 20;
    background-color: #127055;
    overflow: scroll;
  
}

.content-wrapper article{
	border: 1px solid #ddd;
  	padding: 0.2rem;
  	width: 97%;
  	margin-bottom: 0.3rem;
}
.content-wrapper ul{
   list-style-type: none;
   width: 100%;
   float: left;
}
.content-wrapper li {
  display: inline-block;
  font-size: 1.1rem;
  width: auto;
  text-transform: uppercase;
  text-align: center;
  color: #000 !important;
  font-family: OsloBold;
  font-weight: bolder;
}
.content-wrapper li:after {
  content: '|';
  padding: 0 1% 0 7%;
}

.content-wrapper li:last-child:after {
  content: '';
}

nav.menu a {
   font-weight: bolder;
   color: #000;
}

nav.menu a.current{ color: #127055;}

.article-title h1{
	  font-size: 1.1rem;
	  height: 5rem;
	  display: table-cell;
	  vertical-align: middle;
	  padding: 0 0.4rem;
}
button.open-menu{
  left:85% !important;
  border-top-right-radius: 5px;
  border-top-left-radius: 5px;
  border-bottom-right-radius: 0 !important;
  border-bottom-left-radius: 0 !important;
}

button.toggle-slide-left{
  position: fixed;
  top: 30%;
  left:-29px;
  margin: 0;
  padding: 0.1rem !important;
  background: #127055;
  padding: 0;
  z-index: 999;
  border-bottom-right-radius: 5px;
  width: 5rem;
  border-bottom-left-radius: 5px;


}

button.close-menu {
    background-color: #127055;
    color: #fff;
}
button.close-menu:focus {
    outline: none
}

nav.slide-menu-left {
    top: 3.1rem;
    bottom: 2rem;
    width:   100%;;
    height: 100%;
}

nav.slide-menu-left:after {
  background: #127055;
  bottom: 0;
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 7px;

}
nav.slide-menu-left {
   right: 98.5%;
}

body.sml-open nav.menu{ background:#fff;}
body.sml-open nav.slide-menu-left {
    left: 0;
}

body.sml-open .toggle-slide-left {
	left: 0;
}


</style>

<nav class="menu slide-menu-left small-12" id="tap-section" >
	<div class="content-wrapper columns small-12 padding-top">
		<ul id="menu-options">
			<li><a id="newest" class="current">Newest</a></li>
			<li><a id="mostpopular">Most Popular</a></li>
			<li><a id="blogs">Blogs</a></li>
		</ul>
		<div class="columns small-12 no-padding padding-top tap-articles" data-info="newest">
			<?php foreach( $articlesList['articles'] as $article ){
				$linkToArticle = $config['this_url'].$article['cat_dir_name'].'/'.$article["article_seo_title"];
			?>
				<article id="article-<?php echo $article['article_id']; ?>" class="columns">
					<div class="article-image small-6 left">
						<a href="<?php echo $linkToArticle; ?>">
							<img src="http://images.puckermob.com/articlesites/puckermob/large/<?php echo $article['article_id']?>_tall.jpg" alt="<?php echo $article['article_title']; ?>" />
						</a>
					</div>
					<div class="article-title small-6 left">
						<h1><a href="<?php echo $linkToArticle; ?>"><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 35); ?></a></h1>
					</div>
				</article>
				<?php }?>
		</div>
	

	<div class="columns small-12 no-padding padding-top tap-articles  hide" data-info="mostpopular">
			<?php foreach( $mostReadArticlesList as $article ){
				$linkToArticle = $config['this_url'].$article['cat_dir_name'].'/'.$article["article_seo_title"];
			?>
				<article id="article-<?php echo $article['article_id']; ?>" class="columns">
					<div class="article-image small-6 left">
						<a href="<?php echo $linkToArticle; ?>">
							<img src="http://images.puckermob.com/articlesites/puckermob/large/<?php echo $article['article_id']?>_tall.jpg" alt="<?php echo $article['article_title']; ?>" />
						</a>
					</div>
					<div class="article-title small-6 left">
						<h1><a href="<?php echo $linkToArticle; ?>"><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 35); ?></a></h1>
					</div>
				</article>
				<?php }?>

		</div>


	<div class="columns small-12 no-padding padding-top tap-articles hide" data-info="blogs">
			<?php foreach( $moblog_articles as $article ){
				$linkToArticle = $config['this_url'].$article['cat_dir_name'].'/'.$article["article_seo_title"];
			?>
				<article id="article-<?php echo $article['article_id']; ?>" class="columns">
					<div class="article-image small-6 left">
						<a href="<?php echo $linkToArticle; ?>">
							<img src="http://images.puckermob.com/articlesites/puckermob/large/<?php echo $article['article_id']?>_tall.jpg" alt="<?php echo $article['article_title']; ?>" />
						</a>
					</div>
					<div class="article-title small-6 left">
						<h1><a href="<?php echo $linkToArticle; ?>"><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 35); ?></a></h1>
					</div>
				</article>
				<?php }?>

		</div>
	</div>
	 
</nav>
 <button class="nav-toggler toggle-slide-left rotate ">TAP</button>