<?php if( !$detect->isMobile()){?>
<div class="row left" id="related-articles-section">
	<header class="inner-header">Related Articles</header>
	<div class="related_articles_box small-12 columns no-padding">
		<div class="small-6 columns no-padding-left">
			<select name="related_article_1" id="related_article_1"  class="related_articles small-12">
				<option value="-1">Choose an article</option>
				<?php foreach($allarticles as $related_articles){
						$option = '<option value="'.$related_articles['article_id'].'" ';
						if( $related_to_this_article['related_article_id_1'] && $related_articles['article_id'] == $related_to_this_article['related_article_id_1'] ) $option .= ' selected="selected"';
						$option .= '>'.$related_articles['article_title'].'</option>';
						echo $option;
					}
				?>
			</select>
		</div>
		<div class="small-5 columns no-padding">
			<input type="textbox" id="related_article_textbox_1" class="related_article_textbox small-12" name="related_article_textbox_1" />
		</div>
		<div class="small-1 columns">
			<i class="fa fa-search"></i>
		</div>
	</div>
	
	<div class="related_articles_box small-12 columns no-padding">
		<div class="small-6 columns no-padding-left">
			<select name="related_article_2" id="related_article_2" class="related_articles small-12">
				<option value="-1">Choose an article</option>
				<?php foreach($allarticles as $related_articles){
						$option = '<option value="'.$related_articles['article_id'].'"';
						if( $related_to_this_article['related_article_id_2']  && $related_articles['article_id'] == $related_to_this_article['related_article_id_2'] ) $option .= ' selected="selected"';
						$option .= '>'.$related_articles['article_title'].'</option>';
						echo $option;
					}
				?>
			</select>
		</div>
		<div class="small-5 columns no-padding">
			<input type="textbox" id="related_article_textbox_2" class="related_article_textbox small-12" name="related_article_textbox_2" />
		</div>
		<div class="small-1 columns">
			<i class="fa fa-search"></i>
		</div>
	</div>

	<div class="related_articles_box small-12 columns no-padding">
		<div class="small-6 columns no-padding-left">
			<select name="related_article_3" id="related_article_3" class="related_articles small-12" >
				<option value="-1">Choose an article</option>
				<?php foreach($allarticles as $related_articles){
						$option = '<option value="'.$related_articles['article_id'].'" ';
						if( $related_to_this_article['related_article_id_3']  && $related_articles['article_id'] == $related_to_this_article['related_article_id_3'] ) $option .= ' selected="selected"';
						$option .= '>'.$related_articles['article_title'].'</option>';
						echo $option;
					}
				?>
			</select>
		</div>
		<div class="small-5 columns no-padding">
			<input type="textbox" id="related_article_textbox_3" class="related_article_textbox small-12" name="related_article_textbox_3" />
		</div>
		<div class="small-1 columns">
			<i class="fa fa-search"></i>
		</div>
	</div>
</div>
<?php }else{?>
<div class="row left margin-bottom" id="related-articles-section">
	<header class="inner-header">Related Articles</header>
	<div class="related_articles_box small-12 columns no-padding">
		<div class="small-12 columns no-padding-left">
			<select name="related_article_1" id="related_article_1"  class="related_articles small-12">
				<option value="-1">Choose an article</option>
				<?php foreach($allarticles as $related_articles){
						$option = '<option value="'.$related_articles['article_id'].'" ';
						if( $related_to_this_article['related_article_id_1'] && $related_articles['article_id'] == $related_to_this_article['related_article_id_1'] ) $option .= ' selected="selected"';
						$option .= '>'.$related_articles['article_title'].'</option>';
						echo $option;
					}
				?>
			</select>
		</div>
	</div>
	
	<div class="related_articles_box small-12 columns no-padding">
		<div class="small-12 columns no-padding-left">
			<select name="related_article_2" id="related_article_2" class="related_articles small-12">
				<option value="-1">Choose an article</option>
				<?php foreach($allarticles as $related_articles){
						$option = '<option value="'.$related_articles['article_id'].'"';
						if( $related_to_this_article['related_article_id_2']  && $related_articles['article_id'] == $related_to_this_article['related_article_id_2'] ) $option .= ' selected="selected"';
						$option .= '>'.$related_articles['article_title'].'</option>';
						echo $option;
					}
				?>
			</select>
		</div>
		
	</div>

	<div class="related_articles_box small-12 columns no-padding">
		<div class="small-12 columns no-padding-left">
			<select name="related_article_3" id="related_article_3" class="related_articles small-12" >
				<option value="-1">Choose an article</option>
				<?php foreach($allarticles as $related_articles){
						$option = '<option value="'.$related_articles['article_id'].'" ';
						if( $related_to_this_article['related_article_id_3']  && $related_articles['article_id'] == $related_to_this_article['related_article_id_3'] ) $option .= ' selected="selected"';
						$option .= '>'.$related_articles['article_title'].'</option>';
						echo $option;
					}
				?>
			</select>
		</div>
		
	</div>
</div>
<?php }?>