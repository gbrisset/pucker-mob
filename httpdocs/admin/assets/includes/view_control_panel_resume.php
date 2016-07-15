<?php
	 $ManageDashboard = new ManageAdminDashboard( $config );
	 $current_month = date('n');
	 $current_year = date('Y');
	
	//GET WRITER TRAFFIC
	//WRITERS EARNINGS
	//BOOGLER TRAFFIC
	//BLOGGER EARNINGS
						

?>

<div class="small-12 columns no-padding-right half-margin-bottom show-for-large-up">
	<div  class="small-12 large-4 xlarge-3 columns  no-padding ">
		<div style="background-color: #7BB583; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">WRITER TRAFFIC</h3>
				<span class="bold"><?php echo number_format(100); ?></span>
			</div>
		</div>
	</div>
	<div  class="small-12 large-4 xlarge-3 columns ">
		<div style="background-color: #867BB5; " class="small-12 columns articles_resume radius valign-middle" >
			<div class="small-12 columns ">
				<h3 class="uppercase">Writer Earnings</h3>
				<span class="bold"><?php echo '$'.number_format( 1000, 2); ?></span>
			</div>
		</div>		
	</div>
	<div class="small-12 large-4 xlarge-3 columns  no-padding">
		<div style="background-color: #D79324; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">Blogger Traffic</h3>
				<span class="bold"><?php echo number_format(10000); ?></span>
			</div>
		</div>
	</div>
	<div  class="small-12 large-3 columns  show-for-xlarge-up ">
		<div style="background-color: #3593C6; " class="small-12 columns articles_resume radius valign-middle">
			<div class="small-12 columns ">
				<h3 class="uppercase">Blooger Earnings</h3>
				<span class="bold" ><?php echo '$'. number_format(1000, 2) ?></span>
			</div>
		</div>
	</div>
</div>