$(document).foundation();
var aside = Foundation.utils.S('#aside');
var poparticles = Foundation.utils.S("#popular-articles");
var subsidebar = Foundation.utils.S("#sub-sidebar-2");
var subsidebar3 = Foundation.utils.S("#sub-sidebar-3");
var trendingNowHeight = Foundation.utils.S('#trending-now').height();
var socialwidget = Foundation.utils.S('#social_widget');
var adsonarHeight = Foundation.utils.S('#ad-sonar').height();
var main = Foundation.utils.S('#main');
var leftSide = Foundation.utils.S('#puc-articles');
var base_url = 'http://www.puckermob.com';
var URL = $(location).attr('href');
var page = document.body.id;
if(socialwidget.length > 0) socialwidget = socialwidget.height(); else socialwidget=0;

var asideHeight = {
	video: socialwidget,
	atf: 0,
	popular: poparticles.height(),
	subsidebar: subsidebar.height(),
	adSonar: 300,
	connect: Foundation.utils.S("#connect-with-us").height(),
	btf1: 0,
	btf2: 0,
	subsidebar3: poparticles.height() + 140,
	margin: parseInt(main.css("padding-bottom"))
};


$(document).ready(function() {
	if(page != 'recipe' && page != 'home' && page != 'category' && page != 'article') {var adPage = 'category';} else {var adPage = page;}
	var iFrameResizerJS = 'data:text/javascript;base64,IWZ1bmN0aW9uKCl7InVzZSBzdHJpY3QiO2Z1bmN0aW9uIGEoYSxiKXsiYWRkRXZlbnRMaXN0ZW5lciJpbiB3aW5kb3c/d2luZG93LmFkZEV2ZW50TGlzdGVuZXIoYSxiLCExKToiYXR0YWNoRXZlbnQiaW4gd2luZG93JiZ3aW5kb3cuYXR0YWNoRXZlbnQoIm9uIithLGIpfWZ1bmN0aW9uIGIoYSl7cmV0dXJuIHQrIlsiK3YrIl0gIithfWZ1bmN0aW9uIGMoYSl7cyYmImNvbnNvbGUiaW4gd2luZG93JiZjb25zb2xlLmxvZyhiKGEpKX1mdW5jdGlvbiBkKGEpeyJjb25zb2xlImluIHdpbmRvdyYmY29uc29sZS53YXJuKGIoYSkpfWZ1bmN0aW9uIGUoYil7ZnVuY3Rpb24gZSgpe2Z1bmN0aW9uIGUoKXtmdW5jdGlvbiBhKGEpe3JldHVybiJ0cnVlIj09PWE/ITA6ITF9dmFyIGM9Yi5kYXRhLnN1YnN0cih1KS5zcGxpdCgiOiIpO3Y9Y1swXSxpPXZvaWQgMCE9PWNbMV0/cGFyc2VJbnQoY1sxXSxnKTppLGw9dm9pZCAwIT09Y1syXT9hKGNbMl0pOmwscz12b2lkIDAhPT1jWzNdP2EoY1szXSk6cyxxPXZvaWQgMCE9PWNbNF0/cGFyc2VJbnQoY1s0XSxnKTpxLHc9dm9pZCAwIT09Y1s1XT9hKGNbNV0pOncsZj12b2lkIDAhPT1jWzZdP2EoY1s2XSk6ZixqPW0oIm1hcmdpbiIsY1s3XSkscD12b2lkIDAhPT1jWzhdP2NbOF0udG9Mb3dlckNhc2UoKTpwLGg9Y1s5XSxrPWNbMTBdfWZ1bmN0aW9uIG0oYSxiKXtyZXR1cm4tMSE9PWIuaW5kZXhPZigiLSIpJiYoZCgiTmVnYXRpdmUgQ1NTIHZhbHVlIGlnbm9yZWQgZm9yICIrYSksYj0iIiksYn1mdW5jdGlvbiBuKGEsYil7dm9pZCAwIT09YiYmIiIhPT1iJiYibnVsbCIhPT1iJiYoZG9jdW1lbnQuYm9keS5zdHlsZVthXT1iLGMoIkJvZHkgIithKyIgc2V0IHRvICIrYikpfWZ1bmN0aW9uIHIoKXt2b2lkIDA9PT1qJiYoaj1pKyJweCIpLG4oIm1hcmdpbiIsail9ZnVuY3Rpb24gdCgpe2RvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zdHlsZS5oZWlnaHQ9ImF1dG8iLGRvY3VtZW50LmJvZHkuc3R5bGUuaGVpZ2h0PSJhdXRvIixjKCdIVE1MICYgYm9keSBoZWlnaHQgc2V0IHRvICJhdXRvIicpfWZ1bmN0aW9uIHgoKXthKCJyZXNpemUiLGZ1bmN0aW9uKCl7QigicmVzaXplIiwiV2luZG93IHJlc2l6ZWQiKX0pfWZ1bmN0aW9uIHkoKXthKCJjbGljayIsZnVuY3Rpb24oKXtCKCJjbGljayIsIldpbmRvdyBjbGlja2VkIil9KX1mdW5jdGlvbiB6KCl7byE9PXAmJmMoIkhlaWdodCBjYWxjdWxhdGlvbiBtZXRob2Qgc2V0IHRvICIrcCsiSGVpZ2h0Iil9ZnVuY3Rpb24gQSgpeyEwPT09Zj8oeCgpLHkoKSxGKCkpOmMoIkF1dG8gUmVzaXplIGRpc2FibGVkIil9YygiSW5pdGlhbGlzaW5nIGlGcmFtZSIpLGUoKSxyKCksbigiYmFja2dyb3VuZCIsaCksbigicGFkZGluZyIsaykseigpLHQoKSxEKCksQSgpfWZ1bmN0aW9uIEIoYSxiLGQsZSl7ZnVuY3Rpb24gZigpe2Z1bmN0aW9uIGEoYSl7ZnVuY3Rpb24gYihhKXt2YXIgYj0vXlxkKyhweCk/JC9pO2lmKGIudGVzdChhKSlyZXR1cm4gcGFyc2VJbnQoYSxnKTt2YXIgZD1jLnN0eWxlLmxlZnQsZT1jLnJ1bnRpbWVTdHlsZS5sZWZ0O3JldHVybiBjLnJ1bnRpbWVTdHlsZS5sZWZ0PWMuY3VycmVudFN0eWxlLmxlZnQsYy5zdHlsZS5sZWZ0PWF8fDAsYT1jLnN0eWxlLnBpeGVsTGVmdCxjLnN0eWxlLmxlZnQ9ZCxjLnJ1bnRpbWVTdHlsZS5sZWZ0PWUsYX12YXIgYz1kb2N1bWVudC5ib2R5LGQ9MDtyZXR1cm4gZD1kb2N1bWVudC5kZWZhdWx0VmlldyYmZG9jdW1lbnQuZGVmYXVsdFZpZXcuZ2V0Q29tcHV0ZWRTdHlsZT9kb2N1bWVudC5kZWZhdWx0Vmlldy5nZXRDb21wdXRlZFN0eWxlKGMsbnVsbClbYV06YihjLmN1cnJlbnRTdHlsZVthXSkscGFyc2VJbnQoZCxnKX1yZXR1cm4gZG9jdW1lbnQuYm9keS5vZmZzZXRIZWlnaHQrYSgibWFyZ2luVG9wIikrYSgibWFyZ2luQm90dG9tIil9ZnVuY3Rpb24gaCgpe3JldHVybiBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuc2Nyb2xsSGVpZ2h0fWZ1bmN0aW9uIGkoKXtyZXR1cm4gTWF0aC5tYXgoZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LnNjcm9sbFdpZHRoLGRvY3VtZW50LmJvZHkuc2Nyb2xsV2lkdGgpfWZ1bmN0aW9uIGooKXtjKCJUcmlnZ2VyIGV2ZW50ICgiK2IrIikgY2FuY2VsbGVkIiksc2V0VGltZW91dChmdW5jdGlvbigpe3I9YX0seil9ZnVuY3Rpb24gaygpe2MoIlRyaWdnZXIgZXZlbnQ6ICIrYikscj1hfWZ1bmN0aW9uIG4oKXttPXEsQT1zLGsoKSxDKG0sQSxhKX12YXIgbz17b2Zmc2V0OmYsc2Nyb2xsOmh9LHE9dm9pZCAwIT09ZD9kOm9bcF0oKSxzPXZvaWQgMCE9PWU/ZTppKCk7ciBpbntzaXplOjEsaW50ZXJ2YWw6MX0mJiJyZXNpemUiPT09YT9qKCk6KG0hPT1xfHxsJiZBIT09cykmJm4oKX1mdW5jdGlvbiBDKGEsYixkLGUsZil7ZnVuY3Rpb24gZygpe3ZvaWQgMD09PWY/Zj14OmMoIk1lc3NhZ2UgdGFyZ2V0T3JpZ2luOiAiK2YpfWZ1bmN0aW9uIGgoKXt2YXIgZz12KyI6IithKyI6IitiKyI6IitkKyh2b2lkIDAhPT1lPyI6IitlOiIiKTtjKCJTZW5kaW5nIG1lc3NhZ2UgdG8gaG9zdCBwYWdlICgiK2crIikiKSx5LnBvc3RNZXNzYWdlKHQrZyxmKX1nKCksaCgpfWZ1bmN0aW9uIEQoKXt3JiYoYygiRW5hYmxlIHB1YmxpYyBtZXRob2RzIiksd2luZG93LnBhcmVudElGcmFtZT17Y2xvc2U6ZnVuY3Rpb24oKXtCKCJjbG9zZSIsIndpbmRvdy5wYXJlbnRJRnJhbWUuY2xvc2UoKSIsMCwwKX0sZ2V0SWQ6ZnVuY3Rpb24oKXtyZXR1cm4gdn0sc2VuZE1lc3NhZ2U6ZnVuY3Rpb24oYSxiKXtDKDAsMCwibWVzc2FnZSIsYSxiKX0sc2V0VGFyZ2V0T3JpZ2luOmZ1bmN0aW9uKGEpe2MoIlNldCB0YXJnZXRPcmlnaW46ICIrYSkseD1hfSxzaXplOmZ1bmN0aW9uKGEsYil7dmFyIGM9IiIrKGE/YToiIikrKGI/IiwiK2I6IiIpO0IoInNpemUiLCJ3aW5kb3cucGFyZW50SUZyYW1lLnNpemUoIitjKyIpIixhLGIpfX0pfWZ1bmN0aW9uIEUoKXswIT09cSYmKGMoInNldEludGVydmFsOiAiK3ErIm1zIiksc2V0SW50ZXJ2YWwoZnVuY3Rpb24oKXtCKCJpbnRlcnZhbCIsInNldEludGVydmFsOiAiK3EpfSxNYXRoLmFicyhxKSkpfWZ1bmN0aW9uIEYoKXtmdW5jdGlvbiBhKCl7dmFyIGE9ZG9jdW1lbnQucXVlcnlTZWxlY3RvcigiYm9keSIpLGQ9e2F0dHJpYnV0ZXM6ITAsYXR0cmlidXRlT2xkVmFsdWU6ITEsY2hhcmFjdGVyRGF0YTohMCxjaGFyYWN0ZXJEYXRhT2xkVmFsdWU6ITEsY2hpbGRMaXN0OiEwLHN1YnRyZWU6ITB9LGU9bmV3IGIoZnVuY3Rpb24oYSl7QigibXV0YXRpb25PYnNlcnZlciIsIm11dGF0aW9uT2JzZXJ2ZXI6ICIrYVswXS50YXJnZXQrIiAiK2FbMF0udHlwZSl9KTtjKCJFbmFibGUgTXV0YXRpb25PYnNlcnZlciIpLGUub2JzZXJ2ZShhLGQpfXZhciBiPXdpbmRvdy5NdXRhdGlvbk9ic2VydmVyfHx3aW5kb3cuV2ViS2l0TXV0YXRpb25PYnNlcnZlcjtiPzA+cT9FKCk6YSgpOihkKCJNdXRhdGlvbk9ic2VydmVyIG5vdCBzdXBwb3J0ZWQgaW4gdGhpcyBicm93c2VyISIpLEUoKSl9ZnVuY3Rpb24gRygpe3JldHVybiB0PT09IiIrYi5kYXRhLnN1YnN0cigwLHUpfUcoKSYmbiYmKGUoKSxCKCJpbml0IiwiSW5pdCBtZXNzYWdlIGZyb20gaG9zdCBwYWdlIiksbj0hMSl9dmFyIGY9ITAsZz0xMCxoPSIiLGk9MCxqPSIiLGs9IiIsbD0hMSxtPTEsbj0hMCxvPSJvZmZzZXQiLHA9byxxPTMyLHI9IiIscz0hMSx0PSJbaUZyYW1lU2l6ZXJdIix1PXQubGVuZ3RoLHY9IiIsdz0hMSx4PSIqIix5PXdpbmRvdy5wYXJlbnQsej01MCxBPTE7YSgibWVzc2FnZSIsZSl9KCk7';
	var liftCSS = '<link rel="stylesheet" type="text/css" href="data:text/css;base64,Ym9keSB7CmxpbmUtaGVpZ2h0OiAwOwp0ZXh0LWFsaWduOiBsZWZ0ICFpbXBvcnRhbnQ7Cm1hcmdpbi1ib3R0b206IDEuMjVyZW07CmhlaWdodDogYXV0bzsKfQoubGlzdC1hcnRpY2xlcyB7ZGlzcGxheTogdGFibGU7IG1hcmdpbi1sZWZ0OiAtMC45Mzc1cmVtOyBtYXJnaW4tcmlnaHQ6IC0wLjkzNzVyZW07IHdpZHRoOiAxMDAlO30KYm9keSAuYXJ0aWNsZS1pbWFnZSB7CglmbG9hdDogbGVmdDsKCWJveC1zaXppbmc6IGJvcmRlci1ib3g7Cglwb3NpdGlvbjogcmVsYXRpdmU7CglwYWRkaW5nLWxlZnQ6IDAuOTM3NXJlbTsKCXBhZGRpbmctcmlnaHQ6IDAuNDY4NzVyZW07CglwYWRkaW5nLWJvdHRvbTogMS4xODc1cmVtOwp9Ci5hcnRpY2xlLWltYWdlIGltZyB7Cgl3aWR0aDogMTAwJTsKCS1tb3otYm94LXNoYWRvdzogMXB4IDFweCAxcHggMXB4ICM5MzkxOGY7Cgktd2Via2l0LWJveC1zaGFkb3c6IDFweCAxcHggMXB4IDFweCAjOTM5MThmOwoJYm94LXNoYWRvdzogMXB4IDFweCAxcHggMXB4ICM5MzkxOGY7Cn0KLmFydGljbGUtaW5mbyB7CglmbG9hdDogcmlnaHQ7Cglib3gtc2l6aW5nOiBib3JkZXItYm94OwoJcG9zaXRpb246IHJlbGF0aXZlOwoJbGluZS1oZWlnaHQ6IDE7CglwYWRkaW5nLWxlZnQ6IDAuNDY4NzVyZW07CglwYWRkaW5nLXJpZ2h0OiAwLjkzNzVyZW07Cn0KaDIge21hcmdpbi10b3A6IDA7Cm1hcmdpbi1ib3R0b206MC42MjVyZW07CmNvbG9yOiAjMzMzMzMzICFpbXBvcnRhbnQ7CmZvbnQtc2l6ZTogMXJlbTt9CmxhYmVsIHttYXJnaW4tYm90dG9tOiAxLjI1cmVtO30KaDIgPiBhIHtjb2xvcjogIzMzMzMzMyAhaW1wb3J0YW50OyB0ZXh0LWRlY29yYXRpb246IG5vbmUgIWltcG9ydGFudDt9CnAgewoJY29sb3I6ICMzMzMzMzM7Cglmb250LXdlaWdodDogbm9ybWFsOwoJZm9udC1zaXplOiAxcmVtOwoJZm9udC1zdHlsZTogbm9ybWFsOwoJbGluZS1oZWlnaHQ6IDEuNjsKCW1hcmdpbi1ib3R0b206IDEuMTg3NXJlbTsKCXRleHQtcmVuZGVyaW5nOiBvcHRpbWl6ZUxlZ2liaWxpdHk7Cglib3gtc2l6aW5nOiBib3JkZXItYm94OwoJbWFyZ2luLXRvcDogMDsKfQphOmhvdmVyIHt0ZXh0LWRlY29yYXRpb246IHVuZGVybGluZSAhaW1wb3J0YW50O30KYm9keSA+IGRpdjpmaXJzdC1jaGlsZCB7bWFyZ2luLWxlZnQ6IDAuOTM3NXJlbTsgbWFyZ2luLXJpZ2h0OiAwLjkzNzVyZW07IGJvcmRlci1ib3R0b206IDFweCBzb2xpZCAjZGRkOyBkaXNwbGF5OiB0YWJsZSAhaW1wb3J0YW50OyB3aWR0aDogMTAwJTt9CmJyIHtkaXNwbGF5OiBub25lO30KLmFydGljbGUtaW5mbyA+IGxhYmVsID4gYTpob3ZlciB7dGV4dC1kZW9jcmF0aW9uOiB1bmRlcmxpbmUgIWltcG9ydGFudDt9Ci5hcnRpY2xlLWluZm8gPiBsYWJlbCA+IGEge2ZvbnQ6IDFyZW0gJGJvZHktZm9udC1mYW1pbHkgIWltcG9ydGFudDsgY29sb3I6ICMzMzMzMzM7IHRleHQtZGVjb3JhdGlvbjogbm9uZSAhaW1wb3J0YW50O30KYm9keSA+IGltZyB7ZGlzcGxheTogbm9uZSAhaW1wb3J0YW50OyBoZWlnaHQ6IDBweCAhaW1wb3J0YW50O30=" />';
	var browser_width = $(window).width();
	var ad = {
		home: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214357/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
            atf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214359/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
	     	btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214358/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214360/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'
		},
		category: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214366/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			atf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214359/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214367/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214368/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'
		},
		recipe: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214361/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			atf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214359/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214363/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
	     	footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214362/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'
		},
		article: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214371/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			atf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214359/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214372/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
	     	footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214369/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'
		},
		lift: {
			home: liftCSS + '<script src="http://ib.3lift.com/ttj?inv_code=simpledish_main_feed"></script>',
			category: liftCSS + '<script src="http://ib.3lift.com/ttj?inv_code=simpledish_subpage"></script>'
		},
		mobileheader: '<script src="http://uac.advertising.com/mobile/madserverUAC.js" type="text/javascript"></script><script type="text/javascript">(function() {var a = {mobilePlacementID: "348-254-2cd-1635", width: "320", height: "50"}; madserver.requestAd(a);})();</script>',
		medianet: {
			recipe: '<script id="mNCC" language="javascript">  medianet_width=\'600\';  medianet_height= \'175\';  medianet_crid=\'426275056\';  </script>  <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CUCXD4TF" language="javascript"></script>',
			sectioned: '<script id="mNCC" language="javascript">  medianet_width=\'600\';  medianet_height= \'175\';  medianet_crid=\'426275056\';  </script>  <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CUCXD4TF" language="javascript"></script>'
		}
	};
	var mobilead = {
		home: {
			middle: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219871/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			bottom: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219872/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219870/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219869/0/1014/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'
		},
		recipe: {
			middle1: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219883/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			middle2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219884/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			bottom: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219882/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			middle: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219885/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219887/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219886/0/1014/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'
		},
		category: {
			bottom: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219899/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219898/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219897/0/1014/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'
		},
		article: {
			middle1: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219890/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			middle2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219891/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			bottom: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219888/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			middle: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219893/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219892/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219889/0/1014/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'	
		}
	};


	Foundation.utils.image_loaded(Foundation.utils.S('#aside img'), function(){
		asideHeight.popular = poparticles.height();
		main.css("min-height", (asideHeight.popular + asideHeight.atf  + asideHeight.subsidebar +  asideHeight.subsidebar3 +  asideHeight.btf2 ));/*+ (asideHeight.margin * 7) - 8*/
		leftSide.css("min-height", (asideHeight.popular + asideHeight.atf  + asideHeight.subsidebar +  asideHeight.subsidebar3 +  asideHeight.btf2 ));
		//main.css("min-height", (asideHeight.video + asideHeight.atf + asideHeight.popular + asideHeight.connect + asideHeight.btf1 + asideHeight.trending + asideHeight.btf2 + (asideHeight.margin * 7) - 8));
	});

	function resizeMainOnResize() {
		asideHeight.trending = trendingNowHeight;
		asideHeight.popular = poparticles.height();
		main.css("min-height", (asideHeight.popular + asideHeight.atf  + asideHeight.subsidebar +  asideHeight.subsidebar3 + asideHeight.btf2 ));/*+ (asideHeight.margin * 7) - 8*/
		leftSide.css("min-height", (asideHeight.popular + asideHeight.atf  + asideHeight.subsidebar +  asideHeight.subsidebar3 + asideHeight.btf2 ));
	}

	function resizeMainOnAdLoad() {
		asideHeight.trending = trendingNowHeight;
		asideHeight.popular = poparticles.height();
		
		main.css("min-height", (asideHeight.popular + asideHeight.atf  + asideHeight.subsidebar +  asideHeight.subsidebar3 + asideHeight.btf1 +  asideHeight.btf2 /*+ (asideHeight.margin * 7) - 8*/));
		leftSide.css("min-height", (asideHeight.popular + asideHeight.atf  + asideHeight.subsidebar +  asideHeight.subsidebar3 + asideHeight.btf1 +  asideHeight.btf2));

	}

	function loadAd(target, adcode) {
		var iframe = document.createElement('iframe');
		iframe.id=target.id + '-iframe';
		iframe.className="ad-unit hide-for-print";
		iframe.scrolling="no";
		iframe.height="0";
		var child = target.appendChild(iframe);
		var content = child.contentWindow.document;
		content.open().write('<body style="margin: 0; padding: 0; text-align: center !important;"><style>* {text-align: center !important; margin: 0 auto !important;}</style>' + adcode + '<script type="text/javascript" src="' + iFrameResizerJS +'"></script>');
		content.close();
	}

	
	if($('body').hasClass('mobile')) {
		var select = {
			ad: {
				header: document.getElementById("header-ad"),
				middle: document.getElementById("middle-ad"),
				middle1:document.getElementById("middle1-ad"),
				middle2:document.getElementById("middle2-ad"),
				bottom: document.getElementById("bottom-ad"),
				footer: document.getElementById("footer-ad")
			}
		};

		//if(adPage !== 'category') loadAd(select.ad.middle, mobilead[adPage].middle);	
		//if(adPage === 'recipe') loadAd(select.ad.middle1, mobilead[adPage].middle1);
		
		//loadAd(select.ad.header, mobilead[adPage].header);
		//loadAd(select.ad.bottom, mobilead[adPage].bottom);
		
	
	} else {
		var select = {
			ad: {
				header: document.getElementById("header-ad"),
				atf: document.getElementById("atf-ad"),
				//btf1: document.getElementById("btf1-ad"),
				btf2: document.getElementById("btf2-ad"),
				footer: document.getElementById("footer-ad"),
				lift: document.getElementById("lift-ad"),
				medianet: document.getElementById("medianet-ad")
			}
		};
		if(browser_width < 740) {
			loadAd(select.ad.header, ad.mobileheader);
		} else {
			loadAd(select.ad.header, ad[adPage].header);
			loadAd(select.ad.footer, ad[adPage].footer);
		if(adPage === 'category') {
			loadAd(select.ad.medianet, ad.medianet.recipe);
		} else if(page === 'recipe') {
			if(Foundation.utils.S('#sectioned-article-content').length) {
				loadAd(select.ad.medianet, ad.medianet.sectioned);
			} else {
				loadAd(select.ad.medianet, ad.medianet.recipe);
			}
		}
	}
	//if(page === 'category' || page === 'home') {
		//loadAd(select.ad.lift, ad.lift[page]);
	//}

	loadAd(select.ad.atf, ad[adPage].atf);

	loadAd(select.ad.btf2, ad[adPage].btf2);

	$(window).resize(function() {
		resizeMainOnResize();
    });
	}

	iFrameResize({
			checkOrigin: false,
			sizeWidth: true,
			resizedCallback: function(messageData){
				var label = messageData.id.slice(0, -10);
				var container = select.ad[label];
				var classToAdd = 'ad-unit hide-for-print';
				if(label === 'atf' && messageData.height > 500) {
					if(label === 'atf' && messageData.height < 700) {
						classToAdd += ' ad300 ad600'; asideHeight[label] = 600 + asideHeight.margin; resizeMainOnAdLoad();
					}
					else { classToAdd += ' ad300 ad1050'; asideHeight[label] = 1050 + asideHeight.margin; resizeMainOnAdLoad();}
				}
				else if(label === 'atf' || label === 'btf1' || label === 'btf2') { classToAdd += ' ad300 ad250'; asideHeight[label] = 251 + asideHeight.margin; resizeMainOnAdLoad();}
				else if(label === 'header' || label === 'footer') {
					if(label === 'footer' || (label === 'header' && messageData.height < 110 && messageData.height > 80)) {classToAdd += ' ad90';}
					else if(label === 'header' && messageData.height < 80) {Foundation.utils.S("#header-ad").css("min-height", messageData.height);}					
					if(messageData.width < 500) {classToAdd += ' ad320';}
					else if(messageData.width < 780) {classToAdd += ' ad728';}
					else if(messageData.width < 1200) {classToAdd += ' ad980';}
				} else if(label === 'medianet') {classToAdd += ' show-ad padding-right show-for-xxlarge-only'; Foundation.utils.S('hr.hr-hidden').removeClass('hr-hidden');}
				else if(label === 'lift') {classToAdd += 'row half-margin'}
				container.setAttribute("class", classToAdd);
		}
	});
	
    Foundation.utils.S('#around-the-web a').attr('target', '_blank');

	var facebook_button = Foundation.utils.S('#facebook-button');
	var twitter_button = Foundation.utils.S('#twitter-button');
	var pinterest_button = Foundation.utils.S('#pinterest-button');
	var google_plus_button = Foundation.utils.S('#google-plus-button');
	var stumbleupon_button = Foundation.utils.S('#stumbleupon-button');
	var email_button = Foundation.utils.S('#email-button');
	var share_title = Foundation.utils.S('meta[property="og:title"]').attr('content');
	var share_url = Foundation.utils.S('meta[property="og:url"]').attr('content');
	var share_image = Foundation.utils.S('meta[property="og:image"]').attr('content');
	var share_popup_width;
    var share_popup_height;
	var topbar_search_contents = Foundation.utils.S('#topbar-search-contents');
	var topbar_search_submit = Foundation.utils.S('#topbar-search-submit');
	var notfound_search_contents = Foundation.utils.S('#notfound-search-contents');
	var notfound_search_submit = Foundation.utils.S('#notfound-search-submit');
	// Search handlers
	topbar_search_submit.click(function() {window.location.href = base_url+'/search/?q='+topbar_search_contents.val();});
	topbar_search_contents.keypress(function(e) {if(e.keyCode == 13) {window.location.href = base_url+'/search/?q='+topbar_search_contents.val();}});
	notfound_search_submit.click(function() {window.location.href = base_url+'/search/?q='+notfound_search_contents.val();});
	notfound_search_contents.keypress(function(e) {if(e.keyCode == 13) {window.location.href = base_url+'/search/?q='+notfound_search_contents.val();}});

 	// Sharing popups
	facebook_button.click(function () {
		share_popup_width = 650;
		share_popup_height = 380;
		window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(share_url), 'Facebook', 'top='+ ((screen.height / 2) - (share_popup_height / 2)) +',left='+ ((screen.width / 2) - (share_popup_width / 2)) +',height=' + share_popup_height + ',width=' + share_popup_width + ',toolbar=0,location=0,menubar=0,directories=0,scrollbars=0');
	});
	twitter_button.click(function () {
		share_popup_width = 680;
		share_popup_height = 450;
		window.open('http://twitter.com/share?url=' + encodeURIComponent(share_url) + '&text=' + encodeURIComponent(share_title) + '&', 'Twitter', 'top='+ ((screen.height / 2) - (share_popup_height / 2)) +',left='+ ((screen.width / 2) - (share_popup_width / 2)) +',height=' + share_popup_height + ',width=' + share_popup_width + ',toolbar=0,location=0,menubar=0,directories=0,scrollbars=0');
	});
	pinterest_button.click(function () {
		share_popup_width = 760;
		share_popup_height = 350;
		window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(share_url) + '&media=' + encodeURIComponent(share_image) + '&description=' + encodeURIComponent(share_title), 'Pinterest', 'top='+ ((screen.height / 2) - (share_popup_height / 2)) +',left='+ ((screen.width / 2) - (share_popup_width / 2)) +',height=' + share_popup_height + ',width=' + share_popup_width + ',toolbar=0,location=0,menubar=0,directories=0,scrollbars=0');
	});
	google_plus_button.click(function () {
		share_popup_height = 500;
		share_popup_width = 500;
		window.open('https://plus.google.com/share?url=' + encodeURIComponent(share_url), 'Google+', 'top='+ ((screen.height / 2) - (share_popup_height / 2)) +',left='+ ((screen.width / 2) - (share_popup_width / 2)) +',height=' + share_popup_height + ',width=' + share_popup_width + ',toolbar=0,location=0,menubar=0,directories=0,scrollbars=0');
	});
	stumbleupon_button.click(function () {
		share_popup_height = 716;
		share_popup_width = 1024;
		window.open('http://www.stumbleupon.com/submit?url=' + encodeURIComponent(share_url), 'StumbleUpon', 'top='+ ((screen.height / 2) - (share_popup_height / 2)) +',left='+ ((screen.width / 2) - (share_popup_width / 2)) +',height=' + share_popup_height + ',width=' + share_popup_width + ',toolbar=0,location=0,menubar=0,directories=0,scrollbars=0');
	});
	email_button.click(function() {alert("Email"); });
var app = {
    // returns an array of each url to prefetch
    prefetchLinks: function(){
        // returns an array of each a.prefetch link's href
        var hrefs = $("a.prefetch").map(function(index, domElement){
            return $(this).attr("href");
        });
        // returns the array of hrefs without duplicates
        return $.unique(hrefs);
    },

    // adds a link tag to the document head for each of prefetchLinks()
    addPrefetchTags: function(){
        // for each prefetchLinks() ...
        this.prefetchLinks().each(function(index,Element){
            // create a link element...
            $("<link />", {
                // with rel=prefetch and href=Element...
                rel: "prefetch prerender", href: Element
                // and append it to the end of the document head
            }).appendTo("head");            
        });
    },
}
    app.addPrefetchTags();

    if(page === 'article') {
    	$.getJSON( 'http://free.sharedcount.com/?apikey=709226bb97515fd204f07c3d4bac38f78ba009eb&url=' + URL, function(shareData) {
    		Foundation.utils.S('#facebook-count').text(shareData.Facebook.total_count);
       		Foundation.utils.S('#twitter-count').text(shareData.Twitter);
    		Foundation.utils.S('#pinterest-count').text(shareData.Pinterest);
    		Foundation.utils.S('#google-plus-count').text(shareData.GooglePlusOne);
    		Foundation.utils.S('.social-fade-in').fadeTo(800, 1);
    	});
    	var requiredImages = Foundation.utils.S('.wait-for-me');
 		Foundation.utils.image_loaded(requiredImages, function(){
    		var article = Foundation.utils.S('.microsidebar-article');
    		var microSidebar = Foundation.utils.S('#micro-sidebar');
    		var asideHeightCounter = Foundation.utils.S('#micro-sidebar').height();
    		var firstEntryHeight = Foundation.utils.S('#microw-1').height();
 			var rowNumber = 1;
    		while((article.height() > (microSidebar.height() + firstEntryHeight)) && rowNumber < 8) {
    			Foundation.utils.S('#microw-' + (rowNumber + 5)).show();
    			rowNumber++;
    		}
 		});
    }

    
	$(function() {
	  $('a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html,body').animate({
	          scrollTop: target.offset().top
	        }, 1000);
	        return false;
	      }
	    }
	  });
	});
	

});
