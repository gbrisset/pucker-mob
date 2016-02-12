<<<<<<< HEAD
$(document).foundation();
var aside = Foundation.utils.S('#aside');
var poparticles = Foundation.utils.S("#popular-articles");
var subsidebar = Foundation.utils.S("#sub-sidebar-2");
var subsidebar3 = Foundation.utils.S("#sub-sidebar-3");
var main = Foundation.utils.S('#main');
var leftSide = Foundation.utils.S('#puc-articles');
var base_url = 'http://www.puckermob.com';
var URL = $(location).attr('href');
var page = document.body.id;
//var country =ManageCookies.getCookie('country');
var body = document.body;


var isIE11 = !!navigator.userAgent.match(/Trident.*rv\:11\./);
if(isIE11){
	main.css("display", "block");
}

$(document).ready(function() {
	
	if(page != 'articleslide' && page != 'home' && page != 'category' && page != 'article' && page != 'distroscale') {var adPage = 'category';} else {var adPage = page;}

	//READ MORE 
	if($('body').hasClass('mobile')) {
		/*var $el, $ps, $up, totalHeight;
		var parentOrgHeight = $('#article-content').outerHeight();

		var pct_to_show = parseInt($('#read_more_pct').val());
		var height_value = pct_to_show / 100 ;
		var wishDisplayHeight = parentOrgHeight * height_value;*/

		$("#read-more-img").on('click', function(e) {
			e.preventDefault();		
			e.stopPropagation();
			$el = $(this);
			$parent_div  = $('.read-more');
			$content = $('#article-content');
											
			$content.css({
				"height": $content.height(),
				"max-height": 999999
			 });

			$content.animate({
				"height": "auto"
			 },2000);
						
			$parent_div.fadeOut();
			$('.second-section').css('border-top', '2px solid #bbb');
							
			// prevent jump-down
			return false;
							
		});
	}

	function resizeContentByscreenSize(){
		//HIDE LEFT SIDE BAR WHEN BROWSER IS LESS THAT 1030 px.
		if( $(window).width() < 1090 && $(window).width() > 1030 ){
			$('#left-aside').hide();
			if(page === 'home'){
				if( $("#has-sponsored-by").val() == '0') $('#aside').attr('style', 'right:2%;');
				else $('#aside').attr('style', 'right:0;');
			}else{
				$('#aside').attr('style', 'right:2%;');
			}
		}else if( $(window).width() < 1030 ){
			$('#left-aside').hide();
			if(page === 'home'){
				if( $("#has-sponsored-by").val() == '0') $('#aside').attr('style', 'right:1%;');
				else $('#aside').attr('style', 'right:0;');
			}else{
				$('#aside').attr('style', 'right:1%;');
			}
		}else {
			$('#left-aside').show();
			if(page === 'home'){
				if( $("#has-sponsored-by").val() == '0') $('#aside').attr('style', 'right:103px;');
				else $('#aside').attr('style', 'right:103px;');
			}else{
				$('#aside').attr('style', 'right:103px;');
			}
		}
	}	
	resizeContentByscreenSize();

	$('.facebook-comments-button').on('click', function(e){
		if( $('#disqus-comments').hasClass('hide')){
			$('#disqus-comments').removeClass('hide');
			$('#disqus-comments').slideDown(500);
		}else{
			$('#disqus-comments').addClass('hide');
			$('#disqus-comments').slideUp(500);
		}
	});

	//INFINITY SCROLL DOWN
	$('#articlelist-wrapper').scrollPagination({
		nop     : 25,
		offset  : 25, 
		error   : 'No More Articles!',
		delay   : 200,
		scroll  : true, 
	    page    : 1
	});

	//SCROLL DOWN MOST POPULAR ARTICLES
	if(page == 'article'){
		$('#second-popular-articles').scrollPagination({
			nop     : 25,
			offset  : 25,
			error   : 'No More Articles!',
			delay   : 200, 
			scroll  : true,
			page    : 2 
		});
	}

	/* slide menu left */
	if( $( ".toggle-slide-left" ).length > 0){
	    $( ".toggle-slide-left" ).on( "click", function(){
			$(body).toggleClass("sml-open");
			$(this).toggleClass("open-menu");
			$('#slide-menu-left-div').toggleClass("full-height");
	    });
	}

	$('#menu-options li').on('click', function(e){
		e.preventDefault();
		var this_li = $(this);
		var this_a = $(this_li).find('a').attr('id');
		var div_cont = $('.slide-menu-left').find("[data-info='" + this_a + "']");
		$('.tap-articles').hide();
		$('#menu-options').find('a').removeClass('current');
		$(div_cont).show();
		$('#'+this_a).addClass('current');
	});	

<<<<<<< HEAD
=======

	function resizeMainOnResize() {
		resizeContentByscreenSize();
		//asideHeight.trending = trendingNowHeight;
		//asideHeight.popular = poparticles.height();
		if(!$('body').hasClass('mobile')) {
			totalHeight = 5400;//3938;
			//if( page == "videos") totalHeight += 80;
			//leftSide.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
			//main.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
		}
	}

	function resizeMainOnAdLoad() {
		//asideHeight.trending = trendingNowHeight;
		//asideHeight.popular = poparticles.height();
		resizeContentByscreenSize();
		totalHeight = 5400;//3938;
		//if( page == "videos") totalHeight += 80;
		if(!$('body').hasClass('mobile')) {
			//leftSide.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
			//main.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
		}
	}

>>>>>>> e74923f4e7758a668a89cd2ecb17b80121e5f7f3
	if($('body').hasClass('mobile')) {
		//HIDE LEFT SIDE BAR WHEN BROWSER IS LESS THAT 1030 px.
		if( $(window).width() < 1050 ) $('#left-aside').hide();
		else $('#left-aside').show();
	}

	Foundation.utils.S('#around-the-web a').attr('target', '_blank');
	var topbar_search_contents = Foundation.utils.S('#topbar-search-contents');
	var topbar_search_submit = Foundation.utils.S('#topbar-search-submit');
	var topbar_search_contents_login = Foundation.utils.S('#topbar-search-contents-login');
	var topbar_search_submit_login = Foundation.utils.S('#topbar-search-submit-login');
	var notfound_search_contents = Foundation.utils.S('#notfound-search-contents');
	var notfound_search_submit = Foundation.utils.S('#notfound-search-submit');
	
	// Search handlers
	topbar_search_submit.click(function() {
		var search_input = $(this).parent().find('#topbar-search-contents').val();
		var url = base_url+'/search/?q='+search_input;
		window.location.href = url;
	});

	topbar_search_contents.keypress(function(e) {
		if(e.keyCode == 13) {
			var search_input = $(this).parent().find('#topbar-search-contents').val();
			window.location.href = base_url+'/search/?q='+search_input;
		}
	});

	// Search handlers
	topbar_search_submit_login.click(function() {
		var url = base_url+'/search/?q='+topbar_search_contents_login.val();
		window.location.href = url;
	});
	topbar_search_contents_login.keypress(function(e) {if(e.keyCode == 13) {window.location.href = base_url+'/search/?q='+topbar_search_contents_login.val();}});

	notfound_search_submit.click(function() {window.location.href = base_url+'/search/?q='+notfound_search_contents.val();});
	notfound_search_contents.keypress(function(e) {if(e.keyCode == 13) {window.location.href = base_url+'/search/?q='+notfound_search_contents.val();}});
    
<<<<<<< HEAD
=======
   

	function kFormatter(num) {
	  	return num > 999 ? (num/1000).toFixed(1) + 'k' : num
	}

>>>>>>> e74923f4e7758a668a89cd2ecb17b80121e5f7f3
	$('#follow-author').click(function(e){
		e.preventDefault();

		if( $('#ss_user_email').val().length < 1  ){
			$('body').addClass('show-modal-box');
		}else{
			 var author_id = $('#ss_author_id').val(),
			 user_email = $('#ss_user_email').val();

			if( author_id != '0' && user_email != ''){
	        $.ajax({
	            type: 'POST',
	            dataType: 'json',
	            data: { task: 'follow-author', user_email: user_email, author_id: author_id},
	            url: "http://www.puckermob.com/assets/ajax/ajaxmultifunctions.php",
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
	                    $('.hide-for-readers').addClass('hide');
	                	$('body').addClass('show-modal-box-follow');
	                	$('.hide-for-readers').css('display', 'none');                 
	                }
	            }
	     	});
	    	}
		}
	});

	$('.close').click(function(e){
		$('body').removeClass('show-modal-box');
		$('body').removeClass('show-modal-box-follow');
	});

	$('#register-link').click(function(e){
		e.preventDefault();
		$('#login-box').hide();
		$('#register-box').show();
	});

	$('#login-link').click(function(e){
		e.preventDefault();
		$('#register-box').hide();
		$('#login-box').show();
	});

	$('.ajax-form-submit').click(function(e){
		e.preventDefault();
		var dataString = '';	
		var form = $(this).parent('form'),
		task = $(form).attr('data-info-task');

		if(task === 'register-reader'){
			$(form).dynamicRegisterContent();
		}else if(task === 'login-reader'){
			$(form).dynamicLoginContent();
		}
	});

	if($('#warning-icon')){
		$('#warning-icon').on('click', function(e){
			e.stopPropagation();
			$('#dd-shares-content').slideToggle('slow');

		});
	}

    //Inifinite scroll function through an ajax call on all pages
	var current_page = 0;
	var per_page = 40;
	var feature = "<?php echo $featuredArticle; ?>"
	var spinner = $('.loader');
    
    function loadPage() {
		current_page++;
	    // ajax call should go here
	    //console.debug();
	    $(".main-div").append(spinner);
	    $.ajax({
	    	type: "GET",
	    	url: 'index.php?page=' + current_page + '&per_page=' + per_page + '&ajax=true',
	    	success: function(data) {
                var response = $('<div />').html(data);
	    		var temp = response.find('.featured');
	    		temp.children('.featured').remove();
	    		var content = temp.html();
	    		response.children('.featured').remove();
	    		//console.log(response);
	    		$(".main-div").append(response);
	    		spinner.hide();
	    		}
	    	});
	    }


	function isScrolledTo(elem) {
       var docViewTop = $(window).scrollTop(); //num of pixels hidden above current screen
       var docViewBottom = docViewTop + $(window).height();
 
       var elemTop = $(elem).offset().top; //num of pixels above the elem
       var elemBottom = elemTop + $(elem).height();
 
       return ((elemTop <= docViewTop));
    }

    function stopHeightOf(stopHeight, elem){
    	var stopHeight = stopHeight;
    	var sticky = $(elem);

    	console.log(stopHeight, sticky.offset().top);
	    if ( stopHeight > sticky.offset().top) {
	           sticky.css('position','absolute');
	           sticky.css('top',stopHeight);
	    }
    }

	var catcher = $('.catcher');
	var nav_bar = $('#nav_bar');
    var sticky = $('.sticky');
    var articleStick = $('.article-stick');
    var social_sticky = $('.social_sticky');
    var sideAd = $('.ad-unit');
    var height = $(window).scrollTop();
    var s = $("#sticker");
    var pos = s.position();  
    //Back To Top Arrow
    var offset = 220;
	var duration = 500;
    
 	$('.back-to-top').click(function(event) {
		event.preventDefault();
		$('html, body').animate({scrollTop: 0}, duration);
		return false;
	});

    $(window).scroll(function() {
    	//DESKTOP NOT ON ARTICLE PAGES
	    if( !$('body').hasClass('mobile') && adPage !== 'article'){
	    	if ($(document).height() - 10 <= $(window).scrollTop() + $(window).height()) {
	    	  loadPage();
			}
		};
    	if( !$('body').hasClass('mobile') ){
          //sticky right side bar 
			if(sticky.length > 0 ){
		        if(isScrolledTo(sticky)) {
		   	        sticky.css('position','fixed');
		            sticky.css('top','110px');
                   $('.back-to-top').fadeIn(duration);
		        }
		       var stopHeight = catcher.offset().top + (sideAd.height() * 7) + catcher.height();
		       if ( stopHeight > sticky.offset().top) {
		       		console.log(stopHeight, sticky.offset().top);
		            sticky.css('position','absolute');
		            sticky.css('top',stopHeight);
		            $('.back-to-top').fadeOut(duration);
		        }
		    }


           //sticky right side bar on article pages
		    if(articleStick.length > 0 ){
		        if(isScrolledTo(articleStick)) {
		   	        articleStick.css('position','fixed');
		            articleStick.css('top','110px');
                   $('.back-to-top').fadeIn(duration);
		        }
		       var stopHeight = catcher.offset().top + (sideAd.height() * 21.2) + catcher.height();
		       if ( stopHeight > articleStick.offset().top) {
		       		console.log(stopHeight, articleStick.offset().top);
		            articleStick.css('position','absolute');
		            articleStick.css('top',stopHeight);
		            $('.back-to-top').fadeOut(duration);
		        }
		    }
<<<<<<< HEAD
        
=======
		 }
>>>>>>> e74923f4e7758a668a89cd2ecb17b80121e5f7f3
        //MOBILE ARTICLE PAGE
	    if($('body').hasClass('mobile') && adPage === 'article'){
		   
		    if(social_sticky.length > 0){
		    	 if(isScrolledTo(social_sticky)) {
		   	        $(social_sticky).hide();
		   	        $('#social-media-container-header').show().addClass('stick');
		        }else{
		        	$(social_sticky).show();
		   	        $('#social-media-container-header').hide().removeClass('stick');
		        }

		        var stopHeight = $('#social_catcher').offset().top + $('#social_catcher').height();
		        if ( stopHeight > social_sticky.offset().top) {
		       	    $(social_sticky).show();
		   	        $('#social-media-container-header').hide().removeClass('stick');
	        	}
		    }
		}

    });

<<<<<<< HEAD
    //Detect if adblock is enabled 
    if ($('#header-ad').height() == 0) {
	    $("#main").css("margin-top", "120px");
    }
=======
   //Detect if adblock is enabled 
    if ($('#header-ad').height() == 0) {
       $("#main").css("margin-top", "120px");
    }

>>>>>>> e74923f4e7758a668a89cd2ecb17b80121e5f7f3

	function loadArt() {
        current_page++;
	    // ajax call should go here
	    $(".cool").append(spinner);
	    $.ajax({
	    	type: "GET",
	    	url: '../index.php?page=' + current_page + '&per_page=' + per_page + '&ajax=true',
	    	success: function(data) {
                var response = $('<div />').html(data);
	    		var temp = response.find('.featured');
	    		temp.children('.featured').remove();
	    		var content = temp.html();
	    		response.children('.featured').remove();
	    		$(".cool").append(response);
	    		spinner.hide();
	    		}
	    	
	    });
	}
<<<<<<< HEAD
$(window).scroll(function() {
   if( !$('body').hasClass('mobile')) {
   if($(window).scrollTop() + $(window).height() > $(document).height() - .3 * $(document).height()) {
       loadArt();
          }
       }
    });
});
=======

	$(window).scroll(function() {
	   if( !$('body').hasClass('mobile')) {
		   if($(window).scrollTop() + $(window).height() > $(document).height() - .3 * $(document).height()) {
		       loadArt();
		    }
	    }
	});
});
=======
$(document).foundation();var aside=Foundation.utils.S("#aside"),poparticles=Foundation.utils.S("#popular-articles"),subsidebar=Foundation.utils.S("#sub-sidebar-2"),subsidebar3=Foundation.utils.S("#sub-sidebar-3"),trendingNowHeight=Foundation.utils.S("#trending-now").height(),socialwidget=Foundation.utils.S("#social_widget"),adsonarHeight=Foundation.utils.S("#ad-sonar").height(),main=Foundation.utils.S("#main"),leftSide=Foundation.utils.S("#puc-articles"),base_url="http://www.puckermob.com",URL=$(location).attr("href"),page=document.body.id,country=ManageCookies.getCookie("country"),body=document.body,adPage=page;socialwidget=socialwidget.length>0?socialwidget.height():0;var isIE11=!!navigator.userAgent.match(/Trident.*rv\:11\./);isIE11&&main.css("display","block"),$(document).ready(function(){function e(){d++,$(".main-div").append(h),$.ajax({type:"GET",url:"index.php?page="+d+"&per_page="+c+"&ajax=true",success:function(e){var o=$("<div />").html(e),t=o.find(".featured");t.children(".featured").remove();t.html();o.children(".featured").remove(),$(".main-div").append(o),h.hide()}})}function o(e){var o=$(window).scrollTop(),t=(o+$(window).height(),$(e).offset().top);t+$(e).height();return o>=t}function t(){d++,$(".cool").append(h),$.ajax({type:"GET",url:"../index.php?page="+d+"&per_page="+c+"&ajax=true",success:function(e){var o=$("<div />").html(e),t=o.find(".featured");t.children(".featured").remove();t.html();o.children(".featured").remove(),$(".cool").append(o),h.hide()}})}"articleslide"!=page&&"home"!=page&&"category"!=page&&"article"!=page&&(adPage="category"),$(".facebook-comments-button").on("click",function(e){$("#disqus-comments").hasClass("hide")?$("#disqus-comments").removeClass("hide").slideDown(500):$("#disqus-comments").addClass("hide").slideUp(500)}),$("#articlelist-wrapper").scrollPagination({nop:25,offset:25,error:"No More Articles!",delay:200,scroll:!0,page:1}),"article"==page&&$("#second-popular-articles").scrollPagination({nop:25,offset:25,error:"No More Articles!",delay:200,scroll:!0,page:2}),$(".toggle-slide-left").length>0&&$(".toggle-slide-left").on("click",function(){$(body).toggleClass("sml-open"),$(this).toggleClass("open-menu"),$("#slide-menu-left-div").toggleClass("full-height")}),$("#menu-options li").on("click",function(e){e.preventDefault();var o=$(this),t=$(o).find("a").attr("id"),a=$(".slide-menu-left").find("[data-info='"+t+"']");$(".tap-articles").hide(),$("#menu-options").find("a").removeClass("current"),$(a).show(),$("#"+t).addClass("current")}),$("body").hasClass("mobile")&&($(window).width()<1050?$("#left-aside").hide():$("#left-aside").show()),Foundation.utils.S("#around-the-web a").attr("target","_blank");var a=Foundation.utils.S("#topbar-search-contents"),i=Foundation.utils.S("#topbar-search-submit"),s=Foundation.utils.S("#topbar-search-contents-login"),n=Foundation.utils.S("#topbar-search-submit-login"),l=Foundation.utils.S("#notfound-search-contents"),r=Foundation.utils.S("#notfound-search-submit");i.click(function(){var e=$(this).parent().find("#topbar-search-contents").val(),o=base_url+"/search/?q="+e;window.location.href=o}),a.keypress(function(e){if(13==e.keyCode){var o=$(this).parent().find("#topbar-search-contents").val();window.location.href=base_url+"/search/?q="+o}}),n.click(function(){var e=base_url+"/search/?q="+s.val();window.location.href=e}),s.keypress(function(e){13==e.keyCode&&(window.location.href=base_url+"/search/?q="+s.val())}),r.click(function(){window.location.href=base_url+"/search/?q="+l.val()}),l.keypress(function(e){13==e.keyCode&&(window.location.href=base_url+"/search/?q="+l.val())}),$("#follow-author").click(function(e){if(e.preventDefault(),$("#ss_user_email").val().length<1)$("body").addClass("show-modal-box");else{var o=$("#ss_author_id").val(),t=$("#ss_user_email").val();"0"!=o&&""!==t&&$.ajax({type:"POST",dataType:"json",data:{task:"follow-author",user_email:t,author_id:o},url:"http://www.puckermob.com/assets/ajax/ajaxmultifunctions.php",success:function(e){if(e.hasError)$("#login-result").html(e.message).attr("style","color:red; text-transform: inherit;");else{var o=e.email,t=$("#follow-the-author-bg");$("#ss_user_email").val(o),$(t).html('<label class="follow-author" ><i class="fa fa-check"></i>Author Followed</label>'),$("body").removeClass("show-modal-box"),$(".top-header-logout").find(".welcome-email span").html("Welcome, "+o),$(".top-header-logout").find("#image-header-profile").attr("src",e.user_img),$(".top-header-login").attr("style","display:none !important"),$(".top-header-logout").attr("style","display:inherit !important"),$("#follow-msg").html(e.message),$("#my-account-header-link").attr("href","http://www.puckermob.com/admin/following/"),$(".hide-for-readers").addClass("hide"),$("body").addClass("show-modal-box-follow"),$(".hide-for-readers").css("display","none")}}})}}),$(".close").click(function(e){$("body").removeClass("show-modal-box"),$("body").removeClass("show-modal-box-follow")}),$("#register-link").click(function(e){e.preventDefault(),$("#login-box").hide(),$("#register-box").show()}),$("#login-link").click(function(e){e.preventDefault(),$("#register-box").hide(),$("#login-box").show()}),$(".ajax-form-submit").click(function(e){e.preventDefault();var o=$(this).parent("form"),t=$(o).attr("data-info-task");"register-reader"===t?$(o).dynamicRegisterContent():"login-reader"===t&&$(o).dynamicLoginContent()}),$("#warning-icon")&&$("#warning-icon").on("click",function(e){e.stopPropagation(),$("#dd-shares-content").slideToggle("slow")});var d=0,c=40,h=$(".loader"),u=$(".catcher"),p=($("#nav_bar"),$(".sticky")),f=$(".article-stick"),g=$(".social_sticky"),m=$(".ad-unit"),w=($(window).scrollTop(),$("#sticker")),b=(w.position(),500);$(".back-to-top").click(function(e){return e.preventDefault(),$("html, body").animate({scrollTop:0},b),!1}),$(window).scroll(function(){$("body").hasClass("mobile")||"article"===adPage||$(document).height()-10<=$(window).scrollTop()+$(window).height()&&e();var t=0;$("body").hasClass("mobile")||(p.length>0&&(o(p)&&(p.css("position","fixed"),p.css("top","110px"),$(".back-to-top").fadeIn(b)),t=u.offset().top+7*m.height()+u.height(),t>p.offset().top&&(console.log(t,p.offset().top),p.css("position","absolute"),p.css("top",t),$(".back-to-top").fadeOut(b))),f.length>0&&(o(f)&&(f.css("position","fixed"),f.css("top","110px"),$(".back-to-top").fadeIn(b)),t=u.offset().top+21.2*m.height()+u.height(),t>f.offset().top&&(console.log(t,f.offset().top),f.css("position","absolute"),f.css("top",t),$(".back-to-top").fadeOut(b)))),$("body").hasClass("mobile")&&"article"===adPage&&g.length>0&&(o(g)?($(g).hide(),$("#social-media-container-header").show().addClass("stick")):($(g).show(),$("#social-media-container-header").hide().removeClass("stick")),t=$("#social_catcher").offset().top+$("#social_catcher").height(),t>g.offset().top&&($(g).show(),$("#social-media-container-header").hide().removeClass("stick")))}),0===$("#header-ad").height()&&$("#main").css("margin-top","120px"),$(window).scroll(function(){$("body").hasClass("mobile")||$(window).scrollTop()+$(window).height()>$(document).height()-3*$(document).height()&&t()})});
>>>>>>> c097226868863bcb0ef3cc4684f7564d56f71a1e
>>>>>>> e74923f4e7758a668a89cd2ecb17b80121e5f7f3
