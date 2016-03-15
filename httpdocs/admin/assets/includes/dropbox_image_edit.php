<div class="small-12 xxlarge-8 left padding margin-bottom no-padding dropbox-image-edit" id="image-drop" >
	<form  class="dropzone" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
		<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />
				

		<div class="dz-message small-12" data-dz-message>
			<div class=" small-8 large-8 columns no-padding">


				<div class="dropzone-previews">
					<div id="main-image" class="dz-preview dz-image-preview dz-processing dz-success">
						<div class="dz-details columns no-padding">	
							<img id="main-image-src" class="data-dz-thumbnail" style="width:100%;" src="<?php echo $tallImageUrl; ?>" alt="<?php echo $article['article_title'].' Image'; ?>" />
						</div>
					</div>
				</div>


				
			</div>

			<div id="img-container" class=" small-4 large-4 columns">
		   		<label class="padding-top uppercase main-color  show-for-large-up" style="margin-top: 5%;">
		   			Change Image
		   		</label>
				<p class=" show-for-large-up"><a>Click to choose</a> your own image</p>				
				<p class=" show-for-large-up">OR</p>
		   		<p class="lib-img-wrapper"> Choose from our  <span class="photo-library underline" id="search-lib">Photo Library!</span></p>
		   	</div>
		</div>
	</form>
</div>