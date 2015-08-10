$(document).foundation();
var aside = Foundation.utils.S('#aside');
var poparticles = Foundation.utils.S("#popular-articles");
var subsidebar = Foundation.utils.S("#sub-sidebar-2");
var subsidebar3 = Foundation.utils.S("#sub-sidebar-3");
var trendingNowHeight = Foundation.utils.S('#trending-now').height();
var socialwidget = Foundation.utils.S('#social_widget');
var adsonarHeight = Foundation.utils.S('#ad-sonar').height();
var main = Foundation.utils.S('#main');
var leftSide = Foundation.utils.S('#puc-articles');
var base_url = 'http://www.puckermob.com';
var URL = $(location).attr('href');
var page = document.body.id;
var country =ManageCookies.getCookie('country');
var body = document.body;


if(socialwidget.length > 0) socialwidget = socialwidget.height(); else socialwidget=0;

var isIE11 = !!navigator.userAgent.match(/Trident.*rv\:11\./);
if(isIE11){
	//smain.css("left", "0%");
	main.css("display", "block");
}

var asideHeight = {
	video: socialwidget,
	atf: 0,
	popular: poparticles.height(),
	subsidebar: subsidebar.height(),
	adSonar: 300,
	connect: Foundation.utils.S("#connect-with-us").height(),
	btf1: 0,
	btf2: 0,
	btf3: 0,
	subsidebar3: poparticles.height() + 140,
	margin: parseInt(main.css("padding-bottom"))
};


$(document).ready(function() {
	
	if(page != 'articleslide' && page != 'home' && page != 'category' && page != 'article' && page != 'distroscale') {var adPage = 'category';} else {var adPage = page;}

	//READ MORE 
	if($('body').hasClass('mobile')) {
		var $el, $ps, $up, totalHeight;
		var parentOrgHeight = $('#article-content').outerHeight();

		var pct_to_show = parseInt($('#read_more_pct').val());
		var height_value = pct_to_show / 100 ;
		var wishDisplayHeight = parentOrgHeight * height_value;

		$('#article-content').css('max-height', wishDisplayHeight);

		$(".read-more").on('click', '.button', function(e) {
			e.preventDefault();		
			totalHeight = 0
			$el = $(this);
			$parent_div  = $el.parent();
			$content = $('#article-content');
											
			$content.css({
					"height": $content.height(),
					"max-height": 9999
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
				else $('#aside').attr('style', 'right:0;');
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
		nop     : 15,
		offset  : 15, 
		error   : 'No More Articles!',
		delay   : 300,
		scroll  : true, 
	    page    : 1
	});

	//SCROLL DOWN MOST POPULAR ARTICLES
	if(page == 'article'){
		$('#second-popular-articles').scrollPagination({
			nop     : 10,
			offset  : 10,
			error   : 'No More Articles!',
			delay   : 300, 
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

	Foundation.utils.image_loaded(Foundation.utils.S('#aside img'), function(){
		//asideHeight.popular = poparticles.height();
		totalHeight = 5400;//3938;
		//if( page == "videos") totalHeight += 80;
		if(!$('body').hasClass('mobile')) {
			//leftSide.css("min-height", (totalHeight +  asideHeight.atf + asideHeight.video));
			//main.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
		}
	});

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

	/*GET TOTAL SHARES PER ARTICLE ON HP/CATEGORY/INTERIOR PAGE MOST RECENTS*/
	function getTotalShares( url, elm ){
	  		var span_shares_holder = $(elm).find('.span-holder-shares');
	 		var this_count = 0;
	 		var fn_callback = null ;
	 		var label =  " SHARES";
			var service = {
			  "facebook": "http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls=",
			  "twitter": "http://cdn.api.twitter.com/1/urls/count.json?url=",
			 // "pinterest": "http://widgets.pinterest.com/v1/urls/count.json?source=6&url=",
			  "linkedint": "http://www.linkedin.com/countserv/count/share?url="
			};
	 		$.each( service, function( key, value ) {
			  var api_url = value+url;
			  if(key == "facebook"){
			  	var fn_callback = function(obj){
				  	this_count = this_count + obj[0]['total_count'];
				 }
			  }else{
			  	var fn_callback = function(obj){
				  	this_count = this_count + obj['count'];
				 }
			  }
			 $.ajax({ type: 'GET',  dataType: 'jsonp',  data: {}, url: api_url, 
				  	success: fn_callback,
				  	async: false, cache: false
			  	}).then(function(){
			  		var label =  " SHARES";
			  		if(this_count == 1) label = " SHARE";
			  			
			  		span_shares_holder.text(kFormatter(this_count)+label);  		
			  	});  
	 		});
	}

	$.each($('.article-id'),  function( i ){
	 	var url = $(this).attr('data-info-url');
		getTotalShares( url, $(this) );
	});

	//Social Shares Tracking FB Sharing Functionality
	var SocialShares = {
		updateFBShare: function( count, article_id ){
			$.post("http://www.puckermob.com/assets/ajax/ajaxManageData.php", {"count" : count, "articleId" : article_id}, function(data) {} );
		},

		fbEventHandler: function(evt) { 
			if (evt.type == 'addthis.menu.share' && evt.data.service == 'facebook') { 
		     	   addthis.sharecounters.getShareCounts('facebook', function(obj) {        
		    		var count = obj.count;
		    		var article_id = Foundation.utils.S('#article_id').val();
		    		SocialShares.updateFBShare( count, article_id );
		    	});
		  	}
		 }
	}
		
	if(page === 'article' || page === 'articleslide') {
		addthis.sharecounters.getShareCounts('facebook', function(obj) {        
		});
		addthis.addEventListener('addthis.menu.share', SocialShares.fbEventHandler);
	}

	function kFormatter(num) {
	  	return num > 999 ? (num/1000).toFixed(1) + 'k' : num
	}

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
	var per_page = 20;
	var feature = "<?php echo $featuredArticle; ?>"
	var spinner = $('.loader');
    

	function loadPage() {
		current_page++;
	    // ajax call should go here
	    console.debug();
	    
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
	    		console.log(response);
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


	   // return stopHeight > sticky.offset().top;
    }

	var catcher = $('.catcher');
	var nav_bar = $('#nav_bar');
    var sticky = $('.sticky');
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
			
    //var spinner = $('.loader');

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

			if ($(this).scrollTop() > offset) {
				//$('.back-to-top').fadeIn(duration);
			} else {
				//$('.back-to-top').fadeOut(duration);
			}		   	
				
		}

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

       //Detect if adblock is enabled 
        if ($('#header-ad').height() == 0) {
	       $("#main").css("margin-top", "120px");
        }else {
	        console.log("false");
        }

	//ajax loading image to show when calling an ajax call
//BRANOVATE AD MOBILE
	/*
	if($('body').hasClass('mobile') && adPage === 'article'){
		setTimeout(function() {
			loadBranovateAd( document.getElementById("branovate-ad"), '<SCRIPT SRC="http://ib.adnxs.com/ttj?id=4408970&referrer=[REFERRER_URL]" TYPE="text/javascript"></SCRIPT>');
		}, 2000);
	}*/


});


