<?php
$categoryInfo = null;
$isArticle = true;
$articleInfoObj = array();

foreach($MPNavigation->categories as $category){
	if( isset($category['cat_dir_name'])  && !(isset($uri[2])) && ($category['cat_dir_name'] == $uri[0])  ){
			// uri[2] not set, cat has no parent
		$categoryInfo = $category;
		$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[1]))[0];
		$hasParent = false;
		break;
	} else if(isset($category['cat_dir_name']) && (isset($uri[2])) && ($category['cat_dir_name'] == $uri[1]) ){
			// uri[2] set! cat has parent!
		$categoryInfo = $category;
		$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[2]))[0];
		$hasParent = true;
		break;
	}
}

if(!is_null($categoryInfo)){
	$articleInfo = $mpArticle->getArticles(['articleSEOTitle' => $articleTitle]);
	$cat_name = $categoryInfo['cat_dir_name'];

	if(isset($articleInfo['articles']) &&  $articleInfo['articles']){
		$articleInfoObj = $articleInfo['articles'][0];

		$pageName = $articleInfoObj['article_title'];
		if($articleInfoObj['article_id'] == "4349"){
			$pageName = strtoupper($articleInfoObj['article_title']).' | Sponsored by Smarties Candies';
		}
		$relatedArticles = $mpArticle->getArticles(['count' => 18, 'pageId' => $categoryInfo['cat_id'], 'omit' => $articleInfo['ids']]);
		$articleImages = $mpArticle->getArticlesImages($articleInfoObj['article_id']);
	}else {
		$mpShared->get404();
	}
}else {
	$mpShared->get404();
}
	$pagesArray['url'] = $config['this_url'].$categoryInfo['cat_dir_name'];
	$article_link = $config['this_url'].$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title'];

?>
<?php if ( $detect->isMobile() ) { ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>

<?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){ ?>
	<body id="articleslide" class="mobile">
<?php }else{ ?>
	<body id="article" class="mobile">
<?php } ?>

		<?php include_once($config['include_path'].'header.php');?>
		<?php include_once($config['include_path'].'header_ad.php'); ?>
		<?php 
			$style = '';
			if( isset($articleInfoObj['article_id']) && $articleInfoObj['article_id'] == 4314 || $articleInfoObj['article_id'] == 4341){
				$style = 'margin-top: 7rem !important;';
			}
		?>
		<main id="main" class="row panel sidebar-on-right shadow-on-large-up" role="main" style="<?php echo $style; ?>">
			
			<section id="puc-articles" class="sidebar-right shadow-on-large-up small-12 columns translate-fix sidebar-main-left">
				<input type="hidden" value="<?php echo $articleInfoObj['article_id']; ?>" id="article_id"/>
			
				<!-- ARTICLE CONTENT -->
				<?php 
					if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){
						include_once($config['template_path'].'multi_page_article.php');
					} else {
						include_once($config['template_path'].'single_page_article.php');
					}
				?>

				<!-- SMARTIES PROMOTION -->
			    <?php if( $promotedArticle ){?>
			      <div class="padding-bottom  show-on-large-up">
			        <!--JavaScript Tag // Tag for network 5470: Sequel Media Group // Website: Pucker Mob // Page: 1 pg Aritcle // Placement: 300 ATF (3243114) // created at: Oct 14, 2014 11:09:55 AM-->
			        <script language="javascript"><!--
			        document.write('<scr'+'ipt language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243114/0/170/ADTECH;loc=100;target=_blank;key=smarties;grp=[group];misc='+new Date().getTime()+'"></scri'+'pt>');
			        //-->
			        </script><noscript><a href="http://adserver.adtechus.com/adlink/3.0/5470.1/3243114/0/170/ADTECH;loc=300;key=smarties;grp=[group]" target="_blank"><img src="http://adserver.adtechus.com/adserv/3.0/5470.1/3243114/0/170/ADTECH;loc=300;key=smarties;grp=[group]" border="0" width="300" height="250"></a></noscript>
			        <!-- End of JavaScript Tag -->
			      </div>
			     <?php } ?>
		<hr>
		<?php include_once($config['include_path'].'similararticles.php');?>
		<div id="btf1-ad" class="ad-unit hide-for-print"></div>
	<?php include_once($config['include_path'].'fromaroundthewebmobile.php'); ?>
		
	</div>
	<?php include_once($config['include_path'].'abouttheauthor.php'); ?>

	<?php include_once($config['include_path'].'disqus.php'); ?>
</section>
</main>
<?php include_once($config['include_path'].'footer.php');?>
<?php include_once($config['include_path'].'bottomscripts.php');?>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c4498040efc634" ></script>

<script type="text/javascript">
	$(document).ready(function(){
		if(addthis) addthis.init();
	})
	</script>

</body>
</html>

<?php } else { ?>
<!DOCTYPE html>
<html class="no-js" lang="en"  xmlns:fb="http://ogp.me/ns/fb#"> 
<?php include_once($config['include_path'].'head.php');?>

<?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){ ?>
	<body id="articleslide">
<?php }else{ ?>
	<body id="article">
<?php } ?>
	
	<?php include_once($config['include_path'].'header.php');?>
	<?php include_once($config['include_path'].'header_ad.php');?>

	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right shadow-on-large-up small-12 medium-12 large-11 columns translate-fix sidebar-main-left" style="z-index:999;">
			<input type="hidden" value="<?php echo $articleInfoObj['article_id']; ?>" id="article_id"/>
			<?php 
			if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){
				include_once($config['template_path'].'multi_page_article.php');?>
			
			<?php } else {
				include_once($config['template_path'].'single_page_article.php'); ?>
				<?php if( !$promotedArticle ){ ?>
				<!-- Distro Scale AD Tag -->
					<script type="text/javascript" src="http://c.jsrdn.com/s/cs.js?p=22257"> </script>
			  	<!-- Begin comScore Tag -->
			  	<?php } ?>
			<?php } ?>

			<!--
			POPUP READY
			<a href="#" data-reveal-id="myModal" class="reveal-link">Click Me For A Modal</a>
			<div id="myModal" class="reveal-modal" data-reveal>
			  <h2>Awesome. I have it.</h2>
			  <p class="lead">Your couch.  It is mine.</p>
			  <p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
			  <a class="close-reveal-modal">&#215;</a>
			</div>-->
			<?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] == 0){?>
			<hr>
			<?php }?>
			<!-- Setting the Poll -->			
			<?php 
			if(strlen($articleInfoObj['article_poll_id']) > 0){ ?>
			<script src="http://assets-polarb-com.a.ssl.fastly.net/assets/polar-embedded.js" async="true" data-publisher="Sequel" data-poll-id="<?php echo $articleInfoObj['article_poll_id']; ?>"></script>
			
			<?php }?>

			<!-- Like us on FB --> 
			<?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] == 0){?>
			<div class="row hide-for-print like-us-fb">
				<p class="columns small-2">Join the Mob!
					<div class="columns small-9" >
						<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPuckerMob%2F1492027101033794&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=25&amp;appId=1473110846264937" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px; width: 100%;" allowTransparency="true"></iframe>	
					</div>	 
				</p>
			</div>	 
			
			<hr>
			<?php }?>
		
			<!-- Prev & Next Articles -->
			<?php include_once($config['include_path'].'prevnextarticles.php'); ?>

			<!-- LIFT AD 
			<div id="lift-ad">
				<script src="http://ib.3lift.com/ttj?inv_code=puckermob_article_sub"></script>
			</div>-->

			<!-- Media Net
			<div id="medianet-ad" class="ad-unit hide-for-print padding-right show-for-xxlarge-only"></div> -->

			<!-- ALSO IN CATEGORY -->
			<?php include_once($config['include_path'].'similararticles.php');?>
			<hr>
			
			<?php if( !$promotedArticle ){ ?>
			<!-- ADBLADE -->
			<section id="content-ad-around-the-web" class="sidebar-right small-12 columns hide-for-print no-padding">
				<ins class="adbladeads" data-cid="6669-1650351935" data-host="web.adblade.com" data-tag-type="2" style="display:none"></ins>
				<script async src="http://web.adblade.com/js/ads/async/show.js" type="text/javascript"></script>
			</section>
		
			<!-- AROUND THE WEB -->
			<?php //include_once($config['include_path'].'aroundtheweb.php'); ?>
			<hr>

			<!-- CONTENT AD -->
			<div id="contentad24777"></div>
			<script type="text/javascript">
			    (function() {
			        var params =
			        {
			            id: "a8eb16d0-6594-4e2f-a80b-7ff948aee7a2",
			            d:  "cHVja2VybW9iLmNvbQ==",
			            wid: "24777",
			            cb: (new Date()).getTime()
			        };

			        var qs="";
			        for(var key in params){qs+=key+"="+params[key]+"&"}
			        qs=qs.substring(0,qs.length-1);
			        var s = document.createElement("script");
			        s.type= 'text/javascript';
			        s.src = "http://api.content.ad/Scripts/widget.aspx?" + qs;
			        s.async = true;
			        document.getElementById("contentad24777").appendChild(s);
			    })();
			</script>
			

			
			<hr>
			<?php }?>
			<!-- COMMENTS BOX -->
			<?php include_once($config['include_path'].'disqus.php'); ?>
			<hr>
			<!-- ABOUT THE AUTHOR -->
			<?php include_once($config['include_path'].'abouttheauthor.php'); ?>

		</section>
		<?php include_once($config['include_path'].'rightsidebar.php');?>
	</main>
	
	
	<?php include_once($config['include_path'].'footer.php');?>
		

    <?php include_once($config['include_path'].'bottomscripts.php');?>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c4498040efc634" ></script>

    <script type="text/javascript">
	$(document).ready(function(){
		addthis.init();
	})
	</script>
     <?php if( $promotedArticle ){ ?>
    		<!-- SMARTIES -->
			<script language="javascript">document.write('<scr'+'ipt language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3366273/0/16/ADTECH;loc=100;target=_blank;key=smarties;grp=[group];misc='+new Date().getTime()+'"></scri'+'pt>');
			</script>
			<noscript><a href="http://adserver.adtechus.com/adlink/3.0/5470.1/3366273/0/16/ADTECH;loc=300;key=smarties;grp=[group]" target="_blank"><img src="http://adserver.adtechus.com/adserv/3.0/5470.1/3366273/0/16/ADTECH;loc=300;key=smarties;grp=[group]" border="0" width="1" height="1"></a></noscript>
    <?php }?>

</body>
</html>
<?php } ?>