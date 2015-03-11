<?php
  //Header("content-type: application/x-javascript");
  //require_once('../../assets/php/config.php');
?>
<script>


//$facebook = new Facebook(array(
//	'appId' => '1380320725609568',
//	'secret' => '1660831cfa198d28dcfc1748454e4ca7'
//));
//LOCALHOST:
//appid: 781998645209691
//secret: b6e49247747c6c667c6dfb167dc0ea70
  
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      getUserInfoAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
     // document.getElementById('status').innerHTML = 'Please log ' +
      //  'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      //document.getElementById('status').innerHTML = 'Please log ' +
       // 'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    console.log("checkLoginState");
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '781998645209691',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  //FB.getLoginStatus(function(response) {
   // statusChangeCallback(response);
  //});

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function getUserInfoAPI() {
    FB.api('/me', function(response) {
    //  console.log(response);

      if(response && response.id != null && response.id.length > 0 ){
         registerUser(response);
      }
    });

 }

 /* function registerUser(response){
      var isReader = false;
      if($('#isReader')) isReader = $('#isReader').val();
     
      $.ajax({
        type: "POST",
        url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
        data: { user: response, task:'register_fb', isReader: isReader}
      }).done(function(data) {
        if(data){
          data = JSON.parse(data);
           console.log(data);
          if(!data['hasError']){
            setTimeout(function() {window.location = "<?php echo $config['this_admin_url']; ?>";}, 200);
        }
      }
    });
  }*/

    function registerUser(response){
    var isreader = false, author_id = 0;
    if($('#isReader').length > 0){
      isreader = true;
      author_id = $('#author-id').val();
    }

      $.ajax({
        type: "POST",
        url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
        data: { user: response, task:'register_fb', isReader:isreader, author_id : author_id}
      }).done(function(data) {
        if(data){
          data = JSON.parse(data);
          
          if( isreader ){
            if( !data['hasError'] ){
              var email = data['email'],
              container = $('#follow-the-author-bg');
              $('#ss_user_email').val(email);
              
              $(container).html('<label class="follow-author" ><i class="fa fa-check"></i>Author Followed</label>');
              $('body').removeClass('show-modal-box');
              $('.top-header-logout').find('.welcome-email span').html('Welcome, '+email);
              $('.top-header-logout').find('#image-header-profile').attr('src', data['user_img']);
              $('.top-header-login').attr('style', 'display:none !important');
              $('.top-header-logout').attr('style', 'display:inherit !important');
              $('#follow-msg').html(data['message']);
              $('#my-account-header-link').attr('href', 'http://www.puckermob.com/admin/following/');
              $('body').addClass('show-modal-box-follow');
            }else{
                $('#register-result').html(data['message']).attr('style', 'color:red; text-transform: inherit;');
            }
          }else{
            if(!data['hasError']){
             setTimeout(function() {window.location = "<?php echo $config['this_admin_url']; ?>";}, 200);
          }
        }
      }
    });
  }
/*console.log(msg);
                if(msg['hasError']) $('#login-result').html(msg['message']).attr('style', 'color:red; text-transform: inherit;');
                else{
                    var email = msg['email'],
                    container = $('#follow-the-author-bg');
                    $('#ss_user_email').val(msg);

                    $(container).html('<label class="follow-author" ><i class="fa fa-check"></i>Author Followed</label>');
                    $('body').removeClass('show-modal-box');
                    $('.top-header-logout').find('.welcome-email span').html('Welcome, '+email);
                    $('.top-header-logout').find('#image-header-profile').attr('src', msg['user_img']);
                    $('.top-header-login').attr('style', 'display:none !important');
                    $('.top-header-logout').attr('style', 'display:inherit !important');
                    $('#follow-msg').html(msg['message']);
                    $('#my-account-header-link').attr('href', 'http://www.puckermob.com/admin/following/');
                    $('body').addClass('show-modal-box-follow');
                }*/
  
</script>