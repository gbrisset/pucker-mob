<?php
require_once('../php/config.php');
$pageName = $mpArticle->data['article_page_name'];
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home" class="mobile">
	<?php include_once($config['include_path'].'header.php'); ?>
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right  mobile-12 small-12 medium-11 columns translate-fix sidebar-main-left">
			<SCRIPT SRC="http://ib.adnxs.com/ttj?id=4408970&cb=[CACHEBUSTER]&referrer=[REFERRER_URL]" TYPE="text/javascript"></SCRIPT>
		</section>
	</main>

	<?php include_once($config['include_path'].'footer.php'); ?>
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>
</body>

</html>
