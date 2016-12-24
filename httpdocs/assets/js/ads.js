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
if($('body').hasClass('mobile')) {

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
			}

			if( tag == 'p'){
				first_p = first_p;
				second_p = second_p;
				third_p = third_p;
			}

				//LELO
				if( article_id == 16562 ||  article_id == 17425 || article_id == 14479 || article_id == 14576 ||  article_id == 15109 || article_id == 15271 ||  article_id == 17286){
					inBodyAd.loadInArticleAd( 'article-body', 3, 0, '<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>', tag);		
					inBodyAd.loadInArticleAd( 'article-body', 7, 0, '<a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>', tag);		
				}else{ 

					inBodyAd.loadInArticleAd('article-body', 5, 0, '<div id="nativo-id"></div>', tag);
					//inBodyAd.loadInArticleAd('article-body', 12, 0, '<script type="text/javascript" src="//cdn.thoughtleadr.com/v4/page.js" placement-id="e34fc238e71e1dd6a98a47668a9881ba7867205f92bd422ed1fe67b650685273"></script>', tag);
					
					//ANSWERS
					inBodyAd.loadInArticleAd('article-body', 10, 0,  "<script type=\"text/javascript\">window['_rocketyield'] = [];!function (e, f, u) { var c = document.getElementById('article-body'); var d = c.getElementsByTagName('P'); if (d.length > 10) { var my_div = document.createElement(\"DIV\");  my_div.id = 'temp_div'; c.insertBefore(my_div, d[10]);} e.async = 1; e.src = u; f.parentNode.insertBefore(e, f); }(document.createElement('script'), document.getElementsByTagName('script')[0], '//player.videomosh.com/ry/ry.min.js'); window['_rocketyield'].push({ pid: 'puckermob', placementId: '44ee', slot: '#temp_div',width: 600, height: 400});</script>", tag);

					//inBodyAd.loadInArticleAd('article-body', 10, 0, "<script type='text/javascript'> window['_rocketyield'] = [];!function (e, f, u) { var c = document.getElementById('article-body'); var d = c.getElementsByTagName('P'); if (d.length > 7) { var my_div = document.createElement(\"DIV\"); my_div.id = 'temp_div'; c.insertBefore(my_div, d[7]); } e.async = 1;   e.src = u; f.parentNode.insertBefore(e, f); }(document.createElement('script'), document.getElementsByTagName('script')[0], '//player.videomosh.com/ry/ry.min.js'); window['_rocketyield'].push({ pid: 'puckermob', placementId: '44ee', slot: '#temp_div',width: 600, height: 400});</script>", tag);
					//Meme
      				//inBodyAd.loadInArticleAd('article-body', 11, 0, "<iframe id='m_iframe'  src=\"http://growfoodsmart.com/sas/player/mobileIframe.php?sPlt=Direct&sCmpID=10822&sSlr=178&creativeID=123&cb=12345&channelID=56e97118181f4655728b4618&sDmn=www.puckermob.com\" style=\"width:300px;height:250px;border:0;padding:0;margin:0;overflow:hidden;\" scrolling=\"no\" padding=\"0\" border=\"0\"></iframe>", tag);
					
					//CARAMBOLA
//					inBodyAd.loadInArticleAd('article-body', 10, 0,"<img height='0' width='0' alt='' src='//pixel.watch/936x' style='display:block;' /><script data-cfasync=\"false\" class=\"carambola_InContent\" type=\"text/javascript\" cbola_wid=\"2\">  (function (i,d,s,o,m,r,c,l,w,q,y,h,g) {  var e=d.getElementById(r);if(e===null){  var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n); var dt=new Date().getTime();  try{i[l][w+y](h,i[l][q+y](h)+'&'+dt);}catch(er){i[h]=dt;}  } else if(typeof i[c]!=='undefined'){i[c]++}  else{i[c]=1;}  })(window, document, 'InContent', 'script', 'mediaType', 'carambola_proxy','Cbola_IC','localStorage','set','get','Item','cbolaDt','//route.carambo.la/inimage/getlayer?pid=spdsh12&did=110233&wid=2')  </script>", tag);
					
					//if(article_id == 23319 ){
					//inBodyAd.loadInArticleAd('article-body', 12, 0, "<script type=\"text/javascript\"> window._ttf = window._ttf || []; _ttf.push({ pid: 59726, lang: \"en\", slot: '#article-content #article-body > p', format: \"inread\", minSlot: 4, components: { skip: {delay : 0}}, css : \"margin: 0px auto 0px; max-width: 550px;\" }); (function (d) { var js, s = d.getElementsByTagName('script')[0]; js = d.createElement('script'); js.async = true; js.src = '//cdn.teads.tv/media/format.js'; s.parentNode.insertBefore(js, s); })(window.document); </script>", tag);
					//inBodyAd.loadInArticleAd( "article-body", 10, 0, '<div id="external-unit-answers-test" ></div>', tag);
					//$('#external-unit-answers-test').load('http://www.puckermob.com/external-unit-answers-test.html');
					//inBodyAd.loadInArticleAd( "article-body", 10, 0, "<script type=\"text/javascript\"> window._ttf = window._ttf || []; _ttf.push({ pid: 59726, lang: \"en\", slot: '#article-content #article-body > p', format: \"inread\", minSlot: 4, components: { skip: {delay : 0}}, css : \"margin: 0px auto 0px; max-width: 550px;\" }); (function (d) { var js, s = d.getElementsByTagName('script')[0]; js = d.createElement('script'); js.async = true; js.src = '//cdn.teads.tv/media/format.js'; s.parentNode.insertBefore(js, s); })(window.document);</scr"+"ipt>", tag);



						//}else{
						//	inBodyAd.loadInArticleAd('article-body', 10, 0, '<div id="vm_inline"></div><script> window._videomosh = window._videomosh || []; !function (e, f, u) { e.async = 1; e.src = u; f.parentNode.insertBefore(e, f); }(document.createElement(\'script\'),  document.getElementsByTagName(\'script\')[0], \'http://player.videomosh.com/players/loader/loader_final4.js\');  _videomosh.push({ publisher_key: "sequelmedia", mode: "incontent",  container: "vm_inline",  incontent_mobile_id: "9834",  incontent_desktop_id: "42296",  target_type: "mix"  });</script>' , tag);

						//}

						//ADBLADE
					//	inBodyAd.loadInArticleAd( 'article-body', 7, 0, '<ins class="adbladeads" data-cid="23726-4286472148" data-host="web.adblade.com" data-tag-type="4" style="display:none"></ins><script async src="http://web.adblade.com/js/ads/async/show.js" type="text/javascript"></script>', tag);

						//3LIFT
						//inBodyAd.loadInArticleAd( 'article-body', 5, 0, '<script src="//ib.3lift.com/ttj?inv_code=puckermob_article_sub"></script>', tag);
						
						//KIXER
						//inBodyAd.loadInArticleAd( 'article-body', 10, 0, '<div id=\'__kx_ad_4251\'></div><script type="text/javascript" language="javascript" id="__kx_tag_4251">var __kx_ad_slots = __kx_ad_slots || []; (function () { var slot = 4251; var h = false; var doc = document; __kx_ad_slots.push(slot); if (typeof __kx_ad_start == \'function\') { __kx_ad_start(); } else { if (top == self) { var s = doc.createElement(\'script\'); s.type = \'text/javascript\'; s.async = true; s.src = \'//cdn.kixer.com/ad/load.js\'; s.onload = s.onreadystatechange = function(){ if (!h && (!this.readyState || this.readyState == \'loaded\' || this.readyState == \'complete\')) { h = true; s.onload = s.onreadystatechange = null; __kx_ad_start(); } }; var x = doc.getElementsByTagName(\'script\')[0]; x.parentNode.insertBefore(s, x); } else { var tag = doc.getElementById(\'__kx_tag_\'+slot); var win = window.parent; doc = win.document; var top_div = doc.createElement("div"); top_div.id = \'__kx_ad_\'+slot; doc.body.appendChild(top_div); var top_tag = doc.createElement("script"); top_tag.id = \'__kx_top_tag_\'+slot; top_tag.innerHTML = tag.innerHTML; doc.body.appendChild(top_tag); }}})();</script>', tag);
						
						//GOOGLE
						//inBodyAd.loadInArticleAd( 'article-body', 7, 0, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="6383502588"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>', tag);
						
						//STRIKE
						//inBodyAd.loadInArticleAd( 'article-body', 13, 0, '<div id="adunit-300x250-3159"></div><script src="http://4cad707bbe7099c8f3c8-1d22a0d4135badeea192d868b304eb1e.r26.cf5.rackcdn.com/ad_units/3159/unit.js?ord=%%CACHEBUSTER%%" async="true"></script>', tag);
						
						
						//AMAZON
						//inBodyAd.loadInArticleAd( 'article-body', 11, 0, '<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script><script type="text/javascript" language="javascript">//<![CDATA[ aax_getad_mpb({  "slot_uuid":"2e18cb00-0578-49b4-8214-1f204e8327a2" }); //]]></script>', tag);
						
						//ANSWERS
						//inBodyAd.loadInArticleAd( 'article-body', 11, 0, "<div id=\"vm_inline\"></div><script type='text/javascript'> window._videomosh = window._videomosh || []; !function (e, f, u) { e.async = 1; e.src = u; f.parentNode.insertBefore(e, f); }(document.createElement('script'), document.getElementsByTagName('script')[0], 'http://player.videomosh.com/players/loader/loader_final4.js'); _videomosh.push({  publisher_key: \"sequelmedia\",  mode: \"incontent\",  container: \"vm_inline\", incontent_mobile_id: \"9834\", incontent_desktop_id: \"42296\",  target_type: \"mix\", backfill:\"<script src='//ib.3lift.com/ttj?inv_code=puckermob_article_sub'></scr\"+\"ipt>\"}); </script>", tag);

						//TEADS
						//inBodyAd.loadInArticleAd('article-body', 8, 0, "<script type=\"text/javascript\"> window._ttf = window._ttf || []; _ttf.push({ pid: 59726, lang: \"en\", slot: '#article-content #article-body > p', format: \"inread\", minSlot: 4, components: { skip: {delay : 0}}, css : \"margin: 0px auto 0px; max-width: 550px;\" }); (function (d) { var js, s = d.getElementsByTagName('script')[0]; js = d.createElement('script'); js.async = true; js.src = '//cdn.teads.tv/media/format.js'; s.parentNode.insertBefore(js, s); })(window.document); </script>", tag);
      					//inBodyAd.loadInArticleAd('article-body', 9, 0, "<script type=\"text/javascript\"> window._ttf = window._ttf || []; _ttf.push({ pid : 1 , vast: 'http://a.teads.tv/vast/get/1550', lang: \"en\", slot: '#article-content #article-body > p', format: \"inread\", minSlot: 4 ,components: { skip: {delay : 0}}, css: \"margin: 0px auto 0px; max-width: 550px;\"}); (function (d) { var js, s = d.getElementsByTagName('script')[0]; js = d.createElement('script'); js.async = true; js.src = '//cdn.teads.tv/media/format.js'; s.parentNode.insertBefore(js, s); })(window.document);</script>", tag);

      											
						//if( article_id == 22231 ){

					
						//BRANOVATE
						/*if(is_IOS){
							inBodyAd.loadInArticleAd( 'article-body', 10, 0, '<IFRAME SRC="http://ib.adnxs.com/tt?id=5839932&cb=[CACHEBUSTER]" FRAMEBORDER="0" SCROLLING="no" MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" LEFTMARGIN="0" ALLOWTRANSPARENCY="true" WIDTH="300" HEIGHT="250"></IFRAME>', tag );
						}else{
							inBodyAd.loadInArticleAd( 'article-body', 10, 0, '<IFRAME SRC="http://ib.adnxs.com/tt?id=4408970&cb=[CACHEBUSTER]" FRAMEBORDER="0" SCROLLING="no" MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" LEFTMARGIN="0" ALLOWTRANSPARENCY="true" WIDTH="300" HEIGHT="250"></IFRAME>', tag );
						}*/

						//if(article_id == 22165){
							//inBodyAd.loadInArticleAd( 'article-body', 5, 0, '<div id="vm_inline"></div><script>window._videomosh = window._videomosh || []; !function (e, f, u) { e.async = 1; e.src = u; f.parentNode.insertBefore(e, f); }(document.createElement(\'script\'), document.getElementsByTagName(\'script\')[0], \'http://player.videomosh.com/players/loader/loader_final4.js\'); _videomosh.push({ publisher_key: "sequelmedia", mode: "incontent", container: "vm_inline", incontent_mobile_id: "9834", incontent_desktop_id: "42296", target_type: "mix", backfill: "" }); </script>', tag );
						//}
				}
		}
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

			}
				//LELO
				if( article_id == 16562 ||  article_id == 17425 || article_id == 14479 || article_id == 14576 || article_id == 14472 || article_id == 15104 ||  article_id == 15109 || article_id == 15271 || article_id ==  17286){}else{
					if( second_p > 0 ){
						
						if(article_id != 15284 && article_id != 15488 && article_id != 14597 && article_id != 23564){


							//inBodyAd.loadInArticleAd( 'article-body', 5, 0, '<script async src="http://ads.allscreen.tv/embed?placement=181" ></script>', tag);

							//inBodyAd.loadInArticleAd( 'article-body', 5, 0, '<div id="vm_inline"></div><script> window._videomosh = window._videomosh || [];   !function (e, f, u) {  e.async = 1;  e.src = u;  f.parentNode.insertBefore(e, f);  }(document.createElement(\'script\'), document.getElementsByTagName(\'script\')[0], "http://player.videomosh.com/players/loader/loader_final4.js");  _videomosh.push({ publisher_key: "sequelmedia", mode: "slider", container: "vm_inline", incontent_mobile_id: "23002", incontent_desktop_id: "42300", target_type: "mix", backfill: "<script async src=\'http://ads.allscreen.tv/embed?placement=181\' ><\/scr"+"ipt>"});<\/script>', tag);
							
							inBodyAd.loadInArticleAd('article-body', 4, 0, '<div id="nativo-id"></div>' , tag);
							
							$('#inarticle3-ad').removeClass('columns');
							//inBodyAd.loadInArticleAd( 'article-body', 8, 0, '<script src="//ib.3lift.com/ttj?inv_code=puckermob_mid_article"></script>', tag);
						}
					}
				}
		}
}

