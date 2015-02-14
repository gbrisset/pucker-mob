<?php
	Header("content-type: application/x-javascript");
	require_once('../../../assets/php/config.php');
?>

$(document).ready(function (){
	var body = $('body');
	MQ.init([
		{ 
			context: 'admin0', 
			callback: function(){
				console.log('admin0');
				body.addClass('admin0').removeClass('admin0bp1 admin1 admin2');
				$('#header-menu .parent').mpShowSubMenu();
			} 
		},
		{ 
			context: 'admin0bp1', 
			callback: function(){
				console.log('admin0bp1');
				body.addClass('admin0bp1').removeClass('admin0 admin1 admin2');
				$('#header-menu .parent').mpShowSubMenu();
			} 
		},
		{ 
			context: 'admin1', 
			callback: function(){
				console.log('admin1');
				body.addClass('admin1').removeClass('admin0 admin0bp1 admin2');
				$('#header-menu .parent').mpShowSubMenu();
			} 
		},
		{ 
			context: 'admin2', 
			callback: function(){
				body.addClass('admin2').removeClass('admin0 admin0bp1 admin1');
				$('#nav-cont').show();
				$('#header-menu .parent').mpShowSubMenu();
				
			} 
		},
		{ 
			context: 'global', 
			callback: function(){
				if(body.is('.admin0, .admin1')){
					$('#nav-cont').hide().removeClass('shown');
				}else{
					body.removeClass('active_menu');
					$('#nav-sidemenu ul ul').each(function(){
						$(this).fadeTo(0, 1).css('z-index', 1);
						if(!$(this).hasClass('shown')) $(this).hide();
					});
				}

				if(body.hasClass('admin0bp1') || !body.hasClass('admin0')){
					$('.footer-list').each(function(){$(this).removeClass('shown');$(this).find('#connect-cont,ul,form').show();});
				}else{
					$('.footer-list').each(function(){$(this).find('ul, form, #connect-cont').hide();});
					if(!$('.footer-list').filter(':first').hasClass('shown')) $('.footer-list').filter(':first').find('h2').click();
				}
			} 
		}
	]);

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


	$('#menu-icon').click(function(e){
		if($('#nav-cont').hasClass('shown')) $('#nav-cont').slideUp(500);
		else{
			body.removeClass('active_menu');
			$('#nav-cont').slideDown(500);
		}
		$('#nav-cont').toggleClass('shown');
	});

	
		$('#export').on('click', function(e){
			e.preventDefault();
			var ahref ="http://www.puckermob.com/admin/reports/getsocialcsvreport.php?month="+$('#month-option').val()+"&year="+$('#year-option').val()+"&contributor="+$('#contributor-option').val();
			location.href = ahref;
		});
	

	$('#nav-sidemenu .parent').click(function(e){
		var subMenu = $(this).next();
		if(body.is('.admin0, .admin1')){
			$('nav').css('min-height', $(subMenu).height());
			body.toggleClass('active_menu');
			$('nav ul ul').each(function(){$(this).fadeTo(0, 0).css('z-index', 0);});
			$(subMenu).fadeTo(0, 1).css('z-index', 5);
		}else{
			if($(subMenu).hasClass('shown')){
				$(subMenu).slideUp(500, function(){$(this).removeClass('shown')});
			}else{
				$(subMenu).slideDown(500, function(){$(this).addClass('shown')});
			}
			$(this).toggleClass('shown');
		}

		e.preventDefault();
	});

	//Sort By Selection
	if($('#sort-by')){

		var ul = $('#sort-by').children('ul'),
		    a  = $(ul).children('li').children('a');
			 	
		$(a).each(function(e){
		    data_info = $(this).attr('data-info'),
		    sort_value = $('#sort-by-value').val();

		    if( data_info == sort_value ){
		    	$(this).addClass('current-sort-option');
		    }
		});
	}

	$('nav h2').click(function(e){
		body.toggleClass('active_menu');
	});

	$('.footer-list h2').each(function(){
		var thisH2 = $(this),
		cont = $(thisH2).parents('.footer-list'),
		slideObj = $(thisH2).next();

		thisH2.click(function(e){
			if(cont.hasClass('shown')) slideObj.slideUp(500);
			else slideObj.slideDown(500);
			cont.toggleClass('shown');
		});
	}).filter(':first').click();

	$('#sidebar-articles-form').on('submit', function(e){
		var thisForm = $(this),
		theseFields = [],
		selectedArticles = [];
		
		thisForm.find('fieldset select').each(function(){
			theseFields.push($(this));
			selectedArticles.push(parseInt($(this).find('option').filter(':selected').attr('value'), 10));
		});
		
		var len = selectedArticles.length;
		for(var i = 0; i < len; i++){
			var id = selectedArticles[i];
			dupTest = inArray(id, selectedArticles);
			if(dupTest !== i){
				alert("You've selected duplicate articles for the sidebar section!  Please select four unique articles and try again.");
				e.preventDefault();
				break;
			}
		}

		function inArray(needle, haystack){
			var len = haystack.length,
			lastIndex = -1;
			for(var i = 0; i < len; i++){
				if(haystack[i] == needle) lastIndex = i;
			}
			return lastIndex;
		}
	});

	$('#searchsubmit').click(function(e){
		$(this).submit();
	});

	$('.section-bar').each(function(){
		var thisBar = $(this),
		thisBarRight = $(thisBar).find('#right'),
		thisBarRightHeading = $(thisBarRight).find('h2'),
		thisBarRightDropDown = $(thisBarRight).find('ul'),
		headingOver = false,
		listOver = false,
		dropDownTime = 250,
		dropDownTimeOut;

		thisBarRightHeading.mouseenter(function(){
			headingOver = true;
		}).mouseleave(function(){
			headingOver = false;
			dropDownTimeOut = setTimeout(dropDownOut, dropDownTime);
		}).click(function(){
			if(thisBarRightHeading.hasClass('shown')) thisBarRightDropDown.slideUp(dropDownTime);
			else thisBarRightDropDown.slideDown(dropDownTime);

			thisBarRightHeading.toggleClass('shown');
		});

		thisBarRightDropDown.mouseenter(function(){
			listOver = true;
		}).mouseleave(function(){
			listOver = false;
			dropDownTimeOut = setTimeout(dropDownOut, dropDownTime);
		});

		function dropDownOut(){
			if(!listOver && !headingOver && thisBarRightHeading.hasClass('shown')){
				thisBarRightDropDown.slideUp(dropDownTime);
				thisBarRightHeading.removeClass('shown');
			}
			clearTimeout(dropDownTimeOut);
		}
	});

	// Limit the user to select no more than 5 categories at the same time
	if($("input[type=checkbox]:checked").length >= 5){
		$("input[type=checkbox]").not(":checked").attr("disabled",true);
	}  

 	$("input[type=checkbox]").click(function() {
    	var bol = $("input[type=checkbox]:checked").length >= 5;  

 		$("input[type=checkbox]").not(":checked").attr("disabled",bol);
   });
   //End
	
	$('.colorpicker').mpColorPicker();
	$('.tooltip').mpTooltip();
	$('.preview').mpPreview();

	$('.search-form').mpSearch();
    $('.search-form-admin').mpSearchAdmin();

	$('.notify').mpPreview({
		'selector' : 'div',
		'containingElement' : 'div',
		'filter' : '.notify-preview-container'		
	});

	$('.profile-preview').mpPreview({
		'selector' : 'div',
		'containingElement' : 'div',
		'filter' : '.preview-container'
	});

	$('.article-prev').mpPreview({
		'selector' : 'div',
		'containingElement' : 'div',
		'filter' : '.preview-art-container'
	});

	$('.article-prev').click(function(e){
		e.preventDefault();
	});

	if($('#preview-close')){
		$('.preview-close').click(function(e){
			$('#lightbox-cont2').hide();
		});
	}

	$('.add-element-link').mpAddElement();
	
	$('#more-ingredients-yes9').click(function(e){
		console.log('Send Default');
	});

	$('#more-ingredients-yes, #more-instructions-yes').click(function(e){
		var prefix = $(this).attr('data-info'), 
		count = $('.'+prefix+'-box').length, 
		index = count+1;
		
		fieldset = $('<fieldset />', {
			id: prefix+'-'+index,
			class: prefix+'-box'
		}),
		
		label = $('<label />', {
		}).html(prefix+' for: <span></span>'),

		input = $('<input />', {
			type: 'text',
			placeholder: 'ex: Sauce, Glaze, Icing',
			class: 'article_'+prefix+'-title-'+index+'-nf', 
			id: 'article_'+prefix+'-title-'+index+'-nf', 
			name: 'article_'+prefix+'-title-'+index+'-nf' 

		}),

		span = $('<span />', {
			class: 'remove-element',
			id: "remove-span"
		}),

		a = $('<a />', {
			href: ''
		}),
		
		i = $('<i />', {
			class: 'icon-minus-sign'
		}),

		span.click(function(e){
			var element_id = '#'+$(this).prev().attr('id');
			e.preventDefault();
			$(element_id).parent('fieldset').remove();
			$(this).remove();
		});

		element_box = $('<div />', {
			id: 'elements-box'
		}).attr('data-info', 'article_'+prefix+'-nf'),

		add_element = $('<div />', {
			class:'add-element'
		}),

		add_element_link = $('<a />', {
			class: 'add-element-link', 
			name: 'add-element-link',
			href: ''
		}).html('<i class="icon-plus-sign"></i>Add '+prefix),

		input_elements_div = $('<div />', {
			class: 'input-elements'
		});

		add_element_link.click(function(e, prefix2){
			var thisElement = $(this),
			parent = thisElement.parent().parent(),
			box = parent.parent(),
			fieldset = box.parent();
			input_box = parent.children('.input-elements'),
			prefix2 = 'article_'+box.attr('id')+'-nf'; //$(parent).attr('data-info');
		
			e.preventDefault();

			var total = $(input_box).children('input').length+1,
			input = $('<input/>', {
			    	id:    prefix2+'-'+total,
			    	class: prefix2+'-'+total,
			    	name:  prefix2+'-'+total,
			    	type:  "text",
			    	placeholder: "Insert "+prefix+" here."
				 }),
			span = $('<span />', {
				class: 'remove-element'
			});
			a = $('<a />', {
				href: ''
			}),
			i = $('<i />', {
				class: 'icon-minus-sign'
			});

			span.click(function(e){
				var element_id = '#'+$(this).prev().attr('id');
				e.preventDefault();
				$(input_box).children(element_id).remove();
				$(this).remove();
			});

			i.appendTo(a);
			a.appendTo(span);
	
			input.appendTo(input_box);
			span.appendTo(input_box);
		});

		label.appendTo(fieldset);
		input.appendTo(fieldset);
		i.appendTo(a);
		a.appendTo(span);
		span.appendTo(fieldset);
		element_box.appendTo(fieldset);
		input_elements_div.appendTo(element_box);
		add_element_link.appendTo(add_element);
		add_element.appendTo(element_box);

		$('#'+prefix+'-'+count).after(fieldset);
	});

	//Image Article and Contributors Link Hovering and Linking functionalities

	if($('#image-container')){
		$('#image-container').hover(function(e){
			$('#image-container').toggleClass('shown');
		});
	}

	$('#change-art-image').click(function(e){
		e.preventDefault();
		$('#image-file-link').click();
	});
	













	//Form Ajax Processor
	var ajaxCallbacks = {
		'contributor-add-form' : function(form, data){
			setTimeout(function(){
				window.location = "<?php echo $config['this_admin_url']; ?>contributors/edit/" + data['contributorDetails'][':contributor_seo_name'];
			}, 2000);
		},

		'account-settings-form' : function(){
			//	When the email is changed in the account info form, update this in the profile form's hidden email field...
			var accountEmailField = document.getElementById("user_email-e");
			var profileEmailField = document.getElementById("contributor_email_address-e");
			newEmail = accountEmailField.value;
			profileEmailField.setAttribute("value", newEmail);
		},

		'contributor-delete-form' : function(form, data){
			setTimeout(function(){
				window.location = "<?php echo $config['this_admin_url']; ?>contributors/";
			}, 2000);
		},

		'user-account-delete-form' : function(form, data){
			var thisForm = $(form), 
			statusCode = data.statusCode;
		
			if(statusCode == 200) {
				window.location = "<?php echo $config['this_admin_url']; ?>delete/";
			}
		
		},

		'video-add-form' : function(form, data){
			setTimeout(function(){
				window.location = "<?php echo $config['this_admin_url']; ?>media/edit/" + data['videoDetails'][':syn_video_filename'];
			}, 2000);
		},

		'video-delete-form' : function(form, data){
			setTimeout(function(){
				window.location = "<?php echo $config['this_admin_url']; ?>media/";
			}, 2000);
		},

		'list-delete-form': function(form, data){
			var thisForm = $(form),
			list_div = '#'+data.pagelist_data;
			thisId = thisForm.attr('id');
				$(list_div).remove();
				thisForm.mpValidate({
					updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
					callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
				});

		},

		'list-item-delete-form': function(form, data){
			var thisForm = $(form),
			list_div = '#'+data.pagelistitem_data;
			console.log(data.pagelistitem_data);
			thisId = thisForm.attr('id');
				$(list_div).remove();
				thisForm.mpValidate({
					updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
					callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
				});

		},		

		'article-add-form' : function(form, data){
			var thisForm = $(form), 
			statusCode = data.statusCode,
			data_prev_element = $('.preview-art-container');

			if(statusCode == 200) {

				if(data.articleID){
					$('#article-id').val(data.articleID);
					$('#a_i').val(data.articleID);
				}
				$('#article-inline-settings').slideDown(500);
				$('.review').css('display', 'inline');
				$('#main-buttons-text').css('display', 'inline');
				

				var article_seo = data.articleInfo[":article_seo_title"];
				var data_prev = data.article_prev_content;
				data_prev_element.attr('data-preview', data_prev);
				
				$('#preview-recipe').css('display', 'inline');

			}
		},

		'article-info-form' : function(form, data){
			var thisForm = $(form),
			data_prev_element = $('.preview-art-container');

			if(!data.hasError){
				var data_prev = data.article_prev_content;
				data_prev_element.attr('data-preview', data_prev);
			}
		},

		'article-review-form' : function(form, data){
			var thisForm = $(form);

			setTimeout(function(){
				window.location = "<?php echo $config['this_admin_url']; ?>articles/";
			}, 300);
		},

		'article-delete-form': function(form, data){
			var thisForm = $(form),
			article_div = '#article-'+data.article_data;

			thisId = thisForm.attr('id');
				$(article_div).remove();
				thisForm.mpValidate({
					updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
					callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
				});

		},

		'bug-delete-form': function(form, data){
			var thisForm = $(form),
			bug_div = '#'+data.bug_data;
			thisId = thisForm.attr('id');
				$(bug_div).remove();
				thisForm.mpValidate({
					updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
					callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
				});

		},

		'series-add-form' : function(form, data){
			setTimeout(function(){
				window.location = "<?php echo $config['this_admin_url']; ?>media/editseries/" + data['seriesDetails'][':article_page_series_seo'];
			}, 2000);
		},
		
		'category-slideshow-article-form' : function(form, data){
			var thisForm = $(form),
			slideshowList = $('.slideshow'),
			ul = $(slideshowList).children('section').children('ul'),
			selectedOption =  $(thisForm).children('.ss-dd-articles').children('select').children('option:selected'),
			dataList = $(selectedOption).attr('data-list');

			$('<li/>', {
			    id: $(selectedOption).attr('id'),
			 })
			 .html(dataList)
			 .appendTo(ul)
			 .find('.b-delete').click(function() {
     			var thisForm = $(this).parent().parent('form'),
				thisId = thisForm.attr('id');

				thisForm.mpValidate({
					updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
					callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
				});
			});
		},

		'category-slideshow-delete': function(form, data){
			var thisForm = $(form),
			slideshowList = $('.slideshow'),
			ul = $(slideshowList).children('section').children('ul'),
			article_id = '#'+data.article_data;

			$(ul).children(article_id).remove();
		},

		'series-add-edit-video' : function(form, data){
			var thisForm = $(form),
			playlist = $('.series-playlist'),
			ul = $(playlist).children('section').children('ul'),
			selectedOption =  $(thisForm).children('fieldset').children('#series_video').children('option:selected'),
			dataList = $(selectedOption).attr('data-list');

			$('<li/>', {
			    id: $(selectedOption).attr('id'),
			 })
			 .html(dataList)
			 .appendTo(ul)
			 .find('.delete button').click(function() {
     			var thisForm = $(this).parent().parent('form'),
				thisId = thisForm.attr('id');

				thisForm.mpValidate({
					updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
					callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
				});

				$(this).click();
			});;
		},

		'series-video-delete': function (form, data){
			var thisForm = $(form),
			playlist = $('.series-playlist'),
			ul = $(playlist).children('section').children('ul'),
			video_id = '#'+data.article_data;

			$(ul).children(video_id).remove();
		},

		'series-video-add-remove-slideshow': function ( form, data ){
			var thisForm = $(form),
			anchor = $(form).children('a'),
			anchor_id = $(anchor).attr('id'),
			action = $(thisForm).children('#action');
			
			if(anchor_id == 'series-video-add-slideshow-link'){
				$(anchor).attr('id', 'series-video-remove-slideshow-link');
				$(anchor).html('<i class="icon-minus-sign"></i>Remove from slideshow');
				$(action).attr('value', 'series-video-remove-slideshow-link');
			}
			else{
				$(anchor).attr('id', 'series-video-add-slideshow-link');
				$(anchor).html('<i class="icon-plus-sign"></i>Add to slideshow');
				$(action).attr('value', 'series-video-add-slideshow-link');
			}
		}, 

		'collection-add-form': function( form, data){
			setTimeout(function(){
				window.location = "<?php echo $config['this_admin_url']; ?>recipe_collections/edit/" + data['collectionDetails'][':collections_seoname'];
			}, 2000);
		},

		'collection-delete-form': function (form, data){
			var thisForm = $(form),

			collection_div = '#'+data.article_data;

			thisId = thisForm.attr('id');
				console.log(thisId);
				$(collection_div).remove();
				thisForm.mpValidate({
					updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
					callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
				});		
		},

		'article-tall-image-upload-form': function( form, data ){
			var thisForm = $(form),
			article_id = $('#article-id').val(),
			url = '<?php echo $config['image_url']?>articlesites/puckermob/tall/';
			var d = new Date();
			img_url = url+article_id+'_tall.jpg';
			img = $('#image-container').children('img'),
			data_prev_element = $('.preview-art-container');
			
			$('.preview-close').click();
	
			if(!data.hasError){
				$(img).attr('src', img_url+'?'+d.getMilliseconds());
				$('#error-img').text('Image Updated Sucessful!').addClass('new-success').show();
				var data_prev = data.article_prev_content;
				data_prev_element.attr('data-preview', data_prev);

			}else{
				$('#error-img').text('something went wrong. Please try again or contact info@sequelmediagroup.com.').addClass('error');
			}
	
		},

		'contributor-wide-image-upload-form': function( form, data ){
			var thisForm = $(form),
			contributor_id = $('#c_i').val(),
			url = '<?php echo $config['image_url']?>articlesites/contributors_redesign/',
			d = new Date(),
			filename = data.filename;
			img_url = url+filename;
			img = $('#img-profile');
			
			$('.preview-close').click();
			if(!data.hasError){
				$(img).attr('src', img_url+'?'+d.getMilliseconds());
				$('#image-header-profile').attr('src', img_url+'?'+d.getMilliseconds());
				$('#error-img').text('Image Updated Sucessful!').addClass('new-success').slideDown( "slow" ).delay( 1000 ).slideUp( "slow" );
			}else{
				$('#error-img').text('something went wrong. Please try again or contact info@sequelmediagroup.com.').addClass('error');
			}
		},

		'slideshow-add-form' : function(form, data){
			var thisForm = $(form), 
			statusCode = data.statusCode,
			id = data.id;
			
			if(!data.hasError) {

				if(id){
					$('#ss_i').val(id);
				}
				$('#article-inline-settings').slideDown(500);
				$('.review').css('display', 'inline');
				$('#main-buttons-text').css('display', 'inline');
				
				$('#preview-recipe').css('display', 'inline');

			}
		},

		'slider-image-upload-form': function( form, data ){
			var thisForm = $(form),
			id = $('#ss_i').val(),
			url = '<?php echo $config['image_url']?>articlesites/simpledish/flex_test_images/',
			d = new Date(),
			filename = data.filename;
			img_url = url+filename;
			img = $('#image-container').children('img');
			
			$('.preview-close').click();
			if(!data.hasError){
				$(img).attr('src', img_url+'?'+d.getMilliseconds());
				$('#error-img').text('Image Updated Sucessful!').addClass('new-success').show();
			}else{
				$('#error-img').text('something went wrong. Please try again or contact info@simpledish.com.').addClass('error');
			}
		},

		'slideshow-delete': function(form, data){
			var thisForm = $(form),
			slide_div = '#'+data.slideshow_data;
			thisId = thisForm.attr('id');
				$(slide_div).remove();
				thisForm.mpValidate({
					updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
					callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
				});

		},

		'slideshow-update-status-form': function( form, data){
			window.location = "<?php echo $config['this_admin_url']; ?>slideshow/";
		},	

	}; 
	//	END AJAX CALLBACKS








	//	BEGIN HANDLERS FOR THE AJAX FORM SUBMISSIONS

	//	edit LIST: editlist.php

	$('.page-list-data-form').each(function(){

		var thisForm = $(this)
		thisForm.mpValidate({
			updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
			callback : function(){
					//	redirect to the new seo titled page
					$("#page_list_seo_title").redirectToNewSEOTitle('<?php echo $config['this_admin_url'].'lists/edit/'; ?>');
			}
		});
	});


	//	edit LIST ITEM: editlist.php

	$('.page-list-item-data-form').each(function(){
	
	
		var thisForm = $(this),
		listItemId = thisForm.children('#page_list_item_id').attr("value"),
		thisId = thisForm.attr('id');
		
		thisForm.mpValidate({
			updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
			additionalParams : 'file',
			imageFile : '.userfile-'+listItemId,
			
			//	DEFINE THE CALL BACK HERE, because the form's 'id' is variable (There are multiple forms on this page).
			
			callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){
				//	Get the classname of the file input, it is also variable - ex: userFile-332
				var fileInputClassname = $(this)[0].imageFile,
				fileInput = $(fileInputClassname);
				
				//	Check if file was submitted in the file input
				if (fileInput[0].files[0] != null){
					//	the filename in the input, the new src of the uploaded image
					var fileName =  fileInput[0].files[0].name,
					updatedImgSrc = '<?php echo $config['image_url']?>articlesites/simpledish/list/'+fileName

					//	Set the hidden field, 'existing_image' to the new image name
					$('input[name="existing_image"]').val(fileName);
					
					//	replace 'used' file input with a fresh one, that has 'no file chosen'
					//	This prevents the image from repeatedly being uploaded, if the user makes edits to other fields
					fileInput.replaceWith(fileInput = fileInput.clone( true ));

					// target preview img
					preview = $('#preview-'+listItemId);

					//	display new img
					preview.css( "display", "none" );					
					preview.attr("src", updatedImgSrc);
					preview.removeClass('hidden');
					preview.fadeIn( "slow" );
				}
			}
		});
	});


	$('.article-delete-form').each(function(){
		var thisForm = $(this),
		thisId = thisForm.attr('id');
		console.log(thisId);
			thisForm.mpValidate({
				updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
				additionalParams : 'confirm',
				callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
			});
	});


	$('.list-delete-form').each(function(){
		var thisForm = $(this),
		thisId = thisForm.attr('id');
			thisForm.mpValidate({
				updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
				additionalParams : 'confirm',
				callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
			});
	});

	$('.bug-delete-form').each(function(){
		var thisForm = $(this),
		thisId = thisForm.attr('id');

		thisForm.mpValidate({
			updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
			additionalParams : 'confirm',
			callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
		});
	});

	$('.collection-delete-form').each(function(){
		var thisForm = $(this),
		thisId = thisForm.attr('id');
		console.log(thisId);
			thisForm.mpValidate({
				updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
				additionalParams : 'confirm',
				callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
			});
	});


	$('.list-item-delete-form').each(function(){
		var thisForm = $(this),
		thisId = thisForm.attr('id');
			thisForm.mpValidate({
				updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
				additionalParams : 'confirm',
				callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
			});
	});

	$('.series-video-add-remove-slideshow').each(function(){
		var form = $(this), 
		anchor = $(this).children('a'),
		formId = $(form).attr('id'),
		button = $(form).children('button');

		$(anchor).click( function(e){
			e.preventDefault();
			button.click();
		});
	});

	$('.ajax-submit-form').each(function(){
		var thisForm = $(this),
		thisId = thisForm.attr('id');

		thisForm.mpValidate({
			updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
			callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
		});
	});

	$('.ajax-submit-image').each(function(){
		var thisForm = $(this),
		thisId = thisForm.attr('id');
		
		thisForm.mpValidate({
			updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
			additionalParams : 'file',
			imageFile : '.upload-img-file',
			callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
		});
	});


	/*if($('.elm-wysiwyg').length > 0){
		$('.elm-wysiwyg').wysiwyg({
			rmUnusedControls: true,
			autoSave: true,
			rmUnwantedBr: true,
			controls: {
				bold: {visible: true},
				italic: {visible: true},
				underline: {visible: true},
				h1: {visible: true},
				h2: {visible: true},
				h3:{visible:true},
				strikeThrough: {visible: true},
				insertUnorderedList: {visible: true},
				insertOrderedList: {visible: true},
				removeFormat: {visible: true},
				createLink: {visible: true}
			}
		});

		if(body.is('.admin0, .admin1')){
			$('.elm-wysiwyg').css({'margin-left': '0'});
		}else{
			$('.elm-wysiwyg').css({'margin-left': '10%'});
		}
		$('.wysiwyg iframe').css({'width': '100%'});
	}	*/
	

	//Image Ajax Processor
	/*$('#header-logo-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=headerlogo",
		onComplete : function(resp){
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					$('#header-logo-image-upload .image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){$(this).fadeTo(250, 1);};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			$('#header-logo-image-upload #result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});

	$('#footer-logo-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=footerlogo",
		onComplete : function(resp){
			console.log(resp);
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					$('#footer-logo-image-upload .image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){$(this).fadeTo(250, 1);};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			$('#footer-logo-image-upload #result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});

	$('#player-logo-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=playerlogo",
		onComplete : function(resp){
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					$('#player-logo-image-upload .image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){$(this).fadeTo(250, 1);};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			$('#player-logo-image-upload #result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});

	$('#featured-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=featured",
		onComplete : function(resp){
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					$('#featured-image-upload .image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){$(this).fadeTo(250, 1);};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			$('#featured-image-upload #result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});*/

	/*$('#contributor-wide-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=contributorwide&imgType=wide&contributorId=" + $(this).find('#contributor_id').val() + '&currentImage=' + $(this).find('#currentImage').val(),
		onComplete : function(resp){
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					$('#contributor-wide-image-upload .image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){
							if($(this).hasClass('hidden')){
								$(this).removeClass('hidden');
								$(this).parent().find('p.no-img').eq(0).remove();
							}
							$(this).fadeTo(250, 1);
							$('#contributor-wide-image-upload form #currentImage').val(resp.lastUploadedFile.name);
							resp.options.uploadUrl = "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=contributorwide&imgType=wide&contributorId=" + $('#contributor-wide-image-upload').find('#contributor_id').val() + '&currentImage=' + $('#contributor-wide-image-upload').find('#currentImage').val();
						};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			$('#contributor-wide-image-upload #result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});*/

	/*$('#sponsored-by-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=sponsoredBy&articlePageId=" + $(this).find('#c_p_i').val() + '&currentImage=' + $(this).find('#currentImage').val(),
		onComplete : function(resp){
			var uploadContainer = $('#sponsored-by-image-upload');
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					uploadContainer.find('.image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){
							if($(this).hasClass('hidden')){
								$(this).removeClass('hidden');
								$(this).parent().find('p.no-img').eq(0).remove();
							}
							$(this).fadeTo(250, 1);
							uploadContainer.find('form #currentImage').val(resp.lastUploadedFile.name);
							resp.options.uploadUrl = "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=sponsoredBy&imgType=sponsoredBy&articlePageId=" + uploadContainer.find('#c_p_i').val() + '&currentImage=' + uploadContainer.find('#currentImage').val();
						};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			uploadContainer.find('#result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});

	$('#sponsored-super-banner-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=sponsoredSuperBanner&articlePageId=" + $(this).find('#c_p_i').val() + '&currentImage=' + $(this).find('#currentImage').val(),
		onComplete : function(resp){
			var uploadContainer = $('#sponsored-super-banner-upload');
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					uploadContainer.find('.image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){
							if($(this).hasClass('hidden')){
								$(this).removeClass('hidden');
								$(this).parent().find('p.no-img').eq(0).remove();
							}
							$(this).fadeTo(250, 1);
							uploadContainer.find('form #currentImage').val(resp.lastUploadedFile.name);
							resp.options.uploadUrl = "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=sponsoredSuperBanner&imgType=sponsoredSuperBanner&articlePageId=" + uploadContainer.find('#c_p_i').val() + '&currentImage=' + uploadContainer.find('#currentImage').val();
						};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			uploadContainer.find('#result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});*/

	/*$('#article-inline-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=articleinline&articleId=" + $(this).find('#a_i').val() + '&currentImage=' + $(this).find('#currentImage').val(),
		onComplete : function(resp){
			var uploadContainer = $('#article-inline-image-upload');
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					uploadContainer.find('.image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){
							if($(this).hasClass('hidden')){
								$(this).removeClass('hidden');
								$(this).parent().find('p.no-img').eq(0).remove();
							}
							$(this).fadeTo(250, 1);
							uploadContainer.find('form #currentImage').val(resp.lastUploadedFile.name);
							resp.options.uploadUrl = "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=articleinline&imgType=inline&articleId=" + uploadContainer.find('#a_i').val() + '&currentImage=' + uploadContainer.find('#currentImage').val();
						};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			uploadContainer.find('#result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});

	$('#page-list-item-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=pageListItem&pageListItemId=" + $(this).find('#page_list_item_id').val() + '&currentImage=' + $(this).find('#currentImage').val(),
		onComplete : function(resp){
			var uploadContainer = $('#page-list-item-image-upload');
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					uploadContainer.find('.image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){
							if($(this).hasClass('hidden')){
								$(this).removeClass('hidden');
								$(this).parent().find('p.no-img').eq(0).remove();
							}
							$(this).fadeTo(250, 1);
							uploadContainer.find('form #currentImage').val(resp.lastUploadedFile.name);
							resp.options.uploadUrl = "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imgType=pageListItem&pageListItemId=" + uploadContainer.find('#page_list_item_id').val() + '&currentImage=' + uploadContainer.find('#currentImage').val();
						};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			uploadContainer.find('#result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});


	$('#article-preview-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=articlepreview&articleId=" + $(this).find('#a_i').val() + '&currentImage=' + $(this).find('#currentImage').val(),
		onComplete : function(resp){
			var uploadContainer = $('#article-preview-image-upload');
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					uploadContainer.find('.image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){
							if($(this).hasClass('hidden')){
								$(this).removeClass('hidden');
								$(this).parent().find('p.no-img').eq(0).remove();
							}
							$(this).fadeTo(250, 1);
							var currentImage = uploadContainer.find('#currentImage').val()
							uploadContainer.find('form #currentImage').val(resp.lastUploadedFile.name);
							resp.options.uploadUrl = "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=articlepreview&imgType=inline&articleId=" + uploadContainer.find('#a_i').val() + '&currentImage=' + uploadContainer.find('#currentImage').val();
						};
						
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			uploadContainer.find('#result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});

	$('#article-wide-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=articlewide&imgType=wide&articleId=" + $(this).find('#a_i').val() + '&currentImage=' + $(this).find('#currentImage').val(),
		onComplete : function(resp){
			var uploadContainer = $('#article-wide-image-upload');
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					uploadContainer.find('.image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){
							// If the image is currently hidden, ie. nothing has been uploaded as the image
							if($(this).hasClass('hidden')){
								$(this).removeClass('hidden');
								$(this).parent().find('p.no-img').eq(0).remove();
							}
							$(this).fadeTo(250, 1);
							var currentImage = uploadContainer.find('#currentImage').val()
							//uploadContainer.find('form #currentImage').val(resp.lastUploadedFile.name);
							resp.options.uploadUrl = "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=articlewide&imgType=wide&articleId=" + uploadContainer.find('#a_i').val() + '&currentImage=' + currentImage;
						};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			uploadContainer.find('#result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});

	$('#article-tall-image-upload').mpImageUpload({
		uploadUrl : "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=articletall&imgType=tall&articleId=" + $(this).find('#a_i').val() + '&currentImage=' + $(this).find('#currentImage').val(),
		onComplete : function(resp){
			var uploadContainer = $('#article-tall-image-upload');
			if(!resp.hasError){
				var reader = new FileReader;
				reader.onloadend = function(e){
					uploadContainer.find('.image-preview img').fadeTo(250, 0, function(){
						this.onload = function(){
							// If the image is currently hidden, ie. nothing has been uploaded as the image
							if($(this).hasClass('hidden')){
								$(this).removeClass('hidden');
								$(this).parent().find('p.no-img').eq(0).remove();
							}
							$(this).fadeTo(250, 1);
							var currentImage = uploadContainer.find('#currentImage').val()
							//uploadContainer.find('form #currentImage').val(resp.lastUploadedFile.name);
							resp.options.uploadUrl = "<?php echo $config['this_admin_url']; ?>assets/php/ajaximageroute.php?imageType=articletall&imgType=tall&articleId=" + uploadContainer.find('#a_i').val() + '&currentImage=' + currentImage;
						};
						this.src = e.target.result;
					});
				}
				reader.readAsDataURL(resp.lastUploadedFile);
			}
			uploadContainer.find('#result').fadeTo(250, 0, function(){
				$(this).empty().html(resp.message).removeClass('error success');
				(resp.hasError) ? $(this).addClass('error') : $(this).addClass('success');
				$(this).fadeTo(250 , 1);
			});
		}
	});*/


	$('#contributor_wide_img').mpImageCropUpload({
		desWidth: 140,
		desHeight: 143
	});

	$('#article_post_tall_img').mpImageCropUpload({
		desWidth: 784,
		desHeight: 431
	});

	$('#slider_post_img').mpImageCropUpload({
		desWidth: 784,
		desHeight: 431
	});

	$('#image-file-link').click(function(e){
		e.preventDefault();
		var input_file = $('.upload-img-file');
		$('#update-article-image').show();
		input_file.click();
	});

	$('#enable-add-image').click(function(e){
		e.preventDefault();

		$('#add-an-image-fs').slideDown();
	});

	$('#edit-recipe').click(function(e){
		e.preventDefault();

		setTimeout(function(){
			window.location = "<?php echo $config['this_admin_url']; ?>articles/";
		}, 300);
	});

	
	

	//	Upload account image link
	$(function(){
	    $("#upload_link").on('click', function(e){
	        e.preventDefault();
	        $(".account-file-input:hidden").trigger('click');
	    });
	});

	
	//	Account Settings Form Toggler
	/*var fieldSet = document.getElementById("hidden-field-set");
	var toggleButton = document.getElementById("field-toggler");
	var changePasswordHiddenField = document.getElementById("pwd_change");
	if (toggleButton !== null){
		toggleButton.onclick = function(e){
			var currentState = this.innerHTML;
			if (currentState == "Change Password"){
				//	Password is set to be changed...
				this.innerHTML = "Cancel";
				fieldSet.className = "revealed";
				changePasswordHiddenField.setAttribute("value", "true");			
			} else {
				//	Password is not changing...
				this.innerHTML = "Change Password";
				fieldSet.className = "hidden";
				changePasswordHiddenField.setAttribute("value", "false");	
				var passwordFields = fieldSet.getElementsByTagName('input');
				for(var i=0; i < passwordFields.length; i++){
					passwordFields[i].value = "";
				}		
			}
		}
	}*/

	//	Handle click of add new list item...
	var addText = document.getElementById("large-add-text"),
	addNewListItemDiv = document.getElementById("add-list-item"),
	addForm = document.getElementById("page-list-item-data-add-form");
	if(addNewListItemDiv){
		addNewListItemDiv.onclick = function(e){

			//	remove the + add text...
			if (addText.parentNode) {
			  addText.parentNode.removeChild(addText);
			}

			//	add the form...
			addForm.style.display="inherit";
			addNewListItemDiv.style.backgroundColor="#eee";
			addNewListItemDiv.style.cursor="auto";
		}
	}
	
	$('input[name="collections_name-s"]').SDSeoTitleAutoComplete("collections_seoname-s");
	$('input[name="article_title-s"]').SDSeoTitleAutoComplete("article_seo_title-s");
	$('input[name="page_list_title"]').SDSeoTitleAutoComplete("page_list_seo_title", "seo_title_updated");

	$('.toggle-link').SDToggler('#add-list-form');
	$('.toggle-link').SDToggler('#add-list-form');

	//$('.radio-input').SDRadioToggler('#image-inputs', '#you-tube-inputs');

	$('#sub-menu-button').click(function(e){
		$('#main-cont').toggleClass('active_submenu');
		//$(this).hide();
	});


	if($('#publish')){
		$('#publish').on('click', function(e){
			var statusVal = $(this).attr('data-info');
			$.ajax({
			  type: "POST",
			  url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
			  data: { status: statusVal, a_i: $('#a_i').val(), task:'update_status' }
			}).done(function(data) {

				console.log(data);
				if(data == "false" ){
					alert("You need to Upload an Image in order to make this article Live!");
				}else{
					location.reload();
				}
				
			  
			});
			 
		});
	}

	
	if($('.avatar-span')){
		$('.avatar-span').on('click', function(){
			var img = $(this).attr('data-info'),
			avatar_dir = "http://images.puckermob.com/articlesites/contributors_redesign",
			new_img_src = avatar_dir+'/'+img,
			img_profile = $('#img-profile');
			$(img_profile).attr('src', new_img_src);
			$(img_profile).attr('data-info', img);
			console.log(img, new_img_src);
		});

	}

	if($('.select-avatar')){
	$('.select-avatar').on('click', function(event){
		var img_profile = $('#img-profile'),
		img_name = $(img_profile).attr('data-info');

		event.preventDefault();
		$.ajax({
			  type: "POST",
			  url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
			  data: { image: img_name, c_i: $('#cont_i').val(), task:'update_avatar_img' }
			}).done(function(data) {
				if(data){
					avatar_dir = "http://images.puckermob.com/articlesites/contributors_redesign",
					new_img_src = avatar_dir+'/'+img_name;

					$('#image-header-profile').attr('src', new_img_src);
					$('#error-img').text('Image Updated Sucessful!').addClass('new-success').slideDown( "slow" ).delay( 1000 ).slideUp( "slow" );

			 		//alert(data);
			 	}else{
			 		$('#error-img').text('something went wrong. Please try again or contact info@sequelmediagroup.com.').addClass('error').slideDown( "slow" ).delay( 1000 ).slideUp( "slow" );;
			 	}
			});



	});
}

if($('#article_categories')){
	$('#article_categories').on('change', function(event){
		var value = $('#article_categories').val(),
		label = '',
		container = $('#category-description');
		switch(value){

			case '3':
				//RELATIONSHIPS
				label = "<label>Articles about love, sex, marriage, dating, friends and family.</label>";
				break;
			case '4':
				//ENTERTAINMENT
				label = "<label>Articles about movies, TV, books, sports, music and art. Includes Hollywood gossip, reviews, etc.</label>";
				break;
			case '5':
				//MONEY
				label = "<label>Articles about budgeting, saving, spending, career and entrepreneurship.</label>";
				break;
			case '6':
				//LIFESTYLE
				label = "<label>Articles about travel, school, fashion, going out, night life, living better,food, diet, health and spirituality.</label>";
				break;
			case '7':
				//FUN
				label = "<label>Viral and funny videos, memes, nostalgia, general interest/shocking news items.</label>";
				break;
			default:
				label = "<label>Choose one category that best specifies the genre of your article. This is where your post will reside on the site.</label>";
				break;

		}
		console.log(value);
		//console.log(label);
		$(container).html(label);

	
	});
}
		
		$('#preview').on('click', function(event){
			//event.preventDefault();

			//var lightbox = $('#lightbox-preview-cont');

			//$(lightbox).parent().parent().show();


		});
	$('.has-tooltip').tooltipster();

//LIBRARY PHOTOS
	if($('#search-lib')){
		$('#search-lib').on('click', function(e){
			e.preventDefault();
			e.stopPropagation();

		});	
	}

//CLICK TO SEE HOW SHARES ARE CALCULATED

if($('#dd-shares-calc')){
	$('#dd-shares-calc').on('click', function(e){
		e.stopPropagation();
		$('#dd-shares-content').slideToggle('slow');

	});
}

});