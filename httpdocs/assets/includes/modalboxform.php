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

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

if(deleteParam && deleteParam.length > 0) delete_cookie(cookie_name);

var image = 'BeCos_Popup.png';
if($('body').hasClass('mobile'))  image = 'BeCos_Popup_Mobile.png';
if(res != "seen") {
document.write(
  '<div id="openModal" class="modalDialog">'+
		'<div id="popup-content">'+
			'<a href="#close" title="Close" class="close">X</a>'+
			'<div class="modal-img">'+
					'<img src="http://www.puckermob.com/assets/img/modelboximg/Girl-Meets-World-Pop-Up.png" alt=""/>'+
		  '</div>'+
      '<div class="small-12 modal-input"'+
        '<form method="POST" action="" >'+
          '<input type="hidden" value="4653" id="articleId" name ="articleId" />'+
          '<input class="small-4 email" type="text" name="email" id="email" placeholder="ENTER EMAIL ADDRESS">'+
          '<input class="small-3" type="button" id="submit" value="SIGN UP!"></div>'+
			  '</form>'+
          '<div class="small-12 modal-results" style="display:none;"'+
        '<p></p>'+
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

  $('#submit').click(function(e){
    var msg_return = "";
    var msg_el = $('.modal-results').find('p');
    var msg_class = 'sucess';
    var self  = this;

    if( IsEmail($('#email').val()) ){
     
        $.ajax({
          type: "POST",
          url: "<?php echo $config['this_url']?>assets/ajax/subscribers.php",
          data: { articleId: $('#articleId').val(), email: $('#email').val()}
        })
          .done(function( msg ) {
        
            if(msg  == 1) {

               msg_return = "Email added successfully!";
               msg_class = 'success';

            }else{
              msg_return = "There was an error, please try again.";
              msg_class = 'error';
            }

            if(msg_class == 'error')  $(msg_el).html(msg_return).removeClass('success').addClass(msg_class);
            else  $(msg_el).html(msg_return).removeClass('error').addClass(msg_class);

            $('.modal-results').show();
          });
   
    }else{
      msg_return = "Please, insert a valid email address!";
      msg_class = "error";
    }
     if(msg_class == 'error')  $(msg_el).html(msg_return).removeClass('success').addClass(msg_class);
     else  $(msg_el).html(msg_return).removeClass('error').addClass(msg_class);

      $('.modal-results').show();
  });

	$('#openModal').click(function(e){
		//$('body').removeClass('show-modal-box');
	});




}
</script>