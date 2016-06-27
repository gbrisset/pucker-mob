

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

<script>
$(function() {	
  $('.editor').froalaEditor({
  	  key: 'UcbaE2hlypyospbD3ali==',
  	  height: 420,
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

<script src="<?php echo $config['this_url']; ?>admin/assets/js/script.php" async></script>
<script src="<?php echo $config['this_url']; ?>/assets/js/main.js"></script>

<?php
	if(get_magic_quotes_gpc()) echo stripslashes($mpArticle->data['article_page_analytics']);
	else echo $mpArticle->data['article_page_analytics'];
?>

<script>
//$(function() {
	//$('#sortable2').sortable();
//});

if($('#fb-login')){
	$('#fb-login').on('click', function(e){
	    FB.login(function(response) {
	  	  checkLoginState();
	    }, {scope: 'public_profile,email'});
	});
}

// Load the Visualization API 
  google.charts.load('current', {'packages':['bar']});
 //google.load('visualization', '1', {packages: ['corechart', 'bar']});

</script>

<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->


