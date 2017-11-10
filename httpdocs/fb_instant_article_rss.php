<?php


// header("Content-Type: application/rss+xml; charset=ISO-8859-1");

require_once('assets/php/config.php');

// 6148	the-heartbreak-of-being-in-love-with-someone-you-can-never-be-with
// 8610	23-signs-youve-found-your-better-half
// 8625	your-friends-isnt-a-best-friend-until-the-12-stages-of-friendship
// 9690	10-signs-youre-dating-the-man-youre-supposed-to-marry-not-just-date
// 10078	10-things-you-learn-when-you-fall-for-someone-with-a-child
// 10953	to-my-toxic-half,-this-is-my-final-bow-and-last-goodbye
// 11373	an-open-letter-to-the-girl-i-used-to-call-my-best-friend
// 28111	every-year-the-world-stops-to-let-me-remember-you
// 31767	to-the-girl-i-used-to-call-my-best-friend
// 32860	this-is-what-youll-miss-when-shes-had-enough
// 34178	you-lost-her-and-honestly-its-your-own-fault

$cvs_id_list = '6148	, 8610	, 8625	, 9690	, 10078	, 10953	, 11373	, 28111	, 31767	, 32860	, 34178 ';

$articles_list = $mpArticle->get_articles_FB_rss($cvs_id_list); 




foreach ($articles_list as $article) {

//Variable setup
$article_id = $article['article_id'];
$article_title = $article['article_title'];
$article_body = $article['article_body'];
$article_desc = $article['article_desc'];
$article_tags = $article['article_tags'];


$article_seo_title = $article['article_seo_title'];
$cat_dir_name = $article['cat_dir_name'];
	$article_url = "http://www.puckermob.com/" . $cat_dir_name . "/" . $article_seo_title;


$date_created = $article['creation_date'];
	$date_created_text = date("F jS, g:i A", strtotime($date_created));
	$date_created_attr = date("Y-m-d\Th:i:s\Z", strtotime($date_created));

$date_updated = $article['date_updated'];
	$date_updated_text = date("F jS, g:i A", strtotime($date_updated));
	$date_updated_attr = date("Y-m-d\Th:i:s\Z", strtotime($date_updated));

$contributor_name = $article['contributor_name'];

// $ddd = new debug($article_id,0); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
// $ddd = new debug($date_created_text,1); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
// $ddd = new debug($date_created_attr,1); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
// $ddd = new debug($date_updated_text,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
// $ddd = new debug($date_updated_attr,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	



}//end foreach ($articles_list as $article) 





?>



<!--
// ******************************************* article template with placeholders *******************************************
// ******************************************* article template with placeholders *******************************************
// ******************************************* article template with placeholders *******************************************
-->


<!doctype html>
<html lang="en" prefix="op: http://media.facebook.com/op#">
  <head>
    <meta charset="utf-8">
    <link rel="canonical" href="http://example.com/article.html">
    <meta property="op:markup_version" content="v1.0">
  </head>
  <body>
    <article>
      <header>
        <!-- The title and subtitle shown in your Instant Article -->
        <h1>Article Title</h1>


        <!-- The date and time when your article was originally published -->
        <time class="op-published" datetime="2014-11-11T04:44:16Z">November 11th, 4:44 PM</time>

        <!-- The date and time when your article was last updated -->
        <time class="op-modified" dateTime="2014-12-11T04:44:16Z">December 11th, 4:44 PM</time>

        <!-- The authors of your article -->
        <address>
          <a rel="facebook" href="http://facebook.com/brandon.diamond">Brandon Diamond</a>
          Brandon is an avid zombie hunter.
        </address>
        <address>
          <a>TR Vishwanath</a>
          Vish is a scholar and a gentleman.
        </address>

        <!-- The cover image shown inside your article --> 
        <figure>
          <img src="http://mydomain.com/path/to/img.jpg" />
          <figcaption>This image is amazing</figcaption>
        </figure>   

        <!-- A kicker for your article --> 
        <h3 class="op-kicker">
          This is a kicker
        </h3>

      </header>

      <!-- Article body goes here -->

      <!-- Body text for your article -->
      <p> Article content </p> 

      <!-- A video within your article -->
      <figure>
        <video>
          <source src="http://mydomain.com/path/to/video.mp4" type="video/mp4" />
        </video>
      </figure>

      <!-- An ad within your article -->
      <figure class="op-ad">
        <iframe src="https://www.adserver.com/ss;adtype=banner320x50" height="60" width="320"></iframe>
      </figure>

      <!-- Analytics code for your article -->
      <figure class="op-tracker">
          <iframe src="" hidden></iframe>
      </figure>

      <footer>
        <!-- Credits for your article -->
        <aside>Acknowledgements</aside>

        <!-- Copyright details for your article -->
        <small>Legal notes</small>
      </footer>
    </article>
  </body>
</html>

<!-- // ******************************************* end of article template with placeholders ******************************************* -->
<!-- // ******************************************* end of article template with placeholders ******************************************* -->
<!-- // ******************************************* end of article template with placeholders ******************************************* -->


<!--
// ******************************************* sample article *******************************************
// ******************************************* sample article *******************************************
// ******************************************* sample article *******************************************
-->


<!doctype html>
<html lang="en" prefix="op: http://media.facebook.com/op#">
  <head>
    <meta charset="utf-8">
    <link rel="canonical" href="http://example.com/article.html">
    <meta property="op:markup_version" content="v1.0">
  </head>
  <body>
    <article>
      <header>
        <!-- The title and subtitle shown in your Instant Article -->
        <h1>Article Title</h1>


        <!-- The date and time when your article was originally published -->
        <time class="op-published" datetime="2014-11-11T04:44:16Z">November 11th, 4:44 PM</time>

        <!-- The date and time when your article was last updated -->
        <time class="op-modified" dateTime="2014-12-11T04:44:16Z">December 11th, 4:44 PM</time>

        <!-- The authors of your article -->
        <address>
          <a rel="facebook" href="http://facebook.com/brandon.diamond">Brandon Diamond</a>
          Brandon is an avid zombie hunter.
        </address>
        <address>
          <a>TR Vishwanath</a>
          Vish is a scholar and a gentleman.
        </address>

        <!-- The cover image shown inside your article --> 
        <figure>
          <img src="http://mydomain.com/path/to/img.jpg" />
          <figcaption>This image is amazing</figcaption>
        </figure>   

        <!-- A kicker for your article --> 
        <h3 class="op-kicker">
          This is a kicker
        </h3>

      </header>

      <!-- Article body goes here -->

      <!-- Body text for your article -->
      <p> Article content </p> 

      <!-- A video within your article -->
      <figure>
        <video>
          <source src="http://mydomain.com/path/to/video.mp4" type="video/mp4" />
        </video>
      </figure>

      <!-- An ad within your article -->
      <figure class="op-ad">
        <iframe src="https://www.adserver.com/ss;adtype=banner320x50" height="60" width="320"></iframe>
      </figure>

      <!-- Analytics code for your article -->
      <figure class="op-tracker">
          <iframe src="" hidden></iframe>
      </figure>

      <footer>
        <!-- Credits for your article -->
        <aside>Acknowledgements</aside>

        <!-- Copyright details for your article -->
        <small>Legal notes</small>
      </footer>
    </article>
  </body>
</html>

<!-- // ******************************************* end of sample article ******************************************* -->
<!-- // ******************************************* end of sample article ******************************************* -->
<!-- // ******************************************* end of sample article ******************************************* -->



<!--
// ******************************************* sample feed *******************************************
// ******************************************* sample feed *******************************************
// ******************************************* sample feed *******************************************
 -->

<rss version="2.0"
xmlns:content="http://purl.org/rss/1.0/modules/content/">
  <channel>
    <title>News Publisher</title>
    <link>http://www.example.com/</link>
    <description>
      Read our awesome news, every day.
    </description>
    <language>en-us</language>
    <lastBuildDate>2014-12-11T04:44:16Z</lastBuildDate>


    <item>
      <title>This is an Instant Article</title>
      <link>http://example.com/article.html</link>
      <guid>2fd4e1c67a2d28fced849ee1bb76e7391b93eb12</guid>
      <pubDate>2014-12-11T04:44:16Z</pubDate>
      <author>Mr. Author</author>
      <description>This is my first Instant Article. How awesome is this?</description>
      <content:encoded>
        <![CDATA[
        <!doctype html>
        <html lang="en" prefix="op: http://media.facebook.com/op#">
          <head>
            <meta charset="utf-8">
            <link rel="canonical" href="http://example.com/article.html">
            <meta property="op:markup_version" content="v1.0">
          </head>
          <body>
            <article>
              <header>
                <!— Article header goes here -->
              </header>

              <!— Article body goes here -->

              <footer>
                <!— Article footer goes here -->
              </footer>
            </article>
          </body>
        </html>
        ]]>
      </content:encoded>
    </item>
    
 
    
  </channel>
</rss>



<!-- // ******************************************* end of sample feed ******************************************* -->
<!-- // ******************************************* end of sample feed ******************************************* -->
<!-- // ******************************************* end of sample feed ******************************************* -->














