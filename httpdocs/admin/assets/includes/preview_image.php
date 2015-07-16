<?php 
	$image_prev = '<section id="update-article-image">';
		$image_prev .= '<div id="article-tall-image-upload" class="image-uploader">';
			$image_prev .= '<form class="ajax-submit-image" id="article-tall-image-upload-form" name="article-tall-image-upload-form" action="" method="POST">';
				$image_prev .= '<input type="text" class="hidden" id="c_t" name="c_t" value="'.$_SESSION['csrf'].'" >';
				$image_prev .= '<input type="hidden" id="x1" name="x1" />';
				$image_prev .= '<input type="hidden" id="y1" name="y1" />';
				$image_prev .= '<input type="hidden" id="article-id" name="article-id" value="'.$article['article_id'].'"/>';
				$image_prev .= '<fieldset class="step2">';
					$image_prev .= '<span>';
						$image_prev .= '<p>Please select a crop region</p>';
					$image_prev .= '</span>';
					$image_prev .= '<span class="right preview-close">';
						$image_prev .= '<p>CLOSE<i class="icon-remove-sign" id="preview-close"></i></p>';
					$image_prev .= '</span>';
				$image_prev .= '</fieldset>'; 
					    
				$image_prev .= '<fieldset class="image-info">';  	
					$image_prev .= '<img id="preview" alt="" src="" />';
				$image_prev .= '</fieldset>';

				$image_prev .= '<fieldset class="image-info">';
					$image_prev .= '<div class="info">';
						$image_prev .= '<h2>Image Information:</h2>';

						$image_prev .= '<label>Name:</label> <p id="filenametext" name="filenametext"></p>';
						$image_prev .= '<label>Size:</label> <p id="filesizetext" name="filesizetext"></p>';
						$image_prev .= '<label>Type:</label><p id="filetype" name="filetype"></p>';
						$image_prev .= '<label>Dimension:</label><p id="filedim" name="filedim"></p>';
					        
						$image_prev .= '<input type="hidden" id="filesize" name="filesize" />';
						$image_prev .= '<input type="hidden" id="w" name="w" />';
						$image_prev .= '<input type="hidden" id="h" name="h" />';
						$image_prev .= '<input type="hidden" id="dimHeight" name="dimHeight" />';
						$image_prev .= '<input type="hidden" id="dimWidth" name="dimWidth" />';
					$image_prev .= '</div>';
				$image_prev .= '</fieldset>';
				
				$image_prev .= '<div class="file-upload-container">';
					$image_prev .= '<input type="file" name="article_post_tall_img" id="article_post_tall_img" class="upload-img-file"/>';
				$image_prev .= '</div>   ';
				
				$image_prev .= '<fieldset class="save-button">';
					$image_prev .= '<div class="btn-wrapper">';
						$image_prev .= '<button type="submit" id="submit" name="submit" value="Save Image" class="ajax-submit-image">Save Image</button>';
					$image_prev .= '</div>';
				$image_prev .= '</fieldset>';
			$image_prev .= '</form>';
				
		$image_prev .= '</div>';
	$image_prev .= '</section>';
?>