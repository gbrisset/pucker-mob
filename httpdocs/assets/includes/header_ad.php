<?php if($detect->isMobile()){

	if(isset($promotedArticle) && $promotedArticle){ ?>
    	<!-- SMARTIES -->
    	<div id="smarties" class="" style="margin-bottom: -4rem;margin-top: 3rem;">

		<!--JavaScript Tag // Tag for network 5470: Sequel Media Group // Website: Pucker Mob Mobile // Page: 1 pg Article // Placement: 320x120 Header Banner (3366798) // created at: Oct 14, 2014 4:21:59 PM-->
		<script language="javascript">document.write('<scr'+'ipt language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3366798/0/3216/ADTECH;loc=100;target=_blank;key=smarties;grp=[group];misc='+new Date().getTime()+'"></scri'+'pt>');</script>
		<noscript><a href="http://adserver.adtechus.com/adlink/3.0/5470.1/3366798/0/3216/ADTECH;loc=300;key=smarties;grp=[group]" target="_blank"><img src="http://adserver.adtechus.com/adserv/3.0/5470.1/3366798/0/3216/ADTECH;loc=300;key=smarties;grp=[group]" border="0" width="320" height="120"></a></noscript>
		<!-- End of JavaScript Tag -->
		</div>
		<style>
			#main{border: 4px solid rgb(82, 210, 115); border-top: 0; padding-top: 1rem;}
			#smarties img{ width:100% !important;}
		</style>
    <?php }else{?>
    <!-- Totally Her -->
    <div style=" top: 3rem; position: relative; text-align: center;">
		<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
		    <!-- puckermob.com/ros -->
			<script type="text/javascript">
			  var ord = window.ord || Math.floor(Math.random() * 1e16);
			  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/ros;sect=ros;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';dcopt=ist;type=pop;type=int;ord=' + ord + '?"><\/script>');
			</script>
			<noscript>
			<a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/ros;sect=ros;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
			<img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/ros;sect=ros;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" />
			</a>
			</noscript>
		<?php } ?>
		</div>
    <?php } 
}else { ?>
	<div id="header-ad" class="ad-unit hide-for-print" style=" <?php if( $has_sponsored && $isHomepage ) echo 'margin-top:0.5rem;'; ?> ">
		<!-- 728x90, 970x90 combo: 970x90 728x90 -->
		<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
			<div id="ros_1193"></div> 
		<?php }else{?>
			<div id="home_1181"></div> 
		<?php }?> 
	</div>
<?php }  ?>

