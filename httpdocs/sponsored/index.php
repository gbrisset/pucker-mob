<?php
	require_once('../assets/php/config.php');

	$pageName = $mpArticle->data['article_page_name'];
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="distroscale">
<?php include_once($config['include_path'].'header.php');?>
<?php include_once($config['include_path'].'header_ad.php'); ?>


<main id="main" class="row panel sidebar-on-right" role="main">
	<section id="puc-articles" class="sidebar-right shadow-on-large-up mobile-12 small-12 medium-12 large-11 columns translate-fix sidebar-main-left">
		
		<!-- Distro Scale AD Tag -->
			<script type="text/javascript" src="http://c.jsrdn.com/s/cs.js?p=22257"> </script>
		<!-- Begin comScore Tag -->	
	
	</section>
	<?php if ( !$detect->isMobile()) { ?>
		<?php include_once($config['include_path'].'rightsidebar.php');?>
	<?php } ?>
	
</main>
<?php include_once($config['include_path'].'footer.php');?>
<?php include_once($config['include_path'].'bottomscripts.php');?>
</body>
</html>
