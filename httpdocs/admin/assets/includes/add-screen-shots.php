
<?php if( $admin_user == true ){
//ONLY ADMINS CAN UPLOAD SCREEN SHOTS
?>
<div class="small-12 radius margin-bottom show-for-large-up" id="screen-shots-box">
	<div class="ss-label small-12 large-4 xxlarge-3 columns">
		<label>SCREEN SHOTS RECEIPTS: </label>
		<p>(Click to Enlarge)</p>
	</div>
	<div class="ss-box small-12 large-8 xxlarge-9 columns">
		<!-- DROPZONE IMAGE FORM -->
		<form action="upload.php"  class="dropzone" id="my-awesome-dropzone">
			<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
			<input type="hidden" id="c_i"  name="c_i" value="<?php echo $contributor_id; ?>" />
		</form>
	</div>
</div>
<?php }else{?>
<div class="small-12 radius margin-bottom" id="screen-shots-box" style="height: 6.5rem; overflow: hidden;">
	<div class="ss-label small-12 large-4 xxlarge-3 columns">
		<label>SCREEN SHOTS RECEIPTS: </label>
		<p>(Click to Enlarge)</p>
	</div>
	<div class="ss-box small-12 large-8 xxlarge-9 columns">
		<script>
		var contributor_id = <?php echo $contributor_id; ?>;
        var imageUrl = "<?php echo $config['image_url'].'articlesites/puckermob/admatching_ss/'; ?>";
        
        $.get('get_upload_ss.php?c_i='+contributor_id, function(data) {
 	
            $.each(data, function(key,value){
                 
                console.log(key, value, imageUrl+value['name']);
                var img = $('<img data-dz-thumbnail />').attr('src', imageUrl+value['name']).css('height', '5rem').css('width', '100%');
                var div = $('<div id="container"></div>').addClass('columns small-2 left').css('padding', '10px');

                $(img).appendTo(div);
                $(div).appendTo('.ss-box');
                 
            });
             
        });</script>
		
	</div>
</div>


<?php }?>
<a id="show-my-modal" class="hidden" href="#" data-reveal-id="myModal">Click Me For A Modal</a>
<div id="myModal" class="reveal-modal tiny" style="z-index:99999" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <img id="modal-image-active" src="" alt="" />
</div>
<script>
	
	$('body').on('click', 'img[data-dz-thumbnail]', function(e){ 
		$('#modal-image-active').attr('src', $(this).attr('src'));
		$('#show-my-modal').trigger('click');
	});
</script>