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
  exdate.setHours(exdate.getHours() + exdays);
  var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
  document.cookie = name + "=" + c_value;
 
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

var cookie_name = "followers";

var res = retrieve_cookie(cookie_name);
if(res) {
  console.log('Cookie with name "' + cookie_name + '" value is ' + '"' +res + '"');
} else {
  console.log('Cookie with name "' + cookie_name + '" does not exist... Creating...');
  create_cookie(cookie_name, "seen", "/");
}

//var deleteParam = getParameterByName('delete');

//if(deleteParam && deleteParam.length > 0) delete_cookie(cookie_name);

var image = 'follow-auth-pop.jpg';

if(res != "seen") {
document.write('<div id="openModalFollowPopUp" class="modalDialogFollowPopUp">'+
		'<div id="popup-content">'+
			'<a href="" title="Close" class="close">X</a>'+
			'<div class="modal-img">'+
					'<img src="http://www.puckermob.com/assets/img/modelboximg/'+image+'"/>'+
			'</div>'+
		'</div>'+
	'</div>');
	
	$('body').addClass('show-modal-box-follow-popup');
}else{
	$('body').removeClass('show-modal-box-follow-popup');
}

if($('#openModalFollowPopUp')){

	$('.close').click(function(e){
		$('body').removeClass('show-modal-box-follow-popup');
	});

	$('#openModalFollowPopUp').click(function(e){
		$('body').removeClass('show-modal-box-follow-popup');
	});

}
</script>