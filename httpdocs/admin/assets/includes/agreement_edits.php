<?php
	
	$yes = 'checked="checked"';
	$no = '';

	if(isset($edit_page)){
		if(isset($edits) && $edits == 1){
			$yes = 'checked="checked"';
			$no = '';
		}else{
			$yes = '';
			$no = 'checked="checked"';
		}
	}
?>
<div id="agreement-edits" class="row show-for-medium-up margin-bottom">

	<h2>PLEASE NOTE</h2>
	<hr/>
	
				<input type="hidden" id="article_agree_edits_yes" name="article_agree_edits-s" value="1"   />
	
			<ul style="margin-left: 3rem;">
				<li>Your article will be locked and you will not be allowed to make future edits of the article on your own.</li>
			</ul>

	
			<hr/>
			<p class="bold" >
				Once you submit for final review, you will not be able to make further changes to your article. Your article will appear live on our site after review by our editors
			</p>


	<div class=" padding-top clear">
		<div class="small-12 large-12 columns no-padding">
			<button style="margin-bottom: 0;" type="button" id="publish-article" name="publish-article" class="radius small-12 publish-article">SUBMIT FOR FINAL REVIEW</button>
		</div>
	</div>
</div>


