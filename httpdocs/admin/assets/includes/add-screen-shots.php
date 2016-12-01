<?php if( $admin_user === true ){?>
<div class="small-12 radius margin-bottom" id="screen-shots-box">
	<div class="ss-label small-12 large-4 xxlarge-3 columns">
		<label>SCREEN SHOTS RECEIPTS: </label>
		<p>(Click to Enlarge)</p>
	</div>
	<div class="ss-box small-12 large-8 xxlarge-9 columns">
		<form action="upload.php"  class="dropzone" id="my-awesome-dropzone">
			<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
			<input type="hidden" id="c_i"  name="c_i" value="<?php echo $contributor_id; ?>" />
		</form>
	</div>
</div>
<?php }else{?>
<div class="small-12 radius margin-bottom" id="screen-shots-box">
	<div class="ss-label small-12 large-4 xxlarge-3 columns">
		<label>SCREEN SHOTS RECEIPTS: </label>
		<p>(Click to Enlarge)</p>
	</div>
	<div class="ss-box small-12 large-8 xxlarge-9 columns">
	</div>
</div>
<?php }?>