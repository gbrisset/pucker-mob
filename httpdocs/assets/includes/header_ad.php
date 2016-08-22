<?php if(!$detect->isMobile()){ ?>
	<div id="header-ad" class="ad-unit hide-for-print" style="<?php if( $has_sponsored && $isHomepage ) echo 'margin-top:0.5rem;'; ?> ">
		<!-- ARTICLES -->
		<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>

				
	      		<?php if(isset($articleInfoObj['article_id']) &&   $articleInfoObj['article_id'] != 17425  
	      		&& $articleInfoObj['article_id']  != 16562  &&  $articleInfoObj['article_id'] != 14479 
	      		&& $articleInfoObj['article_id'] != 14576 && $articleInfoObj['article_id'] != 15109 
	      		&& $articleInfoObj['article_id'] != 15271 &&  $articleInfoObj['article_id']  != 17286
	      		&& $articleInfoObj['article_id'] != 14613 && $articleInfoObj['article_id'] != 14873 
			    && $articleInfoObj['article_id'] != 12966 && $articleInfoObj['article_id'] != 15284 
			    && $articleInfoObj['article_id'] != 15488 ){  ?>
	      			
	      			<?php if( isset($_COOKIE['city']) && $_COOKIE['city'] == 'Virginia'){ ?>
	      					<!-- /73970039/UT_970x250 -->
								<div id='div-gpt-ad-1466610548103-0' style='height:250px; width:970px;'>
								<script type='text/javascript'>
								googletag.cmd.push(function() { googletag.display('div-gpt-ad-1466610548103-0'); });
								</script>
							</div>
						<?php }elseif( isset($_COOKIE['city']) &&  $_COOKIE['city'] == 'Chicago'){ ?>
								<!-- /73970039/UT_Bill_Chi -->
								<div id='div-gpt-ad-1468348519601-0' style='height:250px; width:970px;'>
									<script type='text/javascript'>
									googletag.cmd.push(function() { googletag.display('div-gpt-ad-1468348519601-0'); });
									</script>
								</div>
						<?php }elseif( isset($_COOKIE['city']) &&  $_COOKIE['city'] == 'Twin Lakes'){ ?>
								<!-- /73970039/UT_Bill_TWI -->
								<div id='div-gpt-ad-1468348519601-1' style='height:250px; width:970px;'>
								<script type='text/javascript'>
								googletag.cmd.push(function() { googletag.display('div-gpt-ad-1468348519601-1'); });
								</script>
								</div>
	      				<?php }else{?>
							<!-- /73970039/UT_BB 
							<div id='div-gpt-ad-1467068250785-0' style='height:250px; width:970px;'>
								<script type='text/javascript'>
								googletag.cmd.push(function() { googletag.display('div-gpt-ad-1467068250785-0'); });
								</script>
							</div>-->
							<!-- /73970039/UT_BB -->
							<div id='div-gpt-ad-1470066258166-1' style='height:250px; width:970px;'>
							<script>
								googletag.cmd.push(function() { googletag.display('div-gpt-ad-1470066258166-1'); });
							</script>
							</div>
						<?php } ?>
				<?php }else{?>
					<!-- LELO -->
					<div class="lelo">
						<a href="https://www.lelo.com/hex-condoms-original?utm_source=publisher_puckermob.com&utm_medium=banner&utm_content=&utm_campaign=hex_display" target="_blank">
							<img src="http://www.puckermob.com/assets/img/campaing/lelo_desk.png" />
						</a>
					</div>
				<?php } ?>
		<!-- ROS -->	
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
