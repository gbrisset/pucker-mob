<?php if(isset($facebook_pages) && $facebook_pages){ ?>

<div class="small-12 columns radius hottopics">
		<h3 class="margin-top bold">PROMOTED PAGE</h3>

		<div id="hotfacebookpages">
			<div class="current-data">
				<?php if($facebook_pages){
					foreach($facebook_pages as $page){ 
						echo  '<label><a class="uppercase" href="'.$page->facebook_page_url.'" target="_blank">'.$page->facebook_page_name.'</a></label>';
					}
				}else{
					echo '<label>No Topics Set...</label>';
				}?>
			</div>
		</div>
	</div>



<?php }?>