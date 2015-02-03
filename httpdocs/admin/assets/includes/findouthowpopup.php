

<div id="openModal2" class="modalDialog" >
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

if($('#openModal2')){

	$('.close').click(function(e){
		$('body').removeClass('show-modal-box');
	});


	$('#openModal2').click(function(e){
		$('body').removeClass('show-modal-box');
	});

	$('#find-more-info').click(function(e){
		$('body').addClass('show-modal-box');
	});

}
</script>