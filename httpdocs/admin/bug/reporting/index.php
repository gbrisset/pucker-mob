<?php 
	$admin = true;
	require_once('../../../assets/php/config.php');
	$user = $adminController->user;
	$userInfo = $user->data = $user->getUserInfo();
	
	//	Verify login
	if(!$user->getLoginStatus()) $adminController->redirectTo('login/');
	if(!$userInfo['user_permission_show_bugs']) $adminController->redirectTo('noaccess/');
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_POST['submit']): //Delete Article
					//var_dump($_POST);
					$updateStatus = array_merge(Bug::delete($_POST));	
					break;
			}
		}else $adminController->redirectTo('logout/');
	}

// for the Pagination class - we provide 3 bits of info...
// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	
// 2. records per page ($per_page)
	$per_page = 15;
	$limit=15;
	$post_date = 'all';

	// $articleStatus = '1, 2, 3';

	// $userArticlesFilter = $userData['user_email'];
	$order = '';
	$filterLabel = 'Most Recent';

// Sorting information
	if (isset($_GET['sort'])) {
		$order = Bug::get_order_string($_GET['sort']);
	}

// 3. total record count ($total_count)	
	$total_count = Bug::count_all();
	$pagination = new Pagination($page, $per_page, $total_count);
	$offset = $pagination->offset();
	
	$bugs = Bug::get_filtered($limit, $order, $offset);

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
			<section id="articles-list">
				<header class="section-bar">
					<h2 class="left">Bug Reports</h2>
					<div id="right">
						<div id="sort-by">
							<input type="hidden" value="<?php echo (isset($_GET['sort'])) ? $_GET['sort'] : 'mr'; ?>" id="sort-by-value" />
							<label>Sort By: </label>
							<ul>
								<?php
									$sortOmits = [2, 3, 4, 5, 6];
									foreach(Pagination::$sortLinks as $sortLink){
										if(in_array($sortLink['id'], $sortOmits)) continue;
										$li = '<li>';
											$li .= '<a data-info="'.$sortLink['shortname'].'" href="'.$config['this_admin_url'].'bug/reporting/';
											$li .= ($page > 1) ? '?p='.$page.'&sort='.$sortLink['shortname'] : '?sort='.$sortLink['shortname'];
											$li .= '">';
												$li .= $sortLink['label'];
											$li .= '</a>';
										$li .= '</li>';
										echo $li;
									}
								?>
							</ul>
						</div>
					</div>
				</header>
 				<?php
					 if(isset($bugs) && $bugs){
						foreach($bugs as $bug){
							$articleUrl = $config['this_admin_url'].'bug/reporting/'.$bug->bug_id;
							$item = '<div class="admin-article" id="'.$bug->bug_id.'">';

							$item .= '<div class="article-info">';

								$item .= '<h2>Bug ID# '.$bug->bug_id.'</h2>';
								$item .= '<div class="bug-data">';
									$item .= '<p class="bug-browser">'.$bug->bug_user_email.'</p>';
									$item .= '<p class="bug-browser">'.$bug->bug_browser.'</p>';
									$snippet = '<p class="list-item-heading">Bug Description:</p>';
									$snippet .= utf8_encode(trim(strip_tags($bug->bug_description)));
									//$articleSnippet = (strlen($articleSnippet) > 100) ? substr($articleSnippet, 0, 100).'...' : $articleSnippet;
									$item .= '<p>'.$snippet.'</p>';
									$snippet = '<p class="list-item-heading">Bug Error Message:</p>';
									$snippet .= utf8_encode(trim(strip_tags($bug->bug_error_message)));
									//$articleSnippet = (strlen($articleSnippet) > 100) ? substr($articleSnippet, 0, 100).'...' : $articleSnippet;
									$item .= '<p>'.$snippet.'</p>';

									$item .='<form class="bug-delete-form" id="bug-delete-form" name="bug-delete-form" action="'.$config['this_admin_url'].'bug/reporting/index.php" method="POST">';
										$item .='<input type="text" class="hidden" id="c_t" name="c_t" value="'.$_SESSION['csrf'].'" >';
										$item .='<input type="text" class="hidden" id="bug_id" name="bug_id" value="'.$bug->bug_id.'" />';
										$item .='<a href="#" class="b-delete" name="submit" id="submit"><i class="icon-remove"></i> Delete</a>';
									$item .='</form>';
								$item .= '</div>';

							$item .= '</div>';
						echo $item;
				?>
						</div>

				<?php
					 	}
					 }else{
				?>
					<p class="not-found">
						Sorry, no bugs were found!
					</p>
<!-- 					<p class="not-found">
						<span>Upload Recipes:</span>
						Start adding your own recipes to our site clicking <a href="<?php //echo $config['this_admin_url']?>articles/newrecipe/">HERE</a>.
					</p> -->
					
					</p>
				<?php } ?>
			</section>

			<?php include_once($config['include_path_admin'].'pages.php'); ?>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>