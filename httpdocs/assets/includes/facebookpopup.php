<script>
var cookie_name = 'like';
var res = ManageCookies.getCookie(cookie_name);

if(res) {
  console.log('Cookie with name "' + cookie_name + '" value is ' + '"' +res + '"');
} else {
  console.log('Cookie with name "' + cookie_name + '" does not exist... Creating...');
  ManageCookies.createCookie(cookie_name, 'seen', 1);
}
if(res != "seen") {
	document.write('<div id="openModalfacebook" class="modalDialogfacebook">'+
			'<div id="popup-content" style="width:20rem; min-width: 20rem;height: 100%;position: relative;">'+
				'<a href="#" title="Close" class="close" style="top: 34%; background:#000;z-index: 999;right: -65px;">X</a>'+
				'<div class="modal-img" style="top: 35%; position: absolute;">'+
				'<div class ="" style="background:white; padding:1rem;width: 23rem;">'+
				'<div class="fb-page" data-href="https://www.facebook.com/puckermob" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">'+
				'<div class="fb-xfbml-parse-ignore">'+
				'<blockquote cite="https://www.facebook.com/puckermob">'+
				'<a href="https://www.facebook.com/puckermob">PuckerMob</a>'+
				'</blockquote>'+
				'</div>'+
				'</div>'+
				'</div>'+
			'</div>'+
		'</div>'
	);

	$('body').addClass('show-modal-box-facebook');
}else{
	$('body').removeClass('show-modal-box-facebook');
}

if($('#popup-content')){
	$('.close').click(function(e){
		e.preventDefault();
		$('body').removeClass('show-modal-box-facebook');
	});

	$('#openModalfacebook').click(function(e){
		e.preventDefault();
		$('body').removeClass('show-modal-box-facebook');
	});
}
</script>