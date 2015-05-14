<?php
require_once('assets/php/config.php');
$pageName = $mpArticle->data['article_page_name'];

if ( $detect->isMobile() ) {?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home" class="mobile">
	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php'); ?>
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right shadow-on-large-up mobile-12 small-12 medium-11 columns translate-fix sidebar-main-left">
		<?php 
		$articlesList = $mpArticle->getArticles(['count' => 24]);
		include_once($config['include_path'].'articlelistmobile.php'); ?>
		</section>
	</main>
	<?php include_once($config['include_path'].'footer.php'); ?>
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>
</body>
</html>

<?php } else { ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home">
	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php');?>
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right shadow-on-large-up small-11 columns translate-fix sidebar-main-left">
		<?php 
		include_once($config['include_path'].'articleslist.php'); ?>
		<div id="articles-results"></div>
		</section>

		<?php //include_once($config['include_path'].'rightsidebar.php'); ?>
	</main>
	<?php include_once($config['include_path'].'footer.php'); ?>
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>
	
	<!-- 1- Determine When the User Scroll to Bottom of Page-->
	<script type="text/javascript">
            $(window).scroll(function(){
            		var count = 2; //I'm adding a counter to be used as the page number of our call
                    if  ($(window).scrollTop() == $(document).height() - $(window).height()){
                          //CALL FUNCTION HERE
                          loadArticle(count);
                          console.log(count);
                       	  count++;
                    }
            });

             function loadArticle(pageNumber){   
                    $.ajax({
                        url: "http://localhost:8888/projects/pucker-mob//httpdocs/assets/includes/articleList_test.php",
                        type:'POST',
                        data: "action=infinite_scroll&page_no="+ pageNumber + '&loop_file=loop',
                        success: function(html){
                            $("#articles-results").append(html);   // This will be the div where our content will be loaded
                        }
                    });
                return false;
            }
	</script>
</body>
</html>
<?php }?>

