<?php
	require_once('config.php');
	require_once ('class.Dashboard.php');
	require_once ('class.CronSocialMediaUpdate.php');

	$cron = new CronSocialMediaInformation($config);
	$dashboard = new Dashboard($config);
	//1- Get All Articles Status = Live.
	$articles = $cron->getArticles();
	$month = date('n');
	$year = date('Y');
//	$apikey = "709226bb97515fd204f07c3d4bac38f78ba009eb";
//"69cfa5b227393e90b620098c7883a89e76626fbf";
	//2- Get Social Media Information From SharedCount for each Article
?>

<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/jquery.min.js"></script>
<script>
	jQuery.sharedCount = function(url, fn) {
	    url = encodeURIComponent(url || location.href);
	    var domain = "//free.sharedcount.com/"; /* SET DOMAIN */
	    var apikey = "709226bb97515fd204f07c3d4bac38f78ba009eb"; /*API KEY HERE*/
	    var arg = {
	      data: {
	        url : url,
	        apikey : apikey
	      },
	        url: domain,
	        cache: true,
	        dataType: "json"
	    };
	    if ('withCredentials' in new XMLHttpRequest) {
	        arg.success = fn;
	    }
	    else {
	        var cb = "sc_" + url.replace(/\W/g, '');
	        window[cb] = fn;
	        arg.jsonpCallback = cb;
	        arg.dataType += "p";
	    }
	    return jQuery.ajax(arg);
	};
</script>
<?php
	foreach( $articles as $article ){
		$cat = $article['cat_dir_name'];
		$url = "http://www.puckermob.com/".$cat."/".$article['article_seo_title'];
		//$url = 'http://www.puckermob.com/entertainment/10-people-who-had-plastic-surgery-to-look-like-a-celeb';
?>
	<script>
		jQuery(document).ready(function($){
			var counts = [];
		    $.sharedCount('<?php echo $url; ?>', function(data){
		    	if(data){
			        var Facebook = {share_count:data.Facebook.share_count,  like_count:data.Facebook.like_count , comment_count:data.Facebook.comment_count };
			        counts = {Facebook: Facebook, Twitter:data.Twitter, Pinterest:data.Pinterest, GooglePlusOne:data.GooglePlusOne, 
			        	Delicious: data.Delicious, StumbleUpon: data.StumbleUpon, LinkedIn:data.LinkedIn};
			      	
			        $.ajax({
					  	type: "POST",
					  	url:  '<?php echo $config["this_url"]; ?>assets/php/cron/updateSocialSharedInfo.php',
					  	data: { counts: counts, article_id:'<?php echo $article["article_id"]; ?>', cat: '<?php echo $cat ?>'  }
					}).done(function(data) {
						//data = JSON.parse(data);
					});
		     	}
			});
 		});
	</script>
<?php 
	}

	//UPDATE CONTRIBUTOR EARNINGS TABLE
	$dashboard->updateContributorsEarnings( $month, $year );

	//4- End ;)
?>