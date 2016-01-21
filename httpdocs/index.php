<?php
if (!empty($_GET['ajax'])) {
	$ajax = true;
} else {
	$ajax = false;
}

require_once('assets/php/config.php');
$pageName = $mpArticle->data['article_page_name'];
$isHomepage = true;
$has_sponsored = 1;
$is_takeover = false;


if ( $detect->isMobile() && !$detect->isTablet()) { ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home" class="mobile background-eee">
	<!-- Totally Her -->
	<div id="home_adoop"></div>

	<style>#nav-bar{ box-shadow: none;} #articlelist-wrapper{ padding-top:0 !important;} .evolve-media{margin-top: 5px;    }</style>
	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php'); ?>

		
	<main id="main" class="row panel sidebar-on-right" role="main">
		
		<section id="puc-articles" class="sidebar-right  mobile-12 small-12 medium-11 columns translate-fix sidebar-main-left">
			<div class="evolve-media">
			<div id="home_1197"></div>
		</div>

			<?php 
			$articlesList = $mpArticle->getArticles(['count' => 24]);
			include_once($config['include_path'].'articlelistmobile.php'); ?>
		</section>
	</main>

	<?php include_once($config['include_path'].'footer.php'); ?>
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>

</body>

</html>

<?php }elseif($detect->isTablet()){?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home" class="">
	<!-- Totally Her -->
	<div id="home_adoop"></div>

	<!-- Sponsored By Totally Her -->
	<input type="hidden" value="<?php echo $has_sponsored; ?>"  id="has-sponsored-by">

	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php');?>

		
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right  mobile-11 tablet-11 small-12 medium-12 large-11 columns translate-fix sidebar-main-left articlelist-wrapper">
			<?php include_once($config['include_path'].'articleslist.php'); ?>
		</section>
		<?php include_once($config['include_path'].'rightsidebar.php'); ?>
	</main>


	<?php include_once($config['include_path'].'footer.php'); ?>
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>

</body>
</html>

<?php }
elseif($ajax) {

	include_once($config['include_path'].'articleslist.php');

}else{ ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home">
	<!-- Totally Her -->
	<div id="home_adoop"></div>
	
	<!-- Sponsored By Totally Her -->
	<input type="hidden" value="<?php echo $has_sponsored; ?>"  id="has-sponsored-by">

	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php');?>

     <main id="main" class="row panel sidebar-on-right" role="main">
		
		<?php include_once($config['include_path'].'rightsidebar.php'); ?>

		<!-- LEFT SIDE BAR -->
		<?php if(!$has_sponsored){
			include_once($config['include_path'].'left_side_bar.php');
		}?>
		
	</main>
	
	<?php 
	include_once($config['include_path'].'ads_to_load.php');

	include_once($config['include_path'].'bottomscripts.php'); ?>


</body>
</html>
<?php }?>