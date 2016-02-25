<!-- ANNOUNCEMENTS BOX -->
<?php 
	$annoucements = $ManageDashboard->getAnnouncements(); 
	
	 if(isset($annoucements) && $annoucements[0] && $annoucements[0]['notification_live']){ ?>
		<div id="announcements" class="announcements-box  mobile-12 small-12" style="MARGIN-BOTTOM: 1rem;">
			<div id="announcement-icon" class="">
				<i class="fa fa-3x fa-comments"></i>
			</div>
			<div id="announcement-txt" class="p-cont">
				<p>
					<?php echo $annoucements[0]['notification_msg']; ?>
				</p>
			</div>
		</div>
	<?php }?>