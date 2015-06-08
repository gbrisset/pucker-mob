<script>
/**
 * Create cookie with javascript
 *
 * @param {string} name cookie name
 * @param {string} value cookie value
 * @param {int} days2expire
 * @param {string} path
 */
function create_cookie(name, value, path) {
  var date = new Date();
  var exdays = 1;
  var exdate = new Date();
  //date.setTime(date.getTime()+(days*24*60*60*1000));
  exdate.setTime(date.getTime() + (exdays*24*60*60*1000));
  var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
  document.cookie = name + "=" + c_value +"; path=/";
 
 console.log('EXPIRES: '+c_value);
  //document.cookie = name + '=' + value + ';' +
  //                 'expires=' + expires + ';' +
  //                 'path=' + path + ';';

//setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/'); // 86400 = 1 day
}

/**
 * Retrieve cookie with javascript
 *
 * @param {string} name cookie name
 */
function retrieve_cookie(name) {
  var cookie_value = "",
    current_cookie = "",
    name_expr = name + "=",
    all_cookies = document.cookie.split(';'),
    n = all_cookies.length;
 
  for(var i = 0; i < n; i++) {
    current_cookie = all_cookies[i].trim();
    if(current_cookie.indexOf(name_expr) == 0) {
      cookie_value = current_cookie.substring(name_expr.length, current_cookie.length);
      break;
    }
  }
  return cookie_value;
}

/**
 * Delete cookie with javascript
 *
 * @param {string} name cookie name
 */
function delete_cookie(name) {
  document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

var cookie_name = "fb_like";

var res = retrieve_cookie(cookie_name);
if(res) {
  console.log('Cookie with name "' + cookie_name + '" value is ' + '"' +res + '"');
} else {
  console.log('Cookie with name "' + cookie_name + '" does not exist... Creating...');
  create_cookie(cookie_name, "seen", "/");
}

if(res != "seen") {

	document.write('<div id="openModalfacebook" class="modalDialogfacebook">'+
			'<div id="popup-content" style="width:20rem; min-width: 20rem;height: 100%;position: relative;">'+
				'<a href="#" title="Close" class="close" style="top: 39%; background:#000;z-index: 999;right: -65px;">X</a>'+
				'<div class="modal-img" style="top: 40%; position: absolute;">'+
				'<div class ="" style="background:white; padding:1rem;width: 23rem;">'+
				'<div class="fb-page" data-href="https://www.facebook.com/puckermob" data-hide-cover="false" data-show-facepile="false" data-show-posts="false">'+
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