var smarties = false;
var page = document.body.id;
var browser_width = $(window).width();
var article_id = Foundation.utils.S('#article_id').val();
var hasSponsored = $("#has-sponsored-by").val();
var country =ManageCookies.getCookie('country_code');
var second_image_url = $('#second-mob-img');

console.log(country);


if(page != 'articleslide' && page != 'home' && page != 'category' && page != 'article' && page != 'distroscale') {var adPage = 'category';} else {var adPage = page;}

var ad = {
	home: { }, category: { },
	articleslide: {
		inarticlesharet: '<div data-str-native-key="58ad4c02" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>',
		inarticlecarambola: '<script class="carambola_InContent" type="text/javascript">(function (i,d,s,o,m,r,t,g) {var e=d.getElementById(r);if(e===null){ var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n);} else { i[t](2) } })(window, document, \'InContent\', \'script\', \'mediaType\', \'carambola_proxy\',\'Cbola_initializeProxy\',\'http://\'+\'route.carambo.la/inimage/getlayer?pid=spdsh12\')<\/script>',
		inarticlesharetothercountry: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> <ins class="adsbygoogle" style="display:inline-block;width:637px;height:90px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="3403405783"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>' ,
		inarticlecarambolaothercountry: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:637px;height:90px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="1926672583"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>',
	},
	article: {
		inarticlesharet: '<div data-str-native-key="58ad4c02" style="display: none;"><\/div>',
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
			var tag = 'p', num_items = p_length, first_p = 3, second_p = 6, third_p = 9, fourth_p = 12, fith_p = 20;

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
	
			//1ST SPOT
			if( first_p > 0 ){ //SHARETH
				//if( country == 'US' || country == 'XX'){
					//inBodyAd.loadInArticleAd( 'article-body', first_p, 0, '<div data-str-native-key="536c62e7" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>', tag);	
				//}else{	
					//inBodyAd.loadInArticleAd( 'article-body', first_p, 0, '<ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="8590484981"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>', tag);	
				//}

				if( country && country == 'CA' ){
					inBodyAd.loadInArticleAd( 'article-body', first_p, 0, '<div id="ad-inline-2978"></div><script src="http://4cad707bbe7099c8f3c8-1d22a0d4135badeea192d868b304eb1e.r26.cf5.rackcdn.com/ad_units/2978/unit.js?ord=%%CACHEBUSTER%%" async="true"></script>', tag);
				}else{
					inBodyAd.loadInArticleAd( 'article-body', first_p, 0, '<div id="ad-kikvid-300x250-3043"></div><script src="http://4cad707bbe7099c8f3c8-1d22a0d4135badeea192d868b304eb1e.r26.cf5.rackcdn.com/ad_units/3043/unit.js?ord=%%CACHEBUSTER%%" async="true"></script>', tag);
				}
			}

			if( second_p > 0 ){ //2ND SPOT Answer Media
				inBodyAd.loadInArticleAd( 'article-body', second_p, 0, "<div id=\"vm_inline\"></div><script type='text/javascript'> window._videomosh = window._videomosh || []; !function (e, f, u) { e.async = 1; e.src = u; f.parentNode.insertBefore(e, f); }(document.createElement('script'), document.getElementsByTagName('script')[0], 'http://player.videomosh.com/players/loader/loader_final4.js'); _videomosh.push({  publisher_key: \"sequelmedia\",  mode: \"incontent\",  container: \"vm_inline\", incontent_mobile_id: \"9834\", target_type: \"mix\", backfill: \"<div id='gpt-backfill'></div><script type='text/javascript'> var googletag = googletag || {}; googletag.cmd = googletag.cmd || []; (function() { var gads = document.createElement('script'); gads.async = true; gads.type = 'text/javascript'; var useSSL = 'https:' == document.location.protocol; gads.src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js'; var node = document.getElementsByTagName('script')[0]; node.parentNode.insertBefore(gads, node); })();  googletag.cmd.push(function() {googletag.defineSlot('/27755252/sequel_media/puckermob.com', [300, 250], 'gpt-backfill').addService(googletag.pubads());googletag.pubads().enableSingleRequest();googletag.enableServices();});googletag.cmd.push(function() { googletag.display('gpt-backfill'); });</scr\"+\"ipt>\" });</script>", tag);	
			}
			
			if( third_p > 0 ){ //3RD SPOT Answer Media
				if( article_id == 8669 ){	
						inBodyAd.loadInArticleAd( 'article-body', third_p, 0, "<script id='helper' data-my_var_1='0-8UiOP8_cHL92Kr9xIW4mjUnB0jYtrFKF1PPqlf' data-my_var_2='//static.adsnative.com/static/js/render.v1.js' data-my_var_3='none' src='https://s3.amazonaws.com/sf.adsparc.com/native/native-inline-ad-2015-noiframe-article.js' async='true'></script>", tag);
				}else{
						inBodyAd.loadInArticleAd( 'article-body', third_p, 0, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="2880293382"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>', tag);	
				}
			}

			if( fourth_p > 0 ){ //4TH SPOT GOOGLE
				inBodyAd.loadInArticleAd( 'article-body', fourth_p, 0, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script> <ins class="adsbygoogle"  style="display:inline-block;width:320px;height:100px"  data-ad-client="ca-pub-8978874786792646" data-ad-slot="9369056981"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>', tag);
			}
		}

		$('.inarticle-ad').prepend("<p style='margin-left: 0.5rem !important;color: #bbb;font-size: 0.9rem !important;font-style: italic; margin-bottom:7px !important;'>Advertisement</p>");
        
//DESKTOP
} else{
	var select = {
		ad: { header: document.getElementById("header-ad") }
	};
		
	if( !smarties ){
		if(browser_width < 740) {
			loadAd(select.ad.header, mobilead[adPage].header);
		}

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

			$.ajax({
				type: "POST",
				url:  'http://www.puckermob.com/admin/assets/php/ajaxfunctions.php',
				data: { article_id: article_id, task:'article_ads' },
				success: function (data) {
					if(data != 'false'){
						var info = $.parseJSON(data);
						console.log(info[0]);
						first_p  = parseInt(info[0].desktop_1) ;
						second_p  = parseInt(info[0].desktop_2);	
					}
				},
				async:   false
			});

			if( tag == 'p'){ first_p = first_p + 1; second_p = second_p + 1; }
			
			//if( first_p > 0 ){
				//SHARET
				/*if( country && country == 'US'){
					inBodyAd.loadInArticleAd( 'article-body', first_p, 0, ad[adPage].inarticlesharet, tag);
				}else{
					inBodyAd.loadInArticleAd( 'article-body', first_p, 0, ad[adPage].inarticlesharetothercountry, tag);
				}*/
		//	}

			//if( p_length > 7 ||  li_length > 7){
				//if( article_id == 9499 ){ 
				//		inBodyAd.loadInArticleAd( 'article-body', 7, 0, '<div style="background-color:#000000;width:520px;"><div style="padding:4px;"><iframe src="http://media.mtvnservices.com/embed/mgid:arc:video:comedycentral.com:96180201-3c00-436a-b2d9-274413842c98" width="512" height="288" frameborder="0"></iframe><p style="text-align:left;background-color:#FFFFFF;padding:4px;margin-top:4px;margin-bottom:0px;font-family:Arial, Helvetica, sans-serif;font-size:12px;">Get More: <a href="http://www.cc.com">Comedy Central</a>,<a href="http://www.cc.com/funny-videos">Funny Videos</a>,<a href="http://www.cc.com/shows">Funny TV Shows</a></p></div></div>', tag);
				//}
			//}
			
			if( first_p > 0 ){
				//if( article_id != 9499 ){ 
					//CARAMBOLA
					inBodyAd.loadInArticleAd( 'article-body', 6, 0, ad['article'].inarticlecarambola, tag);
				//}
			}
		}
	}

}