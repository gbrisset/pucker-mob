<?php if($admin_user ){?>
<div class="small-12 columns show-for-large-up no-padding margin-top">
	<div class="small-12 columns radius filter-by-status">
		<h3 class="margin-top bold">FILTER BY</h3>
		<div class="">
			<label>
				<i class="fa fa-caret-right"></i>
					<a href="<?php echo $userType_URL.'&sort='.$order.'&artype=' ?>" class="uppercase <?php echo $allCurrent; ?>">ALL</a>
			</label>
			<label>
				<i class="fa fa-caret-right"></i>
				<a href="<?php echo $userType_URL.'&sort='.$order.'&artype=writers'; ?>" class="uppercase <?php echo $writersCurrent;?>">WRITERS</a>
			</label>
			<label>
				<i class="fa fa-caret-right"></i>
				<a href="<?php echo $userType_URL.'&sort='.$order.'&artype=bloggers'; ?>" class="uppercase <?php echo $bloggersCurrent?>">BLOGGERS</a>
			</label>
		</div>
	</div>
</div>
<?php } ?>