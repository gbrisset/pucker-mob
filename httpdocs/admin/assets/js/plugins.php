<?php
	Header("content-type: application/x-javascript");
	require_once('../../../assets/php/config.php');
?>

jQuery.fn.farbtastic=function(e){$.farbtastic(this,e);return this};jQuery.farbtastic=function(e,t){var e=$(e).get(0);return e.farbtastic||(e.farbtastic=new jQuery._farbtastic(e,t))};jQuery._farbtastic=function(e,t){var n=this;$(e).html('<div class="farbtastic"><div class="color"></div><div class="wheel"></div><div class="overlay"></div><div class="h-marker marker"></div><div class="sl-marker marker"></div></div>');var r=$(".farbtastic",e);n.wheel=$(".wheel",e).get(0);n.radius=84;n.square=100;n.width=194;if(navigator.appVersion.match(/MSIE [0-6]\./)){$("*",r).each(function(){if(this.currentStyle.backgroundImage!="none"){var e=this.currentStyle.backgroundImage;e=this.currentStyle.backgroundImage.substring(5,e.length-2);$(this).css({backgroundImage:"none",filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=crop, src='"+e+"')"})}})}n.linkTo=function(e){if(typeof n.callback=="object"){$(n.callback).unbind("keyup",n.updateValue)}n.color=null;if(typeof e=="function"){n.callback=e}else if(typeof e=="object"||typeof e=="string"){n.callback=$(e);n.callback.bind("keyup",n.updateValue);if(n.callback.parent().prev("input").val()){n.setColor(n.callback.parent().prev("input").val())}}return this};n.updateValue=function(e){if(this.value&&this.value!=n.color){n.setColor(this.value)}};n.setColor=function(e){var t=n.unpack(e);if(n.color!=e&&t){n.color=e;n.rgb=t;n.hsl=n.RGBToHSL(n.rgb);n.updateDisplay()}return this};n.setHSL=function(e){n.hsl=e;n.rgb=n.HSLToRGB(e);n.color=n.pack(n.rgb);n.updateDisplay();return this};n.widgetCoords=function(e){var t,r;var i=e.target||e.srcElement;var s=n.wheel;if(typeof e.offsetX!="undefined"){var o={x:e.offsetX,y:e.offsetY};var u=i;while(u){u.mouseX=o.x;u.mouseY=o.y;o.x+=u.offsetLeft;o.y+=u.offsetTop;u=u.offsetParent}var u=s;var a={x:0,y:0};while(u){if(typeof u.mouseX!="undefined"){t=u.mouseX-a.x;r=u.mouseY-a.y;break}a.x+=u.offsetLeft;a.y+=u.offsetTop;u=u.offsetParent}u=i;while(u){u.mouseX=undefined;u.mouseY=undefined;u=u.offsetParent}}else{var o=n.absolutePosition(s);t=(e.pageX||0*(e.clientX+$("html").get(0).scrollLeft))-o.x;r=(e.pageY||0*(e.clientY+$("html").get(0).scrollTop))-o.y}return{x:t-n.width/2,y:r-n.width/2}};n.mousedown=function(e){if(!document.dragging){$(document).bind("mousemove",n.mousemove).bind("mouseup",n.mouseup);document.dragging=true}var t=n.widgetCoords(e);n.circleDrag=Math.max(Math.abs(t.x),Math.abs(t.y))*2>n.square;n.mousemove(e);return false};n.mousemove=function(e){var t=n.widgetCoords(e);if(n.circleDrag){var r=Math.atan2(t.x,-t.y)/6.28;if(r<0)r+=1;n.setHSL([r,n.hsl[1],n.hsl[2]])}else{var i=Math.max(0,Math.min(1,-(t.x/n.square)+.5));var s=Math.max(0,Math.min(1,-(t.y/n.square)+.5));n.setHSL([n.hsl[0],i,s])}return false};n.mouseup=function(){$(document).unbind("mousemove",n.mousemove);$(document).unbind("mouseup",n.mouseup);document.dragging=false};n.updateDisplay=function(){var e=n.hsl[0]*6.28;$(".h-marker",r).css({left:Math.round(Math.sin(e)*n.radius+n.width/2)+"px",top:Math.round(-Math.cos(e)*n.radius+n.width/2)+"px"});$(".sl-marker",r).css({left:Math.round(n.square*(.5-n.hsl[1])+n.width/2)+"px",top:Math.round(n.square*(.5-n.hsl[2])+n.width/2)+"px"});$(".color",r).css("backgroundColor",n.pack(n.HSLToRGB([n.hsl[0],1,.5])));if(typeof n.callback=="object"){$(n.callback).css({backgroundColor:n.color,color:n.hsl[2]>.5?"#000":"#fff"});$(n.callback).parent().prev("input").each(function(){if(this.value&&this.value!=n.color){this.value=n.color}})}else if(typeof n.callback=="function"){n.callback.call(n,n.color)}};n.absolutePosition=function(e){var t={x:e.offsetLeft,y:e.offsetTop};if(e.offsetParent){var r=n.absolutePosition(e.offsetParent);t.x+=r.x;t.y+=r.y}return t};n.pack=function(e){var t=Math.round(e[0]*255);var n=Math.round(e[1]*255);var r=Math.round(e[2]*255);return"#"+(t<16?"0":"")+t.toString(16)+(n<16?"0":"")+n.toString(16)+(r<16?"0":"")+r.toString(16)};n.unpack=function(e){if(e.length==7){return[parseInt("0x"+e.substring(1,3))/255,parseInt("0x"+e.substring(3,5))/255,parseInt("0x"+e.substring(5,7))/255]}else if(e.length==4){return[parseInt("0x"+e.substring(1,2))/15,parseInt("0x"+e.substring(2,3))/15,parseInt("0x"+e.substring(3,4))/15]}};n.HSLToRGB=function(e){var t,n,r,i,s;var o=e[0],u=e[1],a=e[2];n=a<=.5?a*(u+1):a+u-a*u;t=a*2-n;return[this.hueToRGB(t,n,o+.33333),this.hueToRGB(t,n,o),this.hueToRGB(t,n,o-.33333)]};n.hueToRGB=function(e,t,n){n=n<0?n+1:n>1?n-1:n;if(n*6<1)return e+(t-e)*n*6;if(n*2<1)return t;if(n*3<2)return e+(t-e)*(.66666-n)*6;return e};n.RGBToHSL=function(e){var t,n,r,i,s,o;var u=e[0],a=e[1],f=e[2];t=Math.min(u,Math.min(a,f));n=Math.max(u,Math.max(a,f));r=n-t;o=(t+n)/2;s=0;if(o>0&&o<1){s=r/(o<.5?2*o:2-2*o)}i=0;if(r>0){if(n==u&&n!=a)i+=(a-f)/r;if(n==a&&n!=f)i+=2+(f-u)/r;if(n==f&&n!=u)i+=4+(u-a)/r;i/=6}return[i,s,o]};$("*",r).mousedown(n.mousedown);n.setColor("#000000");if(t){n.linkTo(t)}}



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
	popupClose = this.find('#'+options.closeButtonClass);
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



/*	Redirect to a new seo title page
	Call this on the form input containing a new seo title to preform a redirect.
	arg1: The url path without the seo title

*/
$.fn.redirectToNewSEOTitle = function(basePath){
	var newSEOName = $(this).attr("value");
	newLocation = basePath + newSEOName;
	seoHasChanged = $('#seo_title_updated').attr("value");
	if(seoHasChanged){
		setTimeout(function(){
			window.location = newLocation;
		}, 400);
	}
}

/*	SEO Title auto complete...

		Call this method on a form input element that the user will be typing in
		argument1: The input to be auto-completed
		argument2: The hidden input that indicates the seo name has changed
*/

$.fn.SDSeoTitleAutoComplete = function(seoTitleInputName, hiddenInput){
	console.log(this);
	$(this).keyup(function () { 
		var title= $(this).val();
		title = title.replace(/[^0-9a-zA-Z_\s]/g, '');
		title = title.trim();
		title = title.toLowerCase().replace(/ /g, '-');

		$('input[name="'+seoTitleInputName+'"]').val(title);

		//	Change the value of the hiddenInput field to true, so we know to perform 
		//	a redirect.  Why?  The SEO name has been changed, so this edit page no longer exists.
		//	A redirect must be called, on submit (callback from mpValidate).
		$('input[name="'+hiddenInput+'"]').val("true");
	});		
}

/*

Radio Button Toggle

	Call this on a radio button input(s)
	When clicked, this function hides both divs given as args,
	Then show's the :selected div

*/

$.fn.SDRadioToggler = function(divName1, divName2){
	$(this).click(function(e){
		var selectedRadio = $(this).parent().find("input[name$='media_type']:checked").val(),
		displayedDiv = $(this).parent().find('#'+selectedRadio);
		div1 = $(this).parent().find(divName1);
		div2 = $(this).parent().find(divName2);

		div1.hide();
		div2.hide();
		displayedDiv.fadeIn(300);

	});	
}


/*	Click toggler...

		Call this method on an element to be clicked
		takes 1 arg: The element to be shown, set it's css display property to none in the css
*/

$.fn.SDToggler = function(hiddenDiv){
	$(this).click(function(e){
		var cont = $(''+hiddenDiv+'');
		if($(cont).hasClass('shown')) {
			$(cont).slideUp(500);
		} else {
			$(cont).slideDown(500);
		}
		//$(cont).toggleClass('shown');
	});
}


$.fn.mpColorPicker = function(){
	return this.each(function(){
		var thisPicker = $(this),
		thisFeildsetParent = $(thisPicker).parents('fieldset'),
		thisPickerParent = $(thisPicker).parents('.colorpicker-parent'),
		thisInput = $(thisFeildsetParent).find('.picker-input'),
		thisPickerHandle = $(thisFeildsetParent).find('.picker-element'),
		thisDefaultValue = $(thisInput).val(),
		farb = $.farbtastic(thisPicker, onColorChange);

		farb.setColor(thisDefaultValue);
		setHandleColor(thisDefaultValue);

		$(thisPickerHandle).click(function(e){
			if($(thisPickerParent).hasClass('shown')) $(thisPickerParent).slideUp(500);
			else $(thisPickerParent).slideDown(500);
			$(thisPickerParent).toggleClass('shown');
		});

		function onColorChange(color){
			setHandleColor(color);
			$(thisInput).val(color);
		};
		
		function setHandleColor(color){
			if(color.substr(0, 1) !== '#') color = "#" + color.substr(0, 6);
			$(thisPickerHandle).css('background-color', color);
		};
	});
};

$.fn.mpTooltip = function(){
	return this.each(function(){
		var thisToolTip = $(this),
		thisToolTipInfo = $(thisToolTip).find('.tooltip-info'),
		ttIconOver = false, ttOver = false, ttTimeout = null;

		$(thisToolTip).mouseenter(function(e){
			$(thisToolTipInfo).fadeTo(200, 1);
			ttIconOver = true;
		}).mouseleave(function(e){
			ttIconOver = false;
			ttTimeout = setTimeout(onTimeout, 200);
		});

		$(thisToolTipInfo).mouseenter(function(e){
			ttOver = true;
		}).mouseleave(function(e){
			ttOver = false;
			ttTimeout = setTimeout(onTimeout, 200);
		});

		function onTimeout(){
			if(!ttOver && !ttIconOver) $(thisToolTipInfo).fadeTo(200, 0, function(){$(this).hide();});
			clearTimeout(ttTimeout);
		};
	});
};

$.fn.mpAddElement = function(){
	return this.each(function(e){
		
		$(this).on('click', function(e){
			
			var thisElement = $(this),
			parent = thisElement.parent(),
			box = parent.parent(),
			fieldset = box.parent();
			input_box = box.children('.input-elements'),
			prefix = 'article_'+fieldset.attr('id')+'-nf';//$(box).attr('data-info'),
			label = $(box).attr('data-label');

			e.preventDefault();

			var total_childrens = $(input_box).children('input').length + 2,
			input = $('<input/>', {
			    	id:    prefix+'-'+total_childrens,
			    	class: prefix+'-'+total_childrens,
			    	name:  prefix+'-'+total_childrens,
			    	type:  "text",
			    	placeholder: "Insert "+label+" here."
				 }),
			span = $('<span />', {
				class: 'remove-element'
			}),
			a = $('<a />', {
				href: ''
			}),
			i = $('<i />', {
				class: 'icon-minus-sign'
			});

			i.appendTo(a);
			a.appendTo(span);
	
			span.click(function(e){
				var element_id = '#'+$(this).prev().attr('id');
				e.preventDefault();
				$(input_box).children(element_id).remove();
				$(this).remove();
			});
			input.appendTo(input_box);
			span.appendTo(input_box);
		});

	});
};

$.fn.mpPreview = function(opts){
	var options = $.extend({
		'selector' : 'select',
		'containingElement' : 'option',
		'filter' : ':selected'
	}, opts),
	lightboxCont = $('#lightbox-cont'),
	overlay = $(lightboxCont).find('.overlay'),
	lightboxContent = $(lightboxCont).find('.lightbox-content'),
	lightboxPreviewCont = $(lightboxCont).find('#lightbox-preview-cont'),
	lightboxClose = $(lightboxCont).find('#preview-close'),
	scrollableEl = scrollableElement('html', 'body');

	return this.each(function(){
		//	This is what is being clicked...
		var thisPreview = $(this),
		//	This is the ancestors of this, in this case, the fieldset
		thisFieldsetParent = $(thisPreview).parents('fieldset'),
		//	This finds the selector that is the parent of the container for the content.
		thisSelector = $(thisFieldsetParent).find(options.selector);

		$(thisPreview).click(function(e){
			//	thisSelected = the parent selector containg the selected option element 
			//	In the default case, a select element
			var thisSelected = $(thisSelector).find(options.containingElement).filter(options.filter);
			$(lightboxPreviewCont).empty().html($(thisSelected).attr('data-preview'));
			console.log(thisSelected);
			$(lightboxCont).addClass('lightbox-shown');
		});

		$(overlay).add(lightboxClose).click(function(e){
			$(lightboxCont).removeClass('lightbox-shown');
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

$.fn.mpSearchAdmin = function(){ 
	return this.each(function(){
		var form = $(this),
		input = $(form).find('input');
		
		$(form).on("submit", function(e){
			var searchTerm = $(input).val().split(' ').join('%20');
			window.location = "<?php echo $config['this_url']; ?>admin/search/?q=" + searchTerm;
			e.preventDefault();
		});
	});
}

$.fn.mpValidate = function(opts){
	var options = $.extend({
		updateUrl : '',
		callback : function(){},
		additionalParams : {},
		imageFile : ''
	}, opts);

	return this.each(function(){
		var thisForm = $(this),
		thisId = thisForm.attr('id'),
		result = thisForm.find('#result'),
		submit = thisForm.find('#submit');

		
		submit.click(function(e){
			if(!options.updateUrl.length) return;
			e.preventDefault();
			submit.attr('disabled', true);
			var confirmed = false;

			if(tinyMCE){
				tinyMCE.triggerSave();
			}

			if(options.additionalParams == 'file' && $(options.imageFile)[0].files[0] != null){
				
				if( !window.FormData ) return;
				
				var file = $(options.imageFile)[0].files[0],
				url = options.updateUrl,
				data = new FormData,
				xhr = new XMLHttpRequest;
			
				data.append('formData', thisForm.serialize());
				data.append('file', file);
				data.append('formId', thisId);
				
				xhr.file = file;
				xhr.open('post', url, true);
				xhr.send(data);

				xhr.onreadystatechange =  function(e){
					console.log("Ready state change", this.readyState, this);
					switch(this.readyState){
						case 4:
							data  = JSON.parse(this.response);
							console.log('Response: ', data);
							
							options.callback(thisForm, data);

							if(data.message) result.empty().append(data.message);
							if(data.hasError !== undefined) result.addClass((!data.hasError) ? 'success' : 'error');
							
							submit.attr('disabled', false);
							
							break;
					}
				};

			} else {
			
				if((options.additionalParams == 'confirm' && !confirm('Are you sure you want to delete this?', function(){confirmed = true}))) {

					//	If the confirm param is true AND the annon func in confirm() resolves to !(true)
					//	Don't do anything...Just reset the submit's state...

						submit.attr('disabled', false);

				} else {
					
					//	Else: Confirm is not a param OR confirm is a param, but the annon func in confirm() resolves to true
					//	Perform the ajax post (or delete)...
					
						console.log(thisForm.serialize());
						$.post(options.updateUrl, {
								formData : thisForm.serialize(),
								formId : thisId,
								additionalParams : options.additionalParams
							},
							function(data){
								console.log(data);
								//alert(data);
								data = JSON.parse(data);

								options.callback(thisForm, data);

								if(data.message) result.empty().append(data.message);
								if(data.hasError !== undefined) result.addClass((!data.hasError) ? 'new-success' : 'error').slideDown('slow').delay(5000).slideUp('slow');
								
								submit.attr('disabled', false);
							}
						);
				}
			}
			
		});
	});
};

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


$.fn.mpImageCropUpload = function( opts, e ){
	var options = $.extend({
		fileCount : 1,
		allowedExtensions: ['png', 'jpg', 'jpeg', 'gif'],
		onClomplete: null,
		desWidth: 0,
		desHeight: 0
	}, opts);

	var jcrop_api, boundx, boundy;

	jQuery.event.props.push("dataTransfer");
	
	return this.each(function(){
		$thisElement = $(this);
		var desWidth= opts['desWidth'], desHeight= opts['desHeight'];
		
		// convert bytes into friendly format
		bytesToSize = function(bytes) {
		    var sizes = ['Bytes', 'KB', 'MB'];
		    if (bytes == 0) return 'n/a';
		    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
		    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
		},

		// check for selected crop region
		checkForm = function() {
		    if (parseInt($('#w').val())) return true;
		    $('.error').html('Please select a crop region and then press Upload').show();
		    return false;
		},


		// update info by cropping (onChange and onSelect events handler)
		updateInfo = function(e) {
		    $('#x1').val(e.x);
		    $('#y1').val(e.y);
		    $('#w').val(e.w);
		    $('#h').val(e.h);
		   
		    $('#fw').text(Math.round(e.w));
		    $('#fh').text(Math.round(e.h));
		},

		// clear info by cropping (onRelease event handler)
		clearInfo = function() {
		    $('.info #w').val('');
		    $('.info #h').val('');

		    $('.info #fh').text('');
		    $('.info #fw').text('');
		},

		fileSelectHandler = function() {

		    // get selected file
		    var oFile = $thisElement[0].files[0];

		    $('.error-img').hide();

		    // check for image type allowed
		    var rFilter = /^(image\/jpeg|image\/jpg|image\/png|image\/gif)$/i;
		    if (! rFilter.test(oFile.type)) {
		        $('.error-img').text('Please select a valid image file (jpg, jpeg, gif and png are allowed)').removeClass('new-success').addClass('error').slideDown( "slow" ).delay( 1000 ).slideUp( "slow" );
		        $('#lightbox-cont2').hide();
		        return;
		    }

		    // check for file size
		    if (oFile.size > 1 * 1024 * 1024) {
		        $('.error-img').text('This image size exceed the max size ( 1MB ), please select an smaller image.').removeClass('new-success').addClass('error').slideDown( "slow" ).delay( 8000 ).slideUp( "slow" );
		        $('#lightbox-cont2').hide();
		        return;
		    }

		    // preview element
		    var oImage = document.getElementById('preview');
		    $('#lightbox-cont2').show();
		    // prepare HTML5 FileReader
		    var oReader = new FileReader();
		    oReader.onload = function(e) {

		        // e.target.result contains the DataURL which we can use as a source of the image
		        oImage.src = e.target.result;
		      

		        oImage.onload = function () { // onload event handler
		        
		        	//check if the width and height are more than the desire width and height provider
		        	if( oImage.naturalWidth < desWidth || oImage.naturalHeight < desHeight){
		        	var msg = "The image selected should have a minimun width and height of: "+desWidth+" x "+desHeight+" pixels.";
		        		$('.error-img').html(msg).removeClass('new-success').show();
		        		$('#lightbox-cont2').hide();
		        		return;
		        	}

		            // display step 2
		            $('.step2').fadeIn(500);
		            $('.info').fadeIn(500);

		            // display some basic image info
		            var sResultFileSize = bytesToSize(oFile.size);
		            var sNameFile = oFile.name;
		            $('#filesize').val(sResultFileSize);
		            $('#filenametext').text(sNameFile);
		            $('#filesizetext').text(sResultFileSize);
		            $('#filetype').text(oFile.type);
		            $('#filedim').text(oImage.naturalWidth + ' x ' + oImage.naturalHeight);
		            $('#dimWidth').val(oImage.naturalWidth);
		            $('#dimHeight').val(oImage.naturalHeight);

		            // destroy Jcrop if it is existed
		            if (typeof jcrop_api != 'undefined') {
		                jcrop_api.destroy();
						jcrop_api = null;
						$('#preview').width(oImage.naturalWidth);
						$('#preview').height(oImage.naturalHeight); 
		            }

		            // initialize Jcrop
		            $('#preview').Jcrop({
		            	aspectRatio: 1,
		                minSize: [desWidth, desHeight],
		                bgFade: true,
		                bgOpacity: .3,
		                onChange: updateInfo,
		                onSelect: updateInfo,
		                onRelease: clearInfo,
		                setSelect: [ 200, 200, 0, 0 ]
		            }, function(){
		                // use the Jcrop API to get the real image size
		                var bounds = this.getBounds();
		                boundx = bounds[0];
		                boundy = bounds[1];
		                
		                // Store the Jcrop API in the jcrop_api variable
		                jcrop_api = this;
		            });
		            
		        };
		    };

		    // read selected file as DataURL
		    oReader.readAsDataURL(oFile);
		}

		$thisElement.on('change', function(e){
			fileSelectHandler();

		});

	});
};

$.fn.mpImageUpload = function(opts){
	var options = $.extend({
		fileCount : 1,
		allowedExtensions : ['png', 'jpg', 'jpeg', 'gif'],
		uploadUrl : '',
		
		onComplete : null
	}, opts);
	jQuery.event.props.push("dataTransfer");
	return this.each(function(){
		var that = {},
		thisContainer = $(this),
		thisUploadZone = $(thisContainer).find('.image-upload-zone'),
		thisUploadForm = $(thisUploadZone).find('form'),
		thisCT = thisUploadForm.find('#c_t').val(),
		thisUploadField = $(thisUploadForm).find('input'),
		thisDropText = $(thisUploadZone).find('p').eq(0),
		thisPreviewContainer = $(thisContainer).find('.image-preview'),
		thisPreviewImg = $(thisPreviewContainer).find('img'),
		currentImageName = $(thisPreviewImg).attr('src').split('/').pop(),
		lastUploadedFile,
		queue = [];

		that.init = function(){
			if(!Modernizr.draganddrop || !window.FileReader || !window.FormData) return;

			$(thisUploadZone).addClass('drop-zone');
			that.imagesUploading = false;
			$(thisUploadZone).on({
				'dragover' : that.onDragOver,
				'dragenter' : that.onDragOver,
				'dragleave' : that.onDragLeave,
				'drop' : that.onImageDrop
			});
			$(thisUploadField).on('change', that.onInputChange);
			$(thisDropText).on('click', 'a', that.onManualTriggerClick);
		};

		that.onDragOver = function(e){
			console.log("Over/Enter");
			e.preventDefault();
			$(thisUploadZone).addClass('hover');
			return false;
		};

		that.onDragLeave = function(e){
			console.log("Out");
			$(thisUploadZone).removeClass('hover');
		};

		that.onImageDrop = function(e){
			console.log("Drop");
			if(e.stopPropagation) e.stopPropagation();
			e.preventDefault();
			var files = e.dataTransfer.files;
			if(!that.imagesUploading) that.fileUploadHandler(files);
		};

		that.onManualTriggerClick = function(e){
			console.log("Manual");
			$(thisUploadField).click();
			return false;
		};

		that.onInputChange = function(e){
			console.log("Input change");
			var files = this.files;
			if(!that.imagesUploading) that.fileUploadHandler(files);
		};

		that.onUserLeave = function(e){
			console.log("User leave");
			return "If you leave now, any images that haven't finished uploading will be lost!";
		};

		that.fileUploadHandler = function(files){
			console.log("Handler");
			that.queueFiles(files);
			if(queue.length){
				console.log("Have length");
				var statusTxt = 'Now uploading!  Please hang around until your image' + ((options.fileCount > 1 && files.length > 1) ? 's have' : ' has') + ' succefully uploaded.'
				$(thisDropText).html(statusTxt);
				window.onbeforeunload = that.onUserLeave;
				that.imagesUploading = true;
				setTimeout(that.uploadFiles(),3000);
				//that.uploadFiles();			
			}else{
				that.upLoadComplete({
					'hasError' : true,
					'message' : 'Sorry, no valid files were found.  Please try again.'
				});
			}
		};

		that.uploadFiles = function(){
			console.log("Upload handler");
			if(!queue.length) return that.upLoadComplete({
				'hasError' : false,
				'message' : 'All files uploaded successfully!',
				'lastUploadedFile' : lastUploadedFile
			});
			
			console.log("Have file to upload", queue[0]);
			
			var file = queue[0],
			url = options.uploadUrl,
			data = new FormData, 
			params,
			xhr = new XMLHttpRequest;
			
			url += (url.indexOf('?') !== -1) ? '&' : '?';
			url += 'allowedExtensions=' + options.allowedExtensions.join(',');
			console.log('Upload DIR: ', url);
			data.append('file', file);
			data.append('c_t', thisCT);
			console.log("data: ", data);
			xhr.file = file;
			xhr.onprogress = that.onUploadProgress;
			xhr.onreadystatechange = that.onUploadReadyStateChange;
			xhr.open('post', url, true);
			xhr.send(data);
			console.log('Request sent: ', xhr);			
		};

		that.onUploadProgress = function(e){
			console.log("upLoad Progress", e);
		};

		that.onUploadReadyStateChange = function(e){
			console.log("Ready state change", this.readyState, this);
			switch(this.readyState){
				case 4:
					var resp  = JSON.parse(this.response);
					console.log('Response: ', resp);
					if(resp.hasError){
						that.upLoadComplete({
							'hasError' : true,
							'message' : resp.message
						});
					}else{
						currentImageName = (queue[0].value !== null && queue[0].value !== undefined) ? queue[0].value.replace(/.*(\/|\\)/, '') : (queue[0].fileName !== null && queue[0].fileName !== undefined) ? queue[0].fileName : queue[0].name;
						lastUploadedFile = queue[0];
						console.log('Current Image Name: ', currentImageName);
						queue.shift();
						that.uploadFiles();
					}
					break;
			}
		};

		that.upLoadComplete = function(resp){
			window.onbeforeunload = null;
			that.imagesUploading = false;
			
			$(thisDropText).html('Drop your image here or click <a id="manual-upload" href="#">here</a> to manually choose one.');
			$(thisUploadZone).removeClass('hover');

			resp.options = options;

			that.dispatchEvent("onComplete", resp);
		};

		that.queueFiles = function(files){
			console.log("Queue files", files, options.fileCount);
			var len = (options.fileCount == -1 || options.fileCount > files.length) ? files.length : options.fileCount;
			for(var i = 0; i < len; i++){
				var file = files[i];
				file.uniqueId = parseInt(Math.random() * 999999999999, 10);
				console.log("File:", file, files, i, len);
				if(that.validateFile(file)){
					console.log("Valid file");
					queue.push(file);
				}
			}
		};

		that.validateFile = function(file){
			var name, size, type, extension,
			re = /^image/;

			name = (file.value !== null && file.value !== undefined) ? file.value.replace(/.*(\/|\\)/, '') : (file.fileName !== null && file.fileName !== undefined) ? file.fileName : file.name;
			size = (file.size !== null && file.size !== undefined) ? file.size : 0;
			type = (file.type !== null && file.type !== undefined) ? file.type : null;
			extension = (name !== null) ? name.split('.').pop() : null;
			console.log('name of file: '+ name);
			console.log('current name of file: '+ currentImageName);
			
			console.log(type, extension, size, $.inArray(extension, options.allowedExtensions), re.test(type), currentImageName, name);
			if(
				currentImageName == name ||
				type === null || 
				extension === null || 
				size == 0 || 
				$.inArray(extension, options.allowedExtensions) == -1 || 
				!re.test(type)
			) {
				console.log('validateFile is returning FALSE');
				return false;
			}
			return true;				
		};

		that.dispatchEvent = function(name){
			if(options[name] && typeof options[name] == "function") options[name](arguments[1]);
		}

		that.init();		
	});
};

$.fn.filterByText = function(textbox, selectSingleMatch) {
        return this.each(function() {
            var select = this;
            var options = [];
            $(select).find('option').each(function() {
                options.push({value: $(this).val(), text: $(this).text()});
            });
            $(select).data('options', options);
            $(textbox).bind('change keyup', function() {
                var options = $(select).empty().data('options');
                var search = $(this).val().trim();
                var regex = new RegExp(search,"gi");
              
                $.each(options, function(i) {
                    var option = options[i];
                    if(option.text.match(regex) !== null) {
                        $(select).append(
                           $('<option>').text(option.text).val(option.value)
                        );
                    }
                });
                if (selectSingleMatch === true && $(select).children().length === 1) {
                    $(select).children().get(0).selected = true;
                }
            });            
        });
    };

$.fn.mpImageDisplay = function(opts){
	var options = $.extend({
		fileCount : 1,
		allowedExtensions : ['png', 'jpg', 'jpeg', 'gif'],
		uploadUrl : '',
		
		onComplete : null
	}, opts);
	jQuery.event.props.push("dataTransfer");
	return this.each(function(){
		var that = {},
		thisContainer = $(this),
		thisUploadZone = $(thisContainer).find('.image-upload-zone'),
		thisUploadForm = $(thisUploadZone).find('form'),
		thisCT = thisUploadForm.find('#c_t').val(),
		thisUploadField = $(thisUploadForm).find('input'),
		thisDropText = $(thisUploadZone).find('p').eq(0),
		thisPreviewContainer = $(thisContainer).find('.image-preview'),
		thisPreviewImg = $(thisPreviewContainer).find('img'),
		currentImageName = $(thisPreviewImg).attr('src').split('/').pop(),
		lastUploadedFile,
		queue = [];

		that.init = function(){
			if(!Modernizr.draganddrop || !window.FileReader || !window.FormData) return;

			$(thisUploadZone).addClass('drop-zone');
			that.imagesUploading = false;
			$(thisUploadZone).on({
				'dragover' : that.onDragOver,
				'dragenter' : that.onDragOver,
				'dragleave' : that.onDragLeave,
				'drop' : that.onImageDrop
			});
			$(thisUploadField).on('change', that.onInputChange);
			$(thisDropText).on('click', 'a', that.onManualTriggerClick);
		};

		that.onDragOver = function(e){
			console.log("Over/Enter");
			e.preventDefault();
			$(thisUploadZone).addClass('hover');
			return false;
		};

		that.onDragLeave = function(e){
			console.log("Out");
			$(thisUploadZone).removeClass('hover');
		};

		that.onImageDrop = function(e){
			console.log("Drop");
			if(e.stopPropagation) e.stopPropagation();
			e.preventDefault();
			var files = e.dataTransfer.files;
			if(!that.imagesUploading) that.ImagePreview(files);
		};

		that.onManualTriggerClick = function(e){
			console.log("Manual");
			$(thisUploadField).click();
			return false;
		};

		that.onInputChange = function(e){
			console.log("Input change");
			var files = this.files;
			if(!that.imagesUploading) that.ImagePreview(files);
		};

		that.onUserLeave = function(e){
			console.log("User leave");
			return "If you leave now, any images that haven't finished uploading will be lost!";
		};

		that.ImagePreview = function(files){
			console.log("Preview Image");
			that.queueFiles(files);
			if(queue.length){
				console.log("Have length");
				var statusTxt = 'Now uploading!  Please hang around until your image' + ((options.fileCount > 1 && files.length > 1) ? 's have' : ' has') + ' succefully uploaded.'
				$(thisDropText).html(statusTxt);
				window.onbeforeunload = that.onUserLeave;
				that.imagesUploading = true;

				console.log('FILE INFO: '+files);
				//setTimeout(that.uploadFiles(),3000);
				that.showFiles();			
			}else{
				that.upLoadComplete({
					'hasError' : true,
					'message' : 'Sorry, no valid files were found.  Please try again.'
				});
			}
		};

		that.fileUploadHandler = function(files){
			console.log("Handler");
			that.queueFiles(files);
			if(queue.length){
				console.log("Have length");
				var statusTxt = 'Now uploading!  Please hang around until your image' + ((options.fileCount > 1 && files.length > 1) ? 's have' : ' has') + ' succefully uploaded.'
				$(thisDropText).html(statusTxt);
				window.onbeforeunload = that.onUserLeave;
				that.imagesUploading = true;
				setTimeout(that.uploadFiles(),3000);
				//that.uploadFiles();			
			}else{
				that.upLoadComplete({
					'hasError' : true,
					'message' : 'Sorry, no valid files were found.  Please try again.'
				});
			}
		};

		that.showFiles = function(){
			console.log("Show handler");
			if(!queue.length) return that.upLoadComplete({
				'hasError' : false,
				'message' : 'All files uploaded successfully!',
				'lastUploadedFile' : lastUploadedFile
			});

			console.log("Have file to Show", queue[0]);

			var file = queue[0];

			that.fileToShow();

		};

		that.fileToShow = function(){
			currentImageName = (queue[0].value !== null && queue[0].value !== undefined) ? queue[0].value.replace(/.*(\/|\\)/, '') : (queue[0].fileName !== null && queue[0].fileName !== undefined) ? queue[0].fileName : queue[0].name;
			lastUploadedFile = queue[0];
			console.log('Current Image Name: ', currentImageName);
			queue.shift();
			that.showFiles();
		};

		that.uploadFiles = function(){
			console.log("Upload handler ");
			if(!queue.length) return that.upLoadComplete({
				'hasError' : false,
				'message' : 'All files uploaded successfully!',
				'lastUploadedFile' : lastUploadedFile
			});
			
			console.log("Have file to upload", queue[0]);
			
			var file = queue[0],
			url = options.uploadUrl,
			data = new FormData, 
			params,
			xhr = new XMLHttpRequest;
			
			url += (url.indexOf('?') !== -1) ? '&' : '?';
			url += 'allowedExtensions=' + options.allowedExtensions.join(',');
			console.log('Upload DIR: ', url);
			data.append('file', file);
			data.append('c_t', thisCT);
			console.log("data: ", data);
			xhr.file = file;
			xhr.onprogress = that.onUploadProgress;
			xhr.onreadystatechange = that.onUploadReadyStateChange;
			xhr.open('post', url, true);
			xhr.send(data);
			console.log('Request sent: ', xhr);			
		};

		that.onUploadProgress = function(e){
			console.log("upLoad Progress", e);
		};

		that.onUploadReadyStateChange = function(e){
			console.log("Ready state change", this.readyState, this);
			switch(this.readyState){
				case 4:
					var resp  = JSON.parse(this.response);
					console.log('Response: ', resp);
					if(resp.hasError){
						that.upLoadComplete({
							'hasError' : true,
							'message' : resp.message
						});
					}else{
						currentImageName = (queue[0].value !== null && queue[0].value !== undefined) ? queue[0].value.replace(/.*(\/|\\)/, '') : (queue[0].fileName !== null && queue[0].fileName !== undefined) ? queue[0].fileName : queue[0].name;
						lastUploadedFile = queue[0];
						console.log('Current Image Name: ', currentImageName);
						queue.shift();
						that.uploadFiles();
					}
					break;
			}
		};

		that.upLoadComplete = function(resp){
			window.onbeforeunload = null;
			that.imagesUploading = false;
			
			$(thisDropText).html('Drop your image here or click <a id="manual-upload" href="#">here</a> to manually choose one.');
			$(thisUploadZone).removeClass('hover');

			resp.options = options;

			that.dispatchEvent("onComplete", resp);
		};

		that.queueFiles = function(files){
			console.log("Queue files", files, options.fileCount);
			var len = (options.fileCount == -1 || options.fileCount > files.length) ? files.length : options.fileCount;
			for(var i = 0; i < len; i++){
				var file = files[i];
				file.uniqueId = parseInt(Math.random() * 999999999999, 10);
				console.log("File:", file, files, i, len);
				if(that.validateFile(file)){
					console.log("Valid file");
					queue.push(file);
				}
			}
		};

		that.validateFile = function(file){
			var name, size, type, extension,
			re = /^image/;

			name = (file.value !== null && file.value !== undefined) ? file.value.replace(/.*(\/|\\)/, '') : (file.fileName !== null && file.fileName !== undefined) ? file.fileName : file.name;
			size = (file.size !== null && file.size !== undefined) ? file.size : 0;
			type = (file.type !== null && file.type !== undefined) ? file.type : null;
			extension = (name !== null) ? name.split('.').pop() : null;
			console.log('name of file: '+ name);
			console.log('current name of file: '+ currentImageName);
			
			console.log(type, extension, size, $.inArray(extension, options.allowedExtensions), re.test(type), currentImageName, name);
			if(
				currentImageName == name ||
				type === null || 
				extension === null || 
				size == 0 || 
				$.inArray(extension, options.allowedExtensions) == -1 || 
				!re.test(type)
			) {
				console.log('validateFile is returning FALSE');
				return false;
			}
			return true;				
		};

		that.dispatchEvent = function(name){
			if(options[name] && typeof options[name] == "function") options[name](arguments[1]);
		}

		that.init();		
	});
};