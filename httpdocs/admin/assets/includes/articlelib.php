<?php
	$directory = $config['image_path_admin'].'articles/';
	$files = glob($directory . '*.jpg');
	$filecount = 0;
	if ( $files !== false ){
	    $filecount = count( $files );
	}

?>
<div id="openModalLib" class="modalDialogLib" >
	<div id="popup-content" style="width:60% !important; min-width: 35rem; margin: 4% auto !important;">
		<a href="#close" title="Close" class="close">X</a>
		<form name="images-lib" id="images-library-form" method="POST" action="" class="ajax-submit-form clear">
		<header id="header-images">Select an image and click insert</header>
		<div class="modal-img" id="article-preset-img" style="background: #fff; padding: 0;">
		<?php
			for($index = 1; $index <= $filecount; $index++){
				echo '<div class="small-4 div-images-holder"><img id="art-img-'.$index.'" data-info="MOBlog_ArticleImage_'.$index.'.jpg" class="article-img-preset" src="http://www.puckermob.com/admin/assets/img/articles/MOBlog_ArticleImage_'.$index.'.jpg" alt="MOBlog_ArticleImage_'.$index.'.jpg" ></div>';
			}
		?>
		</div>
		<input type="hidden" id="image_value" name="image_value" value="" />
		<input type="hidden" id="library" name="library" value="library" />
		<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
		<?php if(isset($article) && $article){?>
		<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />
		<?php }?>
		<div class="buttons-container-preset-art-img">
			<button type="button" id="submit-img" name="submit-img" style="margin-bottom: 0; padding: 0.5rem 1rem;">INSERT</button>
		</div>
		
		</form>
	</div>
</div>


<script>

if($('#openModalLib')){

	$('.close').click(function(e){
		$('body').removeClass('show-modal-box-lib');
	});

	$('#search-lib').click(function(e){
		$('body').addClass('show-modal-box-lib');
	});

	$('.article-img-preset').on('click', function(e){
		$('.article-img-preset').removeClass('highlight-img');//.removeClass('transition');
		$(this).addClass('highlight-img');//.addClass('transition');
		$('#image_value').val($(this).attr('data-info'));
	});

	$('#submit-img').on('click', function(event){
		var img_art = $('#image_value'),
		img_name = $(img_art).val(),
		user_id = $('#u_i').val(),
		c_t = $('#c_t').val(),
		a_i = $('#a_i').val();
		random_val = Math.floor((Math.random() * 10000000000) + 1);

		$.ajax({
			  type: "POST",
			  url:  '<?php echo $config['this_admin_url']; ?>articles/upload.php',
			  data: { image: img_name, isLib:true, u_i: user_id, c_t: c_t, a_i: a_i }
			}).done(function(data) {

				data = JSON.parse(data);
				if(!data.hasError){
					$('.data-dz-thumbnail').attr('src', "<?php echo $config['image_url'].'articlesites/puckermob/'?>"+data.directory+'/'+data.filename+'?'+random_val);
					$('.dz-preview.dz-image-preview.dz-processing.dz-success').find('img').attr('src', "<?php echo $config['image_url'].'articlesites/puckermob/'?>"+data.directory+'/'+data.filename+'?'+random_val);
					$('#main-image').removeClass('hidden');
					$('body').removeClass('show-modal-box-lib');
				}
			});
	});
}
</script>