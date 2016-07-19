	<?php 
		$hotTopicsObj = new HotTopics();
		$hot_topics = $hotTopicsObj->all();

		if(isset($hot_topics[0])){
			$hot_topics = $hot_topics[0];
		}
		
		$topics_msg = $hot_topics->hot_topics_message;
		$topics_list = explode(PHP_EOL, $hot_topics->hot_topics_message);

	?>
	<div class="small-12 columns radius hottopics">
		<h3 class="margin-top bold">HOT TOPICS 
			<?php if($admin_user){ ?><a href="<?php echo $config['this_admin_url'].'alerts/'; ?>" id="edit-list">Edit</a><?php }?>
		</h3>


		<div id="hottopics" data-info="1" data-category="hottopics">
			<div class="current-data">

				<?php if($topics_list){
					foreach($topics_list as $topics){ 
						echo  '<label>'.$topics.'</label>';
					}
				}else{
					echo '<label>No Topics Set...</label>';
				}?>
			</div>
		</div>
	</div>
