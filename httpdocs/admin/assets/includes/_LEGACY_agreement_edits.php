<?php
	
	$yes = 'checked="checked"';
	$no = '';

	if(isset($edit_page)){
		if(isset($edits) && $edits == 1){
			$yes = 'checked="checked"';
		}else{
			$yes = '';
			$no = 'checked="checked"';
		}
	}
?>
<div id="agreement-edits" class="row show-for-medium-up margin-bottom">

	<h2>EDITING: INCREASE YOUR CHANCES FOR PROMOTING THIS  ARTICLE</h2>
	
	<p>By clicking “Yes,” you agree that PuckerMob editors may edit and/or alter this article without prior consultation. Edits may include (but are not limited to), grammar and spelling, article title and image selection. We will NOT add profanity without reaching out to you beforehand to discuss. </p>
	
	<p><span class="bold">Allowing us to edit this article will dramatically incease the chances that we will promote it on one or more of our Fan Pages.</span> Please note that there is no guarantee that your article will be edited or promoted. 
	</p>
	
	<p>Please note too, that by allowing us to edit your article, you will be unable to make your own edits to this article without first requesting permission.</p>

	<div class="small-12 columns no-padding padding-bottom">
		<div class="small-1 columns"><input type="radio" name="article_agree_edits-s" value="1"  <?php echo $yes; ?> /></div>
		<label class="small-11 columns" style="font-size:20px !important; color: #5A9859">Yes, PuckerMob may edit this article</label>
	</div>
	<div class="small-12 columns no-padding">
		<div class="small-1 columns"><input type="radio" name="article_agree_edits-s" value="0"   <?php echo $no; ?> /></div>
		<label class="small-11 columns">No, I’d rather this article not be edited, even though that means it most likely won’t be promoted</label>
	</div>

	<div class=" padding-top clear">
		<div class="small-12 large-12 columns no-padding">
			<button style="margin-bottom: 0;" type="button" id="publish-article" name="publish-article" class="radius small-12 publish-article">PUBLISH MY ARTICLE</button>
		</div>
	</div>
</div>