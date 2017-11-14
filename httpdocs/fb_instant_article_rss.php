<?php


// header("Content-Type: application/rss+xml; charset=ISO-8859-1");

   require_once('../assets/php/config.php');

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

$cvs_id_list = '6148	, 8610	, 8625	, 9690	, 10078	, 10953	, 11373	, 28111	, 31767	, 32860	, 34178 ';

$articles_list = $mpArticle->get_articles_FB_rss($cvs_id_list); 

//Feed variables setup
$feed_date_updated = date("Y-m-d\Th:i:s\Z", strtotime("now"));
$item_list = "";

foreach ($articles_list as $k =>$article) {


	// ** ARTICLE VARIABLES *************************************************
	
	 // -- Article data ------------------------------
	$article_id = $article['article_id'];
	$article_guid = $article_id . "-" . md5($article_id);
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

		//unused as of now - 2017-11-13

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
			<figure class="op-ad">
				<iframe src="https://www.adserver.com/ss;adtype=banner300x250" height="300" width="250"></iframe>
			</figure>

	      </header>

	      <!-- ----------- Article body ----------------------------------------------- -->

		      $article_body 

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

	// $skin = $k%4;
	// $ddd = new debug($item_template,$skin); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
	// // exit();


	$item_list .=   $item_template;


}//end foreach ($articles_list as $article) 

	// ** FEED PROCESSING *************************************************

$feed_template = <<<FEED_TEMPLATE


<rss version="2.0"
xmlns:content="http://purl.org/rss/1.0/modules/content/">
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

echo($feed_template);

?>


