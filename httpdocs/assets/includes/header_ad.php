<?php if($detect->isMobile()){

	//if(isset($promotedArticle) && $promotedArticle){ ?>
    
    <?php //}else{?>
    <!-- Totally Her -->
    <div style=" top: 3rem; position: relative; text-align: center;">

	</div>
    <?php //} 
}else { ?>
	<div id="header-ad" class="ad-unit hide-for-print" style="  background:#fff;  width: 100%; <?php if( $has_sponsored && $isHomepage ) echo 'margin-top:0.5rem;'; ?> ">
		<!--<div style="max-width: 970px;  ">
			<IFRAME SRC="http://ib.adnxs.com/tt?id=6447475&cb=[CACHEBUSTER]" FRAMEBORDER="0" SCROLLING="no" MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" LEFTMARGIN="0" ALLOWTRANSPARENCY="true" WIDTH="970" HEIGHT="250"></IFRAME>		
		</div>-->
		<!-- 728x90, 970x90 combo: 970x90 728x90 -->
		<style> #ros_1193, #home_1181{ display:inline-block !important; }</style>
		<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
			<div id="ros_1193" style="display: inline-block !important;"></div> 
		<?php }else{?>
			<div id="home_1181" style="display: inline-block;"></div> 
		<?php }?> 
	</div>
<?php }  ?>

