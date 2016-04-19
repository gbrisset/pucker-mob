
<?php 
  $has_sponsored = 0;
  if ( isset($isArticle) && $isArticle ){?>
  <aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print" style="">
      <!-- LELO -->
      <?php if(isset($articleInfoObj['article_id']) && $articleInfoObj['article_id'] != 14479 && $articleInfoObj['article_id'] != 14576 ){?>
              
      <div id="atf-ad" class="ad-unit ad300 show-on-large-up" style="height:auto;">
        <div id="ros_1195"></div> 
      </div>
      <?php }else{?>
          <div id="atf-ad" class="ad-unit ad300 show-on-large-up" style="height:auto;">
                <a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/breaking_news_300x250_v1.gif" /></a>
          </div>
      <?php }?>
    
      <!-- MOST POPULAR -->
      <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>

       <!-- LELO -->
      <?php if(isset($articleInfoObj['article_id']) && $articleInfoObj['article_id'] != 14479 && $articleInfoObj['article_id'] != 14576 ){?>
      <?php if($articleInfoObj['article_id'] != 8560){ ?>
        <div id="btf1-ad" class="ad-unit ad300" style="height:auto;">
            <div id="ros_1201"></div> 
        </div>
      <?php } ?>

      <section id="sub-sidebar-3" class="sidebar show-on-large-up"  style="margin: 0.9375rem 0 !important;">
         <?php include_once($config['include_path'].'widget.php'); ?>
      </section>

      <?php }else{?>
         <div id="btf1-ad" class="ad-unit ad300" style="height:auto;">
          <a href="https://www.indiegogo.com/projects/remoji-the-app-that-will-control-your-sex-life--7/?utm_source=display-network&utm_medium=banner&utm_content=puckermob&utm_campaign=remoji-idgg-banners-32016-global" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/shaking_app_300x250_v2.gif" /></a>
       </div>
      <?php }?>
      

      <section id="sub-sidebar-2" class="sidebar sticky" style="padding-top:10px; ">
            <a href="https://www.facebook.com/puckermob" target="_blank"> <img src="http://www.puckermob.com/assets/img/homepage/likeuson.jpg" style="margin-bottom: 8px;"></a>
            <a href="http://sequelmediainternational.com/contact" target="_blank"> <img src="http://www.puckermob.com/assets/img/homepage/WriteForPuckerMob.jpg" style="margin-bottom:15px;"></a>
            <a href="#" class="back-to-top btn"> Back to top  &#8682; </a>
      </section>
</aside>
<?php }else{ ?>
<aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print home">
      <style>
.fixed-width-sidebar{width: auto !important;}
      </style>
      <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>
     
      <div id="btf1-ad" class="ad-unit ad300 show-on-large-up" style="height: auto;">
        <div id="home_1185"></div> 
      </div>
      
      <div id="btf2-ad" class="ad-unit ad300"  style="height: auto;">
          <div id="home_1187"></div> 
      </div>
      
      <?php if( !isset($isHomepage) ){ ?>
        <section id="sub-sidebar-3" class="sidebar show-on-large-up"  style="margin: 0.9375rem 0 !important;">
           <?php include_once($config['include_path'].'widget.php'); ?>
        </section>
      <?php } ?>
        
          <div id="btf3-ad" style="margin-top: 1rem !important; " class="ad-unit ad300"  style="height: auto;">
            <div id="home_1183"></div> 
          </div>
          
          <section id="sub-sidebar-2" class="sidebar sticky" style="padding-top:10px; ">
            <a href="https://www.facebook.com/puckermob" target="_blank"> <img src="http://www.puckermob.com/assets/img/homepage/likeuson.jpg" style="margin-bottom: 8px;"></a>
            <a href="http://sequelmediainternational.com/contact" target="_blank"> <img src="http://www.puckermob.com/assets/img/homepage/WriteForPuckerMob.jpg" style="margin-bottom:15px;"></a>
                    <a href="#" class="back-to-top btn"> Back to top  &#8682; </a>
          </section>
          </aside>
      <?php  
  }?>
