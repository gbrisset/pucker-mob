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
        createCookie: function(name,value,days) {
          if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
          }
          else var expires = "";
          document.cookie = name+"="+value+expires+"; path=/";
        },

        deleteCookie: function(name, path, domain) {
          if (getCookie(name))
            createCookie(name, "", -1, path, domain);
        },

        getCookie: function(name) {
          var nameEQ = name + "=";
          var ca = document.cookie.split(';');
          for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
          }
          return null;
        }
    }

}());