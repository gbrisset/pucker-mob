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
				<li id="contributor_<?php echo $top_blogger['contributor_id']; ?>">
					<label>
						<a href="http://www.puckermob.com/contributors/<?php echo $top_blogger['contributor_seo_name']; ?>"><?php echo $top_blogger['contributor_name']; ?></a>
						<span class="right"><?php echo number_format($top_blogger['total_us_pageviews']);?></span>
					</label>
				</li>
				<?php } ?>
			</ol>
		</div>
	</div>
</div>
<?php } ?>