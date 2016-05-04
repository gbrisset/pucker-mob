<?php
	$directory = $config['image_path_admin'].'articles/';
	$files = glob($directory . '*.jpg');
	$filecount = 0;
	if ( $files !== false ){
	    $filecount = count( $files );
	}

?>
<div id="openModalLib" class="modalDialogLib" >
	<div id="popup-content" style="width:40% !important; min-width: 20rem; margin: 10% auto !important;">
		<a href="#close" title="Close" class="close">X</a>
		
		<form name="images-lib" id="images-library-form" method="POST" action="" class="ajax-submit-form clear">
		
		<div class = "step-1">
			<header id="header-images">Select a Category</header>
			<div class="modal-img" id="article-preset-img" style="background: #fff; padding: 0;">
				<?php 
					$lib_categories = $mpArticleAdmin->getImagesCategories();
					if($lib_categories){
						foreach( $lib_categories as $img_category){ ?>
						<div class="img_categories no-padding no-vertical-padding" data-info="<?php echo $img_category['seo_name']; ?>">
							<div class="lib_cat_img small-4 inline-block">
								<img class="" src="http://www.puckermob.com/admin/assets/img/articles/<?php echo $img_category['img_name']; ?>" alt="<?php echo $img_category['name']; ?>" >
							</div>
							<div class="lib_cat_desc small-7 inline-block">
								<h1><?php echo $img_category['name']; ?></h1>
							</div>
						</div>

					<?php }
					}
				?>
			</div>
			<div class="more-coming">
				<h1>More Categories Coming soon!</h1>
			</div>
		</div>
		
		<div class="step-2">
		<header id="header-images">Select an image and click insert</header>
		<div class="modal-img article-imgs-container" id="article-preset-img" style="background: #fff; padding: 0; overflow: scroll; height: 22rem;"></div>
		<input type="hidden" id="image_value" name="image_value" value="" />
		<input type="hidden" id="library" name="library" value="library" />
		<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
		<?php if(isset($article) && $article){?>
		<input type="hidden" id="a_i" name="a_i" value="<?php echo $article['article_id']; ?>" />
		<?php }?>
		<div class="buttons-container-preset-art-img">
			<button type="button" id="back-img" name="back-img" style="margin-bottom: 0; padding: 0.5rem 1rem; float:left;">BACK</button>
			<button type="button" id="submit-img" name="submit-img" style="margin-bottom: 0; padding: 0.5rem 1rem;">INSERT</button>
		</div>
		</div>
		
		</form>
	</div>
</div>


<script>

if($('#openModalLib')){

	$('.close').click(function(e){
		$('body').removeClass('show-modal-box-lib');
	});

	$('.photo-library').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$('.step-2').hide();
		$('.article-imgs-container').html('');
		$('.step-1').show();
		$('body').addClass('show-modal-box-lib');
	});

	$('body').on('click', '.article-img-preset',  function(e){
		$('.article-img-preset').removeClass('highlight-img');
		$(this).addClass('highlight-img');
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
					var src = "<?php echo $config['image_url'].'articlesites/puckermob/'?>"+data.directory+'/'+data.filename+'?'+random_val;
					if($('img[data-dz-thumbnail]').length > 0 ){
						$('img[data-dz-thumbnail]').attr('src', src );

					}else{
						var div_elm = $('<div class="dz-preview small-12 large-7 dz-image-preview" id="template_copy"><div class="dz-details dztemplate"><img data-dz-thumbnail src="'+ src +'" id="main-image-src"/></div></div>');

						$('.dz-message').append(div_elm);
					}
					$('body').removeClass('show-modal-box-lib');
				}
			});
	});

	$('#back-img').click(function(e){
		$('.step-2').hide();
		$('.article-imgs-container').html('');
		$('.step-1').show();
	});
}
</script>