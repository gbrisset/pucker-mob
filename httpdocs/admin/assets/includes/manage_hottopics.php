<?php 
	
	$hotTopicsObj = new HotTopics();
	$hot_topics = $hotTopicsObj->all();
	
	if(isset($hot_topics[0])){
		$hot_topics = $hot_topics[0];
	}
	
	$topics_msg = $hot_topics->hot_topics_message;
	$topics_list = explode(PHP_EOL, $hot_topics->hot_topics_message);

?>

<div class="small-12 columns manage-alerts no-margin-bottom margin-top radius no-padding">
	<div class="row">
		<h3 class="small-12 columns margin-top uppercase">Hot Topics:</h3>
	</div>
	<div class="row hotopics-div">
	 	<form class="clear" name="form-hottopics" id="form-hottopics" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	 		<div class="small-12 large-12 columns">
	 			<textarea placeholder="Enter Hot Topics here, separete by enter..."  name="hottopics-input" id="hottopics-input"  class="radius" ><?php echo $topics_msg; ?></textarea>
	 		</div>
	 		<div class="columns small-12 large-10">
	 			<label class="success" id="show-msg-hotopics"></label>
	 		</div>
	 		<div class="small-12 large-2 columns">
	 			<button type="button" id="save-hottopics" name="save-hottopics" class="radius columns small-12" >SAVE</button>
	 		</div>
	 	
	 	</form>
	 
	</div>
</div>