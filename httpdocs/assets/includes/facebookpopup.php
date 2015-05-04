<script>
/*var cookie_name = "facebook_pp";
var deleteParam = manageCookies.getParameterByName('delete');

if(deleteParam && deleteParam.length > 0) manageCookies.deleteCookie(cookie_name);

var res = manageCookies.manageCookie(cookie_name);
*/
var image = 'likeus-mobile.jpg';

//if(res != "seen") {
document.write('<div id="openModal" class="modalDialog">'+
		'<div id="popup-content" style="width:25%; min-width: 20rem;">'+
			'<a href="" title="Close" class="close" style="top: -10px; background:#000;">X</a>'+
			'<div class="modal-img">'+
				'<a href="">'+
					'<img src="http://www.puckermob.com/assets/img/modelboximg/'+image+'"/>'+
				'</a>'+
			'</div>'+
		'</div>'+
	'</div>');
	
	$('body').addClass('show-modal-box');
//}else{
//	$('body').removeClass('show-modal-box');
//}
</script>