<div id="lightbox-preview-cont">
	<section id="update-article-image">
		<div id="contributor-wide-image-upload" class="image-uploader">
			<form class="ajax-submit-image" id="contributor-wide-image-upload-form" enctype="multipart/form-data" name="contributor-wide-image-upload-form" 
					  action="<?php echo $config['this_admin_url'].'account/user/'.$uri[2]; ?>" method="POST"  onsubmit="return checkForm()">
				<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
		        <input type="hidden" id="x1" name="x1" />
		        <input type="hidden" id="y1" name="y1" />
		        <input type="hidden" id="c_i" name="c_i" value="<?php echo $userInfo['contributor_id']; ?>" />

		        
		        <div class="step2">
				   	<span>
				       	<p>Please select region</p>
				    </span>
				    <span class="right preview-close">
						<a href="#close" title="Close" id="preview-close" class="close">X</a>
					</span>
			    </div>  
			    
			    <div class="image-info">  	
			        <img id="preview" alt="" src="" />
			    </div>

			    <div class="image-info">
			        <div class="info">
			        	<input type="hidden" id="filesize" name="filesize" />
						<input type="hidden" id="w" name="w" />
			            <input type="hidden" id="h" name="h" />
			            <input type="hidden" id="dimHeight" name="dimHeight" />
			            <input type="hidden" id="dimWidth" name="dimWidth" />
			        </div>
			 	</div>
			    <div class="file-upload-container hidden">
			    	<input type="file" name="contributor_wide_img" id="contributor_wide_img" class="upload-img-file account-file-input" />
				</div>   
			    <div class="save-button left margin-top">
					<div class="btn-wrapper">
						<button type="submit" id="submit" name="submit" value="Save Image" class="ajax-submit-image">Save Image</button>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>