<?php
	if(!$adminController->user->checkPermission('user_permission_show_player_settings')) $adminController->redirectTo('noaccess/');
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$updateStatus = $adminController->updatePlayerSettings($_POST);
			$mpArticle->reloadSiteData();
		}else $adminController->redirectTo('logout/');
	}
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
		
		<div id="content" class='site-settings'>
			<section id="player-settings">
				<header class="section-bar">
					<h2>Player Settings</h2>
				</header>

				<form class="ajax-submit-form" id="player-settings-form" name="player-settings-form" action="<?php echo $config['this_admin_url']; ?>site/player" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					
					<fieldset>
						<label class="radio-button-label-parent">Debug<span>*</span> :</label>

						<input type="radio" name="player_setting_debug" id="player_setting_debug_on" value="player_setting_debug_on" <?php if(isset($mpArticle->data['player_setting_debug']) && $mpArticle->data['player_setting_debug'] == 1) echo "checked"; ?> />
						<label for="player_setting_debug_on" class="radio-label">On</label>
						
						<input type="radio" name="player_setting_debug" id="player_setting_debug_off" value="player_setting_debug_off" <?php if(isset($mpArticle->data['player_setting_debug']) && $mpArticle->data['player_setting_debug'] == 0) echo "checked"; ?> />
						<label for="player_setting_debug_off" class="radio-label">Off</label>
					</fieldset>

					<fieldset>
						<label class="radio-button-label-parent">Autoplay<span>*</span> :</label>

						<input type="radio" name="player_setting_autoplay" id="player_setting_autoplay_on" value="player_setting_autoplay_on" <?php if(isset($mpArticle->data['player_setting_autoplay']) && $mpArticle->data['player_setting_autoplay'] == 1) echo "checked"; ?> />
						<label for="player_setting_autoplay_on" class="radio-label">On</label>
						
						<input type="radio" name="player_setting_autoplay" id="player_setting_autoplay_off" value="player_setting_autoplay_off" <?php if(isset($mpArticle->data['player_setting_autoplay']) && $mpArticle->data['player_setting_autoplay'] == 0) echo "checked"; ?> />
						<label for="player_setting_autoplay_off" class="radio-label">Off</label>
					</fieldset>

					<fieldset>
						<label class="radio-button-label-parent">Randomize Playlist<span>*</span> :</label>

						<input type="radio" name="player_setting_randomize_playlist" id="player_setting_randomize_playlist_on" value="player_setting_randomize_playlist_on" <?php if(isset($mpArticle->data['player_setting_randomize_playlist']) && $mpArticle->data['player_setting_randomize_playlist'] == 1) echo "checked"; ?> />
						<label for="player_setting_randomize_playlist_on" class="radio-label">On</label>
						
						<input type="radio" name="player_setting_randomize_playlist" id="player_setting_randomize_playlist_off" value="player_setting_randomize_playlist_off" <?php if(isset($mpArticle->data['player_setting_randomize_playlist']) && $mpArticle->data['player_setting_randomize_playlist'] == 0) echo "checked"; ?> />
						<label for="player_setting_randomize_playlist_off" class="radio-label">Off</label>
					</fieldset>

					<fieldset>
						<label class="radio-button-label-parent">Click to Kill<span>*</span> :</label>

						<input type="radio" name="player_setting_countoff_start" id="player_setting_countoff_start_on" value="player_setting_countoff_start_on" <?php if(isset($mpArticle->data['player_setting_countoff_start']) && $mpArticle->data['player_setting_countoff_start'] == 1) echo "checked"; ?> />
						<label for="player_setting_countoff_start_on" class="radio-label">On</label>
						
						<input type="radio" name="player_setting_countoff_start" id="player_setting_countoff_start_off" value="player_setting_countoff_start_off" <?php if(isset($mpArticle->data['player_setting_countoff_start']) && $mpArticle->data['player_setting_countoff_start'] == 0) echo "checked"; ?> />
						<label for="player_setting_countoff_start_off" class="radio-label">Off</label>
					</fieldset>

					<fieldset>
						<label class="radio-button-label-parent">Show Ads<span>*</span> :</label>

						<input type="radio" name="player_setting_withads" id="player_setting_withads_on" value="player_setting_withads_on" <?php if(isset($mpArticle->data['player_setting_withads']) && $mpArticle->data['player_setting_withads'] == 1) echo "checked"; ?> />
						<label for="player_setting_withads_on" class="radio-label">On</label>
						
						<input type="radio" name="player_setting_withads" id="player_setting_withads_off" value="player_setting_withads_off" <?php if(isset($mpArticle->data['player_setting_withads']) && $mpArticle->data['player_setting_withads'] == 0) echo "checked"; ?> />
						<label for="player_setting_withads_off" class="radio-label">Off</label>
					</fieldset>

					<fieldset>
						<label class="radio-button-label-parent">Pre Rolls<span>*</span> :</label>

						<input type="radio" name="player_setting_prerolls" id="player_setting_prerolls_on" value="player_setting_prerolls_on" <?php if(isset($mpArticle->data['player_setting_prerolls']) && $mpArticle->data['player_setting_prerolls'] == 1) echo "checked"; ?> />
						<label for="player_setting_prerolls_on" class="radio-label">On</label>
						
						<input type="radio" name="player_setting_prerolls" id="player_setting_prerolls_off" value="player_setting_prerolls_off" <?php if(isset($mpArticle->data['player_setting_prerolls']) && $mpArticle->data['player_setting_prerolls'] == 0) echo "checked"; ?> />
						<label for="player_setting_prerolls_off" class="radio-label">Off</label>
					</fieldset>

					<fieldset>
						<label class="radio-button-label-parent">Post Rolls<span>*</span> :</label>

						<input type="radio" name="player_setting_postrolls" id="player_setting_postrolls_on" value="player_setting_postrolls_on" <?php if(isset($mpArticle->data['player_setting_postrolls']) && $mpArticle->data['player_setting_postrolls'] == 1) echo "checked"; ?> />
						<label for="player_setting_postrolls_on" class="radio-label">On</label>
						
						<input type="radio" name="player_setting_postrolls" id="player_setting_postrolls_off" value="player_setting_postrolls_off" <?php if(isset($mpArticle->data['player_setting_postrolls']) && $mpArticle->data['player_setting_postrolls'] == 0) echo "checked"; ?> />
						<label for="player_setting_postrolls_off" class="radio-label">Off</label>
					</fieldset>

					<fieldset>
						<label for="player_setting_ad_server_key-s">Adap.TV Ad Server Key<span>*</span> :</label>
						<input type="text" name="player_setting_ad_server_key-s" id="player_setting_ad_server_key-s" placeholder="Please enter the site's ad server key here." value="<?php if(isset($mpArticle->data['player_setting_ad_server_key'])) echo $mpArticle->data['player_setting_ad_server_key']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'player_setting_ad_server_key') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the ad server key provided by Adap.TV for the site.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="player_setting_ad_server_keywords-s">Adap.TV Keywords<span>*</span> :</label>
						<input type="text" name="player_setting_ad_server_keywords-s" id="player_setting_ad_server_keywords-s" placeholder="Please enter the site's ad server keywords here." value="<?php if(isset($mpArticle->data['player_setting_ad_server_keywords'])) echo $mpArticle->data['player_setting_ad_server_keywords']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'player_setting_ad_server_keywords') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>These are the keywords that the player provides to the ad server to allow targetting.  Multiple keywords should be separated by a comma, without any spaces.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="player_setting_ad_server_categories-s">Adap.TV Categories<span>*</span> :</label>
						<input type="text" name="player_setting_ad_server_categories-s" id="player_setting_ad_server_categories-s" placeholder="Please enter the site's ad server categories here." value="<?php if(isset($mpArticle->data['player_setting_ad_server_categories'])) echo $mpArticle->data['player_setting_ad_server_categories']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'player_setting_ad_server_categories') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>These are the categories that the player provides to the ad server to allow targetting.  Multiple categories should be separated by a comma, without any spaces.</p>
							</div>
						</div>
					</fieldset>
					
					<fieldset>
						<div class="btn-wrapper">
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'player-settings-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'player-settings-form') echo $updateStatus['message']; ?>
							</p>

							<button type="submit" id="submit" name="submit">Submit</button>
						</div>
					</fieldset>
				</form>
			</section>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>