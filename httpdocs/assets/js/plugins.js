$.fn.dynamicLoginContent = function(){
    return this.each(function(){
        var self = $(this),
        task = $(self).attr('data-info-task'),
        url = "http://localhost:8888/projects/pucker-mob/httpdocs/assets/ajax/ajaxmultifunctions.php";
        //data = $(self).serialize();
      //  console.log(task,data);
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
                    $('#author-action-message').html(msg['message']).attr('style', 'color:green; text-transform: inherit;');
                    $('body').removeClass('show-modal-box');
                    $('.top-header-login').attr('style', 'display:none !important');
                    $('.top-header-logout').attr('style', 'display:inherit !important');
                }
            }
     });
        
    });
};

$.fn.dynamicRegisterContent = function(){
    return this.each(function(){
        var self = $(this),
        task = $(self).attr('data-info-task'),
        url = "http://localhost:8888/projects/pucker-mob/httpdocs/assets/ajax/ajaxmultifunctions.php";

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
                    $('#author-action-message').html(msg['message']).attr('style', 'color:green; text-transform: inherit;');
                    $('body').removeClass('show-modal-box');
                    $('.top-header-login').hide();
                    $('.top-header-logout').show();
                }
            }
        });
        
    });
};