<section id="articles-list" class="columns margin-top no-padding">
<?php
	if(isset($articles) && $articles ){ ?>

	<table class="columns small-12 no-padding" id="promote_articles_list">
		<thead>
		    <tr>
		       <th width="400" class="align-left">Title</th>
		       <th width="100" class="show-for-large-up">Updated</th>
		       <th width="100" class="show-for-large-up">Promotion</th>
		       <th width="100"  class="show-for-large-up">status</th>
		       <th width="100" class="show-for-xlarge-up">U.S. Traffic</th>
		       <th  width="50" class="show-for-large-up">USED</th>
		    </tr>
		</thead>
		
		<tbody>
		 <?php foreach($articles as $articleInfo){
			$articleUrl = $config['this_admin_url'].'articles/edit/'.$articleInfo->article_seo_title;
			$articleUrlLive = $config['this_url'].'/'.$articleInfo->cat_dir_name.'/'.$articleInfo->article_seo_title;
			$article_id = $articleInfo->article_id;
			$facebook_page = $articleInfo->facebook_page_name;
			$facebook_id = $articleInfo->facebook_page_id;
			$ext = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/puckermob/tall/'.$articleInfo->article_id.'_tall');
			$pathToImage = $config['image_upload_dir'].'articlesites/puckermob/large/'.$articleInfo->article_id.'_tall.jpg';
			$article_title = $articleInfo->article_title;
			$article_status = (isset($articleInfo->article_status)) ? MPArticleAdmin::displayArticleStatus($articleInfo->article_status) : '';
			$article_date_created =  date_format(date_create($articleInfo->creation_date), 'm/d/y');
			$article_us_traffic = $articleInfo->usa_pageviews;
			$contributor_name = $articleInfo->contributor_name;
			$contributor_seo_name = $articleInfo->contributor_seo_name;
			$promoted = $articleInfo->promoted;
			$article_date_updated = date_format(date_create($articleInfo->date_updated), 'm/d/y');
			$user_id = $articleInfo->user_id;
			//var_dump($articleInfo); die;

			if(file_exists($pathToImage)){
				$imageUrl = 'http://images.puckermob.com/articlesites/puckermob/large/'.$articleInfo->article_id.'_tall.jpg';
			} else {
				$imageUrl = 'http://cdn.puckermob.com/articlesites/sharedimages/puckermob-default-image.jpg';
			}

			?>

			<tr id="<?php echo 'article-'.$article_id; ?>" data-user= "<?php echo $user_id; ?>">

			  	<td class="border-right">
			  		<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>" />
			  		<div class=" large-4 columns no-padding-left show-for-large-up">
						<a href="<?php echo $articleUrl; ?>">
							<img src="<?php echo $imageUrl; ?>" alt="<?php echo $article_title.' Preview Image'; ?>" />
						</a>
					</div>
					<div class="large-7 columns no-padding" style="display: table-caption">
						<h2 class="small-12 columns no-padding">
							<i class="fa fa-caret-right hide-for-large-up small-1  columns"></i>
							<a href="<?php echo $articleUrl; ?>">
								<?php echo $mpHelpers->truncate(trim(strip_tags($article_title)), 45); ?>
							</a>
							<?php if($admin){?>
								<span class="show-for-large-up"><a href="<?php echo $config['this_admin_url']; ?>profile/user/<?php echo $contributor_seo_name; ?>"><?php echo $contributor_name?></a></span>
							<?php }?>
						</h2>
						
					</div>

					<div class="large-1 columns no-padding show-for-large-up">
					<?php if($articleInfo->article_status == 1 ) { ?>	<a href="<?php echo $articleUrlLive; ?>" target="_blank" style="position: relative; top: 1.5rem;"><i class="fa fa-external-link"></i></a> <?php }?>
					</div>
			  	</td>

			  	<td class="show-for-large-up  border-right"><label><?php echo $article_date_updated; ?></label></td>
			  	<td class="show-for-large-up  border-right"><label><?php echo $facebook_page; ?></label></td>
			  	
			  	<td class="show-for-large-up  border-right"><label><?php echo $article_status ?></label></td>	
				<!-- REMOVE ARTICLE -->
				<td class="show-for-xlarge-up  border-right" ><label><?php  echo (!is_null($article_us_traffic) ) ?   $article_us_traffic :  0; ?></label></td>
				<td class="show-for-large-up no-border-right valign-middle">
					<input type="checkbox" name="promoted" value="<?php echo $promoted ?>" <?php if( $promoted == 1 ) echo 'checked'; ?> class="promoted-cb" 
						data-info = "<?php echo $article_id; ?>"
						data-user = "<?php echo $user_id; ?>"
						data-title = "<?php echo $article_title; ?>" 
						data-fb-id = "<?php echo $facebook_id; ?>" 
						data-fb-name = "<?php echo $facebook_page; ?>"
					/>
				</td>							  			
			</tr>
		<?php }?>
	    </tbody>
	</table>
				
	<?php }else{ ?>
	<p class="not-found">
		Sorry, no articles were found!
	</p>
	<?php }?>