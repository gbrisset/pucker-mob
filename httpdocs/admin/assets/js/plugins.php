<?php
	Header("content-type: application/x-javascript");
	require_once('../../../assets/php/config.php');
?>

var EarningsObj = {	
	start_date : moment().subtract(7, 'days').format("YYYY-MM-DD"), end_date : moment().format("YYYY-MM-DD"),
	chart_info : {}, article_list : {},
	total_earnings: 0,
	options : {
	       	  legend : { position:"none"},
	          chart: {
	            title: '',
	            subtitle: '',
	          },
	          bars: 'vertical',
	          vAxis: {format: 'decimal'},
	          height: 400,
	          colors: ['#014694', '#627E93'],
	},
    
	initChart: function(){
	    google.charts.setOnLoadCallback(EarningsObj.drawChart);
    },
   
    setValues: function( start_date, end_date ){
    	EarningsObj.start_date = start_date;
    	EarningsObj.end_date = end_date;
    	EarningsObj.chart_info =  EarningsObj.getChartData( EarningsObj.start_date, EarningsObj.end_date );
    },
  
    setTotalEarnings: function( total_earned){
    	EarningsObj.total_earnings = total_earned;
	},
   
    getChartData: function(){
    	var info = {}, chart = [ ['', 'This Month', 'Last Month'] ], contributor_id = $('#contributor_id').val(), total_earned = 0;
    	$.ajax({
			type: "POST",
			async: false,
			url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
			data: { task:'get_chart_data', contributor_id : contributor_id, start_date: EarningsObj.start_date, end_date: EarningsObj.end_date  }
		}).done(function(data) {
			if( data != "false" ){ 
				data = $.parseJSON(data);
				$(data).each( function(e){	
					var val = $(this);
					var rate = $('#current-user-rate').val();
					var pageviews = parseInt(val[0].current_pageviews),
					last_month_pageviews = parseInt(val[0].last_month_pageviews),
					amount = 0, 
					last_month_amount = 0;

					if(pageviews > 0 ) amount = ( pageviews / 1000 ) * rate ;
					if(last_month_pageviews > 0 ) 	last_month_amount = ( last_month_pageviews / 1000 ) * rate ;

					total_earned = total_earned + amount;
					info = [ val[0].date, amount, last_month_amount];
					chart.push(info);
				});

			}
			EarningsObj.total_earnings = total_earned;
			EarningsObj.chart_info = chart;
		});
	},

	getChartDataRange: function(){

		var info = {}, 
		chart = [['', 'revenue', ' '] ], 
		contributor_id = $('#contributor_id').val(), 
		total_earned = 0;
    	$.ajax({
			type: "POST",
			async: false,
			url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
			data: { task:'get_chart_data_range', contributor_id : contributor_id, start_date: EarningsObj.start_date, end_date: EarningsObj.end_date  }
		}).done(function(data) {
			if( data != "false" ){ 
				data = $.parseJSON(data);
				$(data).each( function(e){	
					var val = $(this);
					var rate = $('#current-user-rate').val();
					var pageviews = parseInt(val[0].current_pageviews),
					last_month_pageviews = parseInt(val[0].last_month_pageviews),
					amount = 0, 
					last_month_amount = 0;

					if(pageviews > 0 ) amount = ( pageviews / 1000 ) * rate ;
					if(last_month_pageviews > 0 ) 	last_month_amount = ( last_month_pageviews / 1000 ) * rate ;

					total_earned = total_earned + amount;
					info = [ val[0].date, amount, last_month_amount];
					chart.push(info);
				});

				

			}
			EarningsObj.total_earnings = total_earned;
			EarningsObj.chart_info = chart;

			$('#month-year-title').text('Earnings: $'+ parseFloat(EarningsObj.total_earnings, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
			$('.chart-legend').hide();
		});
	},
	
	getArticlesListData: function(){
    	var info = {}, articles = [], contributor_id = $('#contributor_id').val(), total_earned = 0;
    	$.ajax({
			type: "POST",
			async: false,
			url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
			data: { task:'get_chart_article_data', contributor_id : contributor_id, start_date: EarningsObj.start_date, end_date: EarningsObj.end_date  }
		}).done(function(data) {
			var total_amount = 0, total_pageviews = 0,  t_body = $('#article-list tbody'), html = "";
			if( data != "false" ){ 
				data = $.parseJSON(data);
				var rate = $('#current-user-rate').val();
				
				$(data).each( function(e){	
					var val = $(this),
					pageviews = parseInt(val[0].usa_pageviews),
					amount = 0;
					var tr = "";

					if(pageviews > 0 ) amount = ( pageviews / 1000 ) * rate ;	

					tr += "<tr id='article-'"+ val[0].article_id + ">";
						tr += "<td class='article align-left'>";
							tr += "<a href='http://puckermob.com/"+ val[0].cat_dir_name +"/"+ val[0].article_seo_title +" 'target='blank' > "+ val[0].article_title.substring(0,40) +"... </a>";
						tr += "</td>";
						tr += "<td>" + moment( val[0].creation_date ).format("ll") + "</td>";
						tr += "<td>" + pageviews + "</td>";
						tr += "<td>" + rate + "</td>";
						tr += "<td class='bold align-right'>$"+ parseFloat(amount, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString() +"</td>";
					tr += "</tr>";
					html += tr;
					total_amount += amount;
					total_pageviews += pageviews;
				});
				var total_tr = '<tr class="total">';
					total_tr += '<td class="bold">TOTAL</td>';
					total_tr += '<td></td>';
					total_tr += '<td class="bold">'+total_pageviews+'</td>';
					total_tr += '<td class="bold">$'+rate+'</td>';
					total_tr += '<td class="bold align-right">$'+parseFloat(total_amount, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()+'</td>';
				total_tr += '</tr>';

				html += total_tr;
			}
			EarningsObj.total_article_earned += total_amount;
			$(t_body).html(html);

		});
	},

	getWritersReport: function(){
		var info = {}, articles = [], contributor_id = $('#contributor_id').val(), total_earned = 0, total_amount = 0, total_pageviews=0;
		////$dataInfo = ['start_date' => $start_date, 'end_date' => $end_date];

    	$.ajax({
			type: "POST",
			async: false,
			url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
			data: { task:'get_report_writers_data', start_date: EarningsObj.start_date, end_date: EarningsObj.end_date  }
		}).done(function(data) {
			var total_articles = 0, total_per_article = 0,  total_cpm = 0, total_pageviews = 0, total_rev = 0, t_body = $('#writers-tbody'), html = "", pageviews = 0;
			if( data != "false" ){ 
				data = $.parseJSON(data);
				
				$(data).each( function(e){	
					var val = $(this);
					var total_article_rev = parseInt(val[0].article_rate),
					total_CPM_earned = 0, total = 0,
					pageviews = (val[0].pageviews.us_pageviews != null) ? parseInt(val[0].pageviews.us_pageviews) : 0;
					
					if(pageviews > 0) total_CPM_earned = ( pageviews / 1000 ) * 7.5;
					
					new_articles = parseInt(val[0].total_articles);
  			
					total = total_CPM_earned - total_article_rev;
					total_articles += new_articles;
					total_per_article += total_article_rev;
					total_pageviews += pageviews;
					total_cpm  += total_CPM_earned;
					total_rev += total;
					var styling = '';
					if(total < 0 ) styling = 'style="color: red;"'

					var tr = '';
					tr+= '<tr id="contributor-id-'+val[0].contributor_id+'">';
						tr+= '<td class="align-left" >'+val[0].contributor_name+'</td>';
						tr+= '<td>'+new_articles+'</td>';
						tr+= '<td>$'+parseFloat(total_article_rev, 10).toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()+'</td>';
						tr+= '<td>'+parseFloat(pageviews, 10).toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()+'</td>';
						tr+= '<td>$'+parseFloat(total_CPM_earned, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()+'</td>';
						tr+= '<td class="align-right" '+styling+'>$'+parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()+'</td>';
					tr+= '</tr>';

					html += tr;
					total_amount += total;
				});

				var total_tr = '<tr style="background-color: #E6FAFF">';
					total_tr += '<td class="bold align-left">TOTAL:</td>';
					total_tr += '<td>'+parseFloat(total_articles, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()+'</td>';
					total_tr += '<td>'+parseFloat(total_per_article, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()+'</td>';
					total_tr += '<td>'+parseFloat(total_pageviews, 10).toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()+'</td>';
					total_tr += '<td>'+parseFloat(total_cpm, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()+'</td>';
					total_tr += '<td class="align-right">$'+parseFloat(total_amount, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()+'</td>';
				total_tr += '</tr>';

				html += total_tr;
			
			}
			$(t_body).html(html);
			

		});
	},

	drawChart: function( ) {
        if(EarningsObj.chart_info.length > 0){
              
        var data = google.visualization.arrayToDataTable(EarningsObj.chart_info );
		var chart = new google.charts.Bar(document.getElementById('chart_div'));

	    chart.draw(data, google.charts.Bar.convertOptions(EarningsObj.options));

        }else{
       		$('#chart_div').text('Sorry, No data found!').css('text-transform', 'uppercase').css('height', 'auto').css('margin-bottom', '2rem').css('margin-left', '1rem');
       }
     },

     updateTotalEarnings: function(){
     	$('#total_earned_graph').text('$' + parseFloat(EarningsObj.total_earnings, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString())
     }
};

/*	SEO Title auto complete...
		Call this method on a form input element that the user will be typing in
		argument1: The input to be auto-completed
		argument2: The hidden input that indicates the seo name has changed
*/

$.fn.SeoTitleAutoComplete = function(seoTitleInputName, hiddenInput){
	$(this).keyup(function () { 
		var title= $(this).val();
		title = title.replace(/[^0-9a-zA-Z_\s]/g, '');
		title = title.trim();
		title = title.toLowerCase().replace(/ /g, '-');

		$('input[name="'+seoTitleInputName+'"]').val(title);

		$('input[name="'+hiddenInput+'"]').val("true");
	});		
}

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

/*
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
};*/

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

			//if(tinyMCE){
			//	tinyMCE.triggerSave();
			//}

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
					switch(this.readyState){
						case 4:
							data  = JSON.parse(this.response);
							
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
					
						$.post(options.updateUrl, {
								formData : thisForm.serialize(),
								formId : thisId,
								additionalParams : options.additionalParams
							},
							function(data){
								//console.log(data);
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