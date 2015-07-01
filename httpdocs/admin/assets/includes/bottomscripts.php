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
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js"></script>
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

	  // Load the Visualization API 
	  google.load("visualization", "1.1", {packages:["bar"]});

	  $('input[name="daterange"]').val(moment().subtract(7, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
 
    $('input[name="daterange"]').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment().subtract(7, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: { days: 60 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
           //'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }); 

	var chart_info = [];
	//chart_info.push([" ", " "]);


    function getChartData(start_date, end_date){
    	var info = {};
    	console.log('here');
    	$.ajax({
			type: "POST",
			url:  '<?php echo $config['this_admin_url']; ?>assets/php/ajaxfunctions.php',
			data: { task:'get_chart_data', contributor_id : 1123, start_date: start_date, end_date: end_date  }
		}).done(function(data) {
			//console.log(data);
			if( data != false ){ 
				data = $.parseJSON(data);
				$(data).each( function(e){	
					var val = $(this);				
					info = [ val[0].date, val[0].total_usa_pageviews ];
					chart_info.push(info);
				});
			}
		});
//console.log(chart_info);
	};

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker){
	  console.log(picker.startDate.format('YYYY-MM-DD'));
	  console.log(picker.endDate.format('YYYY-MM-DD'));
	  var start_date = picker.startDate.format('YYYY-MM-DD');
	  var end_date = picker.endDate.format('YYYY-MM-DD');

	  getChartData(start_date, end_date);

	  $('input[name="daterange"]').val(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY'));
	});
      	getChartData(moment().subtract(10, 'days').format("YYYY-MM-DD"), moment().format("YYYY-MM-DD"));

	  // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);
      
      function drawChart() {
console.log(chart_info);
        var data = new google.visualization.arrayToDataTable([
          ['', ''],
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


