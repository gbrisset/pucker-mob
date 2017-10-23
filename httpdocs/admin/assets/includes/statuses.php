<div class="small-12 columns show-for-large-up no-padding">
	<div class="small-12 columns radius filter-by-status">
		<h3 class="margin-top bold">ARTICLE STATUS</h3>
		<div class="">
			<label>
				<i class="fa fa-caret-right"></i>
				<a href="<?php  echo $userType_URL.'&artype='.$artType; ?>" class="uppercase <?php echo $allSort;?>">All</a>
			</label>
			<label>
				<i class="fa fa-caret-right"></i>
				<a href="<?php echo $userType_URL.'&sort=1&artype='.$artType; ?>" class="uppercase <?php echo $liveCurrent;?>">Live</a>
			</label>
			<label>
				<i class="fa fa-caret-right"></i>
				<a href="<?php echo $userType_URL.'&sort=2&artype='.$artType; ?>" class="uppercase <?php echo $liveCurrent;?>">Review</a>
			</label>
			<label>
				<i class="fa fa-caret-right"></i>
				<a href="<?php echo $userType_URL.'&sort=3&artype='.$artType; ?>" class="uppercase <?php echo $draftCurrent;?>">Draft</a>
			</label>
			<?php if( $starter_blogger ){?>
			<label>
				<i class="fa fa-caret-right"></i>
				<a href="<?php echo $userType_URL.'&sort=2&artype='.$artType; ?>" class="uppercase <?php echo $pendingCurrent;?>">Approval Required</a>
			</label>
			<?php } ?>
		</div>
	</div>
</div>