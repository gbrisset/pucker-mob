<div class="small-12 columns no-padding advertising-override margin-top">
	<div class="advertising-box small-12 columns  no-padding">
		<header class="inner-header">Ads Override (in-Stream)</header>
	</div>
	<div class="columns advertising-box small-6 no-padding-right">
		<h3 class="uppercase h3-ads">Mobile</h3>
		<?php 
		foreach($mobile_ad as $ad_info){ 
			$name = $ad_info['label'];
			$id = $ad_info['id'];
			$default = $ad_info['default_position'];
			$relation_num = $ad_info['relation_num']; 
			$target = 'mobile_'.$relation_num;
		?>
		<div class="advertising-providers small-12" id="ad-info-<?php echo $relation_num;?>">
			<label class="small-4 columns uppercase"><?php echo $name; ?></label>
			<select id="mobile_<?php echo $relation_num;?>" name="mobile_<?php echo $relation_num;?>" class="related_articles small-8">
			<?php 
			if( $article_ads[$target] == -1) 
				echo '<option value="-1" selected >OFF</option>';
	   		else	
	   			echo '<option value="-1">OFF</option>';
			
			for($i = 1; $i<=30; $i++){
				if( $article_ads && $article_ads[$target] == $i ) 
					echo '<option value="'.$i.'" selected >After Item '.$i.'</option>';
				else 
					echo '<option value="'.$i.'" >After Item '.$i.'</option>';
			}
			?>
			</select>
		</div>
		<?php } ?>
	</div>	
	<div class="columns advertising-box small-6  no-padding-right">
		<h3 class="uppercase h3-ads">Desktop</h3>
		<?php
		foreach($desktop_ad as $ad_info){ 
			$name = $ad_info['label'];
			$id = $ad_info['id'];
			$default = $ad_info['default_position'];
			$relation_num = $ad_info['relation_num']; 
			$target = 'desktop_'.$relation_num;
		?>
		<div class="advertising-providers small-12" id="ad-info-<?php echo $relation_num;?>">
			<label class="small-4 columns"><?php echo $name; ?></label>
			<select id="desktop_<?php echo $relation_num;?>" name="desktop_<?php echo $relation_num;?>" class="related_articles small-8">
				<?php 
				if( $article_ads[$target] == -1) 
					echo '<option value="-1" selected >OFF</option>';
		   		else	
		   			echo '<option value="-1">OFF</option>';
				
				for($i = 1; $i<=30; $i++){
					if( $article_ads && $article_ads[$target] == $i ) 
						echo '<option value="'.$i.'" selected >After Item '.$i.'</option>';
					else 
						echo '<option value="'.$i.'" >After Item '.$i.'</option>';
				} ?>
			</select>
		</div>
		<?php  }?>
	</div>

</div>