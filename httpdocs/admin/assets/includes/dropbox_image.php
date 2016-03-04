<div class="radius small-12 xxlarge-8 columns" id="image-drop" >
	<form class="dropzone dz-clickable small-12 column no-padding" action="<?php echo $config['this_admin_url']; ?>articles/upload.php">
		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
		<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
		
		<div class="dz-message inline-flex" data-dz-message >
			<div id="img-container" class="small-12 large-8" >
				<div class="hide-for-large-up">
					<div class="image-icon small-3 columns "><i class="fa fa-file-image-o font-4x"></i></div>
			   		<label class="small-9 columns">  <span class="photo-library" id="search-lib">Choose An image from our Photo Library!</span> </label>
			   		<label class="mini-fonts mini-fonts small-12 columns">(If you'd like to upload your own photo please login from a desktop computer</label>
		   		</div>
		   		<div class="show-for-large-up">
			   		<label class="large-10 columns uppercase bold no-padding main-label font-170-pct">ADD An Image</label>
			   		<label style="color: #ccc;" class="large-10 columns no-padding margin-bottom-2x">Drag Image Here or <a>Click to Upload</a> (784x431) </label>
			   		<label class="large-10 columns uppercase bold no-padding font-1x margin-bottom second-label font-125-pct">Don't have your own image? Don't worry!</label>
			   		<label class="large-10 columns no-padding left" style="color: #ccc;" >  Pick An image from our free <a href="#" class="photo-library" id="search-lib">Photo Library!</a> </label>
		   		</div>
		   	</div>
		</div>
	</form>

	<div class="dropzone-previews">
		<div id="main-image" class="dz-preview dz-image-preview dz-processing dz-success hidden">
			<div class="dz-details columns no-padding padding-bottom">	
				<img class="data-dz-thumbnail" src=""  />
			</div>
		</div>
	</div>
</div>