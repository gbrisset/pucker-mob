$(document).ready(function (){

//var admin_url = 'http://localhost:8888/projects/pucker-mob/httpdocs/admin/assets/php/';
var admin_url = 'http://www.puckermob.com/admin/';

var maxsize =1024;
var tools = ['resize', 'crop'];
if($('#is_mobile').val() == '1'){
	tools = ['resize'];
	maxsize = 1024;
}

if($('#is_mobile').val() != '1'){

	var featherEditor = new Aviary.Feather({
	    apiKey: '13146877c1064663b3054f86cf4d2b4a',
	    tools: tools,
	   // cropPresets: ['784x431'],
	    theme: 'minimum',
	   // displayImageSize: true,
	  //  fileFormat: 'jpg, png, jpeg',
	   // maxSize: maxsize,

	    onSave: function(imageID, newURL) {
	        //$('.loading').show();
	        var img = document.getElementById(imageID);
	        img.src = newURL;
	        var id = $('#a_i').val();

	    	//alert($('#avpw_resize_width').val()+' - '+$('#avpw_resize_height').val());

	        $.ajax({
	            type: 'POST',
	            dataType: 'json',
	            data: { task: 'get_edited_image', articleId: id, url:newURL, u_i: $('#u_i').val() },
	            url: admin_url+"assets/php/getImage.php"
	        }).done(function(result) {
	        	//$('.loading').hide();
	    		if(result['statusCode'] == 200){
	    			if($('#existing-img').length > 0 ) $('#existing-img').remove();
	    			$('#main-image-src').show();
	    			$('.image-drop-titles').css('display', 'none');
	    		}else{
	    			$('#main-image-src').hide();
	    			$('#main-image-src').attr('src', '');
	    			$('.image-drop-titles').css('display', 'inline-block');
	    			triggerErrorPopup(result);
	    		}
			});
	        
	        $('.dz-error-message').css('display', 'none');
	        featherEditor.close();

	    },
	    onError: function(errorObj) {
	   		alert(errorObj.message);
		},
	    onClose:function(isDirty){
	    	featherEditor.close();
			$('#main-image-src').hide();
			$('.image-drop-titles').css('display', 'inline-block');

	    }
	});

	function launchEditor(id, src) {
	    featherEditor.launch({
	        image: id,
	        url: src,
			forceCropMessage: 'Crop your Article picture:',
	    });
	    //return false;
	}

	var maxImageWidth = 784, maxImageHeight = 431, currentWidth = 0, currentHeight = 0;
	var previewNode = document.querySelector("#template");
	previewNode.id = "";
	var previewTemplate = previewNode.parentNode.innerHTML;
	previewNode.parentNode.removeChild(previewNode);

	Dropzone.options.imageDrop = {
	  paramName: "file", // The name that will be used to transfer the file
		  maxFiles: '1',
		  acceptedFiles: '.jpg, .gif, .png, .jpeg',       // allowed image types don't use image/*
		  maxFilesize: 3, // MB
		  uploadMultiple: false,
		  thumbnailWidth: 784,
		  thumbnailHeight: 431,
		  previewsContainer: ".dropzone-previews",
		  previewTemplate: previewTemplate,

		init: function() {
	  	this.on("maxfilesexceeded", function(file) {
	        console.log('maxfilesexceeded');
	    });

		this.on("addedfile", function(file) {
		  console.log('addedfile');
		  if(this.files[1]!=null){
		    this.removeFile(this.files[0]);
		  } 

		  if($('.dz-preview').length > 0 ){
		    	$('#image-preview-org').remove();
		    }
		 
		  if($('#template_copy').length > 0 ){
		  	$('#template_copy').remove();
		  }

		  $('#icon-pic').hide();

		  currentWidth = 0;
	      currentHeight = 0;
		});

		// Will send the filesize along with the file as POST data.
		this.on("sending", function(file, xhr, formData) {
			formData.append("filesize", file.size); 
		});

		this.on("thumbnail", function(file) {
			if($('#is_mobile').val() == '0'){
				return launchEditor('main-image-src', $('#main-image-src').attr('src') );
			}
	      });

	 },
	 accept: function(file, done) {
	      file.acceptDimensions = done;
	      file.rejectDimensions = function() { 
	      	$('#main-image-src').attr('src', "");
	      	done("Invalid dimension. Must be 784x431"); };
	  }
	};

	function triggerErrorPopup(data){
		if(data){
			
			//Data to Replace
			var h2 = $('.show-status-msg');
			var msg = $('.error-msg');
			var redirect = false;
			var save = data['save'];

			if(data['statusCode'] == 200){
				$(h2).text('Thank you for posting this!').removeClass('errorTxt').addClass('successTxt');
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

	$("#image-drop").hover(function(){
		if( ( $('#main-image-src').attr('src') != undefined   &&  $('#main-image-src').css('display') != 'none' ) || 
			( $('#existing-img').attr('src') != undefined  && $('#existing-img').css('display') != 'none' ) ){
			    $('.image-overlay-content').show();
		}
	}, function() {
	   $('.image-overlay-content').hide();
	});


	$('#edit-image').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();

		return launchEditor('main-image-src', $('#main-image-src').attr('src') );
	});
//MOBILE	
}else{


	var maxImageWidth = 784, maxImageHeight = 431, currentWidth = 0, currentHeight = 0;
	var previewNode = document.querySelector("#template");
	previewNode.id = "";
	var previewTemplate = previewNode.parentNode.innerHTML;
	previewNode.parentNode.removeChild(previewNode);

	Dropzone.options.imageDrop = {
	  paramName: "file", // The name that will be used to transfer the file
		  maxFiles: '1',
		  acceptedFiles: '.jpg, .gif, .png, .jpeg',       // allowed image types don't use image/*
		  maxFilesize: 3, // MB
		  uploadMultiple: false,
		  thumbnailWidth: 784,
		  thumbnailHeight: 431,
		  previewsContainer: ".dropzone-previews",
		  previewTemplate: previewTemplate,

		init: function() {
		  	this.on("maxfilesexceeded", function(file) {
		        console.log('maxfilesexceeded');
		    });

			this.on("addedfile", function(file) {
			    console.log('addedfile');
			    if(this.files[1]!=null){
			    	this.removeFile(this.files[0]);
			    } 

			    if($('.dz-preview').length > 0 ){
			    	$('#image-preview-org').remove();
			    }
		 
			    if($('#template_copy').length > 0 ){
			  	  $('#template_copy').remove();
			    }

		        //$('#icon-pic').hide();

		        currentWidth = 0;
	           currentHeight = 0;
		    });

			// Will send the filesize along with the file as POST data.
			this.on("sending", function(file, xhr, formData) {
				formData.append("filesize", file.size); 
			});

			this.on("thumbnail", function(file) {
		 		if (file.width != maxImageWidth || file.height != maxImageHeight) {
                  file.rejectDimensions()
                }
                else {
                  file.acceptDimensions();
                  $('.div-to-hide').hide();
                  	if($('#existing-img').length > 0 ) $('#existing-img').remove();
	    			$('#main-image-src').show();
                }
	     	});

	 	},
	 	accept: function(file, done) {
	      file.acceptDimensions = done;
	      file.rejectDimensions = function() { 
	      	$('#main-image-src').attr('src', "");
	      	done("Invalid dimension. Must be 784x431"); };
	  }
	};
}

});