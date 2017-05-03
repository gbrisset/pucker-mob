
<?php 
  $has_sponsored = 0;
  if ( isset($isArticle) && $isArticle ){?>
  <aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print" style="">
    <!-- MOST POPULAR -->
    <?php 

    include_once($config['include_path'].'mostpopularrticles.php');
    // // include($config['include_path'] . 'ads/dsk_sidebar_amazon.php');
    // include($config['include_path'] . 'ads/dsk_sidebar_video_answers.php');

       echo $smf_adManager->display_tags("dsk_sidebar_2", $article_id);


     ?>
      
</aside>
<?php }else{ ?>
<aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print home">
    <!-- MOST POPULAR -->
    <?php 

    include_once($config['include_path'].'mostpopularrticles.php');
    // // include($config['include_path'] . 'ads/dsk_sidebar_amazon.php');
    // include($config['include_path'] . 'ads/dsk_sidebar_video_answers.php');

       echo $smf_adManager->display_tags("dsk_sidebar_2", $article_id);

     ?>
  
    <section id="sub-sidebar-2" class="sidebar sticky"">
      <a href="https://www.facebook.com/puckermob" target="_blank"> <img src="http://www.puckermob.com/assets/img/homepage/likeuson.jpg" style="margin-bottom: 8px;"></a>
      <a href="http://www.puckermob.com/login"> <img src="http://www.puckermob.com/assets/img/homepage/WriteForPuckerMob.jpg" style="margin-bottom:15px;"></a>
      <a href="#" class="back-to-top btn"> Back to top  &#8682; </a>
    </section>
</aside>
<?php  }?>
