(function($) {

	$.fn.scrollPagination = function(options) {
		
		var settings = { 
			nop     : 25, // The number of posts per scroll to be loaded
			offset  : 0, // Initial offset, begins at 0 in this case
			error   : 'No More Articles!', // When the user reaches the end this is the message that is
			                            // displayed. You can change this if you want.
			delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
			               // This is mainly for usability concerns. You can alter this as you see fit
			scroll  : true, // The main bit, if set to false posts will not load as the user scrolls. 
			               // but will still load if the user clicks.
			page	: 1    // IF 1 is form homepage or category IF 2 is from an article page.
		}
		
		// Extend the options so they work with the plugin
		if(options) {
			$.extend(settings, options);
		}
		
		// For each so that we keep chainability.
		return this.each(function() {		
			
			// Some variables 
			$this = $(this);
			$settings = settings;
			var offset = $settings.offset;
			var busy = false; // Checks if the scroll action is happening 
			                  // so we don't run it multiple times
			
			// Custom messages based on settings
			if($settings.scroll == true) $initmessage = 'Scroll for more';
			else $initmessage = 'Click for more';
			
			// Append custom messages and extra UI
			$this.append('<div class="content"></div><div class="loading-bar">'+$initmessage+'</div>');
			

			function kFormatter(num) {
			  	return num > 999 ? (num/1000).toFixed(1) + 'k' : num
			}

			function getTotalShares( url, elm ){
 		
		 		var span_shares_holder = $(elm).find('.span-holder-shares');
		 		var this_count = 0;
		 		var fn_callback = null ;
		 		var label =  " SHARES";
				var service = {
				  "facebook": "http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls=",
				  "twitter": "http://cdn.api.twitter.com/1/urls/count.json?url=",
				  "pinterest": "http://widgets.pinterest.com/v1/urls/count.json?source=6&url=",
				 // "linkedint": "http://www.linkedin.com/countserv/count/share?url="
				};
		 		
		 		$.each( service, function( key, value ) {
				 // console.log( key + ": " + value );
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

			function getData() {
				
				// Post data to ajax.php
				var cat_id = $('#cat_id').attr('value');
				//$.post('http://localhost:8888/projects/pucker-mob/httpdocs/assets/ajax/ajax.php', {
				$.post('http://www.puckermob.com/assets/ajax/ajax.php', {
					action        : 'scrollpagination',
				    number        : $settings.nop,
				    offset        : offset,
				    pageid		  : cat_id,
				    page		  : page
					    
				}, function(data) {
						
					// Change loading bar content (it may have been altered)
					$this.find('.loading-bar').html($initmessage);
						
					// If there is no data returned, there are no more posts to be shown. Show error
					if(data == "") { 
						$this.find('.loading-bar').html($settings.error);	
					}
					else {
					
						// Offset increases
					    offset = offset+$settings.nop; 
						console.log("Loading "+$settings.nop+" offset: "+offset);
						// Append the data to the content div
					   	
					   	var content = $this.find('.content');
					
				  	   	$(content).append(data);

						// No longer busy!	
						busy = false;

						$.each($('.article-id'),  function( i ){
					 	 	getTotalShares( $(this).attr('data-info-url'), $(this) );
					 	});
					}	
						
				});
					
			}

			getData(); // Run function initially
			
			
			// If scrolling is enabled
			if($settings.scroll == true) {
				// .. and the user is scrolling
				$(window).scroll(function() {
					
					// Check the user is at the bottom of the element
					if($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
						
						// Now we are working, so busy is true
						busy = true;
						
						// Tell the user we're loading posts
						$this.find('.loading-bar').html('<img src="http://www.puckermob.com/assets/img/ajax-loader.gif" />');
						
						// Run the function to fetch the data inside a delay
						// This is useful if you have content in a footer you
						// want the user to see.
						setTimeout(function() {
							
							getData();
							
						}, $settings.delay);
							
					}	
				});
			}
			
			// Also content can be loaded by clicking the loading bar/
			$this.find('.loading-bar').click(function() {
			
				if(busy == false) {
					busy = true;
					getData();
				}
			
			});
			
		});
	}

	$.fn.scrollPaginationDesktop = function(options) {
		
		var settings = { 
			nop     : 25, // The number of posts per scroll to be loaded
			offset  : 0, // Initial offset, begins at 0 in this case
			error   : 'No More Articles!', // When the user reaches the end this is the message that is
			                            // displayed. You can change this if you want.
			delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
			               // This is mainly for usability concerns. You can alter this as you see fit
			scroll  : true, // The main bit, if set to false posts will not load as the user scrolls. 
			               // but will still load if the user clicks.
			page	: 1    // IF 1 is form homepage or category IF 2 is from an article page.
		}
		
		// Extend the options so they work with the plugin
		if(options) {
			$.extend(settings, options);
		}
		
		// For each so that we keep chainability.
		return this.each(function() {		
			
			// Some variables 
			$this = $(this);
			$settings = settings;
			var offset = $settings.offset;
			var busy = false; // Checks if the scroll action is happening 
			                  // so we don't run it multiple times
			
			// Custom messages based on settings
			if($settings.scroll == true) $initmessage = 'Scroll for more';
			else $initmessage = 'Click for more';
			
			// Append custom messages and extra UI
			$this.append('<div class="content"></div><div class="loading-bar">'+$initmessage+'</div>');
			
			function getData() {
				
				// Post data to ajax.php
				var cat_id = $('#cat_id').attr('value');
				//$.post('http://localhost:8888/projects/pucker-mob/httpdocs/assets/ajax/ajaxdesktop.php', {
				$.post('http://www.puckermob.com/assets/ajax/ajax.php', {
						
					action        : 'scrollpagination',
				    number        : $settings.nop,
				    offset        : offset,
				    pageid		  : cat_id,
				    page		  : page
					    
				}, function(data) {
						
					// Change loading bar content (it may have been altered)
					$this.find('.loading-bar').html($initmessage);
						
					// If there is no data returned, there are no more posts to be shown. Show error
					if(data == "") { 
						$this.find('.loading-bar').html($settings.error);	
					}
					else {
						
						// Offset increases
					    offset = offset+$settings.nop; 
						    
						// Append the data to the content div
					   	
					   	var content = $this.find('.content');
					
				  	   	$(content).append(data);

						// No longer busy!	
						busy = false;

						$.each($('.article-id'),  function( i ){
					 	 	getTotalShares( $(this).attr('data-info-url'), $(this) );
					 	});
					}	
						
				});
					
			}

			getData(); // Run function initially
			
			
			// If scrolling is enabled
			if($settings.scroll == true) {
				// .. and the user is scrolling
				$(window).scroll(function() {
					
					// Check the user is at the bottom of the element
					if($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
						
						// Now we are working, so busy is true
						busy = true;
						
						// Tell the user we're loading posts
						$this.find('.loading-bar').html('<img src="http://www.puckermob.com/assets/img/ajax-loader.gif" />');
						
						// Run the function to fetch the data inside a delay
						// This is useful if you have content in a footer you
						// want the user to see.
						setTimeout(function() {
							
							getData();
							
						}, $settings.delay);
							
					}	
				});
			}
			
			// Also content can be loaded by clicking the loading bar/
			$this.find('.loading-bar').click(function() {
			
				if(busy == false) {
					busy = true;
					getData();
				}
			
			});
			
		});
	}

})(jQuery);
