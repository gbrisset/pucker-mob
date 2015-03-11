<script src="<?php echo $config['this_url']; ?>admin/assets/js/jquery.sortable.js"></script>

<script src="<?php echo $config['this_url']; ?>assets/js/jquery.Jcrop.js"></script>
<!--<script src="<?php echo $config['this_url']; ?>assets/js/jquery.wysiwyg.js"></script>
<script src="<?php echo $config['this_url']; ?>assets/js/jquery.wysiwyg.link.js"></script>-->

	
	<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
	tinymce.init({

		setup: function (ed) {
			var placeholder = $('#' + ed.id).attr('placeholder');
			if (typeof placeholder !== 'undefined' && placeholder !== false) {
				var is_default = false;

				 ed.on('init', function(args) {
		            // get the current content
			        var cont = ed.getContent();

			        // If its empty and we have a placeholder set the value
			        if (cont.length === 0) {
			          	ed.setContent(placeholder);
			         	 // Get updated content
			          	cont = placeholder;
			        }

			        // convert to plain text and compare strings
			        is_default = (cont == placeholder);

			        // nothing to do
			        if (!is_default) {
			          return;
			        }


		        }).on('focus', function() {
		        // replace the default content on focus if the same as original placeholder
		        	if (ed.getContent() == "<p>"+placeholder+"</p>") {
			          ed.setContent('');
			        }
		      	}).on('blur', function() {
			        if (ed.getContent().length === 0) {
			          ed.setContent(placeholder);
			        }
		      	});
			}
	    },
	    selector: "textarea",
	    //external_plugins: {"nanospell": "<?php echo $config['this_url']; ?>assets/js/nanospell/plugin.js"},
		//nanospell_server: "php",
		//nanospell_dictionary: "en_us",
	    //theme: "modern",
	    plugins: [
	        "jbimages advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table contextmenu paste hr spellchecker"
	    ],
	    menubar : "insert tools",
	    toolbar: "insertfile undo redo | styleselect | bold italic | bullist numlist outdent indent | link  hr |  jbimages | preview spellchecker" ,

    	spellchecker_rpc_url: 'spellchecker.php',
    	//spellchecker_language: 'sv_SE',
	    init_instance_callback : function() {
	     tinyMCE.activeEditor.getContent();
	//     console.log(tinyMCE.activeEditor.getContent());
	 }

	});
</script>

<script type="text/javascript" src="<?php echo $config['this_url']; ?>admin/assets/js/jquery.tooltipster.min.js"></script>
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

<script>
if($('#fb-login')){
	$('#fb-login').on('click', function(e){
		//var tos = $('#tos_agreed-s');
		//$('#tos_agreed-s').attr('checked', true);
		//$('#tos_agreed-s').attr('disabled', true);
	    FB.login(function(response) {
	//    console.log("FB.login");
	  	  checkLoginState();
	    }, {scope: 'public_profile,email'});
	});
}
</script>
<!-- PURE CHAT WINDOW-->
<script type='text/javascript'>(function () { var done = false;var script = document.createElement('script');script.async = true;script.type = 'text/javascript';script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript';document.getElementsByTagName('HEAD').item(0).appendChild(script);script.onreadystatechange = script.onload = function (e) {if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {var w = new PCWidget({ c: '5485ade1-6085-4dc8-8d90-4b9ad158adce', f: true });done = true;}};})();</script>
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->