<!-- WARNINGS BOX -->
<?php 
	$warnings = $ManageDashboard->getWarningsMessages(); 
	
	if(isset($warnings) && $warnings[0] && $warnings[0]['notification_live']){ ?>
	<div id="warning-box" class="warning-box  mobile-12 small-12" style="">
		<div id="warning-icon" class="">
			<i class="fa fa-3x fa-exclamation-triangle"></i>
		</div>
		<div id="warning-txt" class="p-cont">
			<p>
				<?php echo $warnings[0]['notification_msg']; ?>
			</p>
		</div>
	</div>
<?php }?>
