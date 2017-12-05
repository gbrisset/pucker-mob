<?php


/*


	
	<!-- COMSCORE -->
		<script>
		  var _comscore = _comscore || [];
		  _comscore.push({ c1: "2", c2: "18667744" });
		  (function() {
		    var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
		    s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
		    el.parentNode.insertBefore(s, el);
		  })();
		</script>
		<noscript>
		  <img src="http://b.scorecardresearch.com/p?c1=2&c2=18667744&cv=2.0&cj=1" />
		</noscript>
	<!-- End COMSCORE Tag -->

	<!-- Quantcast Tag -->
		<script type="text/javascript">
		  var _qevents = _qevents || [];

		  (function() {
		  var elem = document.createElement('script');
		  elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
		  elem.async = true;
		  elem.type = "text/javascript";
		  var scpt = document.getElementsByTagName('script')[0];
		  scpt.parentNode.insertBefore(elem, scpt);
		  })();

		  _qevents.push({
		  qacct:"p-B2Jsd5NDNU3Qq"
		  });
		</script>
		<noscript>
		  <div style="display:none;">
		    <img src="//pixel.quantserve.com/pixel/p-B2Jsd5NDNU3Qq.gif" border="0" height="1" width="1" alt="Quantcast"/>
		  </div>
		</noscript>





*/


/* 
find word count in fields

SELECT (LENGTH(article_body) - LENGTH(REPLACE(article_body, ' ', ''))+1) as wordcount, LENGTH(article_body) as textlength FROM smf_articles where (LENGTH(article_body) - LENGTH(REPLACE(article_body, ' ', ''))+1)>1000 ORDER BY `textlength` ASC


*/

// header("Content-Type: application/rss+xml; charset=UTF-8");
// header('Content-type: application/xml');

require_once('../assets/php/config.php');


// $article_body = "ajsgajksga <H3>QWERTY<h2> <br><br> </h2>AZERTY</H3> dsgdsgdfg";
// echo "\n\n". $article_body;

// $pattern = "/h[3-6]>/i";
// $replacement = "h2>";
// $article_body = preg_replace (  $pattern ,  $replacement ,  $article_body);

// $patterns[] = "/<p>(<br>|\s)*<\/p>/i";
// $patterns[] = "/<li>(<br>|\s)*<\/li>/i";
// $patterns[] = "/<b>(<br>|\s)*<\/b>/i";
// $patterns[] = "/<i>(<br>|\s)*<\/i>/i";
// $patterns[] = "/<h[1-2]>(<br>|\s)*<\/h[1-2]>/i";
// $replacement = "";
// $article_body = preg_replace (  $patterns ,  $replacement ,  $article_body);



	// $skin = $k%4;
	// $ddd = new debug($article_body,0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	



// 6148		the-heartbreak-of-being-in-love-with-someone-you-can-never-be-with
// 8610		23-signs-youve-found-your-better-half
// 8625		your-friends-isnt-a-best-friend-until-the-12-stages-of-friendship
// 9690		10-signs-youre-dating-the-man-youre-supposed-to-marry-not-just-date
// 10078	10-things-you-learn-when-you-fall-for-someone-with-a-child
// 10953	to-my-toxic-half,-this-is-my-final-bow-and-last-goodbye
// 11373	an-open-letter-to-the-girl-i-used-to-call-my-best-friend
// 28111	every-year-the-world-stops-to-let-me-remember-you
// 31767	to-the-girl-i-used-to-call-my-best-friend
// 32860	this-is-what-youll-miss-when-shes-had-enough
// 34178	you-lost-her-and-honestly-its-your-own-fault

// $cvs_id_list = '6148	, 8610	, 8625	, 9690	, 10078	, 10953	, 11373	, 28111	, 31767	, 32860	, 34178 ';





$articles_list = $mpArticle->get_articles_FB_rss_TEST(); 
		// $ddd = new debug($articles_list,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
		// exit();
	// echo "So far so good - Line # " . __LINE__ ; exit();

//Feed variables setup
$feed_date_updated = date("Y-m-d\Th:i:s\Z", strtotime("now"));
$item_list = "";

foreach ($articles_list as $k =>$article) {


	// ** ARTICLE VARIABLES *************************************************
	
	 // -- Article data ------------------------------
	$article_id = $article['article_id'];
	$article_guid = $article_id . "-" . md5($article_id) . "#2";
	$article_title = $article['article_title'];
	$article_body = $article['article_body'];
	$article_desc = $article['article_desc'];
	// $article_tags = $article['article_tags']; //unused as of now - 2017-11-13


	 // -- urls ------------------------------
	$article_seo_title = $article['article_seo_title'];
	$cat_dir_name = $article['cat_dir_name'];
		$article_url = "http://www.puckermob.com/" . $cat_dir_name . "/" . $article_seo_title;
		$article_img_url = "http://images.puckermob.com/articlesites/puckermob/large/" . $article_id  . "_tall.jpg";

	 // -- dates ------------------------------
	$date_created = $article['creation_date'];
		$date_created_text = date("F jS, g:i A", strtotime($date_created));
		$date_created_attr = date("Y-m-d\Th:i:s\Z", strtotime($date_created));

	$date_updated = $article['date_updated'];
		$date_updated_text = date("F jS, g:i A", strtotime($date_updated));
		$date_updated_attr = date("Y-m-d\Th:i:s\Z", strtotime($date_updated));

	 // -- contributor ------------------------------
	$contributor_name = $article['contributor_name'];



	// ** BODY TEXT PROCESSING *************************************************
	//This makes HTML FB instant articles compliant.
	$pattern = "/h[3-6]>/i";
	$replacement = "h2>";
	$article_body = preg_replace (  $pattern ,  $replacement ,  $article_body);

	$patterns[] = "/<strong>(<br>|\s)*<\/strong>/i";
	$patterns[] = "/<p>(<br>|\s)*<\/p>/i";
	$patterns[] = "/<li>(<br>|\s)*<\/li>/i";
	$patterns[] = "/<b>(<br>|\s)*<\/b>/i";
	$patterns[] = "/<i>(<br>|\s)*<\/i>/i";
	$patterns[] = "/<h[1-2]>(<br>|\s)*<\/h[1-2]>/i";
	$replacement = "";
	$article_body = preg_replace (  $patterns ,  $replacement ,  $article_body);
	$article_body = preg_replace (  $patterns ,  $replacement ,  $article_body); //rerun to treat nested tags
	$article_body = preg_replace (  $patterns ,  $replacement ,  $article_body); //rerun to treat nested tags

	/*
	This generic regex did not work in real life (works in tetsters, though)
	<([A-Z][A-Z0-9]*)>(<br>|\s)*</\1>

	*/




	// ** ANALYTICS TEMPLATES - GOOGLE ***************************************

	$analytics_tag_google = <<<ANALYTICS_TAG_GOOGLE


		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		 

			ga('create', 'UA-6839498-81', 'auto');
			ga('require', 'displayfeatures');
			ga('set', 'campaignSource', 'Facebook');
			ga('set', 'campaignMedium', 'Social Instant Article');
			ga('set', 'title', 'FBIA: '+ia_document.title);
			ga('set', 'referrer', ia_document.referrer);
			ga('send', 'pageview');
		 
		</script> 

ANALYTICS_TAG_GOOGLE;
//Heredocs closing tags must be void of newlines, spaces or nay other characters



	// ** ARTICLE PROCESSING *************************************************

	$article_template = <<<ARTICLE_TEMPLATE

	<!doctype html>
	<html lang="en" prefix="op: http://media.facebook.com/op#">
	  <head>
	    <meta charset="utf-8">
	    <link rel="canonical" href="$article_url">
	    <meta property="op:markup_version" content="v1.0">
		<meta property="fb:use_automatic_ad_placement" content="enable=true ad_density=default">
	  </head>
	  <body>
	    <article>
	      <header>
	        <!-- The title and subtitle shown in your Instant Article -->
	        <h1>$article_title</h1>


	        <!-- The date and time when your article was originally published -->
		        <time class="op-published" datetime="$date_created_attr">$date_created_text</time>

	        <!-- The date and time when your article was last updated -->
		        <time class="op-modified" dateTime="$date_updated_attr">$date_updated_text</time>

	        <!-- The authors of your article -->
		        <address>
		          <a>$contributor_name</a>
		        </address>

	        <!-- The cover image shown inside your article --> 
		        <figure>
		          <img src="$article_img_url" />
			    </figure>   

			<!-- Ad to be automatically placed throughout the article -->
			 <section class="op-ad-template">

			<!-- FB audience network #1 -->
				<figure class="op-ad">
				  <iframe width="300" height="250" style="border:0; margin:0;" src="https://www.facebook.com/adnw_request?placement=364763157304584_364778947303005&adtype=banner300x250"></iframe>
				</figure>

			<!-- Nativo One -->
		        <figure class="op-ad">
				  <iframe >
					<script type="text/javascript" src="//s.ntv.io/serve/load.js" async></script>
					<div id="nativo-id"></div>
				  </iframe>
				</figure>

			<!-- FB audience network #2 -->
				<figure class="op-ad">
				  <iframe width="300" height="250" style="border:0; margin:0;" src="https://www.facebook.com/adnw_request?placement=364763157304584_367025620411671&adtype=banner300x250"></iframe>
				</figure>


			<!-- FB audience network #3 -->
				<figure class="op-ad  op-ad-default">
				  <iframe width="300" height="250" style="border:0; margin:0;" src="https://www.facebook.com/adnw_request?placement=364763157304584_367025647078335&adtype=banner300x250"></iframe>
				</figure>

			<!-- FB audience network #4 -->
				<figure class="op-ad">
				  <iframe width="300" height="250" style="border:0; margin:0;" src="https://www.facebook.com/adnw_request?placement=364763157304584_367025667078333&adtype=banner300x250"></iframe>
				</figure>

			 </section>
			<!-- End of Ad to be automatically placed throughout the article -->
		

	      </header>

	      <!-- ----------- Article body ----------------------------------------------- -->
		  <body>
		    <!-- Google Analytics ------------------------------------------------ -->
				<figure class="op-tracker">
				    <iframe>
					    $analytics_tag_google
				    </iframe>
				</figure>

		    <!-- End of Google Analytics ---------------------------------------- -->


		      $article_body 

		  </body>
	      <!-- ----------- end of Article body ----------------------------------------------- -->
	    </article>
	  </body>
	</html>


ARTICLE_TEMPLATE;
//Heredocs closing tags must be void of newlines, spaces or nay other characters

	// ** ITEM PROCESSING *************************************************


	$item_template = <<<ITEM_TEMPLATE

	      <!-- ****************** ITEM BEGINS #$k ************************************************** -->

	    <item>
	      <title>$article_title</title>
	      <link>$article_url</link>
	      <guid>$article_guid</guid>
	      <pubDate>$date_created_attr</pubDate>
	      <author>$contributor_name</author>
	      <description>$article_desc</description>
	      <content:encoded>
	        <![CDATA[

	      <!-- ----------- Article template ----------------------------------------------- -->

				$article_template

	      <!-- ----------- end of Article template ----------------------------------------------- -->

	        ]]>
	      </content:encoded>
	    </item>

	      <!-- ****************** ITEM ENDS #$k ************************************************** -->

ITEM_TEMPLATE;
//Heredocs closing tags must be void of newlines, spaces or nay other characters

	// ** ITEM LIST PROCESSING *************************************************

	$item_list .=   $item_template;


}//end foreach ($articles_list as $article) 

	// ** FEED PROCESSING *************************************************

$feed_template = <<<FEED_TEMPLATE
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
  <channel>
    <title>Pucker MOB</title>
    <link>http://www.puckermob.com/</link>
    <description>We are all part of it</description>
    <language>en-us</language>
    <lastBuildDate>$feed_date_updated</lastBuildDate>
   
	 $item_list


  </channel>
</rss>
FEED_TEMPLATE;
//Heredocs closing tags must be void of newlines, spaces or nay other characters
echo($feed_template);

?>