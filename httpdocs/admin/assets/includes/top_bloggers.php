<?php 
	$bloggers_list  = $adminController->user->getTop5BloggersByPageviews();

if($bloggers_list){
?>
<div class="small-12 columns show-for-large-up no-padding">
	<div class="small-12 columns radius hottopics">
		<h3 class="margin-top bold">TOP 5 BLOGGERS</h3>
		<div class="">
			<ol>
				<?php foreach($bloggers_list as $top_blogger){ ?>
				<li><label><?php echo $top_blogger['contributor_name']; ?><span class="right"><?php echo $top_blogger['total_us_pageviews'];?></span></label></li>
				<?php } ?>
			</ol>
		</div>
	</div>
</div>
<?php } ?>