<?php
	require_once('../assets/php/config.php');

	$pageName = $mpArticle->data['article_page_name'];
?>
<!-- *******************************************MOBILE******************************************* -->
<?php if ( $detect->isMobile() ) {  ?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<!-- BODY -->
<?php include_once($config['include_path'].'nativo_head.php');?>


<!-- HEAD -->
<body id="article" class="mobile">
	<!-- HEADER MENU -->
	<?php include_once($config['include_path'].'nativo_header.php');?>

	

	<!-- MAIN CONTENT -->
	<main id="main" class="row panel sidebar-on-right" role="main" style="">
		<section id="puc-articles" class="sidebar-right small-12   translate-fix sidebar-main-left medium-index">
			<!-- ARTICLE CONTENT -->
			<article id="article" class="columns small-12 no-padding">
				
				<section id="article-summary" class="small-12 column">
					
					<!-- ARTICLE INFO TOP -->
					<!--<div class="puc-articles-top">
						<h1 id="article-title" class="columns padding"></h1>
						
						<div class="small-12 columns puc-articles-padding">
							<p id="article-author" class="author"></p>
						</div>

						<div class="clear margin-bottom">
							<div id="article-image"></div>
						</div>
					</div>-->

					<!-- ARTICLE CONTENT -->
					<div class="row clear" style="margin-top: -1rem;">
						<section id="article-content" class="small-12 column sidebar-box" style="padding-bottom:0.5rem !important; margin-bottom: -5px;"> 
							<!-- TITLE -->
							<h1 id="article-title" class="columns padding"></h1>
							
							<!-- AUTHOR INFO -->
							<div class="small-12 columns puc-articles-padding">
								<p id="article-author" class="author"></p>
							</div>

							<!-- IMAGE -->
							<div class="clear margin-bottom">
								<div id="article-image"></div>
							</div>

							<!-- ARTICLE BODY -->
							<div id="article-body">
								<?php echo $article_body; ?>
							</div>
						</section>
					</div>
					
				</section>

			</article>
			
		</section>
		
	</main>
	
	<!-- SCRIPTS -->
	<?php include_once($config['include_path'].'nativo_bottomscripts.php');?>

</body>
</html>
<!-- *******************************************END MOBILE***************************************** -->

<!--  *******************************************DESKTOP******************************************* -->
<?php }else{ ?>
<!DOCTYPE html>
<html class="no-js" lang="en"  xmlns:fb="http://ogp.me/ns/fb#"> 

<!-- HEAD -->
<?php include_once($config['include_path'].'nativo_head.php');?>

<!-- BODY -->
<body id="article">
	
	<!-- HEADER MENU -->
	<?php include_once($config['include_path'].'new_header.php'); ?>

	<!--<div class="puc-articles-top">
		<div class="puc-articles-top-inner small-12 padding">
			<div class="columns small-12 large-9 no-padding sidebar-right left-div">
				<h1 id="article-title" style="margin-bottom: 0.5rem;" class=""></h1>
				
				<div class="small-12">
					<p id="article-author" class="author"></p>
				</div>
			</div>

			<div class="columns small-12 large-9 no-padding sidebar-right left-div">
				<div id="article-image" class="small-12 clear"></div>
			</div>
			<div class="columns small-3 no-padding-right right-div">
				<aside id="aside-top" class="fixed-width-sidebar column no-padding hide-for-print">
					<div id="sub-sidebar-2" class="ad-unit ad300 show-on-large-up" style="">
				          <a href="http://www.puckermob.com/login"> 
				          	<img src="http://www.puckermob.com/assets/img/homepage/write-box.jpg" style="width: 300px; height: 200px;">
				         </a>
				    </div>
				</aside>
			</div>
		</div>	
	</div>-->

	<?php include_once($config['include_path'].'nativo_header_ad.php'); ?>


	<!-- MAIN CONTENT -->
	<main id="main" class="row panel sidebar-on-right" role="main" style="margin-top:4rem;">
		
		<section id="puc-articles" class="cool sidebar-right small-12 medium-12 large-11 columns translate-fix" style="max-width: 752px; height:auto; ">
			<article id="article" class=" small-12 ">
				<section id="article-summary" class="small-12 column">
					<div class="columns small-12 large-9 no-padding sidebar-right left-div">
						<h1 id="article-title" style="margin-bottom: 0.5rem;" class=""></h1>
				
						<div class="small-12">
							<p id="article-author" class="author"></p>
						</div>
					</div>

					<div class="columns small-12 large-9 no-padding sidebar-right left-div">
						<div id="article-image" class="small-12 clear"></div>
					</div>
					
					<!-- Article Content -->
					<div class="row clear">
						<section id="article-content" class="small-12 column sidebar-box padding-top">
							<!-- ARTICLE BODY -->
							<div id="article-body"></div>
						</section>
					</div>
				</section>
			</article>
		</section>

		<!-- RIGHT SIDE BAR -->
		<?php include_once($config['include_path'].'nativo_rightsidebar.php');?>

	</main>
	
	<!-- SCRITPS -->
	<?php include_once($config['include_path'].'nativo_bottomscripts.php'); ?>

</body>
</html>
<?php } ?>
