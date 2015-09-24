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
	<?php //include_once($config['include_path'].'facebookpopup.php'); ?>

	<script>
(function() {
    var message = "We've detected that you have an ad blocker enabled! Please enable it and help support our work!";

        // Define a function for showing the message.
        // Set a timeout of 2 seconds to give adblocker
        // a chance to do its thing
        var tryMessage = function() {
            setTimeout(function() {
                if(!document.getElementsByClassName) return;
                var ads = document.getElementsByClassName('afs_ads'),
                    ad  = ads[ads.length - 1];

                if(!ad
                    || ad.innerHTML.length == 0
                    || ad.clientHeight === 0) {
                    alert(message);
                    //window.location.href = '[URL of the donate page. Remove the two slashes at the start of thsi line to enable.]';
                } else {
                    ad.style.display = 'none';
                }

            }, 2000);
        }

        /* Attach a listener for page load ... then show the message */
        if(window.addEventListener) {
            window.addEventListener('load', tryMessage, false);
        } else {
            window.attachEvent('onload', tryMessage); //IE
        }
})();
</script>


</body>
</html>
<?php }?>