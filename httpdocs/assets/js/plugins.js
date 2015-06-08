$.fn.dynamicLoginContent = function(){
    return this.each(function(){
        var self = $(this),
        task = $(self).attr('data-info-task'),
        url = "http://www.puckermob.com/assets/ajax/ajaxmultifunctions.php";
      
        var email =  $(self).find('input#email').val(),
        password = $(self).find('input#password').val(),
        author_id = $(self).find('#author-id').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: { task: task, user_login_input: email, user_login_password_input: password, author_id:author_id},
            url: url,
            
            success: function (msg) {
                console.log(msg);
                if(msg['hasError']) $('#login-result').html(msg['message']).attr('style', 'color:red; text-transform: inherit;');
                else{
                    var email = msg['email'],
                    container = $('#follow-the-author-bg');
                    $('#ss_user_email').val(email);

                    $(container).html('<label class="follow-author" ><i class="fa fa-check"></i>Author Followed</label>');
                    $('body').removeClass('show-modal-box');
                    $('.top-header-logout').find('.welcome-email span').html('Welcome, '+email);
                    $('.top-header-logout').find('#image-header-profile').attr('src', msg['user_img']);
                    $('.top-header-login').attr('style', 'display:none !important');
                    $('.top-header-logout').attr('style', 'display:inherit !important');
                    $('#follow-msg').html(msg['message']);
                    $('#my-account-header-link').attr('href', 'http://www.puckermob.com/admin/following/');
                    $('body').addClass('show-modal-box-follow');
                     $('.hide-for-readers').css('display', 'none');
                }
            }
     });
        
    });
};

$.fn.dynamicRegisterContent = function(){
    return this.each(function(){
        var self = $(this),
        task = $(self).attr('data-info-task'),
        url = "http://www.puckermob.com/assets/ajax/ajaxmultifunctions.php";
       
        var email =  $(self).find('input#email').val(),
        password = $(self).find('input#password').val(),
        name = $(self).find('input#name').val(),
        author_id = $(self).find('#author-id').val(),
        g_recaptcha_response = $(self).find('#g-recaptcha-response').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: { task: task, user_email: email, user_password: password, author_id:author_id, name:name, isReader:'true', recaptcha: g_recaptcha_response},
            url: url,

            success: function (msg) {
                console.log(msg);
                if(msg['hasError']) $('#register-result').html(msg['message']).attr('style', 'color:red; text-transform: inherit;');
                else{
                   var email = msg['email'],
                    container = $('#follow-the-author-bg');
                    $('#ss_user_email').val( msg['email'] );

                    $(container).html('<label class="follow-author" ><i class="fa fa-check"></i>Author Followed</label>');
                    $('body').removeClass('show-modal-box');
                    $('.top-header-logout').find('.welcome-email span').html('Welcome, '+email);
                    $('.top-header-logout').find('#image-header-profile').attr('src', msg['user_img']);
                    $('.top-header-login').attr('style', 'display:none !important');
                    $('.top-header-logout').attr('style', 'display:inherit !important');
                    $('#follow-msg').html(msg['message']);
                    $('#my-account-header-link').attr('href', 'http://www.puckermob.com/admin/following/');
                    $('body').addClass('show-modal-box-follow');
                    $('.hide-for-readers').css('display', 'none');

                }
            }
        });
        
    });
};

var ManageCookies = (function() {
    return {
        retrieveCookie:   function( name ){
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
          console.log(name+": "+cookie_value);
          return cookie_value;
        },
        createCookie:   function (name,value,days) {

          var date = new Date();
          var exdays = days;
          var exdate = new Date();

          exdate.setTime(exdate.getTime()+(days*24*60*60*1000));
          var expires = "; expires="+exdate.toGMTString();
      
          document.cookie = name+"="+value+expires;
          console.log( document.cookie);
        
        },
        
        delete: function(name){
            document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
        },

        getParameterByName: function(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    }

}());