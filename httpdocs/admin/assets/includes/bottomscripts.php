<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $config["this_url"];?>assets/js/jquery-1.7.2.min.js"><\/script>')</script>
<script src="<?php echo $config['this_url']; ?>admin/assets/js/jquery.sortable.js"></script>

<script src="<?php echo $config['this_url']; ?>assets/js/jquery.Jcrop.js"></script>
<script src="<?php echo $config['this_url']; ?>assets/js/jquery.wysiwyg.js"></script>
<script src="<?php echo $config['this_url']; ?>assets/js/jquery.wysiwyg.link.js"></script>
<script src="<?php echo $config['this_url']; ?>assets/js/plugins.php"></script>
<script src="<?php echo $config['this_url']; ?>admin/assets/js/plugins.php"></script>
<script src="<?php echo $config['this_url']; ?>admin/assets/js/script.php" async></script>

<?php
	if(get_magic_quotes_gpc()) echo stripslashes($mpArticle->data['article_page_analytics']);
	else echo $mpArticle->data['article_page_analytics'];
?>

<script>
	

		$(function() {
			$('#sortable2').sortable();

		});
	

</script>


<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->