<?php if($detect->isMobile()){ ?>
    
    	 <!--<div id="header-ad" class="ad-unit hide-for-print" style="  background:#fff;  width: 100%; <?php if( $has_sponsored && $isHomepage ) echo 'margin-top:0.5rem;'; ?> ">

   <div style=" top: 3rem; position: relative; text-align: center;">

	</div>-->
    <?php }else { ?>
	<div id="header-ad" class="ad-unit hide-for-print" style="  background:#fff;  width: 100%; <?php if( $has_sponsored && $isHomepage ) echo 'margin-top:0.5rem;'; ?> ">
		
		<!-- 728x90, 970x90 combo: 970x90 728x90 -->
		<style> #ros_1193, #home_1181{ display:inline-block !important; }</style>
		<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
			 <!-- LELO -->
      		<?php if(isset($articleInfoObj['article_id']) && $articleInfoObj['article_id'] != 14479 && $articleInfoObj['article_id'] != 14576 ){?>

			<div id="ros_1193" style="display: inline-block !important;"></div> 
			<?php } ?>
		<?php }else{?>
			<div id="home_1181" style="display: inline-block;"></div> 
		<?php }?> 

		<!--<div id="ad-pushdown-3149"></div><script src="http://4cad707bbe7099c8f3c8-1d22a0d4135badeea192d868b304eb1e.r26.cf5.rackcdn.com/ad_units/3149/unit.js?ord=%%CACHEBUSTER%%" async="true"></script>-->

	</div>
<?php }  ?>

