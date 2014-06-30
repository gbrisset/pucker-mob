<?php
   Header("Content-type: text/xml; charset=UTF-8");
   require_once('../assets/php/config.php');
   $rss = $mpArticle->getArticleRSS();
   //var_dump($rss['articles']);
   // foreach($rss['articles'] as $article){
   //    var_dump(htmlentities($article['article_instructions']));
   //    echo "<br />";
   //    echo "<br />";
   // }
   //var_dump($rss['articles']);
?>
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
   <title><?php echo $mpArticle->data['article_page_name']; ?></title>
   <link><?php echo $mpArticle->data['article_page_full_url']; ?></link>
   <atom:link href="<?php echo $mpArticle->data['article_page_full_url'].'rss/'; ?>" rel="self" type="application/rss+xml" />
   <description><?php echo $mpArticle->data['article_page_desc']; ?></description>
   <category>Recipes</category>
   <language>en-us</language>
   <copyright>Copyright 2013 sequelmediagroup.com, All rights reserved.</copyright>
   <managingEditor>info@sequelmediagroup.com (Sequel Media Group)</managingEditor>
   <webMaster>info@sequelmediagroup.com (Sequel Media Group)</webMaster>
   <image>
      <title><?php echo $mpArticle->data['article_page_name']; ?></title>
      <url><?php echo $config['image_url']; ?>articlesites/logos/simpledish_logo_144.png</url>
      <link><?php echo $mpArticle->data['article_page_full_url']; ?></link>
      <width>144</width>
      <height>40</height>
   </image>
   <pubDate><?php echo date('D, d M Y H:i:s O', strtotime($rss['articles'][0]['creation_date']));?></pubDate>
   <lastBuildDate><?php echo date('D, d M Y H:i:s O', strtotime($rss['articles'][0]['creation_date']));?></lastBuildDate>

   <?php foreach($rss['articles'] as $article){ ?>
      <item>
         <title>![CDATA[<?php echo $article['article_title']; ?>]]</title>
         <description>![CDATA[<?php echo htmlspecialchars(($article['article_desc'])); ?>]]</description>
         <category><?php echo $article['cat_dir_name']; ?></category>
         <link><?php echo $mpArticle->data['article_page_full_url'].$article['parent_dir_name'].'/'.$article['cat_dir_name'].'/'.$article['article_seo_title']; ?></link>
         <guid isPermaLink="true">http://simpledish.com/<?php echo $article['parent_dir_name'].'/'.$article['cat_dir_name'].'/'.$article['article_seo_title']; ?></guid>
         <source url="<?php echo $mpArticle->data['article_page_full_url']; ?>rss/"><?php echo $mpArticle->data['article_page_name']; ?></source>
         <pubDate><?php echo date('D, d M Y H:i:s O', strtotime($article['creation_date']));?></pubDate>
      </item>
   <?php } ?>
</channel>
</rss>
