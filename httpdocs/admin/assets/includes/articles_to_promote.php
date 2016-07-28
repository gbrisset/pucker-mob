<section id="articles-list" class="columns margin-top no-padding">
<?php
	if(isset($articles) && $articles ){ ?>

	<table class="columns small-12 no-padding">
		<thead>
		    <tr>
		       <th width="400" class="align-left">Title</th>
		       <th width="100" class="show-for-large-up">Added</th>
		       <th width="100" class="show-for-large-up">Promotion</th>
		       <th width="100"  class="show-for-large-up">status</th>
		       <th width="100" class="show-for-xlarge-up">U.S. Traffic</th>
		       <th  width="50" class="show-for-large-up">USED</th>
		    </tr>
		</thead>
		
		<tbody>
		 <?php foreach($articles as $articleInfo){
			$articleUrl = $config['this_admin_url'].'articles/edit/'.$articleInfo->article_seo_title;
			$article_id = $articleInfo->article_id;
			$facebook_page = $articleInfo->facebook_page_name;
			$ext = $adminController->getFileExtension($config['image_upload_dir'].'articlesites/puckermob/tall/'.$articleInfo->article_id.'_tall');
			$pathToImage = $config['image_upload_dir'].'articlesites/puckermob/large/'.$articleInfo->article_id.'_tall.jpg';
			$article_title = $articleInfo->article_title;
			$article_status = (isset($articleInfo->article_status)) ? MPArticleAdmin::displayArticleStatus($articleInfo->article_status) : '';
			$article_date_created =  date_format(date_create($articleInfo->creation_date), 'm/d/y');
			$article_us_traffic = $articleInfo->usa_pageviews;
			$contributor_name = $articleInfo->contributor_name;
			$contributor_seo_name = $articleInfo->contributor_seo_name;
			$promoted = $articleInfo->promoted;

			/*if(!is_null($pageviews_list[$article_id])){
		    	$article_us_traffic = $pageviews_list[$article_id];
			}*/

			if(file_exists($pathToImage)){
				$imageUrl = 'http://images.puckermob.com/articlesites/puckermob/large/'.$articleInfo->article_id.'_tall.jpg';
			} else {
				$imageUrl = 'http://cdn.puckermob.com/articlesites/sharedimages/puckermob-default-image.jpg';
			}

			?>
			<tr id="<?php echo 'article-'.$article_id; ?>">
			  	<td class="border-right">
			  		<div class=" large-4 columns no-padding-left show-for-large-up">
						<a href="<?php echo $articleUrl; ?>">
							<img src="<?php echo $imageUrl; ?>" alt="<?php echo $article_title.' Preview Image'; ?>" />
						</a>
					</div>
					<div class="large-8 columns no-padding" style="display: table-caption">
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
			  	</td>

			  	<td class="show-for-large-up  border-right"><label><?php echo $article_date_created; ?></label></td>
			  	<td class="show-for-large-up  border-right"><label><?php echo $facebook_page; ?></label></td>
			  	
			  	<td class="show-for-large-up  border-right"><label><?php echo $article_status ?></label></td>	
				<!-- REMOVE ARTICLE -->
				<td class="show-for-xlarge-up  border-right" ><label><?php  echo (!is_null($article_us_traffic) ) ?   $article_us_traffic :  0; ?></label></td>
				<td class="show-for-large-up no-border-right valign-middle">
					<?php if($admin_user ){?>
						<form class="article-delete-form" id="article-delete-form" name="article-delete-form" action="<?php echo $config['this_admin_url'].'articles/index.php';?>" method="POST">
							<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf'];?>" >
							<input type="text" class="hidden" id="article_id" name="article_id" value="<?php echo $article_id;?>" />
							<input type="checkbox" name="promoted" value="<?php echo $promoted ?>" <?php if( $promoted == 1 ) echo 'checked'; ?>
						</form>
					<?php }?>
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