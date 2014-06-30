<?php
	if(!$adminController->user->checkPermission('user_permission_show_edit_lists')) $adminController->redirectTo('noaccess/');
	
	$next_page_list_item = new PageListItem;
	$page_list = PageList::get_by_seo_title($uri[2]);
	if(empty($page_list)) $mpShared->get404();
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){

//	WHERE I LEFT OFF:
//				I need to make the form inputs an array, so that post includes more than just one element.
//				Maybe checkout my old minute code to see how i did this

				case(isset($_POST['item_slot'])):
					//$post = PageListItem::saveOrder($_POST, $page_list->page_list_id);
					$_POST['page_list_item_order'] = array();
					$_POST['page_list_item_id'] = array();
					for($i=0; $i<count($_POST['item_slot']); $i++){
						if ($_POST['item_slot'][$i] != ""){
							$_POST['page_list_item_order'][] = $i;
							$_POST['page_list_item_id'][] = $_POST['item_slot'][$i];
						}
					}
					$updateStatus = PageListItem::saveOrder($_POST, $page_list->page_list_id);
					$updateStatus['arrayId'] = 'page_list_item_order';
					break;

				//	ADD NEW LIST ITEM
				case ($_POST['submit'] == 'add'):
					if (!empty($_FILES['page_list_item_image']['name'])) {
						$_POST['page_list_item_image'] = $_FILES['page_list_item_image']['name'];
					}
					$next_page_list_item->save($_POST, $_FILES);
					$next_page_list_item->add_to_list($page_list->page_list_id);
					break;

				//	EDIT LIST ITEM
				case (isset($_POST['page_list_item_title'])):
						$page_list_item = new PageListItem;
						//	Test if files array is empty, is not, set image in post var
						//	Place this in an object?
						if (!empty($_FILES['page_list_item_image']['name'])) {
							$_POST['page_list_item_image'] = $_FILES['page_list_item_image']['name'];
						}
						$updateStatus = $page_list_item->save($_POST, $_FILES);
						$updateStatus['arrayId'] = 'page-list-item-data-form';
					break;

				//	EDIT LIST
				case isset($_POST['page_list_title']):
					$page_list = PageList::get_by_seo_title($uri[2]);
					$updateStatus = $page_list->save($_POST);
					$updateStatus['arrayId'] = 'page-list-data-form';
					break;
			}
		} else $adminController->redirectTo('logout/');
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<?php include_once($config['include_path_admin'].'header.php');?>



	<div id="main-cont">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		<div id="content">
			<section id="article-info">

				<header class="section-bar">
					<h2>List Information</h2>
				</header>
				<form class="page-list-data-form" id="page-list-data-form" name="page-list-data-form" action="<?php echo $config['this_admin_url']; ?>lists/edit/<?php echo $uri[2]; ?>" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="page_list_id" name="page_list_id" value="<?php echo $page_list->page_list_id; ?>" />
					<input type="hidden" id="seo_title_updated" name="seo_title_updated" value="" />

					<fieldset>
						<label for="page-list-title">List Title<span>*</span> :</label>
						<input type="text" name="page_list_title" id="page_list_title" placeholder="Please enter the lists's title here." value="<?php if(isset($page_list->page_list_title)) echo $page_list->page_list_title; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'page_list_title') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the lists's title that will be visible throughout the network.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="page_list_seo_title">List SEO Title<span>*</span> :</label>
						<input type="text" name="page_list_seo_title" id="page_list_seo_title" placeholder="Please enter the article's seo-formatted title here." value="<?php if(isset($page_list->page_list_seo_title)) echo $page_list->page_list_seo_title; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_seo_title') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the lists's seo title that will be used in URLs.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="page_list_desc">List Description<span>*</span> :</label>
						<textarea name="page_list_desc" id="page_list_desc" rows="5" required placeholder="Please enter the list's description here." ><?php if(isset($page_list->page_list_desc)) echo $page_list->page_list_desc; ?></textarea>
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the list's description.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="btn-wrapper list-button right-aligned" >
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-info-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-info-form') echo $updateStatus['message']; ?>
							</p>
							
							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
				</form>

			</section>			
			<?php $page_list_items = PageListItem::get_all_by_page_list_id($page_list->page_list_id); ?>


<!--BEGIN SORT ORDER-->
			<section>
				<header class="section-bar">
					<h2>Change order</h2>
					<?php //var_dump($page_list_items); ?>
				</header>	
				<div id="articles-list">
					<form id="page_list_item_order" action="<?php echo $config['this_admin_url']; ?>lists/edit/<?php echo $uri[2]; ?>" method="POST">
						<ul id="sortable2" class="page-list-inline sortable grid">



					<?php 
					if(isset($page_list_items) && !empty($page_list_items)){
						$list_slot = 1;
						foreach($page_list_items as $page_list_item){
							if (!empty($page_list_item->page_list_item_image)){
									$imageUrl = $config['image_url'].'articlesites/puckermob/list/'.$page_list_item->page_list_item_image;
								} else {
									$imageUrl = $config['image_url'].'articlesites/puckermob/list/placeholder.png';
								}
					?>
								<li draggable="true">
									<input type="hidden" name="item_slot[]" value="<?php echo $page_list_item->page_list_item_id; ?>">
									<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
									<img src="<?php echo $imageUrl; ?>" alt="<?php echo $page_list_item->page_list_item_title; ?> Preview Image" />
									<p><?php echo $mpHelpers->truncate($page_list_item->page_list_item_title, 20); ?></p>
								</li>
								<?php $list_slot++; ?>					
					<?php
							}
						} else {
					?>
							<p class="page-list-none">
							<a href="<?php echo (isset($listUrl)) ? $listUrl : ''; ?>" class="orange-link" name="Add List Items" title="Add List Items">CLICK HERE</a> to add items to this list!
							</p>
					<?php } ?>
						<fieldset>
							<div class="btn-wrapper list-button right-aligned">
								<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'page_list_item_order') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result" style="color: #468847; text-align: left; text-transform: none; font-style: italic; padding: 5px 0;">
									<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'page_list_item_order') echo $updateStatus['message']; ?>
								</p>
								
								<button type="submit" id="submit" name="submit">Save List Order</button>
								<br />
							</div>
						</fieldset>

						</ul>
					</form>
				</div>

			</section>


			<section id="page-list-settings">
				<header class="section-bar">
					<h2>Add List Items</h2>
				</header>
				<ul>
				<?php 
					foreach($page_list_items as $page_list_item){
						//	Display EDIT FORM
				?>
				<li class="inline-div" style="background-color: #fff;" id="<?php echo $page_list_item->page_list_item_id; ?>">
				<div id="<?php echo $page_list_item->page_list_item_id; ?>">

					<form class="list-item-delete-form" id="list-item-delete-form" name="list-delete-form" action="<?php echo $config['this_admin_url']; ?>lists/edit/<?php echo $uri[2]; ?>" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
						<input type="hidden" id="page_list_id" name="page_list_id" value="<?php echo $page_list->page_list_id; ?>" />
						<input type="text" class="hidden" id="page_list_item_id" name="page_list_item_id" value="<?php echo $page_list_item->page_list_item_id; ?>" />
						<div class="btn-wrapper delete-page-list-item">
							<button class="b-delete gradient-button red-gradient" name="submit" id="submit" type="submit" data-info="<?php echo $page_list_item->page_list_item_id; ?>">x</button>
						</div>
					</form>


<!-- EDIT FORM -->

					<form id="page-list-item-data-form<?php echo '-'.$page_list_item->page_list_item_id; ?>" enctype="multipart/form-data"  class="page-list-item-data-form" action="<?php echo $config['this_admin_url']; ?>lists/edit/<?php echo $uri[2]; ?>" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
						<input type="text" class="hidden" id="page_list_item_id" name="page_list_item_id" value="<?php echo $page_list_item->page_list_item_id; ?>" >
						<input type="hidden" id="existing_image" name="existing_image" value="<?php echo $page_list_item->page_list_item_image; ?>" />

						<fieldset>
							<input type="text" name="page_list_item_title" id="page_list_item_title" placeholder="Please enter the page list's title here." value="<?php if(isset($page_list_item->page_list_item_title)) echo $page_list_item->page_list_item_title; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'page_list_item_title') echo 'autofocus'; ?> />

							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>This is the page list item's title.</p>
								</div>
							</div>
						</fieldset>

						<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-info-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
							<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-info-form') {echo $updateStatus['message'];} else { echo '&nbsp;';} ?>
						</p>

						<fieldset>
							<textarea class="elm-wysiwyg" name="page_list_item_body" id="page_list_item_body" rows="5" required placeholder="Please enter the item's content here." ><?php if(isset($page_list_item->page_list_item_body)) echo $page_list_item->page_list_item_body; ?></textarea>
							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>This is the list item's main content</p>
								</div>
							</div>
						</fieldset>

<!--BEGIN IMAGE PREVIEW-->
						<div class="image-preview">
							<!-- <p>This is the Page List image.</p> -->
							<div class="image-bg list-item-img">
								<img id="preview-<?php echo $page_list_item->page_list_item_id; ?>" class="<?php if(empty($page_list_item->page_list_item_image)) {echo 'hidden';} ?>" src="<?php echo $config['image_url'].'articlesites/puckermob/list/'.$page_list_item->page_list_item_image; ?>" alt="<?php echo $page_list_item->page_list_item_title; ?> Preview Image" />
								<?php if(empty($page_list_item->page_list_item_image)){ ?>
									<p class="no-img">This page list item doesn't have a preview image yet!</p>
								<?php } ?>
							</div>
						</div>						
<!--END IMAGE PREVIEW-->
<!-- 							<input type="radio" class="radio-input" name="media_type" value="image-inputs" checked>Image
							<input type="radio" class="radio-input" name="media_type" value="you-tube-inputs">YouTube
							
							<div class="tooltip">
								<img src="<?php //echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>Select which Media type to use for the main image placement in the list.</p>
								</div>
							</div> -->


<!--Image Fields-->
						<div id="image-inputs" class="radio-toggle shown">
							<fieldset>
								<label for="page_list_item_image">Change Image</label>
								<input type="file" id="userfile" name="userfile" class="userfile<?php echo '-'.$page_list_item->page_list_item_id; ?>" value="" />
								<div class="tooltip">
									<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

									<div class="tooltip-info">
										<p>This is the main image for the page list item.</p>
									</div>
								</div>

							</fieldset>

							<fieldset>
								<label for="page_list_item_image_source">Image Credit</label>
								<input type="text" name="page_list_item_image_source" id="page_list_item_image_source" placeholder="Please enter the image's source." value="<?php if(isset($page_list_item->page_list_item_image_source)) echo htmlentities($page_list_item->page_list_item_image_source); ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'page_list_item_title') echo 'autofocus'; ?> />

								<div class="tooltip">
									<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

									<div class="tooltip-info">
										<p>This is the source of the item's image.</p>
									</div>
								</div>
							</fieldset>
						</div>
<!--End Image Fields-->	


<!--Youtube -->	
						<div id="you-tube-inputs" class="radio-toggle">
							<fieldset>
								<label for="page_list_item_youtube_embed">YouTube Embed</label>
								<input type="text" name="page_list_item_youtube_embed" id="page_list_item_youtube_embed" placeholder="Add youTube embed code, if desired." value="<?php if(isset($page_list_item->page_list_item_youtube_embed)) echo htmlentities($page_list_item->page_list_item_youtube_embed); ?>"  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'page_list_item_title') echo 'autofocus'; ?> />

								<div class="tooltip">
									<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

									<div class="tooltip-info">
										<p>If this is set, it will show instead of image.</p>
									</div>
								</div>
							</fieldset>
						</div>

<!--End Youtube -->	

						<fieldset>
							<div class="btn-wrapper list-button">

						<?php include_once($config['include_path_admin'].'preview_page_list.php');  ?>

						<div class="main-buttons edit-recipe" style="float: left; ">
							<!--<button type="button" id="cont-preview" name="button" class="profile-preview">Preview</button>-->
						</div>

								<button type="submit" id="submit" name="submit">Save</button>
							</div>
						</fieldset>
					</form>

				</div>
				</li>
			<?php } ?>

<!--   Begin the add new form    -->
				<li class="inline-div">
				<?php  ?>
				<div class="inline-div add-list-item" id="add-list-item">
					<p class="large-add-text" id="large-add-text">+<br />add</p>
					<form id="page-list-item-data-add-form" enctype="multipart/form-data" class="page-list-item-data-add-form" action="<?php echo $config['this_admin_url']; ?>lists/edit/<?php echo $uri[2]; ?>" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
						<input type="text" class="hidden" id="form" name="form" value="add" >
						<input type="text" class="hidden" id="page_list_item_image" name="page_list_item_image" value="" />

						<fieldset>
							<input type="text" name="page_list_item_title" id="page_list_item_title" placeholder="Please enter the page list's title here." value="" required />

							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>This is the page list item's title.</p>
								</div>
							</div>
						</fieldset>
						<p class="" id="result">&nbsp;</p>

						<fieldset>
							<textarea class="elm-wysiwyg" name="page_list_item_body" id="page_list_item_body" rows="5" required placeholder="Please enter the item's content here." ></textarea>
							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>This is the list item's main content</p>
								</div>
							</div>
						</fieldset>

						<fieldset>
							<label for="page_list_item_image">Item Image</label>
							<input type="file" id="page_list_item_image" name="page_list_item_image" />
							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>This is the main image for the page list item.</p>
								</div>
							</div>

						</fieldset>

						<fieldset>
							<input type="text" name="page_list_item_image_source" id="page_list_item_image_source" placeholder="Please enter the image's source." value=""  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'page_list_item_title') echo 'autofocus'; ?> />

							<div class="tooltip">
								<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

								<div class="tooltip-info">
									<p>This is the source of the item's image.</p>
								</div>
							</div>
						</fieldset>

<!--Youtube -->	
						<fieldset>
							<input type="text" name="page_list_item_youtube_embed" id="page_list_item_youtube_embed" placeholder="Add youTube embed code, if desired." value=""  <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'page_list_item_title') echo 'autofocus'; ?> />
								<div class="tooltip">
									<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

									<div class="tooltip-info">
										<p>If this is set, it will show instead of image.</p>
									</div>
								</div>
						</fieldset>

<!--End Youtube -->	
						<fieldset>
							<div class="btn-wrapper list-button">
								<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-info-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
									<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-info-form') echo $updateStatus['message']; ?>
								</p>
								
								<button type="submit" id="submit" name="submit" value="add">Save</button>
							</div>
						</fieldset>
						
					</form>

						<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'page-list-item-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
							<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'page-list-item-image-upload-form') echo $updateStatus['message']; ?>
						</p>

					</div>
				</li>
			</ul>

<!--   End the add new form    -->

			</section>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<div id='lightbox-cont'>
		<div class="overlay"></div>

		<div id="lightbox-content" class="article-lightbox">
			<button type='button' id="preview-close" class="close">X</button>

			<div id="lightbox-preview-cont"></div>
		</div>
	</div>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>