
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
<nav role="navigation" id="other-sites-cont">
	<div id="header-other-sites">
		<?php if(!$loginActive){?>
		<ul>
			<li class="fe-bar" id="sign_join_link"><a href="<?php echo $config['this_admin_url'];?>">Sign in to Simple Dish</a></li>
			<li id="sign_join_link"><a href="<?php echo $config['this_admin_url'].'register';?>">Join Free!</a></li>
		</ul>
		<?php }else{ ?>
		<ul>
			<label>Hi <?php echo $user_first_name; ?>!</label>
			<li  id="sign_join_link"><a href="<?php echo $config['this_admin_url'];?>">My Simple Dish</a></li>
			<li class="cms-bar" id="sign_join_link"><a href="<?php echo $config['this_admin_url'].'articles/newrecipe/';?>">Upload a Recipe</a></li>
			<li id="sign_join_link"><a href="<?php echo $config['this_admin_url'].'logout';?>">Sign Out</a></li>
		</ul>
		<?php }?>
	</div>
</nav>