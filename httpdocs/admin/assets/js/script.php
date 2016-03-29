<?php
	Header("content-type: application/x-javascript");
	require_once('../../../assets/php/config.php');
?>

$(document).ready(function (){

	var body = $('body');
	
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

	
	//$('.tooltip').mpTooltip();
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
				$('#error-img').text('something went wrong. Please try again or contact info@sequelmediainternational.com.').addClass('error');
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
				$('#error-img').text('something went wrong. Please try again or contact info@sequelmediainternational.com.').addClass('error');
			}
		},

	}; 
	//	END AJAX CALLBACKS


	//	BEGIN HANDLERS FOR THE AJAX FORM SUBMISSIONS
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

	//REFACTOR THIS TO ONE PLUGIN

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

	$('.list-item-delete-form').each(function(){
		var thisForm = $(this),
		thisId = thisForm.attr('id');
			thisForm.mpValidate({
				updateUrl : '<?php echo $config['this_admin_url']; ?>assets/php/ajaxsubmitroute.php',
				additionalParams : 'confirm',
				callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
			});
	});
	//REFACTOR THIS TO ONE PLUGIN

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

	//	Upload account image link
	$(function(){
	    $("#upload_link").on('click', function(e){
	        e.preventDefault();
	        $(".account-file-input:hidden").trigger('click');
	    });
	});
	
	//$('input[name="collections_name-s"]').SDSeoTitleAutoComplete("collections_seoname-s");
	//$('input[name="page_list_title"]').SDSeoTitleAutoComplete("page_list_seo_title", "seo_title_updated");

	//$('.toggle-link').SDToggler('#add-list-form');
	//$('.toggle-link').SDToggler('#add-list-form');

	$('#sub-menu-button').click(function(e){
		$('#content').toggleClass('active_submenu');
		$('#nav-cont').toggleClass('mobile-menu');
	});


	//PUBLISH ARTICLE
	if($('#publish')){
		$('#publish').on('click', function(e){
			var statusVal = $(this).attr('data-info');
			$.ajax({
			  type: "POST",
			  url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
			  data: { status: statusVal, a_i: $('#a_i').val(), task:'update_status' }
			}).done(function(data) {

				if(data == "false" ){
					alert("You need to Upload an Image in order to make this article Live!");
				}else{
					location.reload();
				}
				
			  
			});
			 
		});
	}

	//AVATAR
	if($('.avatar-span')){
		$('.avatar-span').on('click', function(){
			var img = $(this).attr('data-info'),
			avatar_dir = "http://images.puckermob.com/articlesites/contributors_redesign",
			new_img_src = avatar_dir+'/'+img,
			img_profile = $('#img-profile');
			$(img_profile).attr('src', new_img_src);
			$(img_profile).attr('data-info', img);
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
			 		$('#error-img').text('something went wrong. Please try again or contact info@sequelmediainternational.com.').addClass('error').slideDown( "slow" ).delay( 1000 ).slideUp( "slow" );;
			 	}
			});
	});
}
		

//$('.has-tooltip').tooltipster();

//LIBRARY PHOTOS
	if($('#search-lib')){
		$('#search-lib').on('click', function(e){
			e.preventDefault();
			e.stopPropagation();

		});	
}

$('.step-2').hide();
$('.img_categories').click(function(e){
	var elm = $(this),
	category = elm.attr('data-info');

	$.ajax({
		type: "POST",
		url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
		data: { category: category, a_i: $('#a_i').val(), task:'get_category_images' }
	}).done(function(data) {
		$('.step-1').hide();
		$('.step-2').show();
		
		var images = $.parseJSON(data),
		html = '',
		div = $('<div />'),
		container = $('.article-imgs-container');
		
		for(var i = 0; i < images.length; i++){
			var img_id = 'art-img-'+images[i].id,
			dataInfo = images[i].img_name,
			src = "http://www.puckermob.com/admin/assets/img/articles/"+dataInfo;
			html = '<div class="small-4 div-images-holder"><img id="'+img_id+'" data-info="'+dataInfo+'" class="article-img-preset" src="'+src+'" alt="'+dataInfo+'"></div>';
			$(container).append(html);
		}
		
		$(div).appendTo(container);
	});
});	


//CLICK TO SEE HOW SHARES ARE CALCULATED
if($('#dd-shares-calc')){
	$('#dd-shares-calc').on('click', function(e){
		e.stopPropagation();
		$('#dd-shares-content').slideToggle('slow');

	});
}

$("#secondImage").on('change', function () {
    $("#uploadFile").val( this.value );
});

$('#show-image').on('click', function(e){
		$('#second_image_div').slideToggle();

	
});

/*PREVIEW BUTTON*/
if($('#preview')){
	$('#preview').click(function(e){
		e.preventDefault();
		var preview = $(this),
		prev_box = $('#preview-article'),
		title = $('#article_title-s').val(),
		body = $('.fr-element').html(),
		contributor = $('#contributor-name').val(),
		category = $('#article_categories option:selected').text(),
		//date =  new Date($('#creation_date').val()),
		template = $(prev_box).html(),
		id = $('#a_i').val();
		//day = date.getDate(),
		//month = date.getMonth(),
		//year = date.getFullYear();

		$('.close').click(function(e){
			$('body').removeClass('show-modal-box-prev-art');
		});

		$('#article-title').text(title);
		$('#article-body').html(body);
		//$('#article-category').text(category).addClass(category);
		
		//$('#article-author').text(contributor);
		
	  //$('#article-date').text(month+'-'+day+'-'+year);
		$('#article_img').attr('src', 'http://images.puckermob.com/articlesites/puckermob/large/'+id+'_tall.jpg');
		$('body').addClass('show-modal-box-prev-art');
	
	});
}

if(document.body.id == 'editarticle'){
	
	var body = $('#article_body-nf').text();
	var li_parent = $(body).find('ol');
	var p_length = $(body).children('p').length;
	var li_length = $(li_parent).find('li').length;
	var isListArticle = false;
	var article_id = $('#a_i').val();

	if($(li_parent) && $(li_parent).length == 0 ) li_parent = $(body).find('ul');
	if(li_length > p_length){
		isListArticle = true;
	}

	$.ajax({
		type: "POST",
		url:  'http://www.puckermob.com/admin/assets/php/ajaxfunctions.php',
		data: { article_id: article_id, task:'article_ads' },
		success: function (data) {
			if(data == 'false'){
				$('select[name="nativo_mobile_ad"]').find('option[value="5"]').attr("selected",true);
				$('select[name="sharethrough_mobile_ad"]').find('option[value="2"]').attr("selected",true);
				$('select[name="branovate_mobile_ad"]').find('option[value="999"]').attr("selected",true);
				$('select[name="google_mobile_ad"]').find('option[value="-1"]').attr("selected",true);
				
				$('select[name="google_desk_ad"]').find('option[value="-1"]').attr("selected",true);
						
				if(isListArticle){ 
					$('select[name="carambola_desk_ad"]').find('option[value="6"]').attr("selected",true);
					$('select[name="sharethrough_desk_ad"]').find('option[value="2"]').attr("selected",true);
				}else {
					$('select[name="carambola_desk_ad"]').find('option[value="5"]').attr("selected",true);
					$('select[name="sharethrough_desk_ad"]').find('option[value="2"]').attr("selected",true);
				}
			}
		},
		async:   false
	});

	//SET DEFAULT VALUES DEPENDING ON ARTICLE BASE TYPE LI/P
	if(isListArticle){
		google_position = -1;
		nativo_position = 1; 
		sharethrough_position = 3;
		carambola_position = -1;
		tag = 'li';
	}else{
		google_position = -1;
		nativo_position = 1; 
		sharethrough_position = 3;
		carambola_position = -1;
	}
}	

//CHECKBOX TO MARK WHEN A BLOGGER HAD BEEN PAY IN THE REPORT
$('.paid-checkbox').click( function(e){
	e.preventDefault();
	var current_cb = $(this), year = $(current_cb).attr('year-info'), month = $(current_cb).attr('month-info'), contributor_id = $(current_cb).attr('contributor-info'),
	task = 'pay_contributors', paid = $(current_cb).is(':checked');

	//var url = 'http://www.puckermob.com/admin/assets/php/ajaxfunctions.php';
	var url = '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php';

	$.ajax({
		type: "POST",
		url:  url,
		data: { contributor_id: contributor_id, task: 'pay_contributors', year: year, month:month, 'paid':  paid},
		success: function (data) {
		console.log(data);
			if(data == 'true'){
				if( paid == true )
					$(current_cb).prop('checked', true);
				else 
					$(current_cb).prop('checked', false);
			}
		}
	});
});

//UPGRADE BLOGGLER LEVEL FROM BASIC TO PRO
if($('.mob-level-contributor')){
	$('.mob-level-contributor').on('click', function(e){
		var level = $(this), 
		cont_type = $(level).attr('data-info-level'),
		contributor_email = $(level).attr('data-info-user-email');

		//console.log(cont_type);
		$.ajax({
			type: "POST",
			url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
			data: { cont_type: cont_type, task:'update_cont_level', contributor_email: contributor_email }
		}).done(function(data){
			if(data){
				var user_type = data;
				console.log(data);
				if(user_type == 8){
					level.val('PRO');
					level.attr('data-info-level', '8');
				}
				if(user_type == 3){
					level.val('BASIC');
					level.attr('data-info-level', '3');
				}
			}
		});

	});
}

//Data Chart, Earnings Page and Report Page.
 if($('#earnings').length > 0  || $('#reports').length > 0 ){ 
	$('input[name="daterange"]').val(moment().startOf('month').format('MMMM D') + ' - ' + moment().format('D') + ', ' + moment().format('YYYY'));
 
    $('input[name="daterange"]').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment().startOf('month'),
        endDate: moment(),
        minDate: '07/01/2015',
        
        dateLimit: { days: 600 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }); 

    //var startDate = moment([year, month - 1]);
    EarningsObj.setValues(moment().startOf('month').format("YYYY-MM-DD"), moment().format("YYYY-MM-DD"));
	if($('#earnings').length > 0 ){
		EarningsObj.initChart();
		EarningsObj.getChartData();
		EarningsObj.updateTotalEarnings(); 
	}

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker){
		  var start_date = picker.startDate.format('YYYY-MM-DD');
		  var end_date = picker.endDate.format('YYYY-MM-DD');

		  EarningsObj.setValues(start_date, end_date);

		  if($('#earnings').length > 0 ){
			  EarningsObj.getChartData();
			  EarningsObj.drawChart();
			  EarningsObj.getArticlesListData();
			  EarningsObj.updateTotalEarnings();   
		  }else{
			  if($('#reports').length > 0 ){
			  	EarningsObj.getWritersReport();
			  }
		  }
	  	$('input[name="daterange"]').val(picker.startDate.format('ll') + ' - ' + picker.endDate.format('ll'));
	});
  }

}); 
 

