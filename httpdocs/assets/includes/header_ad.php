<?php if(!$detect->isMobile()){ ?>
    
	<div id="header-ad" class="ad-unit hide-for-print" style="  background:#fff;  width: 100%; <?php if( $has_sponsored && $isHomepage ) echo 'margin-top:0.5rem;'; ?> ">
		<style> #ros_1193, #home_1181{ display:inline-block !important; }</style>

		<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>

				 <!-- LELO -->
	      		<?php if(isset($articleInfoObj['article_id']) && $articleInfoObj['article_id'] != 14479 && $articleInfoObj['article_id'] != 14576 && $articleInfoObj['article_id'] != 15109 && $articleInfoObj['article_id'] != 15271 ){?>
	      			
			      		<?php if($articleInfoObj['article_id'] != 14613 && $articleInfoObj['article_id'] != 14873 && $articleInfoObj['article_id'] != 12966 && $articleInfoObj['article_id'] != 15284 ){?>
								<!--<div id="ros_1193" style="display: inline-block !important;"></div> -->
								<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
			<script type="text/javascript" language="javascript">
			//<![CDATA[
			aax_getad_mpb({
			  "slot_uuid":"4dccafa1-4eba-4f93-a40f-2c0f5348f76d"
			});
			//]]>
			</script>
						<?php }else{?>
							<?php if($articleInfoObj['article_id'] != 15284  && $articleInfoObj['article_id'] != 15488){ ?>
							<!-- /73970039/UT_BB -->
							<div id='div-gpt-ad-1461622964696-0' style='height:250px; width:970px;'>
								<script type='text/javascript'>
								googletag.cmd.push(function() { googletag.display('div-gpt-ad-1461622964696-0'); });
								</script>
							</div>
							<?php } ?>
						<?php } ?>
				<?php }else{?>
					<div class="">
						<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank">
							<img src="http://www.puckermob.com/assets/img/campaing/lelo_desk.png" />
						</a>
					</div>
				<?php } ?>
			
		<?php }else{?>
			<!--<div id="home_1181" style="display: inline-block;"></div> -->

			<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
			<script type="text/javascript" language="javascript">
			//<![CDATA[
			aax_getad_mpb({
			  "slot_uuid":"4dccafa1-4eba-4f93-a40f-2c0f5348f76d"
			});
			//]]>
			</script>

		<?php }?> 
	</div>
<?php }?>
