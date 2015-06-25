<script src="<?php echo $config['this_url']; ?>admin/assets/js/jquery.sortable.js"></script>
<script src="<?php echo $config['this_url']; ?>assets/js/jquery.Jcrop.js"></script>
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
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
	$(function() {
		$('#sortable2').sortable();
	});

if($('#fb-login')){
	$('#fb-login').on('click', function(e){
	    FB.login(function(response) {
	  	  checkLoginState();
	    }, {scope: 'public_profile,email'});
	});
}

google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['', 'Percentage'],

          ['6/01', 44],
          ['6/02', 31],
          ['6/03', 12],
          ['6/04', 10],
          ['6/05', 3],
          ['6/06', 10],
          ['6/07', 10],
          ['6/08', 10],
          ['6/09', 10],
          ['6/10', 10]
        ]);

        var options = {
          title: '',
          width: 800,
          legend: { position: 'none' },
          vAxis: {
            minValue: 0,
            ticks: [0, .3, .6, .9, 1]
          },
          animation: {easing: 'in', duration: 200 },
          chart: { title: '',
                   subtitle: '' },
          bars: 'vertical', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'bottom', label: ' '} // Top x-axis.
            }
          },
          bar: { groupWidth: "80%" }
        };

        var chart = new google.charts.Bar(document.getElementById('bar_chart'));
        chart.draw(data, options);
      };
    </script>

<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->


