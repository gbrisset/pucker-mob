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

/*ADS FUNCTIONALITIES*/
//Load and Insert the Ad in an IFRAME
function loadAd(target, adcode) {
    if(target != null ){
        var iframe = document.createElement('iframe');
        iframe.id=target.id + '-iframe';
        iframe.className="ad-unit hide-for-print";
        iframe.scrolling="no";
        iframe.height="0";
        var child = target.appendChild(iframe);
        var content = child.contentWindow.document;
        content.open().write('<body style="margin: 0; padding: 0; text-align: center !important;"><style>* {text-align: center !important; margin: 0 auto !important;}</style>' + adcode + '<script type="text/javascript" src="' + iFrameResizerJS +'"></script>');
        content.close();
    }
}

//Load Branovate Player
function loadBranovateAd(target, adcode) {
    if(target != null ){
        var iframe = document.createElement('iframe');
        iframe.id=target.id + '-iframe';
        iframe.className="columns no-padding";
        iframe.scrolling="no";
        iframe.height="250";
        //iframe.width="250";
        var child = target.appendChild(iframe);
        var content = child.contentWindow.document;
        content.open().write('<body style="margin: 0; padding: 0; text-align: center !important;"><style>* {text-align: center !important; margin: 0 auto !important; width: 250px;}</style>' + adcode );
        content.close();
    }
}

//Load An Script
function loadScript(url, callback){
    var script = document.createElement("script")
    script.type = "text/javascript";

    if (script.readyState){  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                script.readyState == "complete"){
                script.onreadystatechange = null;
            }
        };
    } else { 
        script.onload = function(){
            console.log("load script");
        };
    }
    script.src = url;
    $("body").append(script);
};

//LOAD IN-STREAM ADS
var inBodyAd = {
    inserDivAdTag: function(target, adcode){
        $(adcode).appendTo(target);
    },
    insertElement: function(target, id, elm, elClass) {
        var div = $('<'+elm+'></'+elm+'>')
        div.addClass(elClass);
        div.attr('id', id);
        $(target).after(div);
    },
    loadInArticleAd: function( content, position, iframe, ad, elm ){
        if(elm == 'li') var tag = $('#'+content).find(elm);
        else var tag = $('#'+content).find(elm);
        var index = 0,
        totalTag= $(tag).length,
        this_obj = this;

        if(totalTag > 0 && totalTag >= position){
            tag.each( function(){
               index++;
                if( index === position ){
                    if($('body').hasClass('mobile')) {
                        if(elm == 'li') this_obj.insertElement($(this), 'inarticle'+index+'-ad', 'div', ' inarticle-ad ad-unit hide-for-print' );
                        else this_obj.insertElement($(this), 'inarticle'+index+'-ad', 'div', 'row inarticle-ad ad-unit hide-for-print' );
                    }else{
                        this_obj.insertElement($(this), 'inarticle'+index+'-ad', 'div', 'row inarticle-ad ad-unit hide-for-print no-padding margin-bottom ad-unit' );
                    }
                    if(iframe) loadAd(document.getElementById('inarticle'+index+'-ad'), ad);    
                    else this_obj.inserDivAdTag(document.getElementById('inarticle'+index+'-ad'), ad);
                }
            });
        }
    }
};

//APPEND ADS END OF body
function appendAdEndBody( src, dest, delay ){
    var content = $(src).find('#get-content');
    setTimeout(function(){
        $(content).appendTo($(dest));
        $(src).remove();
    }, delay );
}

//COOKIES
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
            if (getCookie(name)) createCookie(name, "", -1, path, domain);
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