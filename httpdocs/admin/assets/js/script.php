<?php
	Header("content-type: application/x-javascript");
	//require_once('../../../assets/php/config.php');
?>

$(document).ready(function (){


var body = $('body');
var base_url = 'http://www.puckermob.com';
var admin_url = 'http://www.puckermob.com/admin/';
var img_url = 'http://images.puckermob.com/'; // http://localhost:8888/projects/pucker-mob/subdomains/images/httpdocs/
var page = document.body.id;

$(document).foundation();

//admin_url = 'http://localhost:8888/projects/pucker-mob/httpdocs/admin/';


//Menu Toggler Functionality Mobile
$('#menu-icon').click(function(e){
	if($('#nav-cont').hasClass('shown')) $('#nav-cont').slideUp(500);
	else{
		body.removeClass('active_menu');
		$('#nav-cont').slideDown(500);
	}
	$('#nav-cont').toggleClass('shown');
});


//ADD Reports export
$('#export').on('click', function(e){
	e.preventDefault();
	var ahref ="http://www.puckermob.com/admin/reports/getsocialcsvreport.php?month="+$('#month-option').val()+"&year="+$('#year-option').val()+"&contributor="+$('#contributor-option').val();
	location.href = ahref;
});


//Menu scroll up and down
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

$('nav h2').click(function(e){
	body.toggleClass('active_menu');
});


//Sort By Selection ??????
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

/******** REMOVE THIS NOT IN USE 
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

*/

	
/* SEARCH BAR */

$('#searchsubmit').click(function(e){
	$(this).submit();
});
$('.search-form').mpSearch();
$('.search-form-admin').mpSearchAdmin();

//NOT SURE
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

//NOT SURE IF IN USE **************************************
/*$('.preview').mpPreview();



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
*********************************************************/

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

	
//Form Ajax Processor
var ajaxCallbacks = {
	'contributor-add-form' : function(form, data){
		setTimeout(function(){
			window.location = admin_url+"contributors/edit/" + data['contributorDetails'][':contributor_seo_name'];
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
			window.location = admin_url+"contributors/";
		}, 2000);
	},

	'user-account-delete-form' : function(form, data){
		var thisForm = $(form), 
		statusCode = data.statusCode;
	
		if(statusCode == 200) {
			window.location =  admin_url+"delete/";
		}
	
	},

	'article-add-form' : function(form, data){
		var thisForm = $(form), 
		statusCode = data.statusCode,
		data_prev_element = $('.preview-art-container');

		if(statusCode == 200) {

			if(data.articleID){
				//$('#article-id').val(data.articleID);
				$('#a_i').val(data.articleID);
			}
			//$('#article-inline-settings').slideDown(500);
			//$('.review').css('display', 'inline');
			//$('#main-buttons-text').css('display', 'inline');
			

			var article_seo = data.articleInfo[":article_seo_title"];
			//var data_prev = data.article_prev_content;
			//data_prev_element.attr('data-preview', data_prev);
			
			//$('#preview-recipe').css('display', 'inline');

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
			window.location =  admin_url + "articles/";
		}, 300);
	},

	'article-delete-form': function(form, data){
		var thisForm = $(form),
		article_div = '#article-'+data.article_data;

		thisId = thisForm.attr('id');
			$(article_div).remove();
			thisForm.mpValidate({
				updateUrl :  admin_url + 'assets/php/ajaxsubmitroute.php',
				callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
			});

	},

	'article-tall-image-upload-form': function( form, data ){
		var thisForm = $(form),
		article_id = $('#article-id').val(),
		url = img_url + 'articlesites/puckermob/tall/';
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
		url = img_url + 'articlesites/contributors_redesign/',
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


//DELETE ARTICLE 
$('.article-delete-form').each(function(){
	var thisForm = $(this),
	thisId = thisForm.attr('id');
		thisForm.mpValidate({
			updateUrl :  admin_url + 'assets/php/ajaxsubmitroute.php',
			additionalParams : 'confirm',
			callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
		});
});


// SAVE ARTICLE
/*if($('#article-add-form')){
	$('#submit').on('click', function(e){
		var thisForm = $(this),
		thisId = thisForm.attr('id');
		thisForm.mpValidate({
			updateUrl :  admin_url + 'assets/php/ajaxsubmitroute.php',
			callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
		});
	});	
}*/



//AJAX HANDLERS
$('.ajax-submit-form').each(function(){
	var thisForm = $(this),
	thisId = thisForm.attr('id');

	thisForm.mpValidate({
		updateUrl : admin_url + 'assets/php/ajaxsubmitroute.php',
		callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
	});
});

$('.ajax-submit-image').each(function(){
	var thisForm = $(this),
	thisId = thisForm.attr('id');
	
	thisForm.mpValidate({
		updateUrl :  admin_url + 'assets/php/ajaxsubmitroute.php',
		additionalParams : 'file',
		imageFile : '.upload-img-file',
		callback : (ajaxCallbacks[thisId]) ? ajaxCallbacks[thisId] : function(){}
	});
});


//CONTRIBUTOR PAGE IMAGE
$('#contributor_wide_img').mpImageCropUpload({
	desWidth: 140,
	desHeight: 143
});


$('#image-file-link').click(function(e){
	e.preventDefault();
	$('#contributor_wide_img').click()
	$('#update-article-image').show();
});


$('#img-profile').click(function(e){
	e.preventDefault();
	$('#contributor_wide_img').click()
	$('#update-article-image').show();
});


//	Upload account image link
$(function(){
    $("#upload_link").on('click', function(e){
        e.preventDefault();
        $(".account-file-input:hidden").trigger('click');
    });
});

$('#sub-menu-button').click(function(e){
	$('#content').toggleClass('active_submenu');
	$('#nav-cont').toggleClass('mobile-menu');
});


function triggerErrorPopup(data){
	if(data){
		
		//Data to Replace
		var h2 = $('.show-status-msg');
		var msg = $('.error-msg');
		var redirect = false;
		var save = data['save'];

		if(data['statusCode'] == 200){
			$(h2).text('Thank you').removeClass('errorTxt').addClass('successTxt');
			redirect = true;
		}else{
			$(h2).text('Sorry...').removeClass('successTxt').addClass('errorTxt');
		}

		if(save){
			redirect = false;
		}
		
		$(msg).html(data['message']);
		//Validation Modal
		$(document).foundation().foundation();
		$('#show-status').foundation('reveal', 'open');
		$('#show-status').foundation('reveal', 'close');

		if(redirect){
			setTimeout(function(){
				window.location = admin_url + '/articles/';
			}, 2000);
		}

	}
}
//PUBLISH ARTICLE FROM NEW ARTICLE PAGE.
if( $('#publish-article') ){
	$('.publish-article').each(function(){
		$(this).on('click', function(e){
			var thisForm = $('#article-add-form');
			var formData = thisForm.serialize();

			$.ajax({
			  type: "POST",
			  url:   admin_url + 'assets/php/ajaxfunctions.php',
			  data: { formData: formData, a_i: $('#a_i').val() ,task:'publish-article' }
			}).done(function(data) {
				data = $.parseJSON(data);

				triggerErrorPopup(data);
			});
		});
	});
}

//SAVE ARTICLE FROM NEW ARTICLE PAGE.
if( $('#save-article') ){
	$('#save-article').each(function(){
		$(this).on('click', function(e){
			var thisForm = $('#article-add-form');
			var formData = thisForm.serialize();

			$.ajax({
			  type: "POST",
			  url:   admin_url + 'assets/php/ajaxfunctions.php',
			  data: { formData: formData, a_i: $('#a_i').val() ,task:'save-article' }
			}).done(function(data) {
				data = $.parseJSON(data);
				var id = data['articleID'];
				if( typeof id != 'undefined'){
					$('.a_i').val(id);
					location.hash = data['articleID']; //data['articleSEO'];
				} 
				
				
				triggerErrorPopup(data);
			});
		});
	});
}

//PUBLISH ARTICLE FROM EDIT PAGE
if($('.publish-button')){
	$('.publish-button').each(function(){
		$(this).on('click', function(e){
			var statusVal = $(this).attr('data-info');
			var thisForm = $('#article-info-form');
			var formData = thisForm.serialize();
			$.ajax({
			  type: "POST",
			  url:   admin_url + 'assets/php/ajaxfunctions.php',
			  data: { formData: formData, status: statusVal, a_i: $('#a_i').val(), task:'publish-article' }
			}).done(function(data) {
				data = $.parseJSON(data);
				triggerErrorPopup(data);			
			});
		});
	});
}

//SAVE ARTICLE FROM EDIT PAGE
if($('#save-existing-article')){
	$('.save-existing-article').each(function(e){
		$(this).on('click', function(e){
			var thisForm = $('#article-info-form');
			var formData = thisForm.serialize();
		//	console.log(formData);

			$.ajax({
			  type: "POST",
			  url:   admin_url + 'assets/php/ajaxfunctions.php',
			  data: { formData: formData, a_i: $('#a_i').val(), task:'save-article' }
			}).done(function(data) {
				data = $.parseJSON(data);

				//$('#status-label').text('DRAFT');
				//$('.see-article-link').hide();

				triggerErrorPopup(data);
			});
		});
	});	
}

//PUBLISH ARTICLE
/*if( $('#publish') ){
	$('.publish-button').each(function(){
		$(this).on('click', function(e){
			var statusVal = $(this).attr('data-info');
			$.ajax({
			  type: "POST",
			  url:   admin_url + 'assets/php/ajaxfunctions.php',
			  data: { status: statusVal, a_i: $('#a_i').val(), task:'update_status' }
			}).done(function(data) {

				if(data == "false" ){
					alert("You need to Upload an Image in order to make this article Live!");
				}else{
					location.reload();
				}
			});
		});
	});
}*/

//AVATAR
if($('.avatar-span')){
	$('.avatar-span').on('click', function(){
		var img = $(this).attr('data-info'),
		avatar_dir = "http://images.puckermob.com/articlesites/contributors_redesign",
		new_img_src = avatar_dir+'/'+img,
		img_profile = $('#img-profile'),
		img_name = $(img_profile).attr('data-info');
		
		$(img_profile).attr('src', new_img_src);

		$(img_profile).attr('data-info', img);

		$.ajax({
		  type: "POST",
		  url:   admin_url + 'assets/php/ajaxfunctions.php',
		  data: { image: img, c_i: $('#cont_i').val(), task:'update_avatar_img' }
		}).done(function(data) {
			if(data){
				avatar_dir = "http://images.puckermob.com/articlesites/contributors_redesign",
				new_img_src = avatar_dir+'/'+img;
				$('#image-header-profile').attr('src', new_img_src);
				$('#error-img').text('Image Updated Sucessful!').addClass('new-success').slideDown( "slow" ).delay( 1000 ).slideUp( "slow" );

		 	}else{
		 		$('#error-img').text('something went wrong. Please try again or contact info@sequelmediainternational.com.').addClass('error').slideDown( "slow" ).delay( 1000 ).slideUp( "slow" );;
		 	}
		});
	});

}

		
//LIBRARY PHOTOS
if( $('#search-lib') ){
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
		url:   admin_url + 'assets/php/ajaxfunctions.php',
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


/*PREVIEW BUTTON*/
if($('#preview')){
	$('.preview-button').each(function() {
	
		$(this).click(function(e){
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

			$('.close').click(function(e){
				$('body').removeClass('show-modal-box-prev-art');
			});

			$('#article-title').text(title);
			$('#article-body').html(body);
			
			if( $('#a_i').length > 0 ){
				$('#article_img').attr('src', 'http://images.puckermob.com/articlesites/puckermob/large/'+id+'_tall.jpg');
			}else{
				$('#article_img').attr('src', $('img[data-dz-thumbnail]').attr('src') );
			}
			
			$('body').addClass('show-modal-box-prev-art');
	
		});
	});
}


//ADS
if(document.body.id == 'editarticle'){
	
	var body_art = $('#article_body-nf').text();
	var li_parent = $(body_art).find('ol');
	var p_length = $(body_art).children('p').length;
	var li_length = $(li_parent).find('li').length;
	var isListArticle = false;
	var article_id = $('#a_i').val();

	if($(li_parent) && $(li_parent).length == 0 ) li_parent = $(body_art).find('ul');
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

	var url =  admin_url + 'assets/php/ajaxfunctions.php';

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
			url:   admin_url + 'assets/php/ajaxfunctions.php',
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
			  EarningsObj.getChartDataRange();
			  EarningsObj.drawChart();
			  //EarningsObj.getArticlesListData();
			  EarningsObj.updateTotalEarnings();   
		  }else{
			  if($('#reports').length > 0 ){
			  	EarningsObj.getWritersReport();
			  }
		  }
	  	$('input[name="daterange"]').val(picker.startDate.format('ll') + ' - ' + picker.endDate.format('ll'));
	});
}


//Add NEW ARTICLE SEO AUTO COMPLETE
if( $('#newarticle').length > 0 ){
	//SEO AUTO COMPLETE
	$('input[name="article_title-s"]').SeoTitleAutoComplete("article_seo_title-s");
}

//MANAGE ALERTS
if( $('#form-alert') ){
	$('#save-alert').each(function(){
		$(this).on('click', function(e){
			var user_id = $('#user-to-alert').val();
			var alert = $('#alert-input').val();

			if(alert.length > 0){
				
				$.ajax({
				  type: "POST",
				  url:   admin_url + 'assets/php/ajaxfunctions.php',
				  data: { user_id: user_id, msg: alert, task:'set_new_alert' },
				}).done(function(data) {
					if(data){
						var result = $.parseJSON(data);
						if(result['hasError']) $('#show-msg-alerts').removeClass('new-success').addClass('error').text('There was an error setting this alert, please try again.');
						else $('#show-msg-alerts').addClass('new-success').removeClass('error').text('Your alert was set successfully.');
					}
				});
			}else{
				$('#show-msg-alerts').removeClass('new-success').addClass('error').text('You need to add an alert message first!');
			}
		});
	});
}

//MANAGE HOTTOPICS
if( $('#form-hottopics') ){
	$('#save-hottopics').each(function(){
		$(this).on('click', function(e){
			var topics_msg = $('#hottopics-input').val();

			if(topics_msg.length > 0){
				//admin_url = 'http://localhost:8888/projects/pucker-mob/httpdocs/admin/'
				$.ajax({
				  type: "POST",
				  url:   admin_url + 'assets/php/ajaxfunctions.php',
				  data: { hot_topics_message: topics_msg, task:'set_hot_topics' },
				}).done(function(data) {
					if(data){
						var result = $.parseJSON(data);
						if(result['hasError']) $('#show-msg-hotopics').removeClass('new-success').addClass('error').text('There was an error adding the topics, please try again.');
						else $('#show-msg-hotopics').addClass('new-success').removeClass('error').text('Your Topics were set successfully.');
					}
				});
			}else{
				$('#show-msg-hotopics').removeClass('new-success').addClass('error').text('You need to add at least one topic!');
			}
		});
	});
}

if( $('#form-send-email') ){
	$('#send-email').each(function(){
		$(this).on('click', function(e){
			var email_msg = $('#email_message').val(),
			email_add = $('#blogger_email').val();

			//console.log(email_add);
			if(email_msg.length > 0){
			//	admin_url = 'http://localhost:8888/projects/pucker-mob/httpdocs/admin/'
				$.ajax({
				  type: "POST",
				  url:   admin_url + 'assets/php/ajaxfunctions.php',
				  data: { email_msg: email_msg, task:'send_email', email_add: email_add },
				}).done(function(data) {
					if(data){
						var result = $.parseJSON(data);
						if(result['hasError']) $('#show-msg-email').removeClass('new-success').addClass('error').text('There was an error sending the email, please try again.');
						else $('#show-msg-email').addClass('new-success').removeClass('error').text('The Email was sent successfully.');
					}
				});
			}else{
				$('#show-msg-email').removeClass('new-success').addClass('error').text('Add a Message!');
			}
		});
	});

	$('#blogger_email').filterByText( $('#bloggers_list_search'), false );
}

if( $('.facebook-sites') ){
	$('.facebook-sites').each( function(){
		$(this).on('change', function(e){
			var value = $(this).val();
			var parent = $(this).parent();
			var article_id = $(parent).attr('data-info');
			var facebook_page =  $("option:selected", this).text();
			var user_id = $(parent).attr('data-user-id');
			var article_title = $(parent).attr('data-title');
			var promoted = 0;
			
			$.ajax({
			  type: "POST",
			  url:   admin_url + 'assets/php/ajaxfunctions.php',
			  data: { 
			  	article_id: article_id, 
			  	facebook_page_id : value,
			  	facebook_page_name : facebook_page, 
			  	promoted: promoted, 
			  	user_id: user_id, 
			  	article_title : article_title, 
			  	task:'promote_articles' 
			  },
			}).done(function(data) {
				if(data){
					var result = $.parseJSON(data);
				}
			});

		});
	});
}

if( $('#promote_articles_list') ){
	$('.promoted-cb').each( function(){
		$(this).on('click', function(){
			var ele = this,
			isCheck = $(this).is(':checked'),
			article_id = $(this).attr('data-info'),
			user_id = $(this).attr('data-user'), 
			facebook_page_id = $(this).attr('data-fb-id'), 
			facebook_page_name = $(this).attr('data-fb-name'),
			article_title = $(this).attr('data-title');
			
			$.ajax({
				  type: "POST",
				  url:   admin_url + 'assets/php/ajaxfunctions.php',
				  data: { 
				  	article_id: article_id, 
				  	promoted : isCheck,  
				  	task:'article_promoted', 
				  	user_id: user_id, 
				  	facebook_page_id : facebook_page_id, 
				  	facebook_page_name : facebook_page_name, 
				  	article_title : article_title  
				  },
				}).done(function(data) {
					if(data){
						var result = $.parseJSON(data);

					}
				});

		});
	});
}

if( $('#ranking')){
	$('#month-option').on('change', function(){
	 	var month = $(this).val(),
	 	form = $('#social-media-shares-form');

		console.log(month);

		form.submit();
	});
}



//REVIEW BUTTON
if($('.review-button')){
	//APPROVE ARTICLE
	$('.review-button').on('click', function(e){
		var id = $('#a_i').val();
		//admin_url = 'http://localhost:8888/projects/pucker-mob/httpdocs/admin/'

		$.ajax({
		  type: "POST",
		  url:   admin_url + 'assets/php/ajaxfunctions.php',
		  data: { 
		  	a_i: id, 
		  	task:'article_status', 
		  	article_status: 2,
		  },
		}).done(function(response) {
			if(response){
				location.reload();
			}
		});

	});
}
	

//APPROVAL REQUIRED
if($('#approval')){
	//APPROVE ARTICLE
	$('.approve').on('click', function(e){
		var title = $(this).attr('data-title');
		var id = $(this).attr('data-id');
		var user_id = $(this).attr('data-user-id');
		var reasons = "Congratulations! Your article "+title+" has been approved and is now live on PuckerMob.com.";

		$.ajax({
		  type: "POST",
		  url:   admin_url + 'assets/php/ajaxfunctions.php',
		  data: { 
		  	a_i: id, 
		  	task:'approve-article', 
		  	article_status: 1,
		  	reasons: reasons, 
		  	user_id : user_id 

		  },
		}).done(function(response) {
			if(response){
				var result = $.parseJSON(response);
				var txt_id = '#article-'+id;
				$(txt_id).slideUp(300);
			}
		});

	});
	
	//REJECT ARTICLE
	$('.send-reasons').on('click', function(e){
		var title = $(this).attr('data-title');
		var id = $(this).attr('data-id');
		var user_id = $(this).attr('data-user-id');
		var reasons_el = $(this).parent().find('.reject-msg');
		var reasons = $(reasons_el).val();

		if($(reasons_el).val().length <= 0) {
			reasons = "We're sorry, but your article '"+title+"' could not be approved. Please review our terms and conditions to ensure future articles meet the necessary requirements."
		}
	
		$.ajax({
		  type: "POST",
		  url:   admin_url + 'assets/php/ajaxfunctions.php',
		  data: { 
		  	a_i: id, 
	  		task:'reject-article', 
	  		msg: reasons, 
	  		article_status: 3, 
	  		user_id : user_id 
		  },
		}).done(function(data) {
			if(data){
				var result = $.parseJSON(data);
				var alert_msg = "Sent!" ;
				var txt_id = '#article-'+id;
				
				var class_name = 'new-success';
				if(result['hasError']){
					alert_msg = " Error Rejecting Article "; 
					class_name = "error-msg";
				} 

				$(reasons_el).val( alert_msg ).addClass(class_name );
				setTimeout(function(){
					$(reasons_el).val('').removeClass(class_name );
					$(txt_id).slideUp(300);
				}, 2000);
			}
		});
	});
}

if($('#reveal-link')){
	$('#reveal-link').trigger('click');
}

$('#more-link').on('click', function(e){
	e.preventDefault();
	e.stopPropagation();
	$el = $(this);
	
	$('.current-data').toggleClass('show');

	if( $('.current-data').is('.show') ){
		$('.current-data').css({ "max-height": "999999"});
		$('.current-data').animate({"height": "auto"});
		$('#more-link').text('...Less');
	}else{
		$('.current-data').css({ "max-height": "999999"});
		$('.current-data').animate({"height": "100px"});
		$('#more-link').text('...More');

	}	
});


//AD MATCH OBJECT
var adMatching = {
	bonusObj: null,
	userCommit: 0,
	matchCommit: 0,
	totalCommit: 0,
	bonusID: 0,
	bonusPCT: 0, 
	bonusMatch: 0,

	init: function(){},

	formatNumbers: function( value ){
		return '$' + parseFloat(value, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
	},

	replaceValues: function( element ){
		var bonus_obj = $(element).parent().parent().find('.bonus-info');
		var user_commit = $(bonus_obj).find('#user_commit').attr('data-amount');
		var match_commit  = $(bonus_obj).find('#match_commit').attr('data-amount');
		var total_commit = $(bonus_obj).find('#total_commit').attr('data-amount');

		adMatching.bonusObj = bonus_obj;
		adMatching.userCommit = user_commit;
		adMatching.matchCommit = match_commit;
		adMatching.totalCommit = total_commit; 
		adMatching.bonusID = $(element).attr('data-bonus-id') ;
		adMatching.bonusPCT = $(element).attr('data-bonus') ;
		adMatching.bonusMatch = $(element).attr('data-bonus-match');

		var schedule_payment = $('#schedule-payment').attr('data-bonus');
		var deducted_payment = $('#deducted-payment');
		var total_deducted = $('#total-deducted');
		var your_contribution = $('#your-contribution');
		var our_contribution = $('#our-contribution');
		var total_contribution = $('#total-contribution');
	
		var total_ded = parseInt(schedule_payment) - parseInt(user_commit);

		$(deducted_payment).text(adMatching.formatNumbers(user_commit));
		$(total_deducted).text(adMatching.formatNumbers(total_ded));
		$(your_contribution).text(adMatching.formatNumbers(user_commit));
		$(our_contribution).text(adMatching.formatNumbers(match_commit));
		$(total_contribution).text(adMatching.formatNumbers(total_commit));
	},

	clearValues: function(element){
		var deducted_payment = $('#deducted-payment');
		var total_deducted = $('#total-deducted');
		var your_contribution = $('#your-contribution');
		var our_contribution = $('#our-contribution');
		var total_contribution = $('#total-contribution');

		adMatching.bonusObj = null;
		adMatching.userCommit = 0;
		adMatching.matchCommit = 0;
		adMatching.totalCommit = 0;
		adMatching.bonusID = 0 ;
		adMatching.bonusPCT = 0 ;
		adMatching.bonusMatch = 0;

		$(deducted_payment).text(adMatching.formatNumbers(0));
		$(total_deducted).text(adMatching.formatNumbers(0));
		$(your_contribution).text(adMatching.formatNumbers(0));
		$(our_contribution).text(adMatching.formatNumbers(0));
		$(total_contribution).text(adMatching.formatNumbers(0));
	},
	
	selectAdMatch: function(element){

		var parent = $(element).parent();
		var cbox = $(parent).find('input:checkbox');
		
		//CLEAR SELECTION
		$('.ad-match-me-element').parent().find('input:checkbox').not(cbox).attr( 'checked', false );
		$('.ad-match-me-element').html('');

		if( $(cbox).attr('checked') === "checked" ){
			 $(cbox).attr('checked', false);
			 $(element).html('');
			 adMatching.clearValues( cbox );
		}else{
			 $(cbox).attr('checked', true);
			$(element).html('<i class="fa fa-check checkd-label" aria-hidden="true"></i>');
			adMatching.replaceValues( cbox );
		} 
	}
}
$('.ad-match-me-element').each( function(){
	$(this).on('click', function(){
		adMatching.selectAdMatch(this);
	});
});

//ORDER OBJECT
var OrderObj = {
	bonus: false,
	agree: false,
	submitStatus : false,//OrderObj.submitReady(false),
	currentDate:  moment().format("YYYY-MM-DD"),
	init: function(){
		//AGREE ORDER
		$('.agree-element').on('click', function(){
			OrderObj.setAgree(this);
		});

		$('#submit-order').on('click', function(){
			OrderObj.clickSubmit();
		});
	},
	setAgree: function(element){
		var parent = $(element).parent();
		var cbox = $(parent).find('#agree');
		
		if( $(cbox).attr('checked') === "checked" ){
			 OrderObj.agree = false;
			 OrderObj.submitReady(false);
			 $(cbox).attr('checked', false);
			 $(element).html('');
		}else{
			OrderObj.agree = true;
			OrderObj.submitReady(true);
			$(cbox).attr('checked', true);
			$(element).html('<i class="fa fa-check checkd-label" aria-hidden="true"></i>');
		} 
	},
	verifyBonusSelected: function(){
		var bonus = $('.ad-match-me-element').parent().find('input:checkbox');
		var bonus_info = false;
		$(bonus).each(function(){
			if($(this).is(':checked')) bonus_info = $(this);
		});

		return bonus_info;
	},
	submitReady: function( status ){
		if( status === true ){
			OrderObj.submitStatus = true;
			//$('#submit-order').attr('disabled', true);
		}else{
			OrderObj.submitStatus = false;
			//$('#submit-order').attr('disabled', false);
		}
	},
	submitOrder: function( $data ){
		OrderObj.bonus = OrderObj.verifyBonusSelected();

		var contributor_id = $('#contributor_id').val(),
			month_relation = $('#month_relation').val(),
			year_relation = $('#year_relation').val(),
			total_earnings = $('#to_be_pay').val(),
			amount_commit = adMatching.userCommit,
			amount_match = adMatching.matchCommit,
			total_commit = adMatching.totalCommit,
			agree = OrderObj.agree, 
			bonus_id = adMatching.bonusID,
			bonus_pct = adMatching.bonusPCT ,
			bonus_match = adMatching.bonusMatch;

			if(	OrderObj.validate() === true ){

		    	$.ajax({
					type: "POST",
					async: false,
					url:  admin_url + 'assets/php/ajaxfunctions.php',
					data: { 
						task           : 'submit_order', 
						date           : OrderObj.currentDate,
						contributor_id : contributor_id, 
						month_relation : month_relation,
						year_relation  : year_relation,
						total_earnings : total_earnings, 
						amount_commit  : amount_commit,
						amount_match   : amount_match,
						total_commit   : total_commit,
						agree          : agree,
						bonus_id       : bonus_id,
						bonus_pct      : bonus_pct,
						bonus_match    : bonus_match
					}
				}).done(function(data) {
					if( data != "false" ){ 
						data = $.parseJSON(data);

						if(data.hasError === false ){
							$('.order-error').remove();
							$('.agree-box').html('<label class="center uppercase small-12 columns radius order-submitted">Your order Has been summited. Thanks</label>');
							$('#submit-order').hide();
						}else{
							$('.order-error').remove();
							$('.agree-box').before('<label class="center uppercase small-12 columns radius order-error">SORRY... Something Happend. Please try to make the order again. Thanks</label>');
						}		
					}
				});
			}else{
				$('.order-error').remove();
				$('.agree-box').before('<label class="center uppercase small-12 columns radius order-error">SORRY YOU NEED TO SELECT BONUS AND AGREE WITH US</label>');
			}
	},
	validate: function(){
		var valid  = false;
		var day = parseInt( moment().format("DD") );

		if( day >= 1 && day <= 21) {
			if( adMatching.bonusID !== 0 && OrderObj.agree === true) valid = true;
		}	
		return valid;
	},
	clickSubmit: function(){
		OrderObj.submitOrder();
	},
	disableSubmit:function(){},
	showModalOrderStatus: function(){}
	}
	
	OrderObj.init();

	var OrderHistory = {
		target : null,
		onClick: function(ele){
			var contributor_id = $(ele).parents().find('#history-link').attr('data-info-id');
			var balance = $(ele).parents().find('#history-link').attr('data-info-total-balance');
			OrderHistory.target = ele;

			OrderHistory.createForm( contributor_id );
		},
		createForm: function( id ){
			$.ajax({
			   type: "POST",
			   url:   admin_url + 'assets/php/ajaxfunctions.php',
			   data: { contributor_id:id , balance: OrderHistory.balance,task:'get_form_history' }
			}).done(function(data) {
			console.log(data);
				$('#add-history').hide();
				$('#order-history').append(data);

			});

		},
		createTdTable: function( data ){
			var row = '';
			row += '<tr>';
			row += '<td width="200">';
			if(data.receipt == 1 ){
				row += '<div><label><i class="fa fa-check main-color" aria-hidden="true"></i></label><input type="checkbox" name="receipt_sent" checked="" class="hidden receipt_sent"></div>';
			}else{
				row += '<div><label>SEND<input type="checkbox" name="receipt_sent" style="margin: 10px; top: 5px; position: relative;" class="receipt_sent"></label></div>';
			}
			row += '</td>';
			row += '<td width="200"><label>'+data.spent+'</label></td>';
			row += '<td width="200"><label>'+data.date+'</label></td>';
			row += '<td width="200"></label>'+data.balance+'</label></td>';
			row += '<td></td>';
			row += '</tr>';

			$('#order-history table tbody').append(row);
			$('#form-transaction').remove();
		}
	}
	$('#history-modal').on('click', '#add-history', function(e){
		OrderHistory.onClick(this);
	});

	
	$('#history-modal').on('click', '#save-transaction', function(e){
		var thisForm = $(this).parents('form');
		var formData = thisForm.serialize();
		$.ajax({
		  type: "POST",
		  url:   admin_url + 'assets/php/ajaxfunctions.php',
		  data: { formData: formData ,task:'save-transaction' }
		}).done(function(data) {
			data = $.parseJSON(data);
			if(data.hasError === false ){
				$('#add-history').show();
				OrderHistory.createTdTable(data.data);
			}
		});
			console.log(formData);
	});

	//$('#history-modal').on('click', '.receipt_sent', function(e){
	// console.log($(this).parents());
	//});

$('.show-msg').on('click', function(e){
	alert('This article has been edited by the PuckerMob staff and can no longer be altered.');
});

}); 
 

