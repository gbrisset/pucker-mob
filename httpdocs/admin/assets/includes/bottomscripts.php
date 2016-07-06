

<script src="<?php echo $config['this_url']; ?>assets/js/dropzone.js"></script>

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

<script src="<?php echo $config['this_url']; ?>admin/assets/js/jquery.sortable.js"></script>
<script src="<?php echo $config['this_url']; ?>assets/js/jquery.Jcrop.js"></script>

<script type="text/javascript" src="<?php echo $config['this_url']; ?>admin/assets/js/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="<?php echo $config['this_url']; ?>assets/js/plugins.php"></script>
<script src="<?php echo $config['this_url']; ?>admin/assets/js/plugins.php"></script>

<script src="<?php echo $config['this_url']; ?>admin/assets/js/script.php" async></script>
<script src="<?php echo $config['this_url']; ?>/assets/js/main.js"></script>

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
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=781998645209691";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

