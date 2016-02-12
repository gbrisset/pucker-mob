<?php if($detect->isMobile()){

	//if(isset($promotedArticle) && $promotedArticle){ ?>
    
    <?php //}else{?>
    <!-- Totally Her -->
    <div style=" top: 3rem; position: relative; text-align: center;">
		<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
		
		<?php } ?>
		</div>
    <?php //} 
}else { ?>
	<div id="header-ad" class="ad-unit hide-for-print" style=" max-width: 970px;     width: 100%; <?php if( $has_sponsored && $isHomepage ) echo 'margin-top:0.5rem;'; ?> ">
		<!-- 728x90, 970x90 combo: 970x90 728x90 -->
		<style> #ros_1193, #home_1181{ display:inline-block !important; }</style>
		<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
			<div id="ros_1193" style="display: inline-block !important;"></div> 
		<?php }else{?>
			<div id="home_1181" style="display: inline-block;"></div> 
		<?php }?> 
	</div>
<?php }  ?>

