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

	<h2>CHOOSE A TRACK FOR PUBLISHING:</h2>
	<hr/>
	

			<div class="small-12 columns no-padding padding-bottom">
				<input type="radio" id="article_agree_edits_yes" name="article_agree_edits-s" value="1"  <?php echo $yes; ?> />
				<label for="article_agree_edits_yes"><span  style="color: green; font-size: 28px; ">REVENUE TRACK</span></label>
			</div>
			<p class="bold" style="color: green;">WHEN YOU WANT TO PUBLISH AND MAKE MONEY FROM IT</p>


			<ul style="margin-left: 3rem;">
				<li>Higher chance of being promoted on our Facebook Fan pages.</li>
				<li>Intensive editing by our team to maximize views and earnings.</li>
				<li>Your article will be locked and you will not be allowed to make future edits of the article on your own.</li>
			</ul>

			<div class="small-12 columns no-padding">
				<input type="radio" id="article_agree_edits_no" name="article_agree_edits-s" value="0"   <?php echo $no; ?> />
				<label for="article_agree_edits_no"  ><span  style="color: green; font-size: 28px; ">BLOGGER TRACK</span></label>
			</div>

			<p class="bold" style="color: green;">WHEN YOU JUST WANT TO PUBLISH SOMETHING PERSONAL</p>
				

			<ul style="margin-left: 3rem;">
				<li>Lower chance to be featured on our Facebook Fan pages.</li>
				<li>For articles that are highly personal, and more like diary entries.</li>
				<li>Your articles will be unlocked, and no editing will be done by our editing team.</li>
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


