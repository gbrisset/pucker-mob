<?php if(!$detect->isMobile()){ ?>
    
	<div id="header-ad" class="ad-unit hide-for-print" style=" background:#fff;  width: 100%; <?php if( $has_sponsored && $isHomepage ) echo 'margin-top:0.5rem;'; ?> ">
	<input type="hidden" value="<?php echo $_COOKIE['city']; ?>" />
	<input id="IP" type="hidden" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
		<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>

				
	      		<?php if(isset($articleInfoObj['article_id']) &&   $articleInfoObj['article_id'] != 17425  && $articleInfoObj['article_id']  != 16562  &&  $articleInfoObj['article_id'] != 14479 && $articleInfoObj['article_id'] != 14576 && $articleInfoObj['article_id'] != 15109 && $articleInfoObj['article_id'] != 15271 &&  $articleInfoObj['article_id']  != 17286){  ?>
	      			
	      			<?php if( $_COOKIE['city'] == 'Virginia'){ ?>
	      					<!-- /73970039/UT_970x250 -->
								<div id='div-gpt-ad-1466610548103-0' style='height:250px; width:970px;'>
								<script type='text/javascript'>
								googletag.cmd.push(function() { googletag.display('div-gpt-ad-1466610548103-0'); });
								</script>
							</div>
						<?php }elseif( $_COOKIE['city'] == 'Chicago'){ ?>
								<!-- /73970039/UT_Bill_Chi -->
								<div id='div-gpt-ad-1468348519601-0' style='height:250px; width:970px;'>
									<script type='text/javascript'>
									googletag.cmd.push(function() { googletag.display('div-gpt-ad-1468348519601-0'); });
									</script>
								</div>
						<?php }elseif( $_COOKIE['city'] == 'Twin Lakes'){ ?>
								<!-- /73970039/UT_Bill_TWI -->
								<div id='div-gpt-ad-1468348519601-1' style='height:250px; width:970px;'>
								<script type='text/javascript'>
								googletag.cmd.push(function() { googletag.display('div-gpt-ad-1468348519601-1'); });
								</script>
								</div>
	      			<?php }else{?>
			      		<?php if($articleInfoObj['article_id'] != 14613 && $articleInfoObj['article_id'] != 14873 && $articleInfoObj['article_id'] != 12966 && $articleInfoObj['article_id'] != 15284 ){?>
								<?php if($articleInfoObj['article_id'] != 15284  && $articleInfoObj['article_id'] != 15488){ ?>
								<!-- /73970039/UT_BB -->
								<div id='div-gpt-ad-1467068250785-0' style='height:250px; width:970px;'>
									<script type='text/javascript'>
									googletag.cmd.push(function() { googletag.display('div-gpt-ad-1467068250785-0'); });
									</script>
								</div>
							<?php }else{ ?>
									<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
									<script type="text/javascript" language="javascript">
									//<![CDATA[
									aax_getad_mpb({
									  "slot_uuid":"4dccafa1-4eba-4f93-a40f-2c0f5348f76d"
									});
									//]]>
									</script>
							<?php } ?>
					<?php } ?>
					<?php } ?>
				<?php }else{?>
					<!-- LELO -->
					<div class="lelo">
						<a href="https://www.lelo.com/hex-condoms-original?utm_source=publisher_puckermob.com&utm_medium=banner&utm_content=&utm_campaign=hex_display" target="_blank">
							<img src="http://www.puckermob.com/assets/img/campaing/lelo_desk.png" />
						</a>
					</div>
				<?php } ?>
			
		<?php }else{?>
			<!-- /73970039/UT_BB -->
			<div id='div-gpt-ad-1467068250785-0' style='height:250px; width:970px;'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1467068250785-0'); });
				</script>
			</div>

		<?php }?> 
	</div>
<?php }?>
