<script src="<?php echo $config['this_url']; ?>admin/assets/js/jquery.sortable.js"></script>

<script src="<?php echo $config['this_url']; ?>assets/js/jquery.Jcrop.js"></script>
<!--<script src="<?php echo $config['this_url']; ?>assets/js/jquery.wysiwyg.js"></script>
<script src="<?php echo $config['this_url']; ?>assets/js/jquery.wysiwyg.link.js"></script>-->

	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
	tinymce.init({
		setup: function (ed) {
	        ed.on('init', function(args) {
	            console.debug(args.target.id);
	        });
	    },
	    selector: "textarea",
	    external_plugins: {"nanospell": "http://www.puckermob.com/assets/js/tinymce/nanospell/plugin.js"},
		nanospell_server: "php",
	    theme: "modern",
	    plugins: [
	        "jbimages advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table contextmenu paste hr spellchecker "
	    ],

	    toolbar: "insertfile undo redo | styleselect | bold italic | bullist numlist outdent indent | link  hr |  jbimages | preview",
	    relative_urls:false,
	    init_instance_callback : function() { tinyMCE.activeEditor.getContent();}

	   
	});
</script>

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