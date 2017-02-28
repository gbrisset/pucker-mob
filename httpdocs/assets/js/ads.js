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
//MOBILE
var article_id = parseInt($('#article-id').val()); //switch is using exact comparisons

if($('body').hasClass('mobile')) {

		

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
			}// end if

			if( tag == 'p'){
				first_p = first_p;
				second_p = second_p;
				third_p = third_p;
			}//end if


			 switch (article_id) {
			 	case 16562:
			 	case 17425:
			 	case 14479:
			 	case 14576:
			 	case 15109:
			 	case 15271:
			 	case 17286:
			 	case 8560 :
			 	case 14613:
			 	case 15104:
			 	case 15284:
			 	case 15488:
			 	case 14873:
				// Lelo sponsored content
					inBodyAd.loadInArticleAd( 'article-body', 3, 0, '<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>', tag);		
					inBodyAd.loadInArticleAd( 'article-body', 7, 0, '<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>', tag);		
					break;
					
			 	case 8158: // relationships/8-things-guys-do-that-make-our-hearts-melt
					//Genesis TEST PAGE
					inBodyAd.loadInArticleAd('article-body', 10, 0, "<script type=\"text/javascript\" id=\"gm-script-tag\" src=\"//adg.bzgint.com/pub/adg/config.js?site_id=146313&publisher_name=SequelMedia_adaptive&css_path=%23adg_main&intercept_id=8001&page_id=769404&ad_url=http%3A%2F%2Fad.crwdcntrl.net%2F5%2Fc%3D1890%2Fpe%3Dy%3Fhttp%3A%2F%2Fadserver.genesismediaus.com%2Fac%3Fsiteid%3D146313%26pgid%3D769404%26fmtid%3D31360%26ab%3D1%26oc%3D1%26out%3Dvast%26ps%3D1%26pb%3D0%26visit%3DS%26vcn%3Dc%26tmstp%3D%5Btimestamp%5D%26tgt%3Dabbr%253D%2524%257Baud_ids%253A%253Babbr%253D%257D%253Bst%253D__KVST__%253Biid%253D__KVIID__%253Bvol%253D__KVVO__&skip_time=10&enableNASA=true&allowed_intercepts=3,8&view_url=%%VIEW_URL_ESC%%\"></script>", tag);
					break;

				case 27296: // moblog/what-time-doesnt-heal-you-have-to-heal-yourself
			 	case 23319: // moblog/15-open-letters-to-leave-your-boyfriend
			 	case 25829: // moblog/what-do-you-do-when-you-feel-like-youre-parents-are-happy-for-everyone-else-but-you
					//do nothing - we do not want other ads to interfer with the test page
					break;

			 	default:
					inBodyAd.loadInArticleAd('article-body', 5, 0, '<div id="nativo-id"></div>', tag);
					inBodyAd.loadInArticleAd('article-body', 10, 0, "<script type=\"text/javascript\">window['_rocketyield'] = [];!function (e, f, u) {var c = document.getElementById('article-body');var d = c.getElementsByTagName('P');if (d.length >10) {var my_div = document.createElement('DIV');    my_div.id = 'temp_div';c.insertBefore(my_div, d[10]); }e.async = 1;e.src = u;f.parentNode.insertBefore(e, f);}(document.createElement('script'), document.getElementsByTagName('script')[0], '//d1gqcw1vqdwn9k.cloudfront.net/ry.min.js');window['_rocketyield'].push({pid: 'puckermob',placementId: '44ee',slot: '#temp_div',width: 320,height: 240});</script>", tag);			

			 }//end switch ($article_id)

		}// end if( adPage === 'article' )



		$('#adunit-300x250-3159').attr('style', 'background:#ddd; height: 250px; width: 300px;');
		//$('.inarticle-ad').prepend("<p style='margin-left: 0.5rem !important;color: #bbb;font-size: 0.9rem !important;font-style: italic; margin-bottom:7px !important;'>Advertisement</p>");
		//$('.inarticle-ad').prepend("<img style='margin-bottom: 3px; width: 100%;' src='http://www.puckermob.com/assets/img/ad-bar.jpg' alt='adsvertiser' />");
        
//DESKTOP
} else{
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

			}// end if

			 switch (article_id) {
			 	case 16562:
			 	case 17425:
			 	case 14479:
			 	case 14576:
			 	case 15109:
			 	case 15271:
			 	case 17286:
			 	case 8560 :
			 	case 14613:
			 	case 15104:
			 	case 15284:
			 	case 15488:
			 	case 14873:
				// Lelo sponsored content
					inBodyAd.loadInArticleAd('article-body', 4, 0, '<div id="nativo-id"></div>' , tag);
					$('#inarticle3-ad').removeClass('columns');
					break;

			 	default:
					//do nothing - we do not want other ads to interfer with the test page

			 }//end switch ($article_id)

		}//end if( adPage === 'article')

}// end if($('body').hasClass('mobile'))

