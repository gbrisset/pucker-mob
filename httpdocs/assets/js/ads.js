var smarties = false;
var page = document.body.id;
var browser_width = $(window).width();
var article_id = Foundation.utils.S('#article_id').val();
var hasSponsored = $("#has-sponsored-by").val();
var country =ManageCookies.getCookie('country');
var second_image_url = $('#second-mob-img');


if(page != 'articleslide' && page != 'home' && page != 'category' && page != 'article' && page != 'distroscale') {var adPage = 'category';} else {var adPage = page;}
if(	Foundation.utils.S('#article_id') && ( Foundation.utils.S('#article_id').val() ==  4349 || Foundation.utils.S('#article_id').val() ==  4399  || Foundation.utils.S('#article_id').val() ==  4396)) smarties = true;
if(!$('body').hasClass('mobile')) var iFrameResizerJS = 'data:text/javascript;base64,IWZ1bmN0aW9uKCl7InVzZSBzdHJpY3QiO2Z1bmN0aW9uIGEoYSxiKXsiYWRkRXZlbnRMaXN0ZW5lciJpbiB3aW5kb3c/d2luZG93LmFkZEV2ZW50TGlzdGVuZXIoYSxiLCExKToiYXR0YWNoRXZlbnQiaW4gd2luZG93JiZ3aW5kb3cuYXR0YWNoRXZlbnQoIm9uIithLGIpfWZ1bmN0aW9uIGIoYSl7cmV0dXJuIHQrIlsiK3YrIl0gIithfWZ1bmN0aW9uIGMoYSl7cyYmImNvbnNvbGUiaW4gd2luZG93JiZjb25zb2xlLmxvZyhiKGEpKX1mdW5jdGlvbiBkKGEpeyJjb25zb2xlImluIHdpbmRvdyYmY29uc29sZS53YXJuKGIoYSkpfWZ1bmN0aW9uIGUoYil7ZnVuY3Rpb24gZSgpe2Z1bmN0aW9uIGUoKXtmdW5jdGlvbiBhKGEpe3JldHVybiJ0cnVlIj09PWE/ITA6ITF9dmFyIGM9Yi5kYXRhLnN1YnN0cih1KS5zcGxpdCgiOiIpO3Y9Y1swXSxpPXZvaWQgMCE9PWNbMV0/cGFyc2VJbnQoY1sxXSxnKTppLGw9dm9pZCAwIT09Y1syXT9hKGNbMl0pOmwscz12b2lkIDAhPT1jWzNdP2EoY1szXSk6cyxxPXZvaWQgMCE9PWNbNF0/cGFyc2VJbnQoY1s0XSxnKTpxLHc9dm9pZCAwIT09Y1s1XT9hKGNbNV0pOncsZj12b2lkIDAhPT1jWzZdP2EoY1s2XSk6ZixqPW0oIm1hcmdpbiIsY1s3XSkscD12b2lkIDAhPT1jWzhdP2NbOF0udG9Mb3dlckNhc2UoKTpwLGg9Y1s5XSxrPWNbMTBdfWZ1bmN0aW9uIG0oYSxiKXtyZXR1cm4tMSE9PWIuaW5kZXhPZigiLSIpJiYoZCgiTmVnYXRpdmUgQ1NTIHZhbHVlIGlnbm9yZWQgZm9yICIrYSksYj0iIiksYn1mdW5jdGlvbiBuKGEsYil7dm9pZCAwIT09YiYmIiIhPT1iJiYibnVsbCIhPT1iJiYoZG9jdW1lbnQuYm9keS5zdHlsZVthXT1iLGMoIkJvZHkgIithKyIgc2V0IHRvICIrYikpfWZ1bmN0aW9uIHIoKXt2b2lkIDA9PT1qJiYoaj1pKyJweCIpLG4oIm1hcmdpbiIsail9ZnVuY3Rpb24gdCgpe2RvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zdHlsZS5oZWlnaHQ9ImF1dG8iLGRvY3VtZW50LmJvZHkuc3R5bGUuaGVpZ2h0PSJhdXRvIixjKCdIVE1MICYgYm9keSBoZWlnaHQgc2V0IHRvICJhdXRvIicpfWZ1bmN0aW9uIHgoKXthKCJyZXNpemUiLGZ1bmN0aW9uKCl7QigicmVzaXplIiwiV2luZG93IHJlc2l6ZWQiKX0pfWZ1bmN0aW9uIHkoKXthKCJjbGljayIsZnVuY3Rpb24oKXtCKCJjbGljayIsIldpbmRvdyBjbGlja2VkIil9KX1mdW5jdGlvbiB6KCl7byE9PXAmJmMoIkhlaWdodCBjYWxjdWxhdGlvbiBtZXRob2Qgc2V0IHRvICIrcCsiSGVpZ2h0Iil9ZnVuY3Rpb24gQSgpeyEwPT09Zj8oeCgpLHkoKSxGKCkpOmMoIkF1dG8gUmVzaXplIGRpc2FibGVkIil9YygiSW5pdGlhbGlzaW5nIGlGcmFtZSIpLGUoKSxyKCksbigiYmFja2dyb3VuZCIsaCksbigicGFkZGluZyIsaykseigpLHQoKSxEKCksQSgpfWZ1bmN0aW9uIEIoYSxiLGQsZSl7ZnVuY3Rpb24gZigpe2Z1bmN0aW9uIGEoYSl7ZnVuY3Rpb24gYihhKXt2YXIgYj0vXlxkKyhweCk/JC9pO2lmKGIudGVzdChhKSlyZXR1cm4gcGFyc2VJbnQoYSxnKTt2YXIgZD1jLnN0eWxlLmxlZnQsZT1jLnJ1bnRpbWVTdHlsZS5sZWZ0O3JldHVybiBjLnJ1bnRpbWVTdHlsZS5sZWZ0PWMuY3VycmVudFN0eWxlLmxlZnQsYy5zdHlsZS5sZWZ0PWF8fDAsYT1jLnN0eWxlLnBpeGVsTGVmdCxjLnN0eWxlLmxlZnQ9ZCxjLnJ1bnRpbWVTdHlsZS5sZWZ0PWUsYX12YXIgYz1kb2N1bWVudC5ib2R5LGQ9MDtyZXR1cm4gZD1kb2N1bWVudC5kZWZhdWx0VmlldyYmZG9jdW1lbnQuZGVmYXVsdFZpZXcuZ2V0Q29tcHV0ZWRTdHlsZT9kb2N1bWVudC5kZWZhdWx0Vmlldy5nZXRDb21wdXRlZFN0eWxlKGMsbnVsbClbYV06YihjLmN1cnJlbnRTdHlsZVthXSkscGFyc2VJbnQoZCxnKX1yZXR1cm4gZG9jdW1lbnQuYm9keS5vZmZzZXRIZWlnaHQrYSgibWFyZ2luVG9wIikrYSgibWFyZ2luQm90dG9tIil9ZnVuY3Rpb24gaCgpe3JldHVybiBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuc2Nyb2xsSGVpZ2h0fWZ1bmN0aW9uIGkoKXtyZXR1cm4gTWF0aC5tYXgoZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LnNjcm9sbFdpZHRoLGRvY3VtZW50LmJvZHkuc2Nyb2xsV2lkdGgpfWZ1bmN0aW9uIGooKXtjKCJUcmlnZ2VyIGV2ZW50ICgiK2IrIikgY2FuY2VsbGVkIiksc2V0VGltZW91dChmdW5jdGlvbigpe3I9YX0seil9ZnVuY3Rpb24gaygpe2MoIlRyaWdnZXIgZXZlbnQ6ICIrYikscj1hfWZ1bmN0aW9uIG4oKXttPXEsQT1zLGsoKSxDKG0sQSxhKX12YXIgbz17b2Zmc2V0OmYsc2Nyb2xsOmh9LHE9dm9pZCAwIT09ZD9kOm9bcF0oKSxzPXZvaWQgMCE9PWU/ZTppKCk7ciBpbntzaXplOjEsaW50ZXJ2YWw6MX0mJiJyZXNpemUiPT09YT9qKCk6KG0hPT1xfHxsJiZBIT09cykmJm4oKX1mdW5jdGlvbiBDKGEsYixkLGUsZil7ZnVuY3Rpb24gZygpe3ZvaWQgMD09PWY/Zj14OmMoIk1lc3NhZ2UgdGFyZ2V0T3JpZ2luOiAiK2YpfWZ1bmN0aW9uIGgoKXt2YXIgZz12KyI6IithKyI6IitiKyI6IitkKyh2b2lkIDAhPT1lPyI6IitlOiIiKTtjKCJTZW5kaW5nIG1lc3NhZ2UgdG8gaG9zdCBwYWdlICgiK2crIikiKSx5LnBvc3RNZXNzYWdlKHQrZyxmKX1nKCksaCgpfWZ1bmN0aW9uIEQoKXt3JiYoYygiRW5hYmxlIHB1YmxpYyBtZXRob2RzIiksd2luZG93LnBhcmVudElGcmFtZT17Y2xvc2U6ZnVuY3Rpb24oKXtCKCJjbG9zZSIsIndpbmRvdy5wYXJlbnRJRnJhbWUuY2xvc2UoKSIsMCwwKX0sZ2V0SWQ6ZnVuY3Rpb24oKXtyZXR1cm4gdn0sc2VuZE1lc3NhZ2U6ZnVuY3Rpb24oYSxiKXtDKDAsMCwibWVzc2FnZSIsYSxiKX0sc2V0VGFyZ2V0T3JpZ2luOmZ1bmN0aW9uKGEpe2MoIlNldCB0YXJnZXRPcmlnaW46ICIrYSkseD1hfSxzaXplOmZ1bmN0aW9uKGEsYil7dmFyIGM9IiIrKGE/YToiIikrKGI/IiwiK2I6IiIpO0IoInNpemUiLCJ3aW5kb3cucGFyZW50SUZyYW1lLnNpemUoIitjKyIpIixhLGIpfX0pfWZ1bmN0aW9uIEUoKXswIT09cSYmKGMoInNldEludGVydmFsOiAiK3ErIm1zIiksc2V0SW50ZXJ2YWwoZnVuY3Rpb24oKXtCKCJpbnRlcnZhbCIsInNldEludGVydmFsOiAiK3EpfSxNYXRoLmFicyhxKSkpfWZ1bmN0aW9uIEYoKXtmdW5jdGlvbiBhKCl7dmFyIGE9ZG9jdW1lbnQucXVlcnlTZWxlY3RvcigiYm9keSIpLGQ9e2F0dHJpYnV0ZXM6ITAsYXR0cmlidXRlT2xkVmFsdWU6ITEsY2hhcmFjdGVyRGF0YTohMCxjaGFyYWN0ZXJEYXRhT2xkVmFsdWU6ITEsY2hpbGRMaXN0OiEwLHN1YnRyZWU6ITB9LGU9bmV3IGIoZnVuY3Rpb24oYSl7QigibXV0YXRpb25PYnNlcnZlciIsIm11dGF0aW9uT2JzZXJ2ZXI6ICIrYVswXS50YXJnZXQrIiAiK2FbMF0udHlwZSl9KTtjKCJFbmFibGUgTXV0YXRpb25PYnNlcnZlciIpLGUub2JzZXJ2ZShhLGQpfXZhciBiPXdpbmRvdy5NdXRhdGlvbk9ic2VydmVyfHx3aW5kb3cuV2ViS2l0TXV0YXRpb25PYnNlcnZlcjtiPzA+cT9FKCk6YSgpOihkKCJNdXRhdGlvbk9ic2VydmVyIG5vdCBzdXBwb3J0ZWQgaW4gdGhpcyBicm93c2VyISIpLEUoKSl9ZnVuY3Rpb24gRygpe3JldHVybiB0PT09IiIrYi5kYXRhLnN1YnN0cigwLHUpfUcoKSYmbiYmKGUoKSxCKCJpbml0IiwiSW5pdCBtZXNzYWdlIGZyb20gaG9zdCBwYWdlIiksbj0hMSl9dmFyIGY9ITAsZz0xMCxoPSIiLGk9MCxqPSIiLGs9IiIsbD0hMSxtPTEsbj0hMCxvPSJvZmZzZXQiLHA9byxxPTMyLHI9IiIscz0hMSx0PSJbaUZyYW1lU2l6ZXJdIix1PXQubGVuZ3RoLHY9IiIsdz0hMSx4PSIqIix5PXdpbmRvdy5wYXJlbnQsej01MCxBPTE7YSgibWVzc2FnZSIsZSl9KCk7';

function resizeContentByscreenSize(){
		//HIDE LEFT SIDE BAR WHEN BROWSER IS LESS THAT 1030 px.
		if( $(window).width() < 1090 && $(window).width() > 1030 ){
			$('#left-aside').hide();
			$('#aside').attr('style', 'right:0;');
			if(page === 'home'){
				if( $("#has-sponsored-by").val() == '0') $('#aside').attr('style', 'right:2%;');
				else $('#aside').attr('style', 'right:0;');
			}else{
				$('#aside').attr('style', 'right:2%;');
			}
		}else if( $(window).width() < 1030 ){
			$('#left-aside').hide();
			if(page === 'home'){
				if( $("#has-sponsored-by").val() == '0') $('#aside').attr('style', 'right:1%;');
				else $('#aside').attr('style', 'right:0;');
				$('#aside').attr('style', 'right:0;');
			}else{
				$('#aside').attr('style', 'right:1%;');
			}
		}else {
			$('#left-aside').show();
			if(page === 'home' ){
				if( $("#has-sponsored-by").val() == '0') $('#aside').attr('style', 'right:103px;');
				else $('#aside').attr('style', 'right:0;');
				$('#aside').attr('style', 'right:0;');
			}else{
				$('#aside').attr('style', 'right:103px;');
			}
		}
	}	
	resizeContentByscreenSize();

	function resizeMainOnResize() {
		resizeContentByscreenSize();
		//asideHeight.trending = trendingNowHeight;
		//asideHeight.popular = poparticles.height();
		if(!$('body').hasClass('mobile')) {
			totalHeight = 5400;//3938;
			//if( page == "videos") totalHeight += 80;
			leftSide.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
			main.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
		}
	}

	function resizeMainOnAdLoad() {
		//asideHeight.trending = trendingNowHeight;
		//asideHeight.popular = poparticles.height();
		resizeContentByscreenSize();
		totalHeight = 5400;//3938;
		//if( page == "videos") totalHeight += 80;
		if(!$('body').hasClass('mobile')) {
			leftSide.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
			main.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
		}
	}
	

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
//MOBILE
if($('body').hasClass('mobile')) {
	var select = {
		ad: {
			branovate: document.getElementById("branovate-ad")
		}
	};

	// Single & Multi Article Pages
	if( !smarties ){
		var article_id = Foundation.utils.S('#article_id').val();

		//SINGLE PAGE ARTICLE
		if( adPage === 'article' ){
			var li_parent = $('#article-body').find('ol');
			var p_length = $('#article-body').children('p:not(.read-more)').length;
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
						first_p  = parseInt(info[0].mobile_1);
						second_p  = parseInt(info[0].mobile_2);
						third_p  = parseInt(info[0].mobile_3);
						fourth_p  = parseInt(info[0].mobile_4);
						fith_p  = 22;//parseInt(info[0].mobile_5);	
					}
				},
				async:   false
			});

			if( tag == 'p'){
				first_p = first_p;
				second_p = second_p;
				third_p = third_p;
			}

			if(article_id == 7614){
				var ip_address = '';
				var current_url = window.location.href;
				var user_agent_str = navigator.userAgent;
				$.get('http://jsonip.com', function (res) {
					ip_address = res.ip;
				});
			}
			
			if( first_p > 0 ){
				
				//if( article_id == 7614 ){ //TESTING SPROCKESTER ADS
					//$.get('http://jsonip.com', function (res) {
					//	inBodyAd.loadInArticleAd( 'article-body', first_p, 0, '<script type="text/javascript" src="http://ad4.liverail.com/?LR_PUBLISHER_ID=136898&LR_SCHEMA=vast2-vpaid& LR_CONTENT=1&LR_FORMAT=application/x-shockwave-flash;application/javascript;video%2Fmp4;video%2Fwebm&LR_TITLE=REPLACE_ME&LR_VIDEO_ID=REPLACE_ME&LR_IP='+ip_address+'&LR_TAGS=REPLACE_ME&LR_UID=REPLACE_ME&CACHEBUSTER=REPLACE_ME&LR_DURATION=REPLACE_ME&&LR_USERAGENT='+user_agent_str+'"></script>', tag);
					//});
				//}else 
				if(article_id == 8669 ){ //http://www.puckermob.com/relationships/8-modern-dating-practices-that-our-parents-generation-wouldnt-understand
					//ADSPARC VIDEO UNIT
					inBodyAd.loadInArticleAd( 'article-body', first_p, 0, '<div id="mobile-instream-adsparc-ad"></div>', tag);
				}else{
					inBodyAd.loadInArticleAd( 'article-body', first_p, 0, mobilead[adPage].inarticlenativo, tag);		
				}
				
			}

			//2ND SPOT
			if( second_p > 0 ){
				if( country && country == 'US' || country == 'XX'){
					inBodyAd.loadInArticleAd( 'article-body', second_p, 0, mobilead[adPage].inarticle, tag);	
				}else{	
					inBodyAd.loadInArticleAd( 'article-body', second_p, 0, mobilead[adPage].inarticlesharetothercountry, tag);	
				}
			}

			//3RD SPOT
			if( third_p > 0 ){
				//inBodyAd.loadInArticleAd( 'article-body', third_p, 0, '<div id="kmni_cb04f88a1ff0727dc9881e3cfe5d8acc" style="display: inline-block;"></div><script>$.getScript("//cdn.komoona.com/scripts/kmn_sa.js").done(function( script, textStatus ) {kmn_sa.tag("cb04f88a1ff0727dc9881e3cfe5d8acc");});</script>', tag);
				//inBodyAd.loadInArticleAd( 'article-body', third_p, 0, '<div id="mobile-instream-branovate-ad"></div>', tag);
				//inBodyAd.loadInArticleAd( 'article-body', third_p, 0, '<div id="mobile-instream-toksnn-ad" class="clear"></div>', tag);
				//inBodyAd.loadInArticleAd( 'article-body', third_p, 0, mobilead[adPage].inarticlenativo, tag);
				//if(article_id == 9445 ){ //http://www.puckermob.com/relationships/11-things-to-know-before-dating-someone-who-seems-intimidating-at-first
					inBodyAd.loadInArticleAd( 'article-body', third_p, 0, '<div id="vm_inreadcontent" class="playerDiv_inline_close"><script id="fifScript"> (function() { var script = document.createElement("script"); script.async = true; script.src = "http://player.videomosh.com/players/instream/puckermob.min.js"; var entry = document.getElementsByTagName("script")[0]; entry.parentNode.insertBefore(script, entry);  })(); </script> </div>', tag);
				//}else{
				//	inBodyAd.loadInArticleAd( 'article-body', third_p, 0, mobilead[adPage].inarticlegoogle4, tag);
				//}
			}

			//4TH SPOT
			console.log( fourth_p, num_items );
			if( fourth_p > 0 ){
				if(num_items >= fourth_p ){
					if($(second_image_url).lenght > 0){
						inBodyAd.loadInArticleAd( 'article-body', fourth_p, 0, '<div id="second_image_holder"><img src="'+second_image_url+'" alt="Second Image Mobile"/></div>', tag);
					}else{
						//inBodyAd.loadInArticleAd( 'article-body', fourth_p, 0, '<div id="kmni_fc4492dc405ee8f7fe28922253e2e0cb" style="display: inline-block;"></div><script>$.getScript("//cdn.komoona.com/scripts/kmn_sa.js").done(function( script, textStatus ) {kmn_sa.tag("fc4492dc405ee8f7fe28922253e2e0cb");});</script>', tag);
						inBodyAd.loadInArticleAd( 'article-body', fourth_p, 0, '<div id="mobile-instream-branovate-ad" class="clear"></div>', tag);

					}
				}
			}

			//5TH SPOT 
			console.log(num_items, fith_p);
			if( fith_p > 0 ){
				if(num_items >= fith_p ){
					inBodyAd.loadInArticleAd( 'article-body', 22, 0, mobilead[adPage].inarticleadblade, tag);
				}
			}
		}

		//MULTIPAGE ARTICLE
		if( adPage === 'articleslide'){
			inBodyAd.loadInArticleAd( 'article-caption', 4, 0, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:150px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="6986976583"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>', 'p');	
			inBodyAd.loadInArticleAd( 'article-caption', 6, 0, mobilead[adPage].inarticle, 'p');	
		}

		 $('.inarticle-ad').prepend("<p style='margin-left: 0.5rem !important;color: #bbb;font-size: 0.9rem !important;font-style: italic;'>Advertisement</p>");
        
	}

	if(adPage == 'article'){
		//appendAdEndBody($('#mobile-instream-toksnn-ad-loader'), $('#mobile-instream-toksnn-ad'), 100);
		appendAdEndBody($('#mobile-instream-branovate-ad-loader'), $('#mobile-instream-branovate-ad'), 100);
		if(article_id == 8669 ){
			appendAdEndBody($('#mobile-instream-adsparc-ad-loader'), $('#mobile-instream-adsparc-ad'), 100);
		}
		
	}
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
			var li_parent = $('#article-content').find('ol');
			var p_length = $('#article-content').children('p').length;
			var li_length = $(li_parent).find('li').length;
			var isListArticle = false;
			var tag = 'p', num_items = p_length, first_p = 2, second_p = 5, third_p = 9, fourth_p = 15, fith_p = 22;

			if($(li_parent) && $(li_parent).length == 0 ) li_parent = $('#article-content').find('ul');
			if(li_length > p_length){
				isListArticle = true;
				tag = 'li';
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
			
			if( first_p > 0 ){
				//SHARET
				if( country && country == 'US'){
					inBodyAd.loadInArticleAd( 'article-body', first_p, 0, ad[adPage].inarticlesharet, tag);
				}else{
					inBodyAd.loadInArticleAd( 'article-body', first_p, 0, ad[adPage].inarticlesharetothercountry, tag);
				}
			}
			
			if( second_p > 0 ){
				if(article_id == 8225){ //http://www.puckermob.com/lifestyle/22-signs-youre-expectations-for-life-are-based-on-disney-movies
				//adSparc
					inBodyAd.loadInArticleAd( 'article-body', second_p, 0, '<div id="adsparc-instream-ad" ></div>', tag);
				}else{
					//CARAMBOLA
					inBodyAd.loadInArticleAd( 'article-body', second_p, 0, ad[adPage].inarticlecarambola, tag);
				}
			}
		}

		//MULTIPAGE ARTICLES
		if( adPage === 'articleslide'){
			inBodyAd.loadInArticleAd( 'article-caption', 4, 0, '<div data-str-native-key="58ad4c02" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>', 'p');
		}
	}

	$(window).resize(function() {
	//	resizeMainOnResize();
	});

	//appendAdEndBody($('#header-ad-loader'), $('#header-ad'), 100);
	//appendAdEndBody($('#atf-ad-loaded'), $('#atf-ad'), 100);

}