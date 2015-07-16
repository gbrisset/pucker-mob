

<div id="find-out-how" class="modalDialogFindOut" >
	<div id="popup-content" style="width:55% !important; min-width: 35rem; margin: 2% auto !important;">
			<a href="#close" title="Close" class="close">X</a>
			<div class="modal-img" style="background: none; padding: 0;">
				<a href="#">
					<img src="http://www.puckermob.com/assets/img/modelboximg/findouthow-popup.jpg"/>
				</a>
			</div>
		</div>
</div>

<script>

if($('#find-out-how')){

	$('.close').click(function(e){
		$('body').removeClass('show-modal-box-find-out');
	});


	$('#find-out-how').click(function(e){
		$('body').removeClass('show-modal-box-find-out');
	});

	$('#find-more-info').click(function(e){
		$('body').addClass('show-modal-box-find-out');
	});

}
</script>