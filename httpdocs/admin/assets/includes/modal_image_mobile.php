<!-- MODAL -->
<div id="img-modal" class="reveal-modal tiny border-radius-10x" data-reveal aria-labelledby="intro-modal-title" aria-hidden="true" role="dialog" style="margin-top: 1.7rem; min-height: auto !important; ">
  <a href="#close" title="Close" class="close">X</a>

  <h2 style="font-family: OswaldRegular; font-size: 22px;" id="modalTitle">IMAGE CROPPING & RESIZING TOOLS</h2>
  	<p style="font-size: 15px;">If you need help cropping or resizing your images, try one of these sites or apps: </p>
	<p style="margin-bottom: 5px;">
		<i class="fa fa-caret-right" style="margin-right: 0px; font-size: 18px;" aria-hidden="true"></i>
		<a style="color: #222;" href="http://webresizer.com/" target="_blank">Web Resizer (web site)</a>
	</p>
	<p style="margin-bottom: 5px;">
		<i style="margin-right: 0px; font-size: 18px;" class="fa fa-caret-right" aria-hidden="true"></i>
		<a style="color: #222;" href="http://imageresize.org/" target="_blank">ImageResize (web site)</a>
	</p>
	<p style="margin-bottom: 5px;">
		<i style="margin-right: 0px; font-size: 18px;" class="fa fa-caret-right" aria-hidden="true"></i>
		<i style="margin-right: 0px; font-size: 18px;" class="fa fa-apple" aria-hidden="true"></i>
		<a style="color: #222;" href="https://appsto.re/us/RRvwY.i" target="_blank">Resize it Free (iPhone app)</a>
	</p>
	<p style="margin-bottom: 5px;">
		<i style="margin-right: 0px; font-size: 18px;" class="fa fa-caret-right" aria-hidden="true"></i>
		<i style="margin-right: 0px; font-size: 18px;" class="fa fa-android" aria-hidden="true"></i>
		<a style="color: #222;" href="https://play.google.com/store/apps/details?id=com.iudesk.android.photo.editor&hl=en" target="_blank">Photo Editor (Android app)</a>
	</p>
	<p class="">Images must be exactly 784x431</p>
</div>
<script>
	$(document).foundation().foundation();

	$('body').addClass('show-modal-box');
		$('.close').click(function(e){
			$('body').removeClass('show-modal-box');
		});
</script>