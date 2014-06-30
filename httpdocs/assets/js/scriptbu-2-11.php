<?php
Header("content-type: application/x-javascript");
require_once('../php/config.php');
?>

  if($('.flexslider2')){
      $('.flexslider2').flexslider({
        animation: "slide",
        start: function(slider){
          $('div').removeClass('loading');
        },
        useCSS: false,
        directionNav: false
      });
  }

$(document).ready(function (e){
	var iD = false,
	ads = [],
	playerCont = $('#player-cont'),
	mediaQueries = [
		{ 
			context: 'bp0', 
			callback: function(){
				console.log('bp0');
				$('body').removeClass('bp3').addClass('bp0');
				MPSTruncation.onReflow('bp0');
				$('#header-menu .parent').mpShowSubMenu();
			} 
		},
		{ 
			context: 'bp1', 
			callback: function(){
				console.log('bp1');
				$('body').removeClass('bp0 bp3');
				MPSTruncation.onReflow('bp1');
				$('#header-menu .parent').mpShowSubMenu();
			} 
		},
		{ 
			context: 'bp1_5', 
			callback: function(){
				console.log('bp1_5');
				$('body').removeClass('bp0 bp3');
				MPSTruncation.onReflow('bp1_5');
				$('#header-menu .parent').mpShowSubMenu();
			} 
		},
		{ 
			context: 'bp2', 
			callback: function(){
				console.log('bp2');
				$('body').removeClass('bp0 bp3');
				MPSTruncation.onReflow('bp2');
				$('#header-menu .parent').mpShowSubMenu();
			} 
		},
		{ 
			context: 'bp3', 
			callback: function(){
				console.log('bp3');
				$('body').removeClass('bp0').addClass('bp3');
				MPSTruncation.onReflow('bp3');
				$('#header-menu .parent').mpShowSubMenu();
			} 
		},
		{ 
			context: 'bp4', 
			callback: function(){
				console.log('bp4');
				$('body').removeClass('bp0 bp3').addClass('bp4');
				MPSTruncation.onReflow('bp3');
				$('#header-menu .parent').mpShowSubMenu();
			} 
		}
	];


	//	This is the event handler for the delete cookie button...
	$('.delete-cookie').click(function(e){
		SDCookie.delete('mySDPromo'); 
		//window.location.reload(false);
	});

	//	Check to see if cookies is enabled
	var cookiesEnabled = SDCookie.checkEnabled();

	//	Check if the mySDPromo cookie is set
	var seenMySDPopup = SDCookie.get('mySDPromo');

	if (!seenMySDPopup && cookiesEnabled) {
	    //	Show Modal Window (SDPopUp)
		if($('#my-sd-promo')){
			$('#my-sd-promo').SDPopUp({
				'useCookie' : true,
				'cookieName' : 'mySDPromo',
				'cookieValue' : 'seen'
			});
		}
	}


	
/*Begin Slider Functions */

	/*HOMEPAGE AND CATEGORIES*/
	$('#carousel').flexslider({
	    animation: "slide",
	    controlNav: false,
	    animationLoop: true,
	    slideshow: false,
	    itemWidth: 100,
	    itemMargin: 5,
	    minItems: 1,
	    maxItems: 6,
		asNavFor: '#slider',
		useCSS: false
	});
	
	$('#slider').flexslider({
	    animation: "slide",
	    controlNav: false,
	    animationLoop: true,
	    slideshow: false,
	    sync: "#carousel",
	    touch: true,
	    prevText: '',
	    nextText: '',

	    start: function(slider){
	     	if(slider.count < 6) {
			    $('.flex-direction-nav').css('display', 'none'); 
			}

			$('.right-prev-arrow').click(function(event){
				event.preventDefault();
			    slider.flexAnimate(slider.getTarget("prev"));
			});

			$('.right-next-arrow').click(function(event){
				event.preventDefault();
			    slider.flexAnimate(slider.getTarget("next"));
			});
		}
	});

	/*VIDEOS SERIES*/
	if($('.videos-slider')){
		$('.videos-slider').each(function(e){
			$(this).flexslider({
		    animation: "slide",
		    animationLoop: true,
		    itemWidth: 140,
		    controlNav: false,
		    touch: true,
		    minItems:1,
		    maxItems:4,
		    prevText: '',
		    nextText: '',
		    slideshow: false,
		    move: 1,

		    

		    start: function(slider) {
			    $(slider).next().click(function(event){
			        event.preventDefault();
			        slider.flexAnimate(slider.getTarget("next"));
			    });
			     $(slider).prev().click(function(event){
			        event.preventDefault();
			        slider.flexAnimate(slider.getTarget("prev"));
			    });

			    if(slider.count < 4) {
				    $(slider).next().css('display', 'none'); 
				    $(slider).prev().css('display', 'none'); 
				}
			},

		    after:function(slider){
		    	var current_index = slider.currentSlide+1;
		    	$('.current-slider-number').text( current_index + " OF " + slider.count);
			}

		  });
		});
	}
	

	/*ARTICLE PAGE*/
	if($('#article-slider')){
		$('#article-slider').flexslider({
			animation: "slide", 
			controlNav: false,
			slideshow: false,
			touch: true,
			prevText: '',
	    	nextText: '',

	    	start: function(slider) {
	    		$count = 1;
	    		//For some Reason when has just one image is returning slide.count undefined
	    		if(slider.count != undefined){ 
	    			$count = slider.count;
	    		}else{
	    			$('.icon-chevron-sign-left').css('display', 'none');
	    			$('.icon-chevron-sign-right').css('display', 'none');
	    		} 
	    		
	    		$('.total-slides').text($count+" Photos");
	    		var current_index = slider.currentSlide+1;
		    	$('.current-slider-number').text( current_index + " OF " + $count);
		    },

		    after:function(slider){
		    	var current_index = slider.currentSlide+1;
		    	$('.current-slider-number').text( current_index + " OF " + slider.count);
			}
		});

		$('.icon-chevron-sign-left').click(function(e){
			$('#article-slider').flexslider("prev");
		});
		    	
		$('.icon-chevron-sign-right').click(function(e){
			$('#article-slider').flexslider("next");
		});

	}
/*END Slider Functions */

	/*View ALL Link On Show Pages*/
	if($('.view-all-link')){
		$('.view-all-link').each(function(e){
			$(this).click(function(e){
				e.preventDefault();
				var all_videos = $(this).next('.all-videos');
				if(!$(all_videos).hasClass('shown'))
					$(all_videos).addClass('shown').slideDown(500);
				else
					$(all_videos).removeClass('shown').slideUp(500);
			});
		});
	}

	//SCROLL FUNCTION
	/*$(window).scroll(function () {
		$("#header-cont").css("border-bottom", "2px solid red");
	});*/

	//SEARCH FUNCTIONALITIES
	var mousedownHappened = false;
	$('#search-text, #search-text-bs div, .close-search').click(function() {
		if($('.search-input-field').hasClass('shown')){
			$('#search').removeClass('shown');
			$('#search-cont').hide();
			mousedownHappened = true;
		}else{
			$('#search').addClass('shown');
			$('#search-cont').show();
			mousedownHappened = false;
		}	
		$('.search-input-field').focus();
	});	 


	$(document).mousedown(function(event) {
		if($(event.target).attr('id') == 'text-search' || $(event.target).attr('id') == 'search-cont' || $(event.target).attr('id') == 'search-text' || $(event.target).attr('class') == 'icon-search'){
		    mousedownHappened = true;
		}else  mousedownHappened = false;
	});

	$('#searchsubmit').click(function(e){
		$(this).submit();
	});

	$('#search').blur(function(e) {
		if( !mousedownHappened ){
			$('.search-input-field').removeClass('shown');
			$('#search-cont').hide();
			mousedownHappened = false;
		}
	});

	//END OF SEARCH FUNCTIONALITIES

	if($('.preview')){
		$('.preview').mpPreview();
	}
	$('.search-form').mpSearch();

	//$('#most-viewed-articles-cont, #featured-article-cont, #featured-ask-cont, #recipe-box-cont, #search-header-cont').appendAround();
	$('#featured-article-cont, #recipe-box-cont, #search-header-cont, #ad-300-atf-cont, #ad-300-btf1-cont, #ad-300-btf2-cont').appendAround();
	
	$('header, footer,  #search-cont').find('form input').focus(function(e){
		$(this).parents('form').find('#search-bg').addClass('focus-bg');
	}).blur(function(e){
		$(this).parents('form').find('#search-bg').removeClass('focus-bg');
	});

	$('#menu-icon').click(function(e){
		var cont = $('#header-menu');
		if($(cont).hasClass('shown')) $(cont).slideUp(500);
		else $(cont).slideDown(500);
		$(cont).toggleClass('shown');
	});

	$('p#other-sites').click(function(e){
		var cont = $('#other-sites-cont');
		if($(cont).hasClass('shown')) $(cont).slideUp(500);
		else $(cont).slideDown(500);
		$(cont).toggleClass('shown');
		$(this).toggleClass('shown');
	});

	$('.email-recipe-link a').each(function(e){
		$link = $(this);
		var article_title = $('#main-article-cont h1').text(),
		pathname = document.domain+window.location.pathname,
		logo = $('#logo a img').attr('src');
		
		var body = "Check out this recipe I found on simpledish.com. I think you'd love it!%0D%0A %0D%0A";
			body += "Go to "+pathname+" to see this recipe";
		
		
        subject = "Simple Dish Recipe | "+article_title,
        content = "mailto:?subject="+subject+"&body="+body;
 
        $link.attr('href',  content);

	});


	$('#social-buttons .social-button').each(function(){
		var elem = $(this),
		thisId = $(elem).attr('id'),
		thisUrl = $(elem).attr('data-url'),
		thisTitle = $(elem).attr('data-title'),
		thisImage = $(elem).attr('data-image'),
		thisDesc = $(elem).attr('data-desc'),
		apiUrl = $(elem).attr('data-api-url').replace('{url}', thisUrl);
		
		if(thisUrl !== undefined && thisUrl.length > 0 && thisId !== "linked-in" && thisId !== "google-plus" && thisId !== "twitter" && thisId !== "stumble"){
			$.get(apiUrl, function(data){
				var count = '0';
				if(thisId == "facebook" && data[thisUrl] !== undefined && data[thisUrl].shares !== undefined) count = data[thisUrl].shares;
				else if(data.count !== undefined) count = data.count;
				$(elem).find('.count p').html(count);
			}, "jsonp").error(function(e){$(elem).find('.count p').html('0');});
		}

		if(thisId == "twitter"){
			$.get("http://urls.api.twitter.com/1/urls/count.json?url=" + thisUrl, function(data){
				if(data !== undefined && data.count !== undefined) $(elem).find('.count p').html(data.count);
				else $(elem).find('.count p').html('0');
			}, "jsonp");
		}

		if(thisId == "linked-in" && IN !== undefined){
			var attempts = 0;
			function tryLinkedIn(){
				if(IN.Tags !== undefined){
					IN.Tags.Share.getCount(thisUrl, function(data){
						if(data) $(elem).find('.count p').html(data);
						else $(elem).find('.count p').html('0');
					});
				}else if(++attempts < 3 && IN.Tags === undefined) setTimeout(tryLinkedIn, 500);
				else $(elem).find('.count p').html('0');
			}
			tryLinkedIn();
		}

		if(thisId == "stumble"){
			$.getJSON('http://www.stumbleupon.com/services/1.01/badge.getinfo?url='+thisUrl , function(data){
				if(data !== undefined && data.result !== undefined) $(elem).find('.count p').html(data.result);
				else $(elem).find('.count p').html('0');
			});
		}

		$(elem).click(function(e){
			e.preventDefault();
			switch(thisId){
				case "stumble":
				
				var stumbleuponUrl = "http://www.stumbleupon.com/submit?url={url}&title={title}",
					stumbleuponUrl = stumbleuponUrl.replace('{url}', encodeURIComponent(thisUrl)).replace('{title}', encodeURIComponent(thisTitle));
					//window.open(stumbleuponUrl, '_blank');
					 window.open(stumbleuponUrl, "popupWindow", "width=850,height=600,scrollbars=yes");
					
					break;
				case "facebook":
					FB.init({appId: "<?php echo $mpArticle->data['article_page_facebook_app_id']; ?>", status: true, cookie: true});
					FB.ui({
						method: "feed",
						display: "popup",
						link: thisUrl
					});
					break;
				case "twitter":
					var twitterHandle = "<?php echo $mpArticle->data['article_page_twitter_url']; ?>".split('/').slice(-1)[0],
					twitterTextLength = 140 - (25 + twitterHandle.length + 7),
					twitterText = '',
					twitterUrl = "https://www.twitter.com/share?text={twittertext}&url={twitterurl}&via={twittervia}";
					
					twitterText = (thisTitle.length < (twitterTextLength - 7)) ? thisTitle + ' - ' : thisTitle.substr(0, twitterTextLength - 3) + '...';
					twitterTextLength = twitterTextLength - twitterText.length;
					twitterText += (thisDesc.length < (twitterTextLength - 3)) ? thisDesc : thisDesc.substr(0, twitterTextLength - 3) + '...';

					twitterUrl = twitterUrl.replace('{twitterurl}', thisUrl).replace('{twittervia}', twitterHandle).replace('{twittertext}', twitterText.split(' ').join('+'));
					break;
				case "pinterest":
					var pinterestUrl = "http://pinterest.com/pin/create/button/?url={url}&media={image}&description={desc}",
					pinterestDesc = (thisDesc.length > 100) ? thisDesc.substr(0, 100) + '...' : thisDesc;
					pinterestUrl = pinterestUrl.replace('{url}', encodeURIComponent(thisUrl)).replace('{image}', encodeURIComponent(thisImage)).replace('{desc}', encodeURIComponent(pinterestDesc));
					window.open(pinterestUrl, '_blank');
					break;
				case "google-plus":
					var googlePlusUrl = "https://plus.google.com/share?url=" + thisUrl;
					//window.open(googlePlusUrl, '_blank');
					break;
				case "linked-in":
					var linkedInUrl = "http://www.linkedin.com/shareArticle?mini=true&url=" + encodeURIComponent(thisUrl) + "&title=" + encodeURIComponent(thisTitle) + "&source=" + encodeURIComponent("<?php echo $mpArticle->data['article_page_visible_name']; ?>");
					window.open(linkedInUrl, '_blank');
					break;
			}			
		});
	});

	$('#newsletter-form').on('submit', function(e){
		var thisForm = $(this),
		thisResult = $(thisForm).parent().find('#result'),
		thisEmail = $(thisForm).find('#emailinput'),
		emailVal = $(thisEmail).val(),
		emailPH = $(thisEmail).attr('placeholder'),
		hasError = false,
		errorMsg = "One or more required feilds are incorrect.  Please try again.";

		
		if(!emailVal.length || emailVal == emailPH ){
			$(thisEmail).focus();
			hasError = true;
			errorMsg = "Oops! Your email address is a required field."
		}

			

		if(hasError && (!$(thisResult).hasClass('error') || $(thisResult).html() !== errorMsg)){
			$(thisResult).empty().html(errorMsg).addClass('error').fadeTo(500, 1);
			e.preventDefault();
		}else{
			$(thisResult).empty().removeClass('error');
		}
	});

	function validateEmail($email) {
	  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	  if( !emailReg.test( $email ) ) {
	    return false;
	  } else {
	    return true;
	  }
	}
	
/* HomePage Video Playlist & Player Settings */
	if($('#mp-video-player-cont').length){
		<?php if ($local){ ?>

					mpvp.init('mp-video-player-cont', 'OWEwN2QxMzhkNWYxMDJmZmMzNDVmMTAzNmIzZmRlZmNkYWFjNTI4Zg==', {
					//Begin Database-driven options
					debug : <?php echo ($mpArticle->data['player_setting_debug'] == 1) ? 'true' : 'false'; ?>,
					autoPlay : false,
					
					randomizePlaylist : false,
					countoffStart : false,
					withAds : false,
					preRolls : <?php echo ($mpArticle->data['player_setting_prerolls'] == 1) ? 'true' : 'false'; ?>,
					postRolls : <?php echo ($mpArticle->data['player_setting_postrolls'] == 1) ? 'true' : 'false'; ?>,
					adServerKey : '<?php echo (isset($mpArticle->data['player_setting_ad_server_key']) && !is_null($mpArticle->data['player_setting_ad_server_key'])) ? $mpArticle->data['player_setting_ad_server_key'] : 'integration_test'; ?>',
					adServerKeywords : '<?php echo (isset($mpArticle->data['player_setting_ad_server_keywords']) && !is_null($mpArticle->data['player_setting_ad_server_keywords'])) ? $mpArticle->data['player_setting_ad_server_keywords'] : $mpArticle->data['syn_ad_keywords']; ?>',
					adServerCategories : '<?php echo (isset($mpArticle->data['player_setting_ad_server_categories']) && !is_null($mpArticle->data['player_setting_ad_server_categories'])) ? $mpArticle->data['player_setting_ad_server_categories'] : ''; ?>',
					
					//Begin Hard-coded overrides
					adCompanionId: 'ad-300-atf',
					logoImgUrl:"<?php echo $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_player_logo']; ?>",
					logoImgLink: '',
					flashSwfUrl:"http://syndication.sequelmediagroup.com/assets/swf/MyPodHTML5Player.swf",
					adSwfUrl:"http://syndication.sequelmediagroup.com/assets/swf/MyPodAdPlayer.swf",
					playlist : 'http://syndication.playlists.sequelmediagroup.com/foodanddrink&id=<?php echo $mpArticle->data['player_setting_api_key']?>',
//					playlist : 'http://syndication.playlists.sequelmediagroup.com/testdefault&id=OWEwN2QxMzhkNWYxMDJmZmMzNDVmMTAzNmIzZmRlZmNkYWFjNTI4Zg==',

					callbacks:{
						adBreakStarted : function(){$('#ad-300-atf-companion').show();},
		                adBreakEnded : function(){$('#ad-300-atf-companion').hide();},
						videoChange : function(){
		                	var currentTitle = mpvp.currentItem['title'];
		                	var currentDescription = mpvp.currentItem['description'];
		                	var currentVideoId = mpvp.currentItem['id'];
							switch(currentVideoId)
							{
							case 200:
							  console.log('First Nilla ad viewed!');
							  // Fire GA tracking event
							  //_gaq.push(['_trackEvent', 'simpledish_video_event', 'view', 'Nilla Wafer Ad 1']);
							  break;
							case 198:
							  // Fire GA tracking event
							  console.log('Second Nilla ad viewed!');
							  //_gaq.push(['_trackEvent', 'simpledish_video_event', 'view', 'Nilla Wafer Ad 2']);
							  break;
							}
		                	$.ajax({
						        type: 'POST',
						        cache: false,
						        url: '<?php echo $config['this_url']?>assets/php/ajaxgetrecipes.php',
						        data: 'id='+currentVideoId,
						        dataType: 'json',
						        success: function(data) {
						        	if(data.valid){
							       		$('#video_description h1').text(currentTitle);
							       		$('#video_description p').html(currentDescription);
							       		$('#article-video-url').attr('href', data.article_url);
							       		$('#article-video-url').css('display', 'inline');
							       		$('#video_description').show();
							       	}else{
							       		$('#article-video-url').css('display', 'none');
							       		$('#video_description h1').text(currentTitle);
							       		$('#video_description p').html(currentDescription);
							       }
						        }
						    });
		                 
				        }
					}

		<?php } else { ?>

					mpvp.init('mp-video-player-cont', '<?php echo $mpArticle->data['player_setting_api_key']; ?>', {
					//Begin Database-driven options
					debug : <?php echo ($mpArticle->data['player_setting_debug'] == 1) ? 'true' : 'false'; ?>,
//					autoPlay : <?php echo ($mpArticle->data['player_setting_autoplay'] == 1) ? 'true' : 'false'; ?>,
					autoPlay : true,
//					randomizePlaylist : <?php echo ($mpArticle->data['player_setting_randomize_playlist'] == 1) ? 'true' : 'false'; ?>,
					randomizePlaylist : false,
					countoffStart : <?php echo ($mpArticle->data['player_setting_countoff_start'] == 1) ? 'true' : 'false'; ?>,
					withAds : <?php echo ($mpArticle->data['player_setting_withads'] == 1) ? 'true' : 'false'; ?>,
					preRolls : <?php echo ($mpArticle->data['player_setting_prerolls'] == 1) ? 'true' : 'false'; ?>,
					postRolls : <?php echo ($mpArticle->data['player_setting_postrolls'] == 1) ? 'true' : 'false'; ?>,
					adServerKey : '<?php echo (isset($mpArticle->data['player_setting_ad_server_key']) && !is_null($mpArticle->data['player_setting_ad_server_key'])) ? $mpArticle->data['player_setting_ad_server_key'] : 'integration_test'; ?>',
					adServerKeywords : '<?php echo (isset($mpArticle->data['player_setting_ad_server_keywords']) && !is_null($mpArticle->data['player_setting_ad_server_keywords'])) ? $mpArticle->data['player_setting_ad_server_keywords'] : $mpArticle->data['syn_ad_keywords']; ?>',
					adServerCategories : '<?php echo (isset($mpArticle->data['player_setting_ad_server_categories']) && !is_null($mpArticle->data['player_setting_ad_server_categories'])) ? $mpArticle->data['player_setting_ad_server_categories'] : ''; ?>',
					
					//Begin Hard-coded overrides
					cacheRequests : false,
					adCompanionId: 'ad-300-atf',
					logoImgUrl:"<?php echo $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_player_logo']; ?>",
					logoImgLink: '',
					flashSwfUrl:"http://syndication.sequelmediagroup.com/assets/swf/MyPodHTML5Player.swf",
					adSwfUrl:"http://syndication.sequelmediagroup.com/assets/swf/MyPodAdPlayer.swf",
					playlist : 'http://syndication.playlists.sequelmediagroup.com/<?php echo $mpArticle->data['player_setting_playlist_slug']; ?>&id=<?php echo $mpArticle->data['player_setting_api_key']; ?>',
					callbacks:{
						adBreakStarted : function(){$('#ad-300-atf-companion').show();},
		                adBreakEnded : function(){$('#ad-300-atf-companion').hide();},
						videoChange : function(){
		                	var currentTitle = mpvp.currentItem['title'];
		                	var currentDescription = mpvp.currentItem['description'];
		                	var currentVideoId = mpvp.currentItem['id'];
							switch(currentVideoId)
							{
							case 200:
							  console.log('First Nilla ad viewed!');
							  // Fire GA tracking event
							  _gaq.push(['_trackEvent', 'simpledish_video_event', 'view', 'Nilla Wafer Ad 1']);
							  break;
							case 198:
							  // Fire GA tracking event
							  console.log('Second Nilla ad viewed!');
							  _gaq.push(['_trackEvent', 'simpledish_video_event', 'view', 'Nilla Wafer Ad 2']);
							  break;
							}
		                	$.ajax({
						        type: 'POST',
						        cache: false,
						        url: '<?php echo $config['this_url']?>assets/php/ajaxgetrecipes.php',
						        data: 'id='+currentVideoId,
						        dataType: 'json',
						        success: function(data) {
						        	if(data.valid){
							       		$('#video_description h1').text(currentTitle);
							       		$('#video_description p').html(currentDescription);
							       		$('#article-video-url').attr('href', data.article_url);
							       		$('#article-video-url').css('display', 'inline');
							       		$('#video_description').show();
							       	}else{
							       		$('#article-video-url').css('display', 'none');
							       		$('#video_description h1').text(currentTitle);
							       		$('#video_description p').html(currentDescription);
							       }
						        }
						    });
		                }
					}	
			<?php } ?>

		});
	}

/* Series Page Playlist & Player Settings */

	if($('#mp-series-video-player-cont').length){
		var serieInformation = $('#series-playlist-keyword').val();
		console.log(serieInformation);
		
		<?php if ($local){ ?>

					mpvp.init('mp-series-video-player-cont', 'ZjM2YTcwZDJjZTk1YjUzMWI0NjYwYjdjZTMxODIyZTExNDkyOTBkNQ==', {
					//Begin Database-driven options
					debug : <?php echo ($mpArticle->data['player_setting_debug'] == 1) ? 'true' : 'false'; ?>,
					autoPlay : true,
					
					randomizePlaylist : false,
					countoffStart : false,
					withAds : false,
					preRolls : false,
					postRolls : false,
					adServerKey : '<?php echo (isset($mpArticle->data['player_setting_ad_server_key']) && !is_null($mpArticle->data['player_setting_ad_server_key'])) ? $mpArticle->data['player_setting_ad_server_key'] : 'integration_test'; ?>',
					adServerKeywords : '<?php echo (isset($mpArticle->data['player_setting_ad_server_keywords']) && !is_null($mpArticle->data['player_setting_ad_server_keywords'])) ? $mpArticle->data['player_setting_ad_server_keywords'] : $mpArticle->data['syn_ad_keywords']; ?>',
					adServerCategories : '<?php echo (isset($mpArticle->data['player_setting_ad_server_categories']) && !is_null($mpArticle->data['player_setting_ad_server_categories'])) ? $mpArticle->data['player_setting_ad_server_categories'] : ''; ?>',
					
					//Begin Hard-coded overrides
					adCompanionId: 'ad-300-atf',
					logoImgUrl:"<?php echo $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_player_logo']; ?>",
					logoImgLink: '',
					flashSwfUrl:"http://syndication.sequelmediagroup.com/assets/swf/MyPodHTML5Player.swf",
					adSwfUrl:"http://syndication.sequelmediagroup.com/assets/swf/MyPodAdPlayer.swf",
					playlist : 'http://syndication.playlists.sequelmediagroup.com/'+serieInformation+'&id=ZjM2YTcwZDJjZTk1YjUzMWI0NjYwYjdjZTMxODIyZTExNDkyOTBkNQ==',

					callbacks:{
						adBreakStarted : function(){$('#ad-300-atf-companion').show();},
		                adBreakEnded : function(){$('#ad-300-atf-companion').hide();},
						videoChange : function(){
		                	var currentTitle = mpvp.currentItem['title'];
		                	var currentDescription = mpvp.currentItem['description'];
		                	var currentVideoId = mpvp.currentItem['id'];
							
		                	$.ajax({
						        type: 'POST',
						        cache: false,
						        url: '<?php echo $config['this_url']?>assets/php/ajaxgetrecipes.php',
						        data: 'id='+currentVideoId,
						        dataType: 'json',
						        success: function(data) {
						        	if(data.valid){
							       		$('#video_description h1').text(currentTitle);
							       		$('#video_description p').html(currentDescription);
							       		$('#article-video-url').attr('href', data.article_url);
							       		$('#article-video-url').css('display', 'inline');
							       		$('#video_description').show();
							       	}else{
							       		$('#article-video-url').css('display', 'none');
							       		$('#video_description h1').text(currentTitle);
							       		$('#video_description p').html(currentDescription);
							       }
						        }
						    });
		                 
				        }
					}

		<?php } else { ?>
					console.log("<?php echo $mpArticle->data['player_setting_api_key'];?>");
					mpvp.init('mp-series-video-player-cont', '<?php echo $mpArticle->data['player_setting_api_key']; ?>', {
					//Begin Database-driven options
					debug : <?php echo ($mpArticle->data['player_setting_debug'] == 1) ? 'true' : 'false'; ?>,
					autoPlay : true,
					randomizePlaylist : false,
					countoffStart : <?php echo ($mpArticle->data['player_setting_countoff_start'] == 1) ? 'true' : 'false'; ?>,
					withAds : false,
					preRolls : false,
					postRolls : false,
					adServerKey : '<?php echo (isset($mpArticle->data['player_setting_ad_server_key']) && !is_null($mpArticle->data['player_setting_ad_server_key'])) ? $mpArticle->data['player_setting_ad_server_key'] : 'integration_test'; ?>',
					adServerKeywords : '<?php echo (isset($mpArticle->data['player_setting_ad_server_keywords']) && !is_null($mpArticle->data['player_setting_ad_server_keywords'])) ? $mpArticle->data['player_setting_ad_server_keywords'] : $mpArticle->data['syn_ad_keywords']; ?>',
					adServerCategories : '<?php echo (isset($mpArticle->data['player_setting_ad_server_categories']) && !is_null($mpArticle->data['player_setting_ad_server_categories'])) ? $mpArticle->data['player_setting_ad_server_categories'] : ''; ?>',
					
					//Begin Hard-coded overrides
					cacheRequests : false,
					adCompanionId: 'ad-300-atf',
					logoImgUrl:"<?php echo $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_player_logo']; ?>",
					logoImgLink: '',
					flashSwfUrl:"http://syndication.sequelmediagroup.com/assets/swf/MyPodHTML5Player.swf",
					adSwfUrl:"http://syndication.sequelmediagroup.com/assets/swf/MyPodAdPlayer.swf",
					playlist : 'http://syndication.playlists.sequelmediagroup.com/'+serieInformation+'&id=ZjM2YTcwZDJjZTk1YjUzMWI0NjYwYjdjZTMxODIyZTExNDkyOTBkNQ==',
					callbacks:{
						adBreakStarted : function(){$('#ad-300-atf-companion').show();},
		                adBreakEnded : function(){$('#ad-300-atf-companion').hide();},
						videoChange : function(){
		                	var currentTitle = mpvp.currentItem['title'];
		                	var currentDescription = mpvp.currentItem['description'];
		                	var currentVideoId = mpvp.currentItem['id'];
							
							$.ajax({
						        type: 'POST',
						        cache: false,
						        url: '<?php echo $config['this_url']?>assets/php/ajaxgetrecipes.php',
						        data: 'id='+currentVideoId,
						        dataType: 'json',
						        success: function(data) {
						        	if(data.valid){
							       		$('#video_description h1').text(currentTitle);
							       		$('#video_description p').html(currentDescription);
							       		$('#article-video-url').attr('href', data.article_url);
							       		$('#article-video-url').css('display', 'inline');
							       		$('#video_description').show();
							       	}else{
							       		$('#article-video-url').css('display', 'none');
							       		$('#video_description h1').text(currentTitle);
							       		$('#video_description p').html(currentDescription);
							       }
						        }
						    });
		                }
					}	
			<?php } ?>

		});
	}



	if($('#mp-article-video-player-cont').length){
		var videoData = JSON.parse($('#mp-article-video-player-cont').attr('data-info'));
		//mpvp.init('mp-video-player-cont', '<?php echo $mpArticle->data['player_setting_api_key']; ?>', {		
		mpvp.init('mp-article-video-player-cont', 'ZjM2YTcwZDJjZTk1YjUzMWI0NjYwYjdjZTMxODIyZTExNDkyOTBkNQ==', {
			debug : true,
			autoPlay: false,
			loopPlayback : false,
			logoImgUrl:"<?php echo $config['image_url'].'articlesites/logos/'.$mpArticle->data['article_page_player_logo']; ?>",
			logoImgLink: '',
			withAds : <?php echo ($mpArticle->data['player_setting_withads'] == 1) ? 'true' : 'false'; ?>,
			flashSwfUrl:"http://syndication.sequelmediagroup.com/assets/swf/MyPodHTML5Player.swf",
			adSwfUrl:"http://syndication.sequelmediagroup.com/assets/swf/MyPodAdPlayer.swf",
			playlist : [videoData],
			adServerKey : '<?php echo (isset($mpArticle->data['player_setting_ad_server_key']) && !is_null($mpArticle->data['player_setting_ad_server_key'])) ? $mpArticle->data['player_setting_ad_server_key'] : 'integration_test'; ?>'
		});
	}
	
	
	var MPSTruncation = (function(mpstruncation){
		var mpstruncation  = mpstruncation || {},
		truncationObjs = [];

 	$('#featured-contributor').each(function(){
			var thisInfo = $(this).find('.featured-info');
			truncationObjs.push({
				'titleCont' : $(thisInfo).find('h2 a').filter(':first'),
				'descCont' : $(thisInfo).find('p.contributor-bio'),
				'fullTitle' : $(thisInfo).attr('data-name'),
				'fullDesc' : $(thisInfo).attr('data-bio'),
				'trunctations' : {
					'bp0' : {
						'title' : 1000,
						'desc' : 450
					},
					'bp1' : {
						'title' : 25,
						'desc' : 250
					},
					'bp1_5' : {
						'title' : 35,
						'desc' : 200
					},
					'bp2' : {
						'title' : 45,
						'desc' : 250
					},
					'bp3' : {
						'title' : 35,
						'desc' : 300
					}
				}
			});
		});
		$('.recent-article').each(function(){
			var thisInfo = $(this).find('.article-info');
			truncationObjs.push({
				'titleCont' : $(thisInfo).find('h2 a'),
				'descCont' : $(thisInfo).find('p').eq(0),
				'fullTitle' : $(thisInfo).attr('data-title'),
				'fullDesc' : $(thisInfo).attr('data-desc'),
				'trunctations' : {
					'bp0' : {
						'title' : 20,
						'desc' : 30
					},
					'bp1' : {
						'title' : 15,
						'desc' : 35
					},
					'bp1_5' : {
						'title' : 15,
						'desc' : 35
					},
					'bp2' : {
						'title' : 25,
						'desc' : 40
					},
					'bp3' : {
						'title' : 300,
						'desc' : 50
					}
				}
			});
		});
		$('.submenu-wrapper').each(function(){
			var thisInfo = $(this).find('.article-info');
			truncationObjs.push({
				'titleCont' : $(thisInfo).find('h2 a'),
				'descCont' : $(thisInfo).find('p').eq(0),
				'fullTitle' : $(thisInfo).attr('data-title'),
				'fullDesc' : $(thisInfo).attr('data-desc'),
				'trunctations' : {
					'bp0' : {
						'title' : 200,
						'desc' : 30
					},
					'bp1' : {
						'title' : 200,
						'desc' : 35
					},
					'bp1_5' : {
						'title' : 200,
						'desc' : 35
					},
					'bp2' : {
						'title' : 200,
						'desc' : 60
					},
					'bp3' : {
						'title' : 200,
						'desc' : 70
					}
				}
			});
		}); 
		
	/*	$('.article-slideshow').each(function(){
			var thisInfo = $(this).find('.article-info');
			truncationObjs.push({
				'titleCont' : $(thisInfo).find('h2 a'),
				'descCont' : $(thisInfo).find('p').eq(0),
				'fullTitle' : $(thisInfo).attr('data-title'),
				'fullDesc' : $(thisInfo).attr('data-desc'),
				'trunctations' : {
					'bp0' : {
						'title' : 20,
						'desc' : 30
					},
					'bp1' : {
						'title' : 25,
						'desc' : 35
					},
					'bp1_5' : {
						'title' : 25,
						'desc' : 35
					},
					'bp2' : {
						'title' : 25,
						'desc' : 40
					},
					'bp3' : {
						'title' : 25,
						'desc' : 50
					}
				}
			});
		});*/

		$('.list-articles').each(function(){
			var thisInfo = $(this).find('.article-info');
			truncationObjs.push({
				'titleCont' : $(thisInfo).find('h2 a'),
				'descCont' : $(thisInfo).find('p').eq(0),
				'fullTitle' : $(thisInfo).attr('data-title'),
				'fullDesc' : $(thisInfo).attr('data-desc'),
				'trunctations' : {
					'bp0' : {
						'title' : 40,
						'desc' : 60
					},
					'bp1' : {
						'title' : 50,
						'desc' : 200
					},
					'bp1_5' : {
						'title' : 50,
						'desc' : 200
					},
					'bp2' : {
						'title' : 100,
						'desc' : 200
					},
					'bp3' : {
						'title' : 200,
						'desc' : 150
					}
				}
			});
		});
		/*$('.sidebar-articles article').each(function(){
			var thisInfo = $(this).find('.article-info');
			truncationObjs.push({
				'titleCont' : $(thisInfo).find('h2 a'),
				'descCont' : $(thisInfo).find('p'),
				'fullTitle' : $(thisInfo).attr('data-title'),
				'fullDesc' : $(thisInfo).attr('data-desc'),
				'trunctations' : {
					'bp0' : {
						'title' : 200,
						'desc' : 80
					},
					'bp1' : {
						'title' : 200,
						'desc' : 400
					},
					'bp1_5' : {
						'title' : 200,
						'desc' : 100
					},
					'bp2' : {
						'title' : 200,
						'desc' : 150
					},
					'bp3' : {
						'title' : 200,
						'desc' : 100
					}
				}
			});
		});*/
		$('#related-articles-cont article').each(function(){
			var thisInfo = $(this).find('.article-info');
			truncationObjs.push({
				'titleCont' : $(thisInfo).find('h2 a'),
				'descCont' : $(thisInfo).find('p'),
				'fullTitle' : $(thisInfo).attr('data-title'),
				'fullDesc' : $(thisInfo).attr('data-desc'),
				'trunctations' : {
					'bp0' : {
						'title' : 20,
						'desc' : 80
					},
					'bp1' : {
						'title' : 40,
						'desc' : 450
					},
					'bp1_5' : {
						'title' : 20,
						'desc' : 150
					},
					'bp2' : {
						'title' : 25,
						'desc' : 150
					},
					'bp3' : {
						'title' : 20,
						'desc' : 150
					}
				}
			});
		});
		$('.contributor').each(function(){
			var thisInfo = $(this).find('.contribtuor-info');
			truncationObjs.push({
				'titleCont' : $(thisInfo).find('h2 a').filter(':first'),
				'descCont' : $(thisInfo).find('p'),
				'fullTitle' : $(thisInfo).attr('data-name'),
				'fullDesc' : $(thisInfo).attr('data-bio'),
				'trunctations' : {
					'bp0' : {
						'title' : 200,
						'desc' : 80
					},
					'bp1' : {
						'title' : 200,
						'desc' : 200
					},
					'bp1_5' : {
						'title' : 200,
						'desc' : 200
					},
					'bp2' : {
						'title' : 200,
						'desc' : 330
					},
					'bp3' : {
						'title' : 200,
						'desc' : 330
					}
				}
			});
		});

		$('.top-articles-fav').each(function(){
		var thisInfo = $(this).find('.single-article');
		truncationObjs.push({
				'titleCont' : $(thisInfo).find('h2 a').filter(':first'),
				'descCont' : $(thisInfo).find('h2 a').filter(':first'),
				'fullTitle' : $(thisInfo).attr('data-title'),
				'fullDesc' : $(thisInfo).attr('data-title'),
				'trunctations' : {
					'bp0' : {
						'title' : 60,
						'desc' : 60
					},
					'bp1' : {
						'title' : 60,
						'desc' : 60
					},
					'bp1_5' : {
						'title' : 60,
						'desc' : 60
					},
					'bp2' : {
						'title' : 60,
						'desc' : 60
					},
					'bp3' : {
						'title' : 60,
						'desc' : 60
					}
				}
			});
		});

		mpstruncation.onReflow = function(bp){
			var len = truncationObjs.length;
			for(var i = 0; i < len; i++){
				var truncationObj = truncationObjs[i],
				currentTruncation = truncationObj.trunctations[bp],
				newTitle = (currentTruncation.title < truncationObj.fullTitle.length) ? truncationObj.fullTitle.substring(0, currentTruncation.title) + '...' : truncationObj.fullTitle,
				newDesc = (currentTruncation.desc < truncationObj.fullDesc.length) ? truncationObj.fullDesc.substring(0, currentTruncation.desc) + '...' : truncationObj.fullDesc;

				if(!$('body').hasClass('msie7') && !$('body').hasClass('msie8')){
					$(truncationObj.titleCont).html(newTitle);
					$(truncationObj.descCont).html(newDesc);
				}
			}
		};

		return mpstruncation;
	})(MPSTruncation || {});

	var MPRating = (function(mprating){
		var mprating = mprating || {},
		cont = $('#article-rating'),
		parent = $(cont).parents('article'),
		starCont = $(cont).find('.star-cont'),
		visibleText = $(cont).find('.label'),
		stars = [], i = 0, len = 0;

		mprating.init = function(){
			$(starCont).find('i').each(function(){
				stars.push({
					full : $(this).hasClass('icon-star full') ? true : false,
					half : $(this).hasClass('icon-star-half-empty') ? true : false,
					el : $(this)
				});
			});

			len = stars.length;

			if(!$(cont).hasClass('prev-vote')){
				$(starCont).on("mouseover", "i", mprating.onStarOver);
				$(starCont).on("mouseout", mprating.onStarOut);
				$(starCont).on("click", mprating.onStarClick);
			}			
		};

		mprating.onStarOver = function(e){
			var target = $(e.target), targetId = $(target).attr('id');
			for(i = 0; i < len; i++){
				var starObj = stars[i];
				$(starObj.el).removeClass('full empty icon-star-half-empty');
				($(starObj.el).attr('id') <= targetId) ? $(starObj.el).addClass('icon-star full') : $(starObj.el).addClass('icon-star empty');
			}
		};

		mprating.onStarOut = function(e){
			for(i = 0; i < stars.length; i++){
				var starObj = stars[i];
				$(starObj.el).removeClass('full empty icon-star-half-empty');
				starObj.full ? $(starObj.el).addClass('icon-star full') : starObj.half ? $(starObj.el).addClass('icon-star-half-empty') : $(starObj.el).addClass('icon-star empty');
			}
		};

		mprating.onStarClick = function(e){
			var articleId = $(parent).find('h1').attr('id'),
			vote = $(e.target).attr('id');
			$.post('<?php echo $config['this_url']; ?>assets/php/castvote.php',
				{article: articleId, votecast: vote},
				function(data){
					$(visibleText).fadeTo(500, 0, function(){
						$(this).empty().append('Thanks for voting!').fadeTo(500 ,1);
					});
					$(starCont).off("mouseover").off("mouseout").off("click");
				},
				"json"
			);
		};

		return mprating;
	})(MPRating || {});

//	If we're including google adSense ads, they can't be included in any iframe, so use a different implementation - adsense.php is included and appendChild() is used...
<?php if ($mpArticle->data['has_google_ad_sense']) { ?>
	MPAds.init(null, <?php echo $mpArticle->data['ads_rotate']; ?>, <?php echo $mpArticle->data['ad_rotation_time']; ?>)
	//	Start google adsense appending...
			document.getElementById('ad-300-atf-cont').appendChild(document.getElementById('ad1_footer'));
			document.getElementById('ad1_footer').style.display = 'inline';

			document.getElementById('ad-300-btf1-cont').appendChild(document.getElementById('ad2_footer'));
			document.getElementById('ad2_footer').style.display = 'inline';

			document.getElementById('ad-300-btf2-cont').appendChild(document.getElementById('ad3_footer'));
			document.getElementById('ad3_footer').style.display = 'inline';

			if($('#ad-728-atf').length > 0){
				if($('#ad4_footer').length > 0){
					document.getElementById('ad-728-atf').appendChild(document.getElementById('ad4_footer'));
					document.getElementById('ad4_footer').style.display = 'inline';
				}	
			}
			
			if($('#ad-728-btf1').length > 0){
				if($('#ad5_footer').length > 0){
					document.getElementById('ad-728-btf1').appendChild(document.getElementById('ad5_footer'));
					document.getElementById('ad5_footer').style.display = 'inline';
				}
			}	

			if($('#ad-728-btf2').length > 0){
				if($('#ad6_footer').length > 0){
					document.getElementById('ad-728-btf2').appendChild(document.getElementById('ad6_footer'));
					document.getElementById('ad6_footer').style.display = 'inline';
				}
			}

			if($('#ad-728-btf3').length > 0){
				if($('#ad7_footer').length > 0){
					document.getElementById('ad-728-btf3').appendChild(document.getElementById('ad7_footer'));
					document.getElementById('ad7_footer').style.display = 'inline';
				}
			}

			for(var i = 0; i < ads.length; i++){MPAds.addAd(ads[i]);}

<?php } else { ?>
	//	We are not using google adsense, use individual php files that query the db for the given ad...
	MPAds.init(null, <?php echo $mpArticle->data['ads_rotate']; ?>, <?php echo $mpArticle->data['ad_rotation_time']; ?>)

	$('#ad-300-atf').each(function(){
		var adObj = {name: 'ad-300', el: $(this), url: '<?php echo $config['shared_url']; ?>assets/ads/ad300atf.php', width: '100%', height: 250};
		ads.push(adObj);
	});

	$('#ad-300-btf1').each(function(){
		var adObj = {name: '300btf1', el: $(this), url: '<?php echo $config['shared_url']; ?>assets/ads/ad300btf1.php', width: '100%', height: 250};
		ads.push(adObj);
	});

	$('#ad-300-btf2').each(function(){
		var adObj = {name: '300btf2', el: $(this), url: '<?php echo $config['shared_url']; ?>assets/ads/ad300btf2.php', width: '100%', height: 250};
		ads.push(adObj);
	});

	$('#ad-728-atf').each(function(){
		var adObj = {name: '728atf', el: $(this), url: '<?php echo $config['shared_url']; ?>assets/ads/ad728atf.php', width: '100%', height: 90};
		ads.push(adObj);
	});

	$('#ad-728-btf').each(function(){
		var adObj = {name: '728btf', el: $(this), url: '<?php echo $config['shared_url']; ?>assets/ads/ad728btf.php', width: '100%', height: 90};
		ads.push(adObj);
	});

	$('#ad-728-ctf').each(function(){
		var adObj = {name: '728ctf', el: $(this), url: '<?php echo $config['shared_url']; ?>assets/ads/ad728ctf.php', width: '100%', height: 90};
		ads.push(adObj);
	});

	$('#ad-728-dtf').each(function(){
		var adObj = {name: '728dtf', el: $(this), url: '<?php echo $config['shared_url']; ?>assets/ads/ad728dtf.php', width: '100%', height: 90};
		ads.push(adObj);
	});

	$('#ad-300-mobile, #ad-300-mobile2, #ad-300-mobile3').each(function(){
		var adObj = {name: '300mobile', el: $(this), url: '<?php echo $config['shared_url']; ?>assets/ads/ad300mobile.php', width: '100%', height: 250};
		ads.push(adObj);
	});

	/*$('#ad-1050-btf').each(function(){
		var adObj = {name: '1050btf', el: $(this), url: '<?php echo $config['shared_url']; ?>assets/ads/ad1050banner.php', width: '100%', height: 230};
		ads.push(adObj);
	});*/


	for(var i = 0; i < ads.length; i++){
		MPAds.addAd(ads[i]);
	}

<?php } ?>

	mediaQueries.push({ 
		context: 'global', 
		callback: function(){
			//console.log('global');
			if(!$('body').is('bp0, bp1, bp1_5') ){
				$('.footer-list').each(function(){$(this).removeClass('shown');$(this).find('#connect-cont,ul,form').show();});
				$('header #search-cont').removeClass('shown').hide();
				//$('#header-menu').removeClass('shown').show();
		
			}else{
				$('.footer-list').each(function(){$(this).find('ul, form, #connect-cont').hide();});
				$('.footer-list').filter(':first').find('h2').click();
				//$('#header-menu').removeClass('shown').hide();
			}

			setTimeout(function(){
				if($(playerCont).css('display') == 'none' && mpvp.flashPlayer.el && mpvp.html5Player.el) (mpvp.flashPlayerActive) ? mpvp.flashPlayer.el.pause() : mpvp.html5Player.el.pause();
			}, 500);

			MPAds.resetAds();
			fixPodSlides();
		} 
	});
	MQ.init(mediaQueries);
	MPAds.resetAds();

	function fixPodSlides(){
		if($('html').hasClass('no-csstransitions')){
			$('.pod').each(function(){
				var thisPod = $(this), thisImage = $(thisPod).find('.pod-image');
				if($('body').hasClass('bp3') || $('body').hasClass('msie7') || $('body').hasClass('msie8')) $(thisPod).mouseenter(function(e){$(thisImage).animate({left : '-100%'}, 333);}).mouseleave(function(e){$(thisImage).animate({left : '0'}, 333);});
				else $(thisPod).unbind('mouseenter mouseleave');
			});
		}
	}
	fixPodSlides();
	
	if($('#article-rating').length) MPRating.init();
	if($('#fb-comments').length && !$('body').hasClass('msie7') && !$('body').hasClass('msie8')){
		var commentsWidth = $('.left-content').innerWidth(),
		currentUrl = 'http://' + window.location.host + window.location.pathname
		$('#fb-comments').empty().append('<div class="fb-comments" data-href="' + currentUrl + '" data-num-posts="5" data-width="' + commentsWidth + '"></div>');
	}

});