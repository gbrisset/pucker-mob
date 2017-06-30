<?php
	$admin = true;
	require_once('../../assets/php/config.php');
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body class="background-blue" id="how-it-words">
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right " role="main">
		<section class="row how-it-words-box">
			<div class="columns small-12" style="padding: 30px 20%;" >
				
				<h1 class="margin-bottom">HOW DO PUCKERMOB BLOGGERS EARN MONEY?</h1>


				<p>Unlike many other sites, we believe that writers should get paid for their work - if we benefit from the article that you write, so should you. You earn money on PuckerMob based on the amount of U.S.-based traffic that visits your articles. The more people who read your work, the more you get paid. </p>

<?php if(strtotime("now") < strtotime("2017-07-31")){  ?>

<p>      Starting July 01, 2017, our way to calculate your earnings has changed. </p>

	
<?php }//end if  ?>

				<p>At the start of each month, every blogger starts with zero views. As your articles attract more readers throughout the month, you’ll climb higher through a number of different levels. Each new level is determined by a specific amount of traffic, and each higher level rewards you with a higher set amount of money that you can earn. Whatever level you’re on at the end of the month will determine how much money you’ll make. </p>

				<p>For example, let’s say that in a given month, Level 4 pays out $80, and requires 50,000 total U.S. based views. If, by the end of the month, you’ve reach that minimum traffic level, then you’ll have earned $80 for that month. Higher levels pay more, and require higher levels of traffic. </p>

				<p>Level qualifications and payouts may change from month to month. Our bloggers typically earn more than they can earn on any other viral content site, and many of our bloggers who write often, understand our audience, stay involved in the community and market themselves aggressively make a significant amount of money each month.</p>

			</div>
		</section>
	</main>
	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
