<div class="small-12 columns show-for-large-up no-padding">
	<div class="small-12 columns radius filter-by-status">
		<h3 class="margin-top bold">STATUS</h3>
		<div class="">
			<label>
				<i class="fa fa-caret-right"></i>
				<a href="<?php  echo $userType_URL.'&artype='.$artType; ?>" class="uppercase <?php echo $allSort;?>">All Articles</a>
			</label>
			<label>
				<i class="fa fa-caret-right"></i>
				<a href="<?php echo $userType_URL.'&sort=1&artype='.$artType; ?>" class="uppercase <?php echo $liveCurrent;?>">Live Articles</a>
			</label>
			<label>
				<i class="fa fa-caret-right"></i>
				<a href="<?php echo $userType_URL.'&sort=3&artype='.$artType; ?>" class="uppercase <?php echo $draftCurrent;?>">Draft Articles</a>
			</label>
		</div>
	</div>
</div>