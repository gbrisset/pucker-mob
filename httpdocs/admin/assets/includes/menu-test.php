<?php 
$uri = $adminController->helpers->getURI($mpHelpers->curPageURL());
($adminController->user->data['user_name']) ? $userLink = 'account/user/'.$adminController->user->data['user_name'] : $userLink = 'noacess';
?>
<h1 class="main-header"><a href="<?php echo $config['this_admin_url'].'articles/'?>">My Pucker Mob</a></h1>
<div id="nav-cont" class="columns small-3 large-1 no-padding sticky hide-for-print fixed-content padding-top">
		<ul class="side-nav">

			<li class="heading"><a href="#">Manage Categories</a></li>
			<li class="divider"></li>
			
			<li class="heading"><a href="#">Articles</a></li>
			<li><a href="#">Add an Article</a></li>
			<li><a href="#">Edit an Article</a></li>
			<li class="divider"></li>
			
			<li class="heading"><a href="#">Contributors</a></li>
			<li><a href="#">Add New Contributor</a></li>
			<li><a href="#">Edit Contributors</a></li>
			<li class="divider"></li>

			<li class="heading"><a href="#">My Profile</a></li>
			<li class="divider"></li>

			<li class="heading"><a href="#">Contact Us</a></li>
			<li class="divider"></li>

			<li class="heading"><a href="#">Sign Out</a></li>
		</ul>

</div>