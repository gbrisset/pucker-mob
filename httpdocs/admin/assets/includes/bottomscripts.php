<!-- <script src="<?php echo $config['this_url']; ?>assets/js/foundation.min.js"></script>
<script src="<?php echo $config['this_url']; ?>assets/js/dropzone.js"></script> -->

<!-- Include JS files. -->
<script src="<?php echo $config['this_url']; ?>assets/js/froalajs/froala_editor.min.js"></script>

<!-- Include Plugins. -->
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/align.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/char_counter.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/entities.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/link.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/lists.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/quote.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/froalajs/plugins/url.min.js"></script>


<script>

      $(function() {	
          $('.editor').froalaEditor({
          	  key: 'UcbaE2hlypyospbD3ali==',
          	  height: 420,
          	  toolbarSticky: false,
          	  placeholderText: 'Start Writing Here.',
		      toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'underline', 'strikethrough', 'align', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', 'insertLink', 'clearFormatting'],
      		  toolbarButtonsMD: ['bold', 'italic', 'underline', 'strikethrough', 'align', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', 'insertLink', 'clearFormatting'],
      		  toolbarButtonsSM: ['bold', 'italic', 'underline', 'align', 'formatUL', 'quote', 'insertHR', 'insertLink', 'clearFormatting'],
      		  toolbarButtonsXS: ['bold', 'italic', 'align', 'formatUL',  'insertHR', 'insertLink']
          });
      });

</script>

<script src="<?php echo $config['this_url']; ?>admin/assets/js/jquery.sortable.js"></script>
<script src="<?php echo $config['this_url']; ?>assets/js/jquery.Jcrop.js"></script>

<script type="text/javascript" src="<?php echo $config['this_url']; ?>admin/assets/js/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="<?php echo $config['this_url']; ?>assets/js/plugins.php"></script>
<script src="<?php echo $config['this_url']; ?>admin/assets/js/plugins.php"></script>

<script src="<?php echo $config['this_url']; ?>admin/assets/js/script.php?ver=2373" async></script>
<script src="<?php echo $config['this_url']; ?>assets/js/main.js"></script>

<?php
	if(get_magic_quotes_gpc()) echo stripslashes($mpArticle->data['article_page_analytics']);
	else echo $mpArticle->data['article_page_analytics'];
?>

<script>

if($('#fb-login')){
	$('#fb-login').on('click', function(e){
	    FB.login(function(response) {
	  	  checkLoginState();
	    }, {scope: 'public_profile,email'});
	});
}

// Load the Visualization API 
  google.charts.load('current', {'packages':['bar']});

</script>

<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->

<!-- FACEBOOK API -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=108075136519369";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<!-- VALERO CHAT-->
<script type="text/javascript">
    (function(){
        var globals = document.createElement('script');
        globals.src = 'https://galleryuseastprod.blob.core.windows.net/velaroscripts/20307/globals.js';

        var inline = document.createElement('script');
        inline.src = 'https://eastprodcdn.azureedge.net/bundles/velaro.inline.js';

        var scriptNode = document.getElementsByTagName('script')[0];
        scriptNode.parentNode.insertBefore(globals, scriptNode)

        globals.onload = function() {
            scriptNode.parentNode.insertBefore(inline, scriptNode)
        }

        inline.onload = function() {
            Velaro.Globals.ActiveSite = 20307;
            Velaro.Globals.ActiveGroup = 0;
            Velaro.Globals.InlineEnabled = true;
            Velaro.Globals.VisitorMonitoringEnabled = true;
            Velaro.Globals.InlinePosition = 0;
        }
    }())
</script>
<noscript>
    <a href="https://www.velaro.com" title="Contact us" target="_blank">Questions?</a>
    powered by <a href="http://www.velaro.com" title="Velaro live chat">velaro live chat</a>
</noscript>

