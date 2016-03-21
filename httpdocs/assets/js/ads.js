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
	
			//if( first_p > 0 ){ //ANSWERS
				inBodyAd.loadInArticleAd( 'article-body', 4, 0, "<div id=\"vm_inline\"></div><script type='text/javascript'> window._videomosh = window._videomosh || []; !function (e, f, u) { e.async = 1; e.src = u; f.parentNode.insertBefore(e, f); }(document.createElement('script'), document.getElementsByTagName('script')[0], 'http://player.videomosh.com/players/loader/loader_final4.js'); _videomosh.push({  publisher_key: \"sequelmedia\",  mode: \"incontent\",  container: \"vm_inline\", incontent_mobile_id: \"9834\", target_type: \"mix\", backfill: \"<div id='gpt-backfill'></div><script type='text/javascript'> var googletag = googletag || {}; googletag.cmd = googletag.cmd || []; (function() { var gads = document.createElement('script'); gads.async = true; gads.type = 'text/javascript'; var useSSL = 'https:' == document.location.protocol; gads.src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js'; var node = document.getElementsByTagName('script')[0]; node.parentNode.insertBefore(gads, node); })();  googletag.cmd.push(function() {googletag.defineSlot('/27755252/sequel_media/puckermob.com', [300, 250], 'gpt-backfill').addService(googletag.pubads());googletag.pubads().enableSingleRequest();googletag.enableServices();});googletag.cmd.push(function() { googletag.display('gpt-backfill'); });</scr\"+\"ipt>\" });</script>", tag);		
				//inBodyAd.loadInArticleAd( 'article-body', first_p, 0, '<div data-str-native-key="536c62e7" style="display: none;"></div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>', tag);	
			//}

			//if( second_p > 0 ){ //KIOSKED
				inBodyAd.loadInArticleAd( 'article-body', 8, 0, '<script type="text/javascript" async="async" src="//scripts.kiosked.com/loader/kiosked-loader.js?pub=11623&site=12230"></script>', tag);
			//}
			
			//if( third_p > 0 ){ //3Lift
			//	inBodyAd.loadInArticleAd( 'article-body', 12, 0, '<script src="//ib.3lift.com/ttj?inv_code=puckermob_article_sub"></script>', tag);	

			//}

			
			//if( fourth_p > 0 ){ 

				inBodyAd.loadInArticleAd( 'article-body', 12, 0, '<div id=\'__kx_ad_4251\'></div><script type="text/javascript" language="javascript" id="__kx_tag_4251">var __kx_ad_slots = __kx_ad_slots || []; (function () { var slot = 4251; var h = false; var doc = document; __kx_ad_slots.push(slot); if (typeof __kx_ad_start == \'function\') { __kx_ad_start(); } else { if (top == self) { var s = doc.createElement(\'script\'); s.type = \'text/javascript\'; s.async = true; s.src = \'//cdn.kixer.com/ad/load.js\'; s.onload = s.onreadystatechange = function(){ if (!h && (!this.readyState || this.readyState == \'loaded\' || this.readyState == \'complete\')) { h = true; s.onload = s.onreadystatechange = null; __kx_ad_start(); } }; var x = doc.getElementsByTagName(\'script\')[0]; x.parentNode.insertBefore(s, x); } else { var tag = doc.getElementById(\'__kx_tag_\'+slot); var win = window.parent; doc = win.document; var top_div = doc.createElement("div"); top_div.id = \'__kx_ad_\'+slot; doc.body.appendChild(top_div); var top_tag = doc.createElement("script"); top_tag.id = \'__kx_top_tag_\'+slot; top_tag.innerHTML = tag.innerHTML; doc.body.appendChild(top_tag); }}})();</script>', tag);
				//inBodyAd.loadInArticleAd( 'article-body', fourth_p, 0, '<div class="dailymotion-widget" data-placement="56d75ebdb71169002859de44"></div><script>(function(w,d,s,u,n,e,c){w.PXLObject = n; w[n] = w[n] || function(){(w[n].q = w[n].q || []).push(arguments);};w[n].l = 1 * new Date();e = d.createElement(s); e.async = 1; e.src = u;c = d.getElementsByTagName(s)[0]; c.parentNode.insertBefore(e,c);})(window, document, "script", "//api.dmcdn.net/pxl/client.js", "pxl");</script>', tag);
			//}	

			//inBodyAd.loadInArticleAd( 'article-body', fith_p, 0, "<div id='div-gpt-ad-1458332569430-0' style='height:250px; width:300px;'><script type='text/javascript'>googletag.cmd.push(function() { googletag.display('div-gpt-ad-1458332569430-0'); });</script></div>", tag);

			

			//if( article_id == 12930 ){	
				
				//inBodyAd.loadInArticleAd( 'article-body', fith_p, 0, '<div data-str-native-key="536c62e7" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>', tag);	
			//}
		}
		$('.inarticle-ad').attr('style', 'display:inline');
		//$('.inarticle-ad').prepend("<p style='margin-left: 0.5rem !important;color: #bbb;font-size: 0.9rem !important;font-style: italic; margin-bottom:7px !important;'>Advertisement</p>");
        
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
			
			if( second_p > 0 ){//BRANOVATE
				inBodyAd.loadInArticleAd( 'article-body', second_p, 0, '<IFRAME SRC="http://ib.adnxs.com/tt?id=6447475&cb=[CACHEBUSTER]" FRAMEBORDER="0" SCROLLING="no" MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" LEFTMARGIN="0" ALLOWTRANSPARENCY="true" WIDTH="970" HEIGHT="250"></IFRAME>', tag);
			}

//			if( second_p > 0 ){//CARAMBOLA
				//inBodyAd.loadInArticleAd( 'article-body', 8, 0, '<script class="carambola_InContent" type="text/javascript">(function (i,d,s,o,m,r,t,g) {var e=d.getElementById(r);if(e===null){ var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n);} else { i[t](2) } })(window, document, \'InContent\', \'script\', \'mediaType\', \'carambola_proxy\',\'Cbola_initializeProxy\',\'http://\'+\'route.carambo.la/inimage/getlayer?pid=spdsh12\')<\/script>', tag);

			//}
		}
	}

}

