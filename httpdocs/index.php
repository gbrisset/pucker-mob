<?php
if (!empty($_GET['ajax'])) {
	$ajax = true;
} else {
	$ajax = false;
}

require_once('assets/php/config.php');
$pageName = $mpArticle->data['article_page_name'];
$isHomepage = true;
$has_sponsored = $mpArticle->data['has_sponsored_by'];

if ( $detect->isMobile() && !$detect->isTablet()) { ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home" class="mobile background-eee">
	<!-- Out of page for home -->
	<div id="home_adoop"></div>
	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php'); ?>

	<!-- MOBILE LEFT TAP -->
	<?php //include_once($config['include_path'].'mobiletapsection.php'); ?>
		
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right  mobile-12 small-12 medium-11 columns translate-fix sidebar-main-left">
			<?php 
			$articlesList = $mpArticle->getArticles(['count' => 24]);
			include_once($config['include_path'].'articlelistmobile.php'); ?>
		</section>
	</main>

	<?php include_once($config['include_path'].'footer.php'); ?>
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>
	<!-- MODAL BOX POPUP -->
	<?php //include_once($config['include_path'].'modalbox.php'); ?>
</body>

</html>

<?php }elseif($detect->isTablet()){?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home" class="">
	<!-- Out of page for home -->
	<div id="home_adoop"></div>
	<!-- Sponsored By Totally Her -->
	<input type="hidden" value="<?php echo $has_sponsored; ?>"  id="has-sponsored-by">

	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php');?>

	<!-- MOBILE LEFT TAP -->
	<?php //include_once($config['include_path'].'mobiletapsection.php'); ?>
		
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right  mobile-11 tablet-11 small-12 medium-12 large-11 columns translate-fix sidebar-main-left articlelist-wrapper">
			<?php include_once($config['include_path'].'articleslist.php'); ?>
		</section>
		<?php include_once($config['include_path'].'rightsidebar.php'); ?>
	</main>
	
	<!-- GUM GUM In Screen 
	<script type="text/javascript">ggv2id='56d76089';</script>-->

	<?php include_once($config['include_path'].'footer.php'); ?>
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>
	<!-- MODAL BOX POPUP -->
	<?php //include_once($config['include_path'].'modalbox.php'); ?>
</body>
</html>

<?php }
else if($ajax) {
	include_once($config['include_path'].'articleslist.php');
}else{ ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home" class="">
	<!-- Out of page for home -->
	<div id="home_adoop"></div>
	<!-- Sponsored By Totally Her -->
	<input type="hidden" value="<?php echo $has_sponsored; ?>"  id="has-sponsored-by">

	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php');?>

     
        <div id="light" class="white_content">
            <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><i class="fa fa-times-circle fa-lg"></i></a>
            <center>
            
            <ul class="info-list">
               <h1 style="width:50%;">INFO</h1>
               <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 50px;" href="http://www.sequelmediainternational.com/"><i class="fa fa-book"></i>Publications</a></li>
               <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 73px;" href="http://www.puckermob.com/policy/#privacy"><i class="fa fa-shield"></i>Privacy</a></li>
               <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 77px;" href="http://www.puckermob.com/policy/"><i class="fa fa-bank"></i>Legal</a></li>
               <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 60px;" href="http://www.sequelmediainternational.com/"><i class="fa fa-briefcase"></i>Advertise</a></li>
               <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 67px;" href="http://www.sequelmediainternational.com/"><i class="fa fa-phone-square"></i>Contact</a></li>
            </ul>
            </center>
            <ul class="social-links">
               <li class="pop-up-links"><a href="https://www.facebook.com/puckermob"><i class="fa fa-facebook-square"></i></a></li>
               <li class="pop-up-links"><a href="https://twitter.com/Puckermob"><i class="fa fa-twitter"></i></a></li>
               <li class="pop-up-links"><a href="https://www.pinterest.com/puckermob/"><i class="fa fa-pinterest"></i></a></li>
               <li class="pop-up-links"><a href="https://plus.google.com/112707727253651609975/posts"><i class="fa fa-google-plus-square"></i></a></li>
            </ul>
            </center>
        </div>

        <div id="fade" class="black_overlay" href= "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"></div>

	<main id="main" class="row panel sidebar-on-right" role="main" style="<?php if($has_sponsored) echo 'max-width: 56rem !important; '?>">
		
		<section id="puc-articles" class="sidebar-right  mobile-12 small-12 medium-12 large-11 columns translate-fix sidebar-main-left articlelist-wrapper main-div">
			<?php include_once($config['include_path'].'articleslist.php'); ?>
			<div class="loader"><center><img class="load_image" src="https://s3.amazonaws.com/pucker-mob/images/Preloader.gif"></center></div>
		</section>

		<?php include_once($config['include_path'].'rightsidebar.php'); ?>

		<!-- LEFT SIDE BAR -->
		<?php if(!$has_sponsored){
			include_once($config['include_path'].'left_side_bar.php');
		}?>
		
	</main>
	
	<?php 
	include_once($config['include_path'].'ads_to_load.php');

	include_once($config['include_path'].'bottomscripts.php'); ?>

	<!-- MODAL BOX FOLLOWERS POPUP -->
	<?php //include_once($config['include_path'].'modal_box_followers.php'); ?>

	<!-- FACEBOOK POPUP -->
	<?php include_once($config['include_path'].'facebookpopup.php'); ?>


</body>
</html>
<?php }?>

