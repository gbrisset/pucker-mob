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
  date.setTime(date.getTime() + ( 9 * 24 * 60 * 60 * 1000));
  var expires = date.toUTCString();
  console.log('EXPIRES: '+expires);
  document.cookie = name + '=' + value + ';' +
                   'expires=' + expires + ';' +
                   'path=' + path + ';';
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

var cookie_name = "beCos";

var res = retrieve_cookie(cookie_name);
if(res) {
  console.log('Cookie with name "' + cookie_name + '" value is ' + '"' +res + '"');
} else {
  console.log('Cookie with name "' + cookie_name + '" does not exist... Creating...');
  create_cookie(cookie_name, "seen", "/");
}

var deleteParam = getParameterByName('delete');

if(deleteParam && deleteParam.length > 0) delete_cookie(cookie_name);

var image = 'BeCos_Popup.png';
if($('body').hasClass('mobile'))  image = 'BeCos_Popup_Mobile.png';
if(res != "seen") {
document.write('<div id="openModal" class="modalDialog">'+
		'<div id="popup-content">'+
			'<a href="#close" title="Close" class="close">X</a>'+
			'<div class="modal-img">'+
				'<a href="https://www.change.org/p/tv-land-be-cos-reinstate-cosby-s-shows-don-t-prosecute-based-on-accusations#" target="blank">'+
					'<img src="http://www.puckermob.com/assets/img/'+image+'" alt="Be Cos"/>'+
				'</a>'+
			'</div>'+
		'</div>'+
	'</div>');
	
	$('body').addClass('show-modal-box');
}else{
	$('body').removeClass('show-modal-box');
}

if($('#openModal')){

	$('.close').click(function(e){
		$('body').removeClass('show-modal-box');
	});

	$('#openModal').click(function(e){
		$('body').removeClass('show-modal-box');
	});

}
</script>