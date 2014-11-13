<?php
	require_once('../assets/php/config.php');

	$pageName = $mpArticle->data['article_page_name'];
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'nativo_head.php');?>
<body id="category">
<?php include_once($config['include_path'].'header.php');?>


<main id="main" class="row panel sidebar-on-right" role="main">
	<section id="puc-articles" class="sidebar-right mobile-12 small-12 medium-12 large-11 columns translate-fix sidebar-main-left">
		
	<section id="nativo" class="small-12 columns sidebar-right">
		<h1><!-- @Title --></h1>
		<h5>Promoted post by <!-- @Author --></h5>
		<div id="nativo-brand-logo"><!-- @AuthorLogo --></div>
		<div id="nativo-content"><!-- @Content --></div>
	</section>
	</section>
	<?php if ( !$detect->isMobile() ) { ?>
		<?php include_once($config['include_path'].'rightsidebar.php');?>
	<?php } ?>
	
</main>
<?php include_once($config['include_path'].'footer.php');?>
<?php include_once($config['include_path'].'nativo_bottomscripts.php');?>
</body>
</html>
