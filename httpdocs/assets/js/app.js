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

var isIE11 = !!navigator.userAgent.match(/Trident.*rv\:11\./);
if(isIE11){
	//smain.css("left", "0%");
	main.css("display", "block");
}

var asideHeight = {
	video: socialwidget,
	atf: 0,
	popular: poparticles.height(),
	subsidebar: subsidebar.height(),
	adSonar: 300,
	connect: Foundation.utils.S("#connect-with-us").height(),
	btf1: 0,
	btf2: 0,
	btf3: 0,
	subsidebar3: poparticles.height() + 140,
	margin: parseInt(main.css("padding-bottom"))
};


$(document).ready(function() {
console.log(page);


	function resizeContentByscreenSize(){
		//HIDE LEFT SIDE BAR WHEN BROWSER IS LESS THAT 1030 px.
		if( $(window).width() < 1090 && $(window).width() > 1030 ){
			 $('#left-aside').hide();
			 $('#aside').attr('style', 'right:2%;');
		}else if( $(window).width() < 1030 ){
			 $('#left-aside').hide();
			 $('#aside').attr('style', 'right:1%;');
		}else {
			$('#left-aside').show();
			$('#aside').attr('style', 'right:103px;');
		}

	}

	resizeContentByscreenSize();
	if(page != 'articleslide' && page != 'home' && page != 'category' && page != 'article' && page != 'distroscale') {var adPage = 'category';} else {var adPage = page;}
	var iFrameResizerJS = 'data:text/javascript;base64,IWZ1bmN0aW9uKCl7InVzZSBzdHJpY3QiO2Z1bmN0aW9uIGEoYSxiKXsiYWRkRXZlbnRMaXN0ZW5lciJpbiB3aW5kb3c/d2luZG93LmFkZEV2ZW50TGlzdGVuZXIoYSxiLCExKToiYXR0YWNoRXZlbnQiaW4gd2luZG93JiZ3aW5kb3cuYXR0YWNoRXZlbnQoIm9uIithLGIpfWZ1bmN0aW9uIGIoYSl7cmV0dXJuIHQrIlsiK3YrIl0gIithfWZ1bmN0aW9uIGMoYSl7cyYmImNvbnNvbGUiaW4gd2luZG93JiZjb25zb2xlLmxvZyhiKGEpKX1mdW5jdGlvbiBkKGEpeyJjb25zb2xlImluIHdpbmRvdyYmY29uc29sZS53YXJuKGIoYSkpfWZ1bmN0aW9uIGUoYil7ZnVuY3Rpb24gZSgpe2Z1bmN0aW9uIGUoKXtmdW5jdGlvbiBhKGEpe3JldHVybiJ0cnVlIj09PWE/ITA6ITF9dmFyIGM9Yi5kYXRhLnN1YnN0cih1KS5zcGxpdCgiOiIpO3Y9Y1swXSxpPXZvaWQgMCE9PWNbMV0/cGFyc2VJbnQoY1sxXSxnKTppLGw9dm9pZCAwIT09Y1syXT9hKGNbMl0pOmwscz12b2lkIDAhPT1jWzNdP2EoY1szXSk6cyxxPXZvaWQgMCE9PWNbNF0/cGFyc2VJbnQoY1s0XSxnKTpxLHc9dm9pZCAwIT09Y1s1XT9hKGNbNV0pOncsZj12b2lkIDAhPT1jWzZdP2EoY1s2XSk6ZixqPW0oIm1hcmdpbiIsY1s3XSkscD12b2lkIDAhPT1jWzhdP2NbOF0udG9Mb3dlckNhc2UoKTpwLGg9Y1s5XSxrPWNbMTBdfWZ1bmN0aW9uIG0oYSxiKXtyZXR1cm4tMSE9PWIuaW5kZXhPZigiLSIpJiYoZCgiTmVnYXRpdmUgQ1NTIHZhbHVlIGlnbm9yZWQgZm9yICIrYSksYj0iIiksYn1mdW5jdGlvbiBuKGEsYil7dm9pZCAwIT09YiYmIiIhPT1iJiYibnVsbCIhPT1iJiYoZG9jdW1lbnQuYm9keS5zdHlsZVthXT1iLGMoIkJvZHkgIithKyIgc2V0IHRvICIrYikpfWZ1bmN0aW9uIHIoKXt2b2lkIDA9PT1qJiYoaj1pKyJweCIpLG4oIm1hcmdpbiIsail9ZnVuY3Rpb24gdCgpe2RvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zdHlsZS5oZWlnaHQ9ImF1dG8iLGRvY3VtZW50LmJvZHkuc3R5bGUuaGVpZ2h0PSJhdXRvIixjKCdIVE1MICYgYm9keSBoZWlnaHQgc2V0IHRvICJhdXRvIicpfWZ1bmN0aW9uIHgoKXthKCJyZXNpemUiLGZ1bmN0aW9uKCl7QigicmVzaXplIiwiV2luZG93IHJlc2l6ZWQiKX0pfWZ1bmN0aW9uIHkoKXthKCJjbGljayIsZnVuY3Rpb24oKXtCKCJjbGljayIsIldpbmRvdyBjbGlja2VkIil9KX1mdW5jdGlvbiB6KCl7byE9PXAmJmMoIkhlaWdodCBjYWxjdWxhdGlvbiBtZXRob2Qgc2V0IHRvICIrcCsiSGVpZ2h0Iil9ZnVuY3Rpb24gQSgpeyEwPT09Zj8oeCgpLHkoKSxGKCkpOmMoIkF1dG8gUmVzaXplIGRpc2FibGVkIil9YygiSW5pdGlhbGlzaW5nIGlGcmFtZSIpLGUoKSxyKCksbigiYmFja2dyb3VuZCIsaCksbigicGFkZGluZyIsaykseigpLHQoKSxEKCksQSgpfWZ1bmN0aW9uIEIoYSxiLGQsZSl7ZnVuY3Rpb24gZigpe2Z1bmN0aW9uIGEoYSl7ZnVuY3Rpb24gYihhKXt2YXIgYj0vXlxkKyhweCk/JC9pO2lmKGIudGVzdChhKSlyZXR1cm4gcGFyc2VJbnQoYSxnKTt2YXIgZD1jLnN0eWxlLmxlZnQsZT1jLnJ1bnRpbWVTdHlsZS5sZWZ0O3JldHVybiBjLnJ1bnRpbWVTdHlsZS5sZWZ0PWMuY3VycmVudFN0eWxlLmxlZnQsYy5zdHlsZS5sZWZ0PWF8fDAsYT1jLnN0eWxlLnBpeGVsTGVmdCxjLnN0eWxlLmxlZnQ9ZCxjLnJ1bnRpbWVTdHlsZS5sZWZ0PWUsYX12YXIgYz1kb2N1bWVudC5ib2R5LGQ9MDtyZXR1cm4gZD1kb2N1bWVudC5kZWZhdWx0VmlldyYmZG9jdW1lbnQuZGVmYXVsdFZpZXcuZ2V0Q29tcHV0ZWRTdHlsZT9kb2N1bWVudC5kZWZhdWx0Vmlldy5nZXRDb21wdXRlZFN0eWxlKGMsbnVsbClbYV06YihjLmN1cnJlbnRTdHlsZVthXSkscGFyc2VJbnQoZCxnKX1yZXR1cm4gZG9jdW1lbnQuYm9keS5vZmZzZXRIZWlnaHQrYSgibWFyZ2luVG9wIikrYSgibWFyZ2luQm90dG9tIil9ZnVuY3Rpb24gaCgpe3JldHVybiBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuc2Nyb2xsSGVpZ2h0fWZ1bmN0aW9uIGkoKXtyZXR1cm4gTWF0aC5tYXgoZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LnNjcm9sbFdpZHRoLGRvY3VtZW50LmJvZHkuc2Nyb2xsV2lkdGgpfWZ1bmN0aW9uIGooKXtjKCJUcmlnZ2VyIGV2ZW50ICgiK2IrIikgY2FuY2VsbGVkIiksc2V0VGltZW91dChmdW5jdGlvbigpe3I9YX0seil9ZnVuY3Rpb24gaygpe2MoIlRyaWdnZXIgZXZlbnQ6ICIrYikscj1hfWZ1bmN0aW9uIG4oKXttPXEsQT1zLGsoKSxDKG0sQSxhKX12YXIgbz17b2Zmc2V0OmYsc2Nyb2xsOmh9LHE9dm9pZCAwIT09ZD9kOm9bcF0oKSxzPXZvaWQgMCE9PWU/ZTppKCk7ciBpbntzaXplOjEsaW50ZXJ2YWw6MX0mJiJyZXNpemUiPT09YT9qKCk6KG0hPT1xfHxsJiZBIT09cykmJm4oKX1mdW5jdGlvbiBDKGEsYixkLGUsZil7ZnVuY3Rpb24gZygpe3ZvaWQgMD09PWY/Zj14OmMoIk1lc3NhZ2UgdGFyZ2V0T3JpZ2luOiAiK2YpfWZ1bmN0aW9uIGgoKXt2YXIgZz12KyI6IithKyI6IitiKyI6IitkKyh2b2lkIDAhPT1lPyI6IitlOiIiKTtjKCJTZW5kaW5nIG1lc3NhZ2UgdG8gaG9zdCBwYWdlICgiK2crIikiKSx5LnBvc3RNZXNzYWdlKHQrZyxmKX1nKCksaCgpfWZ1bmN0aW9uIEQoKXt3JiYoYygiRW5hYmxlIHB1YmxpYyBtZXRob2RzIiksd2luZG93LnBhcmVudElGcmFtZT17Y2xvc2U6ZnVuY3Rpb24oKXtCKCJjbG9zZSIsIndpbmRvdy5wYXJlbnRJRnJhbWUuY2xvc2UoKSIsMCwwKX0sZ2V0SWQ6ZnVuY3Rpb24oKXtyZXR1cm4gdn0sc2VuZE1lc3NhZ2U6ZnVuY3Rpb24oYSxiKXtDKDAsMCwibWVzc2FnZSIsYSxiKX0sc2V0VGFyZ2V0T3JpZ2luOmZ1bmN0aW9uKGEpe2MoIlNldCB0YXJnZXRPcmlnaW46ICIrYSkseD1hfSxzaXplOmZ1bmN0aW9uKGEsYil7dmFyIGM9IiIrKGE/YToiIikrKGI/IiwiK2I6IiIpO0IoInNpemUiLCJ3aW5kb3cucGFyZW50SUZyYW1lLnNpemUoIitjKyIpIixhLGIpfX0pfWZ1bmN0aW9uIEUoKXswIT09cSYmKGMoInNldEludGVydmFsOiAiK3ErIm1zIiksc2V0SW50ZXJ2YWwoZnVuY3Rpb24oKXtCKCJpbnRlcnZhbCIsInNldEludGVydmFsOiAiK3EpfSxNYXRoLmFicyhxKSkpfWZ1bmN0aW9uIEYoKXtmdW5jdGlvbiBhKCl7dmFyIGE9ZG9jdW1lbnQucXVlcnlTZWxlY3RvcigiYm9keSIpLGQ9e2F0dHJpYnV0ZXM6ITAsYXR0cmlidXRlT2xkVmFsdWU6ITEsY2hhcmFjdGVyRGF0YTohMCxjaGFyYWN0ZXJEYXRhT2xkVmFsdWU6ITEsY2hpbGRMaXN0OiEwLHN1YnRyZWU6ITB9LGU9bmV3IGIoZnVuY3Rpb24oYSl7QigibXV0YXRpb25PYnNlcnZlciIsIm11dGF0aW9uT2JzZXJ2ZXI6ICIrYVswXS50YXJnZXQrIiAiK2FbMF0udHlwZSl9KTtjKCJFbmFibGUgTXV0YXRpb25PYnNlcnZlciIpLGUub2JzZXJ2ZShhLGQpfXZhciBiPXdpbmRvdy5NdXRhdGlvbk9ic2VydmVyfHx3aW5kb3cuV2ViS2l0TXV0YXRpb25PYnNlcnZlcjtiPzA+cT9FKCk6YSgpOihkKCJNdXRhdGlvbk9ic2VydmVyIG5vdCBzdXBwb3J0ZWQgaW4gdGhpcyBicm93c2VyISIpLEUoKSl9ZnVuY3Rpb24gRygpe3JldHVybiB0PT09IiIrYi5kYXRhLnN1YnN0cigwLHUpfUcoKSYmbiYmKGUoKSxCKCJpbml0IiwiSW5pdCBtZXNzYWdlIGZyb20gaG9zdCBwYWdlIiksbj0hMSl9dmFyIGY9ITAsZz0xMCxoPSIiLGk9MCxqPSIiLGs9IiIsbD0hMSxtPTEsbj0hMCxvPSJvZmZzZXQiLHA9byxxPTMyLHI9IiIscz0hMSx0PSJbaUZyYW1lU2l6ZXJdIix1PXQubGVuZ3RoLHY9IiIsdz0hMSx4PSIqIix5PXdpbmRvdy5wYXJlbnQsej01MCxBPTE7YSgibWVzc2FnZSIsZSl9KCk7';
	var liftCSS = '<link rel="stylesheet" type="text/css" href="data:text/css;base64,Ym9keSB7CmxpbmUtaGVpZ2h0OiAwOwp0ZXh0LWFsaWduOiBsZWZ0ICFpbXBvcnRhbnQ7Cm1hcmdpbi1ib3R0b206IDEuMjVyZW07CmhlaWdodDogYXV0bzsKfQoubGlzdC1hcnRpY2xlcyB7ZGlzcGxheTogdGFibGU7IG1hcmdpbi1sZWZ0OiAtMC45Mzc1cmVtOyBtYXJnaW4tcmlnaHQ6IC0wLjkzNzVyZW07IHdpZHRoOiAxMDAlO30KYm9keSAuYXJ0aWNsZS1pbWFnZSB7CglmbG9hdDogbGVmdDsKCWJveC1zaXppbmc6IGJvcmRlci1ib3g7Cglwb3NpdGlvbjogcmVsYXRpdmU7CglwYWRkaW5nLWxlZnQ6IDAuOTM3NXJlbTsKCXBhZGRpbmctcmlnaHQ6IDAuNDY4NzVyZW07CglwYWRkaW5nLWJvdHRvbTogMS4xODc1cmVtOwp9Ci5hcnRpY2xlLWltYWdlIGltZyB7Cgl3aWR0aDogMTAwJTsKCS1tb3otYm94LXNoYWRvdzogMXB4IDFweCAxcHggMXB4ICM5MzkxOGY7Cgktd2Via2l0LWJveC1zaGFkb3c6IDFweCAxcHggMXB4IDFweCAjOTM5MThmOwoJYm94LXNoYWRvdzogMXB4IDFweCAxcHggMXB4ICM5MzkxOGY7Cn0KLmFydGljbGUtaW5mbyB7CglmbG9hdDogcmlnaHQ7Cglib3gtc2l6aW5nOiBib3JkZXItYm94OwoJcG9zaXRpb246IHJlbGF0aXZlOwoJbGluZS1oZWlnaHQ6IDE7CglwYWRkaW5nLWxlZnQ6IDAuNDY4NzVyZW07CglwYWRkaW5nLXJpZ2h0OiAwLjkzNzVyZW07Cn0KaDIge21hcmdpbi10b3A6IDA7Cm1hcmdpbi1ib3R0b206MC42MjVyZW07CmNvbG9yOiAjMzMzMzMzICFpbXBvcnRhbnQ7CmZvbnQtc2l6ZTogMXJlbTt9CmxhYmVsIHttYXJnaW4tYm90dG9tOiAxLjI1cmVtO30KaDIgPiBhIHtjb2xvcjogIzMzMzMzMyAhaW1wb3J0YW50OyB0ZXh0LWRlY29yYXRpb246IG5vbmUgIWltcG9ydGFudDt9CnAgewoJY29sb3I6ICMzMzMzMzM7Cglmb250LXdlaWdodDogbm9ybWFsOwoJZm9udC1zaXplOiAxcmVtOwoJZm9udC1zdHlsZTogbm9ybWFsOwoJbGluZS1oZWlnaHQ6IDEuNjsKCW1hcmdpbi1ib3R0b206IDEuMTg3NXJlbTsKCXRleHQtcmVuZGVyaW5nOiBvcHRpbWl6ZUxlZ2liaWxpdHk7Cglib3gtc2l6aW5nOiBib3JkZXItYm94OwoJbWFyZ2luLXRvcDogMDsKfQphOmhvdmVyIHt0ZXh0LWRlY29yYXRpb246IHVuZGVybGluZSAhaW1wb3J0YW50O30KYm9keSA+IGRpdjpmaXJzdC1jaGlsZCB7bWFyZ2luLWxlZnQ6IDAuOTM3NXJlbTsgbWFyZ2luLXJpZ2h0OiAwLjkzNzVyZW07IGJvcmRlci1ib3R0b206IDFweCBzb2xpZCAjZGRkOyBkaXNwbGF5OiB0YWJsZSAhaW1wb3J0YW50OyB3aWR0aDogMTAwJTt9CmJyIHtkaXNwbGF5OiBub25lO30KLmFydGljbGUtaW5mbyA+IGxhYmVsID4gYTpob3ZlciB7dGV4dC1kZW9jcmF0aW9uOiB1bmRlcmxpbmUgIWltcG9ydGFudDt9Ci5hcnRpY2xlLWluZm8gPiBsYWJlbCA+IGEge2ZvbnQ6IDFyZW0gJGJvZHktZm9udC1mYW1pbHkgIWltcG9ydGFudDsgY29sb3I6ICMzMzMzMzM7IHRleHQtZGVjb3JhdGlvbjogbm9uZSAhaW1wb3J0YW50O30KYm9keSA+IGltZyB7ZGlzcGxheTogbm9uZSAhaW1wb3J0YW50OyBoZWlnaHQ6IDBweCAhaW1wb3J0YW50O30=" />';
	var browser_width = $(window).width();
	console.log(browser_width);
	var ad = {

		home: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243108/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			atf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214359/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf1: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243109/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3247637/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf3: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3247638/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214360/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			flyatf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3285623/0/154/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'

		},
		category: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243116/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			atf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243119/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf1: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243119/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3247639/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf3: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3247640/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3214368/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			flyatf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3285606/0/154/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'

		},
		articleslide: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273034/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			atf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273028/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			atfleft:'<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273032/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			atfright:'<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273029/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf1: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273031/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273030/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273033/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			flyatf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3285630/0/154/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			inarticlesharet: '<div data-str-native-key="58ad4c02" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>',
			inarticlecarambola: '<script class="carambola_InContent" type="text/javascript">(function (i,d,s,o,m,r,t,g) {var e=d.getElementById(r);if(e===null){ var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n);} else { i[t](2) } })(window, document, \'InContent\', \'script\', \'mediaType\', \'carambola_proxy\',\'Cbola_initializeProxy\',\'http://\'+\'route.carambo.la/inimage/getlayer?pid=spdsh12\')<\/script>',


		},
		article: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243112/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			atf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243114/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf1: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243115/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3247641/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243113/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			flyatf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3285586/0/154/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			inarticlesharet: '<div data-str-native-key="58ad4c02" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>',
			inarticlecarambola: '<script class="carambola_InContent" type="text/javascript">(function (i,d,s,o,m,r,t,g) {var e=d.getElementById(r);if(e===null){ var t = d.createElement(o); t.src = g; t.id = r; t.setAttribute(m, s);t.async = 1;var n=d.getElementsByTagName(o)[0];n.parentNode.insertBefore(t, n);} else { i[t](2) } })(window, document, \'InContent\', \'script\', \'mediaType\', \'carambola_proxy\',\'Cbola_initializeProxy\',\'http://\'+\'route.carambo.la/inimage/getlayer?pid=spdsh12\')<\/script>',

		},
		lift: {
			home: liftCSS + '<script src="http://ib.3lift.com/ttj?inv_code=simpledish_main_feed"></script>',
			category: liftCSS + '<script src="http://ib.3lift.com/ttj?inv_code=simpledish_subpage"></script>'
		},
		mobileheader: '<script src="http://uac.advertising.com/mobile/madserverUAC.js" type="text/javascript"></script><script type="text/javascript">(function() {var a = {mobilePlacementID: "348-254-2cd-1635", width: "320", height: "50"}; madserver.requestAd(a);})();</script>',
		medianet: {
			article: '<script id="mNCC" language="javascript">  medianet_width=\'600\';  medianet_height= \'175\';  medianet_crid=\'470643824\';  </script>  <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CUCXD4TF" language="javascript"></script>',
			sectioned: '<script id="mNCC" language="javascript">  medianet_width=\'600\';  medianet_height= \'175\';  medianet_crid=\'470643824\';  </script>  <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CUCXD4TF" language="javascript"></script>'
		},
		distroscale: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243112/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			atf: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243114/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf1: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243115/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3247641/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243113/0/225/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',

		}
	};
	var mobilead = {
		home: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273100/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219869/0/1014/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'
		},
		articleslide: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273459/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf1: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273458/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273460/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273461/0/1014/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			inarticle: '<div data-str-native-key="536c62e7" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>',
			inarticleadblade: '<ins class="adbladeads" data-cid="7958-2737561138" data-host="web.adblade.com" data-tag-type="2" style="display:none"><\/ins><script async src="http://web.adblade.com/js/ads/async/show.js" type="text/javascript"><\/script>',
			inarticlegoogle:'<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:150px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="6986976583"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>',
			inarticlemopub:'<script type="text/javascript">mopub_ad_unit = "97dd84c12ded49899e4c7636a63773ac"; mopub_ad_width = 300; mopub_ad_height = 250; mopub_keywords = "custom keywords";<\/script><script src="http://ads.mopub.com/js/client/mopub.js"><\/script>',
			inarticlenativo: '<div class="nativo" id="nativo-ad"></div>',	
			//inarticlebranovate: '<SCRIPT SRC="http://ib.adnxs.com/ttj?id=4408970&cb=[CACHEBUSTER]&referrer=[REFERRER_URL]" TYPE="text/javascript"></SCRIPT>',
			//inarticlebranovate: '<div id="119xpg4yi2pn8"></div><script src="http://119xpg.go2cloud.org/aff_ad?campaign_id=4&aff_id=1044&format=js&divid=119xpg4yi2pn8" type="text/javascript"></script><noscript><iframe src="http://119xpg.go2cloud.org/aff_ad?campaign_id=4&aff_id=1044&format=iframe" scrolling="no" frameborder="0" marginheight="0" marginwidth="0" width="300" height="250"></iframe></noscript>',
			inarticlebranovate: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="3900787786"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>'
		},
		category: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273103/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3219897/0/1014/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>'
		},
		article: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273456/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf1: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273453/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273457/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273455/0/1014/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			inarticle: '<div data-str-native-key="536c62e7" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>',
			inarticleadblade: '<ins class="adbladeads" data-cid="7958-2737561138" data-host="web.adblade.com" data-tag-type="2" style="display:none"><\/ins><script async src="http://web.adblade.com/js/ads/async/show.js" type="text/javascript"><\/script>',
			inarticlegoogle:'<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:150px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="6986976583"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>',
			inarticlemopub:'<script type="text/javascript">mopub_ad_unit = "97dd84c12ded49899e4c7636a63773ac"; mopub_ad_width = 300; mopub_ad_height = 250; mopub_keywords = "custom keywords";<\/script><script src="http://ads.mopub.com/js/client/mopub.js"><\/script>',
			inarticlenativo: '<div class="nativo" id="nativo-ad"></div>',
			//inarticlebranovate: '<SCRIPT SRC="http://ib.adnxs.com/ttj?id=4408970&cb=[CACHEBUSTER]&referrer=[REFERRER_URL]" TYPE="text/javascript"></SCRIPT>',
			//inarticlebranovate: '<div id="119xpg4yi2pn8"></div><script src="http://119xpg.go2cloud.org/aff_ad?campaign_id=4&aff_id=1044&format=js&divid=119xpg4yi2pn8" type="text/javascript"></script><noscript><iframe src="http://119xpg.go2cloud.org/aff_ad?campaign_id=4&aff_id=1044&format=iframe" scrolling="no" frameborder="0" marginheight="0" marginwidth="0" width="300" height="250"></iframe></noscript>',
			inarticlebranovate: '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="3900787786"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>'

		},
		distroscale: {
			header: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273456/0/3055/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf1: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273453/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			btf2: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273457/0/170/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
			footer: '<script language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3273455/0/1014/ADTECH;loc=100;target=_blank;key=key1+key2+key3+key4;grp=[group];misc='+new Date().getTime()+'"><\/script>',
		}
	};


	Foundation.utils.image_loaded(Foundation.utils.S('#aside img'), function(){
		asideHeight.popular = poparticles.height();
		//main.css("min-height", (asideHeight.popular + asideHeight.atf  + asideHeight.subsidebar +  asideHeight.subsidebar3 +  asideHeight.btf2 ));/*+ (asideHeight.margin * 7) - 8*/
		//leftSide.css("min-height", (asideHeight.popular + asideHeight.atf  + asideHeight.subsidebar +  asideHeight.subsidebar3 +  asideHeight.btf2 ));
		//main.css("min-height", (asideHeight.video + asideHeight.atf + asideHeight.popular + asideHeight.connect + asideHeight.btf1 + asideHeight.trending + asideHeight.btf2 + (asideHeight.margin * 7) - 8));

		totalHeight = 5400;//3938;

		//if( page === 'home' || page === 'category' || page === 'distroscale'){
			//totalHeight+= 300;
		//}
		if( page == "videos") totalHeight += 80;
		if(!$('body').hasClass('mobile')) {
			leftSide.css("min-height", (totalHeight +  asideHeight.atf + asideHeight.video));
			main.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
		}
	});

	function resizeMainOnResize() {

		console.log("BROWSER WIDTH: ");
		console.log($(window).width());

		resizeContentByscreenSize();

		asideHeight.trending = trendingNowHeight;
		asideHeight.popular = poparticles.height();

		if(!$('body').hasClass('mobile')) {

			totalHeight = 5400;//3938;

			//if( page === 'home' || page === 'category' || page === 'distroscale'){
				//totalHeight+= 300;
			//}
			if( page == "videos") totalHeight += 80;
			
			leftSide.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
			main.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));

		}

	}

	function resizeMainOnAdLoad() {
		asideHeight.trending = trendingNowHeight;
		asideHeight.popular = poparticles.height();
		
		resizeContentByscreenSize();
		//main.css("min-height", (asideHeight.popular + asideHeight.atf  + asideHeight.subsidebar +  asideHeight.subsidebar3 + asideHeight.btf1 +  asideHeight.btf2 /*+ (asideHeight.margin * 7) - 8*/));
		//leftSide.css("min-height", (asideHeight.popular + asideHeight.atf  + asideHeight.subsidebar +  asideHeight.subsidebar3 + asideHeight.btf1 +  asideHeight.btf2));
		
		totalHeight = 5400;//3938;

		//if( page === 'home' || page === 'category' || page === 'distroscale'){
			//totalHeight+= 300;
		//}
		if( page == "videos") totalHeight += 80;
		if(!$('body').hasClass('mobile')) {
			leftSide.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
			main.css("min-height", (totalHeight +  asideHeight.atf  + asideHeight.video));
		}
	}

	//Load and Insert the Ad in an IFRAME
	function loadAd(target, adcode) {
		if(target != null ){
		var iframe = document.createElement('iframe');
		iframe.id=target.id + '-iframe';
		console.log(target);
		iframe.className="ad-unit hide-for-print";
		iframe.scrolling="no";
		iframe.height="0";
		var child = target.appendChild(iframe);
		var content = child.contentWindow.document;
		content.open().write('<body style="margin: 0; padding: 0; text-align: center !important;"><style>* {text-align: center !important; margin: 0 auto !important;}</style>' + adcode + '<script type="text/javascript" src="' + iFrameResizerJS +'"></script>');
		content.close();
		}
	}

	//LOAD MIDDLE ARTICLE BODY OBJ
	var inBodyAd = {
		inserDivAdTag: function(target, adcode){
			$(adcode).appendTo(target);
		},
		insertElement: function(target, id, elm, elClass) {
			var div = $('<'+elm+'></'+elm+'>')
			div.addClass(elClass);
			div.attr('id', id);
			console.log('TARGET: '+target.context.localName);
			if($('body').hasClass('mobile') && target.context.localName === 'li')  div.attr('style', 'margin-left: -1.4rem; padding-left: 0rem !important;');

			$(target).after(div);
		},
		loadInArticleAd: function( content, position, iframe, ad, elm ){

			if(elm == 'li') var tag = $('#'+content).find(elm);
			else var tag = $('#'+content).children(elm);

			var index = 0,
			totalTag= $(tag).length,
			this_obj = this;

			if(totalTag > 0 && totalTag >= position){

				tag.each( function(){
					index++;

					if( index === position ){

						if($('body').hasClass('mobile')) {
							this_obj.insertElement($(this), 'inarticle'+index+'-ad', 'div', 'row inarticle-ad ad-unit hide-for-print padding' );
						}else{
							this_obj.insertElement($(this), 'inarticle'+index+'-ad', 'div', 'row inarticle-ad ad-unit hide-for-print padding margin-bottom' );
						}
						if(iframe) loadAd(document.getElementById('inarticle'+index+'-ad'), ad);	
						else this_obj.inserDivAdTag(document.getElementById('inarticle'+index+'-ad'), ad);
					}
				});
			}
		}
	}

	//SMARTIES PROMOTION
	var smarties = false;
	if(	Foundation.utils.S('#article_id') && ( Foundation.utils.S('#article_id').val() ==  4349 || Foundation.utils.S('#article_id').val() ==  4399  || Foundation.utils.S('#article_id').val() ==  4396)) smarties = true;
	
	if($('body').hasClass('mobile')) {
		var select = {
			ad: {
				header: document.getElementById("header-ad"),
				btf1: document.getElementById("btf1-ad"),
				btf2:document.getElementById("btf2-ad"),
				bottom: document.getElementById("bottom-ad"),
				footer: document.getElementById("footer-ad"),
			}
		};

	// Single & Multi Article Pages
	if( !smarties ){
		var article_id = Foundation.utils.S('#article_id').val();

		//SINGLE PAGE ARTICLE
		if( adPage === 'article' ){
			var li_parent = $('#article-content').find('ol');
			var p_length = $('#article-content').children('p').length;
			var li_length = $(li_parent).find('li').length;
			var isListArticle = false;

			var google_position = -1, 
			nativo_position = -1, 
			sharethrough_position = -1,
			carambola_position = -1,
			tag = 'p';

			if($(li_parent) && $(li_parent).length == 0 ) li_parent = $('#article-content').find('ul');
			if(li_length > p_length){
				isListArticle = true;
			}

			//SET DEFAULT VALUES DEPENDING ON ARTICLE BASE TYPE LI/P
			if(isListArticle){
				google_position = -1;
				nativo_position = 1; 
				sharethrough_position = 3;
				carambola_position = -1;
				tag = 'li';
			}else{
				google_position = -1;
				nativo_position = 1; 
				sharethrough_position = 3;
				carambola_position = -1;
			}

			$.ajax({
				type: "POST",
				url:  'http://www.puckermob.com/admin/assets/php/ajaxfunctions.php',
				data: { article_id: article_id, task:'article_ads' },
				success: function (data) {
					if(data != 'false'){
						var info = $.parseJSON(data);
						google_position  = parseInt(info[0].mobile_google);
						nativo_position = parseInt(info[0].mobile_nativo);
						sharethrough_position  = parseInt(info[0].mobile_sharethrough);
						//carambola_position = info[0].mobile_carambola;

						//set defaults
						//$('select[name="options"]').find('option[value="3"]').attr("selected",true);

					}
				},
				async:   false
			});

			if( tag == 'p'){ sharethrough_position = sharethrough_position + 1; nativo_position = nativo_position + 1;}

			//SHARETHROUG
			inBodyAd.loadInArticleAd( 'article-content', sharethrough_position, 0, mobilead[adPage].inarticle, tag);	

			//NATIVO
			inBodyAd.loadInArticleAd( 'article-content', nativo_position, 0, mobilead[adPage].inarticlenativo, tag);
			
			

			//NATIVO
			//if(p_length >= 8) inBodyAd.loadInArticleAd( 'article-content', first_ad, 0, mobilead[adPage].inarticlenativo, 'p');	
		
			//if(isListArticle){
				//var ads_insertions = Math.round(li_length / 3) ;
				/*var first_ad = 1,
					second_ad = 3,
					third_ad = 6;*/
				
				//Google AD 300x150
				//console.log('Google');
				//inBodyAd.loadInArticleAd( 'article-content', first_ad, 0, mobilead[adPage].inarticlebranovate, 'p');	
				
				//SHARETHROUG
				//if(article_id != 4314 && article_id != 4341){
					//inBodyAd.loadInArticleAd( 'article-content', second_ad, 0, mobilead[adPage].inarticle, 'li');
				//} 
				
				//ADBLADE
				//inBodyAd.loadInArticleAd( 'article-content', third_ad, 0, mobilead[adPage].inarticleadblade, 'li');

			/*}else{
				var ads_insertions = Math.round(p_length / 3) ;
				var first_ad = 1,
					second_ad = 3,//first_ad + ads_insertions,
					third_ad = 5; //second_ad + ads_insertions;*/
				//Google AD 300x150
				//inBodyAd.loadInArticleAd( 'article-content', first_ad, 0, mobilead[adPage].inarticlebranovate , 'p');		
				
				
				//if( article_id == 4314 ){
				//	inBodyAd.loadInArticleAd( 'article-content', second_ad, 0, mobilead[adPage].inarticle, 'p');	
				//}else if( article_id == 4341 ){
				//	inBodyAd.loadInArticleAd( 'article-content', 4, 0, mobilead[adPage].inarticle, 'p');	
				//}else{
					//if(p_length >= 5) 
					//	inBodyAd.loadInArticleAd( 'article-content', second_ad, 0, mobilead[adPage].inarticle, 'p');	
				//}

				//ADBLADE
				//if(p_length >= 8) inBodyAd.loadInArticleAd( 'article-content', 8, 0, mobilead[adPage].inarticleadblade, 'p');	
				
			//}
		}

		//MULTIPAGE ARTICLE
		if( adPage === 'articleslide'){
			if( article_id != 5050 ){
				//inBodyAd.loadInArticleAd( 'article-caption', 2, 0, mobilead[adPage].inarticleadblade, 'p');	
			}else{
				inBodyAd.loadInArticleAd( 'article-caption', 4, 0, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script><ins class="adsbygoogle" style="display:inline-block;width:300px;height:150px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="6986976583"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>', 'p');	
			}
			inBodyAd.loadInArticleAd( 'article-caption', 6, 0, mobilead[adPage].inarticle, 'p');	
		}

	}

	console.log("BROWSER WIDTH: ");
		console.log($(window).width());

		//HIDE LEFT SIDE BAR WHEN BROWSER IS LESS THAT 1030 px.
		if( $(window).width() < 1050 ) $('#left-aside').hide();
		else $('#left-aside').show();

} else {
		
		var select = {
			ad: {
				header: document.getElementById("header-ad"),
				atf: document.getElementById("atf-ad"),
				atfleft: document.getElementById("atfleft-ad"),
				atfright: document.getElementById("atfright-ad"),
				btf1: document.getElementById("btf1-ad"),
				btf2: document.getElementById("btf2-ad"),
				btf3: document.getElementById("btf3-ad"),
				footer: document.getElementById("footer-ad"),
				lift: document.getElementById("lift-ad"),
				medianet: document.getElementById("medianet-ad"),
				flyatf: document.getElementById("flyatf-ad"),
			}
		};
		var hasSponsored = $("#has-sponsored-by").val();
		var article_id = Foundation.utils.S('#article_id').val();
		
	//if( !smarties && (hasSponsored == undefined || hasSponsored == 0)){
	if( !smarties ){
		if(browser_width < 740) {
			loadAd(select.ad.header, mobilead[adPage].header);
		} else {
			loadAd(select.ad.header, ad[adPage].header);
			loadAd(select.ad.footer, ad[adPage].footer);
			if(adPage === 'category' && page != 'writeforus') {
				loadAd(select.ad.medianet, ad.medianet.article);
			}
		}

		if( page === 'article' ||  page === 'articleslide'){
			//ATF//
			loadAd(select.ad.atf, ad[adPage].atf);
		}

		//Load and Insert a middle article in the article body

		//SINGLE PAGE ARTICLE
		if( adPage === 'article'){
			var li_parent = $('#article-content').find('ol');
			var p_length = $('#article-content').children('p').length;
			var li_length = $(li_parent).find('li').length;
			var isListArticle = false;
			
			var google_position = -1, 
			nativo_position = -1, 
			sharethrough_position = -1,
			carambola_position = -1,
			tag = 'p';

			if($(li_parent) && $(li_parent).length == 0 ) li_parent = $('#article-content').find('ul');
			if(li_length > p_length){
				isListArticle = true;
			}

			//SET DEFAULT VALUES DEPENDING ON ARTICLE BASE TYPE LI/P
			if(isListArticle){
				google_position = -1;
				nativo_position = -1; 
				sharethrough_position = 2;
				carambola_position = 6;
				tag = 'li';
			}else{
				google_position = -1;
				nativo_position = -1; 
				sharethrough_position = 3;
				carambola_position = 5;
			}

			$.ajax({
				type: "POST",
				url:  'http://www.puckermob.com/admin/assets/php/ajaxfunctions.php',
				data: { article_id: article_id, task:'article_ads' },
				success: function (data) {
					if(data != 'false'){
						var info = $.parseJSON(data);
						//console.log(info.desk_google);
						google_position  = parseInt(info[0].desk_google);
						//nativo_position = parseInt(info[0].desk_nativo);
						sharethrough_position  = parseInt(info[0].desk_sharethrough);
						carambola_position = parseInt(info[0].desk_carambola);
					}
				},
				async:   false
			});

			console.log("IS LIST ARTICLE? "+isListArticle);

			if( tag == 'p'){ sharethrough_position = sharethrough_position + 1; nativo_position = nativo_position + 1; google_position = google_position + 1;}
			//Google AD
			if(google_position && google_position != -1){
				inBodyAd.loadInArticleAd( 'article-content', google_position, 0, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script><ins class="adsbygoogle" style="display:inline-block;width:637px;height:90px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="5892997788"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>', tag);	
			}

			//CARAMBOLA 
			if(carambola_position && carambola_position != -1){
				/*if($('span.span-category.moblog').length == 0) */
				inBodyAd.loadInArticleAd( 'article-content', carambola_position, 0, ad[adPage].inarticlecarambola, tag);
			}

			//SHARETHROUGH
			if(sharethrough_position && sharethrough_position != -1){
				inBodyAd.loadInArticleAd( 'article-content', sharethrough_position, 0, ad[adPage].inarticlesharet, tag);
			}
		}

		//MULTIPAGE ARTICLES
		if( adPage === 'articleslide'){
			//inBodyAd.loadInArticleAd( 'article-caption', 2, 0, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script><ins class="adsbygoogle" style="display:inline-block;width:637px;height:90px" data-ad-client="ca-pub-8978874786792646" data-ad-slot="5892997788"><\/ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>', 'p');	
			inBodyAd.loadInArticleAd( 'article-caption', 4, 0, '<div data-str-native-key="58ad4c02" style="display: none;"><\/div><script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"><\/script>', 'p');
				
		}

		//BTF1
		loadAd(select.ad.btf1, ad[adPage].btf1);

		//BTF2
		loadAd(select.ad.btf2, ad[adPage].btf2);
	}
	//BTF3
	if( page === 'home' ||  page === 'category'){
		if(hasSponsored == undefined || hasSponsored == 0){
		loadAd(select.ad.btf3, ad[adPage].btf3);
		}
	}

	$(window).resize(function() {

		resizeMainOnResize();
	});
}

	// If is Desktop
	if(!$('body').hasClass('mobile')) {
		iFrameResize({
			checkOrigin: false,
			sizeWidth: true,
			//maxWidth: 1000,
			log: true,

			resizedCallback: function(messageData){
				var label = messageData.id.slice(0, -10);
				var container = select.ad[label];

				var classToAdd = 'ad-unit hide-for-print';
				if((label === 'atf' || label === 'atfleft' || label === 'atfright') && messageData.height > 500) {
					if( (label === 'atf' || label === 'atfleft' || label === 'atfright') && messageData.height < 700) {
						classToAdd += ' ad300 ad600'; asideHeight[label] = 600 + asideHeight.margin; resizeMainOnAdLoad();
					}
					else { classToAdd += ' ad300 ad1050'; asideHeight[label] = 1050 + asideHeight.margin; resizeMainOnAdLoad();}
				}
				else if(label === 'atf' || label === 'btf1' || label === 'btf2' || label === 'btf3') { classToAdd += ' ad300 ad250'; asideHeight[label] = 251 + asideHeight.margin; resizeMainOnAdLoad();}
				else if(label === 'atfleft') { classToAdd += ' ad300 ad250 left'; asideHeight[label] = 251 + asideHeight.margin; resizeMainOnAdLoad();}
				else if( label === 'atfright') { classToAdd += ' ad300 ad250 right'; asideHeight[label] = 251 + asideHeight.margin; resizeMainOnAdLoad();}
				else if(label === 'header' || label === 'footer') {
					if(label === 'footer' || (label === 'header' && messageData.height < 110 && messageData.height > 80)) {classToAdd += ' ad90';}
					else if(label === 'header' && messageData.height < 80) {Foundation.utils.S("#header-ad").css("min-height", messageData.height);}					
					if(messageData.width < 500) {classToAdd += ' ad320';}
					else if(messageData.width < 780) {classToAdd += ' ad728';}
					else if(messageData.width < 1200) {classToAdd += ' ad980';}
				} else if(label === 'medianet') {classToAdd += ' show-ad padding-right show-for-xxlarge-only'; Foundation.utils.S('hr.hr-hidden').removeClass('hr-hidden');}
				else if(label === 'lift') {classToAdd += 'row half-margin'}
					if( container != null ) container.setAttribute("class", classToAdd);
			}
		});
}

var body = document.body;
	
/* slide menu left */
if( $( ".toggle-slide-left" ).length > 0){
    $( ".toggle-slide-left" ).on( "click", function(){
		$(body).toggleClass("sml-open");
		$(this).toggleClass("open-menu");

    } );
}


$('#menu-options li').on('click', function(e){
	e.preventDefault();

	var this_li = $(this);
	var this_a = $(this_li).find('a').attr('id');

	var div_cont = $('.slide-menu-left').find("[data-info='" + this_a + "']");

	$('.tap-articles').hide();
	$('#menu-options').find('a').removeClass('current');
	$(div_cont).show();
	$('#'+this_a).addClass('current');

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
 	
 	/*console.log('FACEBOOK SHARES');
 	$.ajax({
        type: 'GET',
        dataType: 'jsonp',
        data: {},
        url: "http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls="+location.href,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR FACEBOOK");
            console.log(jqXHR)
        },
        success: function (msg) {
        	console.log("SUCCESS FACEBOOK");
            console.log(msg);
        }
    });
 	console.log("================");
 	
 	console.log('LINKEDIN SHARES');
 	$.ajax({
        type: 'GET',
        dataType: 'jsonp',
        data: {},
        url: "http://www.linkedin.com/countserv/count/share?url="+location.href,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR LINKEDIN");
            console.log(jqXHR)
        },
        success: function (msg) {
        	console.log("SUCCESS LINKEDIN");
            console.log(msg);
        }
    });
 	console.log("================");


 	console.log('PINTEREST SHARES');
 	$.ajax({
        type: 'GET',
        dataType: 'jsonp',
        data: {},
        url: "http://widgets.pinterest.com/v1/urls/count.json?source=6&url="+location.href,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR PINTEREST");
            console.log(jqXHR)
        },
        success: function (msg) {
        	console.log("SUCCESS PINTEREST");
            console.log(msg);
        }
    });
 	console.log("================");

 	
 	
 	console.log('stumbleupon SHARES');
 	$.ajax({
        type: 'GET',
        dataType: 'jsonp',
        data: {},
        url: "http://www.stumbleupon.com/services/1.01/badge.getinfo?url="+location.href,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR stumbleupon");
            console.log(textStatus);
        },
        success: function (msg) {
        	console.log("SUCCESS stumbleupon");
            console.log(msg);
        }
    });
 	console.log("================");

 	console.log('DELICIOUS SHARES');
 	$.ajax({
        type: 'GET',
        dataType: 'jsonp',
        data: {},
        url: "http://feeds.delicious.com/v2/json/urlinfo/data?url="+location.href,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR DELICIOUS");
            console.log(jqXHR)
        },
        success: function (msg) {
        	console.log("SUCCESS DELICIOUS");
            console.log(msg);
        }
    });
 	console.log("================");
 	
 	console.log('TWITTER SHARES');
 	$.ajax({
        type: 'GET',
        dataType: 'jsonp',
        data: {},
        url: "http://cdn.api.twitter.com/1/urls/count.json?url="+location.href,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR TWITTER");
            console.log(jqXHR)
        },
        success: function (msg) {
        	console.log("SUCCESS TWITTER");
            console.log(msg);
        }
    });
    console.log("================");
*/
 	
 	

 	//Prefetch Links
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

//Social Shares Tracking FB Sharing Functionality
var SocialShares = {
	updateFBShare: function( count, article_id ){
		$.post("http://www.puckermob.com/assets/ajax/ajaxManageData.php", {"count" : count, "articleId" : article_id}, function(data) {} );
	},

	fbEventHandler: function(evt) { 
		if (evt.type == 'addthis.menu.share' && evt.data.service == 'facebook') { 
			console.log(evt.data.service);
	     	   addthis.sharecounters.getShareCounts('facebook', function(obj) {        
	    		console.log(obj.count);
	    		var count = obj.count;
	    		var article_id = Foundation.utils.S('#article_id').val();
	    		SocialShares.updateFBShare( count, article_id );
	    	});
	  	}
	  }
	}
	
	// Listen to events	
	if(page === 'article' || page === 'articleslide') {
		console.log('ADDTHIS');
		console.log(addthis);
		addthis.sharecounters.getShareCounts('facebook', function(obj) {        
		    console.log("IN");
		    console.log(obj);
		});
		addthis.addEventListener('addthis.menu.share', SocialShares.fbEventHandler);
	}


//Scroll Window 
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


/* DETECT SCROLLLING POSITION */
function isOnScreen( element ) {

	var win = $(window);

	var viewport = {
		top : win.scrollTop(),
		left : win.scrollLeft()
	};
	viewport.right = viewport.left + win.width();
	viewport.bottom = viewport.top + win.height();

	var bounds = element.offset();
	bounds.right = bounds.left + element.outerWidth();
	bounds.bottom = bounds.top + element.outerHeight();

	return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

}

	/* Every time the window is scrolled ... */
	// Alert a message when the AddThis API is ready
	function addthisReady(evt) {
		if(isOnScreen($('#social-buttons'))){
			$('#at4-share').removeClass('social-show').addClass('at4-hide');
		}else{
			$('#at4-share').removeClass('at4-hide').addClass('social-show');
		}
	}

	function kFormatter(num) {
    	return num > 999 ? (num/1000).toFixed(1) + 'k' : num
	}

	//Get Total Shares For an Article
	/*$.get(
		"http://www.puckermob.com/assets/ajax/ajaxManageData.php", 
		{"url" : location.href, "articleId" : Foundation.utils.S('#article_id').val()}, 
		function(shares) {
			console.log("SHARES FROM ME");
			console.log(shares);
			//$(".shares_counter").text(kFormatter(shares));
		} 
	);*/


//READ MORE 
/*if($('body').hasClass('mobile')) {
	var $el, $ps, $up, totalHeight;
	var parentOrgHeight = $('#article-content').outerHeight();
	var wishDisplayHeight = parentOrgHeight * 0.55;
	$('#article-content').height(wishDisplayHeight);

	$(".sidebar-box .button").click(function() {
				
		// IE 7 doesn't even get this far.
								
		totalHeight = 0
			
		$el = $(this);
		$p  = $el.parent();
		$up = $p.parent();
		$children = $up.children();
		$shTAdHeight = $('.inarticle-ad').outerHeight();
		
		$children.each(function(){
			totalHeight += $(this).outerHeight();
		});
		
		totalHeight +=  $shTAdHeight;
										
		$up.css({
				// Set height to prevent instant jumpdown when max height is removed
				"height": $up.height(),
				"max-height": 9999
		 });
		$up.animate({
				"height": "auto"
		 },2000);
					
		// fade out read-more
		$p.fadeOut();
		$('#grad').fadeOut();
						
		// prevent jump-down
		return false;
						
	});
}*/

$('#follow-author').click(function(e){
	e.preventDefault();

	if( $('#ss_user_email').val().length < 1  ){
		$('body').addClass('show-modal-box');
	}else{
		 var author_id = $('#ss_author_id').val(),
		 user_email = $('#ss_user_email').val();

		if( author_id != '0' && user_email != ''){
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: { task: 'follow-author', user_email: user_email, author_id: author_id},
            //url: "http://localhost:8888/projects/pucker-mob//httpdocs/assets/ajax/ajaxmultifunctions.php",
            url: "http://www.puckermob.com/assets/ajax/ajaxmultifunctions.php",
            success: function (msg) {
                if(msg['hasError']) $('#login-result').html(msg['message']).attr('style', 'color:red; text-transform: inherit;');
                else{
                	var email = msg['email'],
                	container = $('#follow-the-author-bg');
                	$('#ss_user_email').val(email);

                	$(container).html('<label class="follow-author" ><i class="fa fa-check"></i>Author Followed</label>');
                    $('body').removeClass('show-modal-box');
                    $('.top-header-logout').find('.welcome-email span').html('Welcome, '+email);
                    $('.top-header-logout').find('#image-header-profile').attr('src', msg['user_img']);
                    $('.top-header-login').attr('style', 'display:none !important');
                    $('.top-header-logout').attr('style', 'display:inherit !important');
                    $('#follow-msg').html(msg['message']);
                    $('#my-account-header-link').attr('href', 'http://www.puckermob.com/admin/following/');
                	$('body').addClass('show-modal-box-follow');
                   
                }
            }
     	});
    	}
	}
});

$('.close').click(function(e){
	$('body').removeClass('show-modal-box');
	$('body').removeClass('show-modal-box-follow');
});

$('#register-link').click(function(e){
	e.preventDefault();
	$('#login-box').hide();
	$('#register-box').show();
});

$('#login-link').click(function(e){
	e.preventDefault();
	$('#register-box').hide();
	$('#login-box').show();
});


$('.ajax-form-submit').click(function(e){
	e.preventDefault();
	var dataString = '';	
	var form = $(this).parent('form'),
	task = $(form).attr('data-info-task');

	if(task === 'register-reader'){
		$(form).dynamicRegisterContent();
	}else if(task === 'login-reader'){
		$(form).dynamicLoginContent();
	}
});

if($('#warning-icon')){
	$('#warning-icon').on('click', function(e){
		e.stopPropagation();
		$('#dd-shares-content').slideToggle('slow');

	});
}


});

