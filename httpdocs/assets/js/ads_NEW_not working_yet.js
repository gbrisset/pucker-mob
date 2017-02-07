var smarties = false;
var page = document.body.id;
var browser_width = $(window).width();
var article_id = Foundation.utils.S('#article_id').val();
var hasSponsored = $("#has-sponsored-by").val();
var country =ManageCookies.getCookie('country_code');
var second_image_url = $('#second-mob-img');
var is_IOS = $('#IOS').val();
var sponsored_aricle = false; 

if( article_id == 14785 ) sponsored_aricle = true;
if(page != 'articleslide' && page != 'home' && page != 'category' && page != 'article' && page != 'distroscale') {var adPage = 'category';} else {var adPage = page;}

//PUCKERMOB

if($('body').hasClass('mobile')) {
//MOBILE -------------------------------------------------------------------------------------------------------------------------------------------------------------------

		var article_id = $('#article-id').val();

		//SINGLE PAGE ARTICLE
		if( adPage === 'article' ){
			var li_parent = $('#article-body').find('ol');
			var p_length = $('#article-body').children('p:not(.read-more)').length;
			var li_length = $(li_parent).find('li').length;
			var isListArticle = false;
			var tag = 'p', num_items = p_length, first_p = 2, second_p = 5, third_p = 8, fourth_p = 12, fith_p = 20;

			if($(li_parent) && $(li_parent).length == 0 ) li_parent = $('#article-body').find('ul');
			
			if(li_length > p_length){
				isListArticle = true;
				tag = 'li';
				num_items = li_length;
			}// end if(li_length > p_length)

			if( tag == 'p'){
				first_p = first_p;
				second_p = second_p;
				third_p = third_p;
			}//end if( tag == 'p')

				//LELO
				if( article_id == 16562 ||  
					article_id == 17425 || 
					article_id == 14479 || 
					article_id == 14576 ||  
					article_id == 15109 || 
					article_id == 15271 ||  
					article_id == 17286){
					inBodyAd.loadInArticleAd( 'article-body', 3, 0, '<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>', tag);		
					inBodyAd.loadInArticleAd( 'article-body', 7, 0, '<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>', tag);		
				}else{ 
				// NOT LELO

					// Sample insertion calls----
					//inBodyAd.loadInArticleAd('article-body', 10, 0, "", tag);			
					//inBodyAd.loadInArticleAd('article-body', 10, 0, "", tag);			
					//inBodyAd.loadInArticleAd('article-body', 10, 0, "", tag);			

					 
					// -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					// Scripts for Test Pages --- Scripts for Test Pages --- Scripts for Test Pages --- Scripts for Test Pages --- Scripts for Test Pages --- Scripts for Test Pages --- 
					if( isset( article_id) &&  
						(  
						article_id == 23319 || 
						article_id == 23305 || 
						article_id == 25829 || 
						article_id == 27296 ) 
						){
				
						 if(article_id == 23319 ){ // http://www.puckermob.com/moblog/15-open-letters-to-leave-your-boyfriend 	
							// inverting ad order -  Answers @ P5 and Nativo @ P10
							// Outstream Mediation aka Answers
							inBodyAd.loadInArticleAd('article-body', 5, 0, "<script type=\"text/javascript\">window['_rocketyield'] = [];!function (e, f, u) {var c = document.getElementById('article-body');var d = c.getElementsByTagName('P');if (d.length >10) {var my_div = document.createElement('DIV');    my_div.id = 'temp_div';c.insertBefore(my_div, d[10]); }e.async = 1;e.src = u;f.parentNode.insertBefore(e, f);}(document.createElement('script'), document.getElementsByTagName('script')[0], '//player.videomosh.com/ry/ry.min.js');window['_rocketyield'].push({pid: 'puckermob',placementId: '44ee',slot: '#temp_div',width: 320,height: 240});</script>", tag);			
							// Nativo
							inBodyAd.loadInArticleAd('article-body', 10, 0, '<div id="nativo-id"></div>', tag);

			 			 } //end if(article_id == 23319 )


						 if(article_id == 23305 ){ // http://www.puckermob.com/relationships/25-little-white-lies-of-every-long-distance-relationship 	
							// place script here 
			 			 } // end if(article_id == 23305 )


						 if(article_id == 25829 ){ // http://www.puckermob.com/moblog/what-do-you-do-when-you-feel-like-youre-parents-are-happy-for-everyone-else-but-you 	
							// place script here 
						 } // end if(article_id == 25829 ) 


						 if(article_id == 27296 ){ // http://www.puckermob.com/moblog/what-time-doesnt-heal-you-have-to-heal-yourself 	
							// place script here 
			 			 } //end  if(article_id == 27296 ) 

					 
					// ABOVE test pages - specific scripts ------------------------------------------------------------------------------------------------------
					}	else {
					// BELOW - current scripts - general audience ------------------------------------------------------------------------------------------------------
						
							// Nativo
							inBodyAd.loadInArticleAd('article-body', 5, 0, '<div id="nativo-id"></div>', tag);
							// Outstream Mediation aka Answers
							inBodyAd.loadInArticleAd('article-body', 10, 0, "<script type=\"text/javascript\">window['_rocketyield'] = [];!function (e, f, u) {var c = document.getElementById('article-body');var d = c.getElementsByTagName('P');if (d.length >10) {var my_div = document.createElement('DIV');    my_div.id = 'temp_div';c.insertBefore(my_div, d[10]); }e.async = 1;e.src = u;f.parentNode.insertBefore(e, f);}(document.createElement('script'), document.getElementsByTagName('script')[0], '//player.videomosh.com/ry/ry.min.js');window['_rocketyield'].push({pid: 'puckermob',placementId: '44ee',slot: '#temp_div',width: 320,height: 240});</script>", tag);			

					} // end if( isset( article_id) &&  ... TEST PAGES
					// -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
						
				}// end 	if( article_id == 16562 || ... LELO/NOT LELO 



		$('#adunit-300x250-3159').attr('style', 'background:#ddd; height: 250px; width: 300px;');
		//$('.inarticle-ad').prepend("<p style='margin-left: 0.5rem !important;color: #bbb;font-size: 0.9rem !important;font-style: italic; margin-bottom:7px !important;'>Advertisement</p>");
		//$('.inarticle-ad').prepend("<img style='margin-bottom: 3px; width: 100%;' src='http://www.puckermob.com/assets/img/ad-bar.jpg' alt='adsvertiser' />");

	}// end if( adPage === 'article')

} else{

//DESKTOP -------------------------------------------------------------------------------------------------------------------------------------------------------------------

		//SINGLE PAGE ARTICLE
		if( adPage === 'article'){
			var li_parent = $('#article-body').find('ol');
			var p_length = $('#article-body').children('p').length;
			var li_length = $(li_parent).find('li').length;
			var isListArticle = false;
			var tag = 'p', num_items = p_length, first_p = 2, second_p = 5, third_p = 9, fourth_p = 15, fith_p = 22;

			if($(li_parent) && $(li_parent).length == 0 ) li_parent = $('#article-body').find('ul');
			
			if(li_length > p_length){
				isListArticle = true;
				tag = 'li';
				num_items = li_length;
			}// end if(li_length > p_length)

				//LELO
				if( article_id == 16562 ||  
					article_id == 17425 || 
					article_id == 14479 || 
					article_id == 14576 || 
					article_id == 14472 || 
					article_id == 15104 ||  
					article_id == 15109 || 
					article_id == 15271 || 
					article_id == 17286){

					// Do nothing 

					}else{
						if( second_p > 0 ){
						
						if(article_id != 15284 && article_id != 15488 && article_id != 14597 && article_id != 23564){

							inBodyAd.loadInArticleAd('article-body', 4, 0, '<div id="nativo-id"></div>' , tag);
							$('#inarticle3-ad').removeClass('columns');

						}// end if(article_id != 15284 ...

					}// end if( second_p > 0 )

				}// end if( article_id == 16562 || ...

		}// end if( adPage === 'article')

} // end if($('body').hasClass('mobile'))

