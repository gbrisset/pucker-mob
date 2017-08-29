<?php
	Header("content-type: application/x-javascript"); 
	require_once('../php/config.php');
?>

// Scroll function
var header = $('#header-cont');

$(window).scroll(function(e){
    if(header.offset() !== null){
	    if(header.offset() && header.offset().top !== 0){
	        if(!header.hasClass('shadow')){
	            header.addClass('shadow');
	        }
	    }else{
	        header.removeClass('shadow');
	    }
	}
});


window.log = function(){
	log.history = log.history || [];
	log.history.push(arguments);
	if(this.console) {
	arguments.callee = arguments.callee.caller;
	var newarr = [].slice.call(arguments);
	//(typeof console.log === 'object' ? log.apply.call(console.log, console, newarr) : console.log.apply(console, newarr));
	}
};
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,timeStamp,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();){b[a]=b[a]||c}})((function(){try
{console.log();return window.console;}catch(err){return window.console={};}})());

/* Begin onmediaquery */
var MQ=function(b){b=b||{};b.init=function(a){this.callbacks=[];this.new_context=this.context="";if("undefined"!==typeof a)for(i=0;i<a.length;i++)this.addQuery(a[i]);this.addEvent(window,"resize",b.listenForChange,b);this.listenForChange()};b.listenForChange=function(){document.documentElement.currentStyle&&(query_string=document.documentElement.currentStyle.fontFamily);window.getComputedStyle&&(query_string=window.getComputedStyle(document.documentElement, null).getPropertyValue("font-family"));null!=query_string&&(query_string=query_string.replace(/['",]/g,""),query_string!==this.context&&(this.new_context=query_string,this.triggerCallbacks(this.new_context)),this.context=this.new_context)};b.addQuery=function(a){if(!(null==a||void 0==a))return this.callbacks.push(a),"string"==typeof a.context&&(a.context=[a.context]),"boolean"!==typeof a.call_for_each_context&&(a.call_for_each_context=!0),""!=this.context&&this._inArray(this.context,a.context)&&a.callback(),this.callbacks[this.callbacks.length- 1]};b.removeQuery=function(a){if(!(null==a||void 0==a))for(var c=-1;-1<(c=this.callbacks.indexOf(a));)this.callbacks.splice(c,1)};b.triggerCallbacks=function(a){var c,b;for(c=0;c<this.callbacks.length;c++)!1==this.callbacks[c].call_for_each_context&&this._inArray(this.context,this.callbacks[c].context)||(b=this.callbacks[c].callback,(this._inArray(a,this.callbacks[c].context)||this.callbacks[c].context=='global')&&void 0!==b&&b())};b.addEvent=function(a,c,b,d){null==a||void 0==a||(a.addEventListener?a.addEventListener(c,function(){b.call(d)}, !1):a.attachEven?a.attachEvent("on"+c,function(){b.call(d)}):a["on"+c]=function(){b.call(d)})};b._inArray=function(a,b){for(var e=b.length,d=0;d<e;d++)if(b[d]==a)return!0;return!1};return b}(MQ||{});
/* End onmediaquery */

/* Begin Scrollable Element Detection */
function scrollableElement(els) {
	for (var i = 0, argLength = arguments.length; i < argLength; i++){
		var el = arguments[i],
		$scrollElement = $(el);
		if($scrollElement.scrollTop()> 0) return el;
		else{
			$scrollElement.scrollTop(1);
			var isScrollable = $scrollElement.scrollTop() > 0;
			$scrollElement.scrollTop(0);
			if(isScrollable) return el;
		}
	}
	return [];
}
/* End Scrollable Element Detection */


var SDCookie = (function() {
    return {
    	checkEnabled: 	function(){
	        var r = false;
	        this.save("SDCheck", "success", 1);
	        if (this.get("SDCheck") != null) {
	            r = true;
	            this.delete("SDCheck");
	        }
	        return r;
    	},
        save: 	function (name,value,days) {
					if (days) {
					    var date = new Date();
					    date.setTime(date.getTime()+(days*24*60*60*1000));
					    var expires = "; expires="+date.toGMTString();
					}
					else var expires = "";
					document.cookie = name+"="+value+expires+"; path=/";
		},
        get: 	function (name) {
					var nameEQ = name + "=";
					var ca = document.cookie.split(';');
					for(var i=0;i < ca.length;i++) {
					    var c = ca[i];
					    while (c.charAt(0)==' ') c = c.substring(1,c.length);
					    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
					}
					return null;
		},
		delete: function(name){
					this.save(name,"",-1);
		}
    }

}());

$.fn.SDPopUp = (function(opts){
	var options = $.extend({
		'useCookie' : false,
		'cookieName' : '',
		'cookieValue' : '',
		'closeButtonClass' : 'popup-close'//,
	}, opts),
	overlay = $('<div class="overlay"></div>'),
	// lightboxPreviewCont = this.find('#lightbox-preview-cont'),
	popupClose = this.find('#'+options.closeButtonClass),
	scrollableEl = scrollableElement('html', 'body');
	console.log(options.cookieData);
	if(options.useCookie){
		SDCookie.save(options.cookieName,options.cookieValue,365);
	}

	this.append(overlay);
	this.addClass('popup-shown');		

	overlay.add(popupClose).click(function(e){
		overlay.parent().removeClass('popup-shown');
	});
});



var MPAds = (function(mpads){
	var mpads = mpads || {};
	mpads.allowRotate = false;
	mpads.rotationTime = 5 * 1000;
	mpads.rotation;

	mpads.init = function(ads, rotate, rotationTime){
		mpads.ads = [];
		mpads.allowRotate = rotate;
		mpads.rotationTime = rotationTime * 1000;

		if(typeof ads !== 'undefined' && ads !== null){
			var len = mpads.length;
			for(var i = 0; i < len; i++){
				var a = mpads.addAd(mpads[i]);
			}
		}
		mpads.resetAds();
		return mpads;
	}

	mpads.addAd = function(adObj){
		if(adObj == null || adObj == undefined) return;
		mpads.ads.push(adObj);
		return mpads;
	}

	mpads.removeAd = function(adObj){
		if(adObj == null || adObj == undefined) return;
		var match = -1;

		while((match = mpads.ads.indexOf(adObj)) > -1){
			mpads.ads.splice(match, 1);
		}
		return mpads;
	}

	mpads.resetAds = function(){
		var len = 0;
		if((len = mpads.ads.length) == 0) return;
		mpads.rotation = null;
		for(var i = 0; i < len; i ++){
			var adObj = mpads.ads[i];
			if(adObj.url.length > 0 && adObj.el !== null && typeof(adObj.el) !== 'undefined'){
				var el = $(adObj.el);
				$(el).empty();
				if($(el).css('display') !== 'none'){
					$(el).append('<iframe src="' + adObj.url + '" width="' + adObj.width + '" height="' + adObj.height + '" frameborder="0" scrolling="no"></iframe>');
				}
			}
		}
		if(mpads.allowRotate) mpads.rotation = setTimeout(mpads.resetAds, mpads.rotationTime);
		return mpads;
	}

	return mpads;
})(MPAds || {});

$(document).ready(function(){
	var ua = navigator.userAgent.toLowerCase(),
	rwebkit = /(webkit)[ \/]([\w.]+)/,
	rchrome = /(chrome)[ \/]([\w.]+)/,
	rsafari = /(version)[ \/]([\w.]+)[\s](safari)/,
	ropera = /(opera)(?:.*version)?[ \/]([\w.]+)/,
	rmsie = /(msie) ([\w.]+)/,
	rff = /(firefox)(?:.*?([\d]))?/,
	rmozilla = /(mozilla)(?:.*? rv:([\w.]+))?/;

	var match = rchrome.exec( ua ) || 
	rsafari.exec( ua ) ||
	rwebkit.exec( ua ) ||
	ropera.exec( ua ) ||
	rmsie.exec( ua ) ||
	ua.indexOf("compatible") < 0 && rmozilla.exec( ua ) ||
	[],
	ffMatch = ua.indexOf("compatible") < 0 && rff.exec( ua ) ||
	[];

	if(match[1]) $('body').addClass(match[1]);
	if(match[1] && match[2]){
		$('body').addClass(match[1] + match[2].split('.')[0]);
		$('body').addClass(match[1] + match[2]);
		if(match[1].toLowerCase() == 'mozilla' && parseInt(match[2].split('.')[0]) <= 12) $('body').addClass(match[1] + '-12pre');
		if(match[1].toLowerCase() == 'mozilla' && parseInt(match[2].split('.')[0]) > 12) $('body').addClass(match[1] + '-12post');
	}
	if(ffMatch[1] && ffMatch[2]) $('body').addClass(ffMatch[1] + ffMatch[2]);
	if($.inArray('safari', match) !== -1 && match[2] && match[3]){
		$('body').addClass(match[3] + match[2]);
		$('body').addClass(match[3]);
	}

	if(!$('body').hasClass('msie7') && !$('body').hasClass('msie8')){
		(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) {return;} js = d.createElement(s); js.id = id; js.async = true; js.src = "//connect.facebook.net/en_US/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));
	}

	/*$('input').each(function(){
		var thisInput = $(this),
		thisType = $(thisInput).attr('type'),
		thisPlaceholder = $(thisInput).attr('placeholder'),
		supportedTypes = ['text', 'email', 'url'],
		placeHolderSupported = Modernizr.input.placeholder;

		if(!placeHolderSupported && thisPlaceholder !== undefined && $.inArray(thisType, supportedTypes) !== -1){
			//$(thisInput).val(thisPlaceholder);
			//$(thisInput).on("focus", function(e){if($(thisInput).val() == thisPlaceholder) $(thisInput).val('');}).on("blur", function(){if($(thisInput).val() == '') $(thisInput).val(thisPlaceholder);});
		}
	});*/
});


$.fn.appendAround = function(){
	return this.each(function(){
		var $self = $(this),
		att = "data-set",
		$set = $("["+ att +"='"+ $self.closest("["+ att +"]").attr(att) + "']");
		function appendToVisibleContainer(){
			if( $self.is( ":hidden" )) $self.appendTo($set.filter(":visible:eq(0)"));
		}
		appendToVisibleContainer();
		$(window).resize(appendToVisibleContainer);
	});
};

$.fn.mpShowSubMenu = function(){
	return this.each(function(e){	
		var ttIconOver = false, ttOver = false, ttTimeout = null;
		var parent = $(this), 
		submenu = $(this).children('.submenu-wrapper'),
		parent_label = $(this).children('.parent-title');


		$(parent).off();
		

		if($('body').is('.bp3') || $('body').is('.bp4') || $('body').is('.admin2')){
			
			$(this).on('mouseenter', function(e){
				e.preventDefault();
				$(submenu).addClass('shown').show();
				$(parent_label).addClass('shown');
				ttIconOver = true;
			}).on('mouseleave', function(e){
				ttIconOver = false;
				$(submenu).removeClass('shown').hide();
				$(parent_label).removeClass('shown');
				ttTimeout = setTimeout(onTimeout, 200);
			});
		
		}
		else{
			$(this).click(function(e){
			 if($(e.target).attr('class') == "isParent"){
				if( $(submenu).hasClass('shown') ) $(submenu).slideUp(500, function(){$(this).removeClass('shown')});
				else $(submenu).slideDown(500, function(){$(this).addClass('shown')});

				e.preventDefault();

				$(submenu).children('li:not(.parent)').each(function(){
					var li = $(this),
					anch = $(li).children('a');

					$(this).click(function(e){
						window.location = $(anch).attr('href');
					});
				});
			}
			});
		}
		
		function onTimeout(){
			if(!ttOver && !ttIconOver) $(submenu).removeClass('shown').hide();//slideUp(200, function(){$(this).removeClass('shown')});
			clearTimeout(ttTimeout);
		};
		
	});
};

$.fn.outside = function(ename, cb){
      return this.each(function(){
          var $this = $(this),
              self = this;

          $(document).bind(ename, function tempo(e){
              if(e.target !== self && !$.contains(self, e.target)){
                  cb.apply(self, [e]);
                  if(!self.parentNode) $(document.body).unbind(ename, tempo);
              }
          });
      });
  };



$.fn.mpsDropDown = function(){
	return this.each(function(){
		var mpsdd = {},
		thatUL = $(this),
		thatParent = $(thatUL).parent(),
		thatH2 = $(thatParent).find('h2'),
		thatLoading = $(thatParent).parent().find('#loading'),
		content = $(thatParent).next(),
		thatH2Over = false, thatULOver = false, thatULTimeout = null,
		podStrings;

		mpsdd.onH2Enter = function(e){
			thatH2Over = true;
		};

		mpsdd.onH2Leave = function(e){
			thatH2Over = false;
			thatULTimeout = setTimeout(mpsdd.onTimeout, 500);
		};

		mpsdd.onH2Click = function(e){
			if($(thatH2).hasClass('shown')) $(thatUL).slideUp(500);
			else $(thatUL).slideDown(500);
			$(thatH2).toggleClass('shown');
		};

		mpsdd.onULEnter = function(e){
			thatULOver = true;
		};

		mpsdd.onULLeave = function(e){
			thatULOver = false;
			thatULTimeout = setTimeout(mpsdd.onTimeout, 500);
		};

		mpsdd.onTimeout = function(){
			if(!thatULOver && !thatH2Over && $(thatH2).hasClass('shown')) $(thatH2).click();
			clearTimeout(thatULTimeout);
		};

		mpsdd.onLiClick = function(e){
			if($(this).hasClass('current')) return;
			var thisLi = $(this),
			thisId = $(thisLi).attr('id');
			pods = podStrings[thisId - 1].pods;
			$(thatUL).find('li').each(function(){$(this).removeClass('current');});
			$(thisLi).addClass('current');
			$(thatH2).click();
			$(thatLoading).fadeTo(500, 1);
			$(content).fadeTo(500, 0, function(){
				var podsOutput = '',
				local = <?php echo $local; ?>;
				$(this).css({'min-height' : $(this).innerHeight() + 'px'}).empty();
				for(var i = 0; i < pods.length; i++){
					var pod = pods[i],
					podUrl = (local) ? '<?php echo $config['pod_url']; ?>' : pod.pod_url,
					imageUrl = pod.pod_url.split('/')[2].split('.');
					imageUrl[0] = 'images';
					imageUrl = 'http://' + imageUrl.join('.') + '/';
					
					podsOutput += '<div class="pod" id="pod' + (i + 1) + '">';
						podsOutput += '<div class="pod-image">';
							podsOutput += '<a href="' + podUrl + '" title="' + pod.pod_name + '">';
								podsOutput += '<img src="' + imageUrl + pod.pod_html_img + '" alt="' + pod.pod_name + ' Image">';
								
								podsOutput += '<div id="play-button">';
									podsOutput += '<img src="<?php echo $config['image_url']; ?>sharedimages/playbutton.png" alt="Play Button">';
								podsOutput += '</div>';
							podsOutput += '</a>';
						podsOutput += '</div>';
						
						podsOutput += '<div class="pod-info" data-title="' + pod.pod_name + '" data-desc="' + pod.pod_desc.replace(/<[^>]+>/ig, "") + '">';
							podsOutput += '<h2>';
								podsOutput += '<a href="' + podUrl + '" title="' + pod.pod_name + '">';
									podsOutput += pod.pod_name.substr(0, 50) + '...';
								podsOutput += '</a>';
							podsOutput += '</h2>';
							
							podsOutput += '<p>' + pod.pod_desc.replace(/<[^>]+>/ig, "").substr(0, 150) + '...' + '</p>';
						podsOutput += '</div>';
					
						podsOutput += '<div class="visit-pod">';
							podsOutput += '<a href="' + podUrl + '" title="' + pod.pod_name + '">';
								podsOutput += 'Visit Pod';
							podsOutput += '</a>';
						podsOutput += '</div>';
					podsOutput += '</div>';
				}
				$(thatH2).find('span').html($(thisLi).text());
				$(this).html(podsOutput).fadeTo(500, 1, function(){$(this).css({'min-height' : '0px'});$(thatLoading).fadeTo(500, 0, function(){$(this).hide();});});
				if($('html').hasClass('no-csstransitions')){
					$('.pod').each(function(){
						var thisPod = $(this), thisImage = $(thisPod).find('.pod-image');
						if($('body').hasClass('bp3') || $('body').hasClass('msie7') || $('body').hasClass('msie8')) $(thisPod).mouseenter(function(e){$(thisImage).animate({left : '-100%'}, 333);}).mouseleave(function(e){$(thisImage).animate({left : '0'}, 333);});
						else $(thisPod).unbind('mouseenter mouseleave');
					});
				}
			});
		};

		podStrings = [
			<?php //echo json_encode($mpShared->getCategoryPods(['count' => 12, 'sortType' => 1, 'categoryId' => $mpArticle->data['cat_id']])); ?>,
			<?php //echo json_encode($mpShared->getCategoryPods(['count' => 12, 'sortType' => 2, 'categoryId' => $mpArticle->data['cat_id']])); ?>,
			<?php //echo json_encode($mpShared->getCategoryPods(['count' => 12, 'sortType' => 4, 'categoryId' => $mpArticle->data['cat_id']])); ?>,
			<?php //echo json_encode($mpShared->getCategoryPods(['count' => 12, 'sortType' => 5, 'categoryId' => $mpArticle->data['cat_id']])); ?>
		];

		$(thatParent).css({'cursor' : 'pointer'});
		$(thatH2).mouseenter(mpsdd.onH2Enter).mouseleave(mpsdd.onH2Leave).click(mpsdd.onH2Click);
		$(thatUL).mouseenter(mpsdd.onULEnter).mouseleave(mpsdd.onULLeave);
		$(thatUL).find('li').each(function(){$(this).click(mpsdd.onLiClick);});
	});
};

$.fn.mpPreview = function(opts){
	
	var lightboxCont = $('#lightbox-cont'),
	overlay = $(lightboxCont).find('.overlay'),
	lightboxContent = $(lightboxCont).find('#lightbox-content'),
	lightboxPreviewCont = $(lightboxCont).find('#lightbox-preview-cont'),
	lightboxClose = $(lightboxCont).find('.preview-close'),
	scrollableEl = scrollableElement('html', 'body');
	
	return this.each(function(){
		var thisPreview = $(this);
	
		$(thisPreview).click(function(e){
			$(lightboxCont).addClass('lightbox-shown');
			$(lightboxContent).css('display', 'block');
			$('#lightbox-preview-cont').css('z-index', '55');
	
		});

		$(overlay).add(lightboxClose).click(function(e){
			$(lightboxCont).removeClass('lightbox-shown');
			$(lightboxContent).css('display', 'none');
			$('#pause-button').trigger('click');
			
		});
	});
};

$.fn.mpSearch = function(){ 
	return this.each(function(){
		var form = $(this),
		input = $(form).find('input');
		
		$(form).on("submit", function(e){
			var searchTerm = $(input).val().split(' ').join('%20');
			window.location = "<?php echo $config['this_url']; ?>search/?q=" + searchTerm;
			e.preventDefault();
		});
	});
}

