var smarties = false;
var page = document.body.id;
var browser_width = $(window).width();
var article_id = Foundation.utils.S('#article_id').val();
var hasSponsored = $("#has-sponsored-by").val();
var country =ManageCookies.getCookie('country_code');
var second_image_url = $('#second-mob-img');

var sponsored_aricle = false; 

if( article_id == 14785 ) sponsored_aricle = true;
//console.log(country);


if(page != 'articleslide' && page != 'home' && page != 'category' && page != 'article' && page != 'distroscale') {var adPage = 'category';} else {var adPage = page;}

var ad = {
	home: { }, category: { },
	articleslide: {
		inarticlesharet: '<div data-str-native-key="58ad4c02" style="display: none;"></div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>',
		inarticlecarambola: '<script class="carambola_InContent" type="text/javascript">(function (i,d,s,o,m,r,t,g) {var e=d.getElementById(r);if(e===null){ var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n);} else { i[t](2) } })(window, document, \'InContent\', \'script\', \'mediaType\', \'carambola_proxy\',\'Cbola_initializeProxy\',\'http://\'+\'route.carambo.la/inimage/getlayer?pid=spdsh12\')<\/script>',
		inarticlesharetothercountry: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> <ins class="adsbygoogle" style="display:inline-block;width:637px;height:90px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="3403405783"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>' ,
		inarticlecarambolaothercountry: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:637px;height:90px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="1926672583"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>',
	},
	article: {
		inarticlesharet: '<div data-str-native-key="58ad4c02" style="display: none;"></div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>',
		inarticlecarambola: '<script class="carambola_InContent" type="text/javascript">(function (i,d,s,o,m,r,t,g) {var e=d.getElementById(r);if(e===null){ var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n);} else { i[t](2) } })(window, document, \'InContent\', \'script\', \'mediaType\', \'carambola_proxy\',\'Cbola_initializeProxy\',\'http://\'+\'route.carambo.la/inimage/getlayer?pid=spdsh12\')<\/script>',
	    inarticlesharetothercountry: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> <ins class="adsbygoogle" style="display:inline-block;width:637px;height:90px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="3403405783"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>' ,
		inarticlecarambolaothercountry: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:637px;height:90px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="1926672583"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>',
	}

};
var mobilead = {
	home: { }, category: {	},
	articleslide: {
				viacom:'<div style="background-color:#000000;"><div style="padding:4px;"><iframe src="http://media.mtvnservices.com/embed/mgid:arc:video:comedycentral.com:96180201-3c00-436a-b2d9-274413842c98" width="300" height="288" frameborder="0"></iframe><p style="text-align:left;background-color:#FFFFFF;padding:4px;margin-top:4px;margin-bottom:0px;font-family:Arial, Helvetica, sans-serif;font-size:12px;">Get More: <a href="http://www.cc.com">Comedy Central</a>,<a href="http://www.cc.com/funny-videos">Funny Videos</a>,<a href="http://www.cc.com/shows">Funny TV Shows</a></p></div></div>',

		inarticle: '<div data-str-native-key="536c62e7" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>',
		inarticleadblade: '<ins class="adbladeads" data-cid="7958-2737561138" data-host="web.adblade.com" data-tag-type="2" style="display:none"><\/ins><script async src="http://web.adblade.com/js/ads/async/show.js" type="text/javascript"><\/script>',
		inarticlegoogle:'<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:150px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="6986976583"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>',
		inarticlemopub:'<script type="text/javascript">mopub_ad_unit = "97dd84c12ded49899e4c7636a63773ac"; mopub_ad_width = 300; mopub_ad_height = 250; mopub_keywords = "custom keywords";<\/script><script src="http://ads.mopub.com/js/client/mopub.js"><\/script>',
		inarticlenativo: '<div class="nativo" id="nativo-ad"></div>',	
		inarticlebranovate: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="3900787786"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>',
		inarticlesharetothercountry: '<ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="8590484981"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>' ,
		inarticlegoogle2: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="1986084582"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>',
		inarticlegoogle4: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="2880293382"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>',
	},
	article: {
		viacom:'<div style="background-color:#000000;"><div style="padding:4px;"><iframe src="http://media.mtvnservices.com/embed/mgid:arc:video:comedycentral.com:96180201-3c00-436a-b2d9-274413842c98" width="300" height="288" frameborder="0"></iframe><p style="text-align:left;background-color:#FFFFFF;padding:4px;margin-top:4px;margin-bottom:0px;font-family:Arial, Helvetica, sans-serif;font-size:12px;">Get More: <a href="http://www.cc.com">Comedy Central</a>,<a href="http://www.cc.com/funny-videos">Funny Videos</a>,<a href="http://www.cc.com/shows">Funny TV Shows</a></p></div></div>',

		inarticle: '<div data-str-native-key="536c62e7" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>',
		inarticleadblade: '<ins class="adbladeads" data-cid="7958-2737561138" data-host="web.adblade.com" data-tag-type="2" style="display:none"><\/ins><script async src="http://web.adblade.com/js/ads/async/show.js" type="text/javascript"><\/script>',
		inarticlegoogle:'<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:150px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="6986976583"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>',
		inarticlegoogle3: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="6120722987"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>',	
		inarticlegoogle2: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="1986084582"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>',
		inarticlemopub:'<script type="text/javascript">mopub_ad_unit = "97dd84c12ded49899e4c7636a63773ac"; mopub_ad_width = 300; mopub_ad_height = 250; mopub_keywords = "custom keywords";<\/script><script src="http://ads.mopub.com/js/client/mopub.js"><\/script>',
		inarticlenativo: '<div class="nativo" id="nativo-ad"></div>',
		inarticlebranovate: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="3900787786"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>',
		inarticlesharetothercountry: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="8590484981"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>' ,
		inarticlegoogle4: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="2880293382"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>',


	}
};	
//PUCKERMOB
//MOBILE
if($('body').hasClass('mobile')) {

		var article_id = Foundation.utils.S('#article_id').val();

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
			}

			if( tag == 'p'){
				first_p = first_p;
				second_p = second_p;
				third_p = third_p;
			}
	
		
			//LELO
			if(article_id == 14479 || article_id == 14576 ||  article_id == 15109 || article_id == 15271){
				inBodyAd.loadInArticleAd( 'article-body', 4, 0, '<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/Remoji_300x250.gif" /></a>', tag);		
				inBodyAd.loadInArticleAd( 'article-body', 8, 0, '<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/Remoji_300x250.gif" /></a>', tag);		
			}else{ 
			if(article_id != 15284 &&  article_id != 15488 ){
				
				inBodyAd.loadInArticleAd( 'article-body', 4, 0, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="6383502588"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>', tag);

				//ADNEMOS http://www.puckermob.com/relationships/to-the-friend-i-thought-would-be-there-on-my-wedding-day
				if(article_id == 10534){ 
					inBodyAd.loadInArticleAd( 'article-body', 8, 0, "<script type='text/javascript' src='//rtb.adnemo.com/sys/adnemo.js?pzoneid=4269&dmid=444&height=250&width=300&tld=puckermob.com_mobile&cb=1889485789'></script>", tag);
				}else if(article_id == 14820){
					inBodyAd.loadInArticleAd( 'article-body', 8, 0, '<script type="text/javascript">function myAdDoneFunction(spotx_ad_found)  { if(spotx_ad_found)  {}else {}}</script><script type="text/javascript" src="//search.spotxchange.com/js/spotx.js" data-spotx_channel_id="148392" data-spotx_ad_unit="incontent" data-spotx_ad_done_function="myAdDoneFunction" data-spotx_content_width="300" data-spotx_content_height="250" data-spotx_loop="1" data-spotx_ad_volume="0" data-spotx_autoplay="1" data-spotx_ad_format="html5" data-spotx_https="0"></script>', tag);
				}else{
					//ANSWERS
					//inBodyAd.loadInArticleAd( 'article-body', 8, 0, "<div id=\"vm_inline\"></div><script type='text/javascript'> window._videomosh = window._videomosh || []; !function (e, f, u) { e.async = 1; e.src = u; f.parentNode.insertBefore(e, f); }(document.createElement('script'), document.getElementsByTagName('script')[0], 'http://player.videomosh.com/players/loader/loader_final4.js'); _videomosh.push({  publisher_key: \"sequelmedia\",  mode: \"incontent\",  container: \"vm_inline\", incontent_mobile_id: \"9834\", target_type: \"mix\", backfill: \"<div id='gpt-backfill'></div><script type='text/javascript'> var googletag = googletag || {}; googletag.cmd = googletag.cmd || []; (function() { var gads = document.createElement('script'); gads.async = true; gads.type = 'text/javascript'; var useSSL = 'https:' == document.location.protocol; gads.src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js'; var node = document.getElementsByTagName('script')[0]; node.parentNode.insertBefore(gads, node); })();  googletag.cmd.push(function() {googletag.defineSlot('/27755252/sequel_media/puckermob.com', [300, 250], 'gpt-backfill').addService(googletag.pubads());googletag.pubads().enableSingleRequest();googletag.enableServices();});googletag.cmd.push(function() { googletag.display('gpt-backfill'); });</scr\"+\"ipt>\" });</script>", tag);		
					//inBodyAd.loadInArticleAd( 'article-body', 8, 0, "<div id=\"vm_inline\"></div><script type='text/javascript'> window._videomosh = window._videomosh || []; !function (e, f, u) { e.async = 1; e.src = u; f.parentNode.insertBefore(e, f); }(document.createElement('script'), document.getElementsByTagName('script')[0], 'http://player.videomosh.com/players/loader/loader_final4.js'); _videomosh.push({  publisher_key: \"sequelmedia\",  mode: \"incontent\",  container: \"vm_inline\", incontent_mobile_id: \"9834\", incontent_desktop_id: \"42296\",  target_type: \"mix\", backfill:\"<script src='//ib.3lift.com/ttj?inv_code=puckermob_article_sub'></scr\"+\"ipt>\"}); </script>", tag);
				}

				inBodyAd.loadInArticleAd( 'article-body', 8, 0, '<div id=\'__kx_ad_4251\'></div><script type="text/javascript" language="javascript" id="__kx_tag_4251">var __kx_ad_slots = __kx_ad_slots || []; (function () { var slot = 4251; var h = false; var doc = document; __kx_ad_slots.push(slot); if (typeof __kx_ad_start == \'function\') { __kx_ad_start(); } else { if (top == self) { var s = doc.createElement(\'script\'); s.type = \'text/javascript\'; s.async = true; s.src = \'//cdn.kixer.com/ad/load.js\'; s.onload = s.onreadystatechange = function(){ if (!h && (!this.readyState || this.readyState == \'loaded\' || this.readyState == \'complete\')) { h = true; s.onload = s.onreadystatechange = null; __kx_ad_start(); } }; var x = doc.getElementsByTagName(\'script\')[0]; x.parentNode.insertBefore(s, x); } else { var tag = doc.getElementById(\'__kx_tag_\'+slot); var win = window.parent; doc = win.document; var top_div = doc.createElement("div"); top_div.id = \'__kx_ad_\'+slot; doc.body.appendChild(top_div); var top_tag = doc.createElement("script"); top_tag.id = \'__kx_top_tag_\'+slot; top_tag.innerHTML = tag.innerHTML; doc.body.appendChild(top_tag); }}})();</script>', tag);
			}
				
			}
			
		
	}
		//$('.inarticle-ad').attr('style', 'display:inline');
		//$('.inarticle-ad').prepend("<p style='margin-left: 0.5rem !important;color: #bbb;font-size: 0.9rem !important;font-style: italic; margin-bottom:7px !important;'>Advertisement</p>");
		//$('.inarticle-ad').prepend("<img style='margin-bottom: 3px; width: 100%;' src='http://www.puckermob.com/assets/img/ad-bar.jpg' alt='adsvertiser' />");
        
//DESKTOP
} else{
	var select = {
		ad: { header: document.getElementById("header-ad") }
	};
		
	if( !smarties ){
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

			}

			

				//LELO
				if(article_id == 14479 || article_id == 14576 || article_id == 14472 || article_id == 15104 ||  article_id == 15109 || article_id == 15271){}else{
					if( second_p > 0 ){
						
						if(article_id != 15284 && article_id != 15488){

							inBodyAd.loadInArticleAd( 'article-body', 3, 0, '<div><div id="mb_video_syncad" class="floating_banner no_video"></div></div>', tag);
							$('#inarticle3-ad').removeClass('columns');
							//inBodyAd.loadInArticleAd( 'article-body', 8, 0, '<script src="//ib.3lift.com/ttj?inv_code=puckermob_mid_article"></script>', tag);
						}
					}
				}
		}
	}

}

