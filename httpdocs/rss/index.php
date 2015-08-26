<?php
   header('Content-type: application/xml');
   require_once('../assets/php/config.php');
   $rss = $mpArticle->getArticleRSS();

?>
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
   <title>Pucker Mob | We're All Part of It</title>
   <link>http://www.puckermob.com</link>
   <atom:link href="http://www.puckermob.com/rss/" rel="self" type="application/rss+xml" />
   <description>General interest news, information, articles and advice for a world on the move</description>
   <category>Articles</category>
   <language>en-us</language>
   <copyright>Copyright 2013 sequelmediainternational.com, All rights reserved.</copyright>
   <managingEditor>info@sequelmediainternational.com (Sequel Media Group)</managingEditor>
   <webMaster>info@sequelmediainternational.com (Sequel Media Group)</webMaster>
   <image>
      <title>Pucker Mob | We're All Part of It</title>
      <url>http://images.puckermob.com/articlesites/logos/Puckermob_color.png</url>
      <link>http://www.puckermob.com</link>
      <width>203</width>
      <height>29</height>
   </image>
   <pubDate><?php echo date('D, d M Y H:i:s O', strtotime($rss['articles'][0]['creation_date']));?></pubDate>
   <lastBuildDate><?php echo date('D, d M Y H:i:s O', strtotime($rss['articles'][0]['creation_date']));?></lastBuildDate>

   <?php foreach($rss['articles'] as $article){ ?>
      <item>
         <title><![CDATA[<?php echo $article['article_title']; ?>]]></title>
         <description><![CDATA[<?php echo htmlspecialchars(($article['article_desc'])); ?>]]></description>
         <category><?php echo $article['cat_dir_name']; ?></category>
         <link>http://www.puckermob.com/<?php echo $article['cat_dir_name'].'/'.$article['article_seo_title']; ?></link>
         <guid isPermaLink="true">http://www.puckermob.com/<?php echo $article['cat_dir_name'].'/'.$article['article_seo_title']; ?></guid>
         <source url="http://www.puckermob.com/rss/">Pucker Mob | We're All Part of It</source>
         <pubDate><?php echo date('D, d M Y H:i:s O', strtotime($article['creation_date']));?></pubDate>
      </item>
   <?php } ?>
</channel>
</rss>
