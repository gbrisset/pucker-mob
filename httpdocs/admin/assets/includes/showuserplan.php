<?php 
	$user_type = $adminController->user->data['user_type'];
	$moblevel = "Basic";
	$explanation = "Find more about Mob Levels, and how you can earn more by becoming a Pro blogger";
	
	switch($user_type){
		case 1:
		case 2:
			$moblevel = 'Admin';
			$explanation = "Find more about Mob Levels, and the benefits you enjoy by being a Pro blogger";
			break;
		case 3:
			$moblevel = 'Basic';
			$explanation = "Find more about Mob Levels, and how you can earn more by becoming a Pro blogger";
			break;
		case 6:
		case 7:
			$moblevel = 'Writer';
			$explanation = "Find more about Mob Levels, and the benefits you enjoy by being a Pro blogger";
			berak;
		case 8:
			$moblevel = 'Pro'; 
			$explanation = "Find more about Mob Levels, and the benefits you enjoy by being a Pro blogger";
			break;
		default:
			$moblevel = 'Basic';
			$explanation = "Find more about Mob Levels, and how you can earn more by becoming a Pro blogger";
			break;
	}
?>
<section class="user-plan padding-bottom small-12 right">

<div class="user-plan-cont column small-12 padding-bottom padding-top">
	<div class="current-level small-5 inline left">
		<h2>Current Mob Level: <?php echo $moblevel; ?></h2>
	</div>
	<div class="mob-level-explanation small-6 inline left">
		<a href="<?php echo $config['this_admin_url'].'moblevels.php'; ?>">
			<p class="show-mob-levels"><?php echo $explanation; ?></p>
		</a>
	</div>
	<div class="arrow-level small-1 right">
		<a href="<?php echo $config['this_admin_url'].'moblevels.php'; ?>">
			<i class="fa 2x fa-caret-right"></i>
		</a>
	</div>
</div>

</section>