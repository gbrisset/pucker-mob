
<?php 
	$loginActive = isset($_SESSION['login_hash']) || isset($_SESSION['user_id']);

	if(isset($_SESSION['user_id']) && $_SESSION['user_id']){
		$user_info = $mpArticle->getUserInfo();
		$user_first_name = "";
		if(isset($user_info) && $user_info){
			$user_first_name = $user_info["user_first_name"]; 
		}
	}
?>
		<nav role="navigation" id="other-sites-cont" class="sd-promo-other-sites-cont" style="">
			<div id="my-sd-mini-header">
				<?php if( isset($user_info) && !empty($user_info) ){?>
				<ul id="signed-in-nav">
					<li><p class="larger-header-text">Hi <?php echo $user_first_name; ?>!</p></li>
					<li id="sign_join_link"><a href="<?php echo $config['this_admin_url'];?>">My Simple Dish</a></li>
					<li class="cms-bar" id="sign_join_link"><a href="<?php echo $config['this_admin_url'].'articles/newrecipe/';?>">Upload a Recipe</a></li>
					<li id="sign_join_link"><a href="<?php echo $config['this_admin_url'].'logout';?>">Sign Out</a></li>
				</ul>
				<?php }else{ ?>
				<ul>
					<li><p class="larger-header-text yellow-header-text">GET COOKIN', GOOD LOOKIN'!</p></li>
					<li><img class="spatula-image" src="<?php echo $config['image_url'] ?>articlesites/simpledish/sd-promo-header/spatula.png" alt=""></li>
					<li><p class="larger-header-text">Submit Your Own Recipes!<p></li>
					<li><img class="angles-image" src="<?php echo $config['image_url'] ?>articlesites/simpledish/sd-promo-header/angles.png" alt=""></li>
					<li><p><a class="yellow-header-text" href="<?php echo $config['this_admin_url'];?>">SIGN IN</a> to Simple Dish</p></li>
					<li><p class="link-spacer-text">or</p></li>
					<li><a class="yellow-header-text" href="<?php echo $config['this_admin_url'].'register';?>">JOIN FREE!</a></li>
				</ul>
				<?php }?>
			</div>
		</nav>
