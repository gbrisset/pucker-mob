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
var article_id = 1*parseInt($('#article-id').val()); //switch is using exact comparisons



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

//alert ('before switch = ' + article_id*2);
// article_id = article_id*1;
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
					inBodyAd.loadInArticleAd('article-body', 8, 0, "<div id=\"adg_main\"></div><script type=\"text/javascript\" id=\"gm-script-tag\" src=\"//adg.bzgint.com/pub/adg/config.js?site_id=146313&publisher_name=SequelMedia_adaptive&css_path=%23adg_main&intercept_id=8001&page_id=769404&ad_url=http%3A%2F%2Fad.crwdcntrl.net%2F5%2Fc%3D1890%2Fpe%3Dy%3Fhttp%3A%2F%2Fadserver.genesismediaus.com%2Fac%3Fsiteid%3D146313%26pgid%3D769404%26fmtid%3D31360%26ab%3D1%26oc%3D1%26out%3Dvast%26ps%3D1%26pb%3D0%26visit%3DS%26vcn%3Dc%26tmstp%3D%5Btimestamp%5D%26tgt%3Dabbr%253D%2524%257Baud_ids%253A%253Babbr%253D%257D%253Bst%253D__KVST__%253Biid%253D__KVIID__%253Bvol%253D__KVVO__&skip_time=10&enableNASA=true&mobile_dock_return=true&allowed_intercepts=3,8&view_url=%%VIEW_URL_ESC%%\"></script>", tag);
					break;


					

				case 23305: // relationships/25-little-white-lies-of-every-long-distance-relationship
				case 27296: // moblog/what-time-doesnt-heal-you-have-to-heal-yourself
			 	case 23319: // moblog/15-open-letters-to-leave-your-boyfriend
			 	case 25829: // moblog/what-do-you-do-when-you-feel-like-youre-parents-are-happy-for-everyone-else-but-you
			 	case 4019: // TEST PAGE DEDICATED TO BETHANY FOR DFP TESTING /relationships/how-to-date-when-you-are-broke
					//do nothing - we do not want other ads to interfer with the test page
					break;

			 	default:
					//PuckerStore
					// inBodyAd.loadInArticleAd('article-body', 2, 0, "<!-- BRAVONATE --> <div id=\"mobile-instream-branovate-ad\" style=\"text-align: center; clear: both; padding-top: 1rem;\"> <script type=\"text/javascript\"> (function() {var lkqdSettings = {pid: 16, sid: 346089, playerContainerId: 'ad' + Math.round(Math.random()*1000000000).toString(), playerId: '', playerWidth: 300, playerHeight: 250, execution: 'inbanner', placement: '', playInitiation: 'auto', volume: 0, pageUrl: '', trackImp: '', trackClick: '', custom1: '', custom2: '', custom3: '', pubMacros: '', dfp: false, lkqdId: new Date().getTime().toString() + Math.round(Math.random()*1000000000).toString(), supplyContentVideo: {url: '', clickurl: '', play: 'pre'} }; var lkqdVPAID; var creativeData = ''; if (!document.getElementById(lkqdSettings.playerContainerId)) { try { if (document.readyState && document.readyState != 'complete' && document.readyState != 'interactive'){ document.write('<div id=' + lkqdSettings.playerContainerId + '></div>'); }} catch (e) {}} var environmentVars = { slot: document.getElementById(lkqdSettings.playerContainerId), videoSlot: document.getElementById(lkqdSettings.playerId), videoSlotCanAutoPlay: true, lkqdSettings: lkqdSettings }; function onVPAIDLoad() {lkqdVPAID.subscribe(function() { lkqdVPAID.startAd(); }, 'AdLoaded'); } var vpaidFrame = document.createElement('iframe'); vpaidFrame.id = lkqdSettings.lkqdId; vpaidFrame.name = lkqdSettings.lkqdId; vpaidFrame.style.display = 'none'; var vpaidFrameLoaded = function() {vpaidLoader = vpaidFrame.contentWindow.document.createElement('script'); vpaidLoader.src = 'https://ad.lkqd.net/vpaid/formats.js?pid=16&sid=346089'; vpaidLoader.onload = function() {lkqdVPAID = vpaidFrame.contentWindow.getVPAIDAd(); onVPAIDLoad(); lkqdVPAID.handshakeVersion('2.0'); lkqdVPAID.initAd(lkqdSettings.playerWidth, lkqdSettings.playerHeight, 'normal', 600, creativeData, environmentVars); }; vpaidFrame.contentWindow.document.body.appendChild(vpaidLoader); }; vpaidFrame.onload = vpaidFrameLoaded; vpaidFrame.onerror = vpaidFrameLoaded; document.documentElement.appendChild(vpaidFrame); })(); </script> </div>", tag);
					//PuckerStore
					// inBodyAd.loadInArticleAd('article-body', 2, 0, '<a href="https://puckershop.com/collections/sale"><img src="http://www.puckermob.com/assets/img/PuckerStore_300x150.jpg" alt="Pucker Shop"></a>', tag);
					//Nativo 1
					inBodyAd.loadInArticleAd('article-body', 4, 0, '<div id="nativo-id"></div>', tag);
					//Answers
					inBodyAd.loadInArticleAd('article-body', 8, 0, "<script type=\"text/javascript\">window['_rocketyield'] = [];!function (e, f, u) {e.async = 1;e.src = u;f.parentNode.insertBefore(e, f);}(document.createElement('script'), document.getElementsByTagName('script')[0], '//d1gqcw1vqdwn9k.cloudfront.net/ry.min.js'); window['_rocketyield'].push({pid: 'puckermob',placementId: '44ee', slot: '#inarticle8-ad', width: 320,height: 240});</script>", tag);			
					//UnderTone SeeThrough
					inBodyAd.loadInArticleAd('article-body', 12, 0, '<script> googletag.cmd.push(function() {googletag.defineSlot("/73970039/UT_ST", [1, 1], "div-gpt-ad-1493987901721-0").addService(googletag.pubads()); googletag.pubads().enableSingleRequest(); googletag.enableServices(); }); </script> <!-- /73970039/UT_ST --> <div id="div-gpt-ad-1493987901721-0" style="height:1px; width:1px;"> <script> googletag.cmd.push(function() { googletag.display("div-gpt-ad-1493987901721-0"); }); </script> </div>', tag);



					// inBodyAd.loadInArticleAd('article-body', 10, 0, '<script type="text/javascript" src="http://us.ads.justpremium.com/adserve/js.php?zone=31674"></script>', tag);
					//temporary double ad - Answers fills at 7% only as of 2017-03-31 - GB
					// inBodyAd.loadInArticleAd('article-body', 10, 0, '<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script> <script type="text/javascript" language="javascript"> //<![CDATA[aax_getad_mpb({"slot_uuid":"9a325e3c-d956-4bd6-93a4-1faf53d4d8a5"}); //]]> </script>', tag);
					// Google
					// inBodyAd.loadInArticleAd('article-body', 10, 0, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> <!-- MOB Mobile After 10th paragraph --> <ins class="adsbygoogle"style="display:inline-block;width:300px;height:250px"data-ad-client="ca-pub-8978874786792646"data-ad-slot="6579881382"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script> ', tag);
					// Kixer
					inBodyAd.loadInArticleAd('article-body', 16, 0, '<!-- Start Pucker Mob - 300x250 - mobile web --> <div id="__kx_ad_8446"></div> <script type="text/javascript" language="javascript"> var __kx_ad_slots = __kx_ad_slots || []; (function () {var slot = 8446; var h = false; __kx_ad_slots.push(slot); if (typeof __kx_ad_start == "function") {__kx_ad_start(); } else {var s = document.createElement("script"); s.type = "text/javascript"; s.async = true; s.src = "//cdn.kixer.com/ad/load.js"; s.onload = s.onreadystatechange = function(){if (!h && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {h = true; s.onload = s.onreadystatechange = null; __kx_ad_start(); } }; var x = document.getElementsByTagName("script")[0]; x.parentNode.insertBefore(s, x); } })(); </script> <!-- End Pucker Mob - 300x250 - mobile web -->', tag);

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
					inBodyAd.loadInArticleAd( 'article-body', 3, 0, '<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>', tag);		
					inBodyAd.loadInArticleAd( 'article-body', 7, 0, '<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>', tag);		
					break;

			 	default:
					inBodyAd.loadInArticleAd('article-body', 3, 0, '<div id="nativo-id"></div>' , tag);
					$('#inarticle3-ad').removeClass('columns');

			 }//end switch ($article_id)

		}//end if( adPage === 'article')

}// end if($('body').hasClass('mobile'))

