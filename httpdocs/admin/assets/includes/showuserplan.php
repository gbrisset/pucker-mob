<?php 
	$moblevel = "Basic";
	
	switch($user_type){
		case 99:
		case 1:
		case 2:
			$moblevel = 'Admin';
			break;
		case 3:
			$moblevel = 'Basic';
			break;
		case 6:
		case 7:
			$moblevel = 'Writer';
			berak;
		case 8:
			$moblevel = 'Pro'; 
			break;
		case 9:
			$moblevel = 'Invited'; 
			break;
		case 0:
			$moblevel = 'Suspend'; 
			break;
		default:
			$moblevel = 'Basic';
			break;
	}
?>
<div class="user-plan" class="small-12 columns right">

	<div class="user-plan-cont column small-12 box-it-up">
		<div class="current-level">
			<label class="uppercase">Mob Level: <span><?php echo $moblevel; ?></span></label>
		</div>
	</div>

</div>