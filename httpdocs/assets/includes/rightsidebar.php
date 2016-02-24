
<?php 
  $has_sponsored = 0;
  if ( isset($isArticle) && $isArticle ){?>
  <aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print" style="">

      <div id="atf-ad" class="ad-unit ad300 show-on-large-up" style="height:auto;">
        <div id="ros_1195"></div> 
      </div>
    
      <!-- MOST POPULAR -->
      <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>

      <div id="btf1-ad" class="ad-unit ad300" style="height:auto;">
          <div id="ros_1201"></div> 
      </div>
       
      <section id="sub-sidebar-3" class="sidebar show-on-large-up"  style="margin: 0.9375rem 0 !important;">
         <?php include_once($config['include_path'].'widget.php'); ?>
      </section>

      <section id="sub-sidebar-2" class="sidebar article-stick hide" style="padding-top:10px; ">
            <a href="https://www.surveymonkey.com/r/QMXVYTC"> <img src="https://s3.amazonaws.com/pucker-mob/images/midnight.png"></a>
            <a href="http://www.puckermob.com/admin/register/"> <img src="https://s3.amazonaws.com/pucker-mob/images/themob.png" style="margin-bottom:15px;"></a>
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
            <a href="https://www.surveymonkey.com/r/QMXVYTC"> <img src="https://s3.amazonaws.com/pucker-mob/images/midnight.png"></a>
            <a href="http://www.puckermob.com/admin/register/"> <img src="https://s3.amazonaws.com/pucker-mob/images/themob.png" style="margin-bottom:15px;"></a>
                    <a href="#" class="back-to-top btn"> Back to top  &#8682; </a>
          </section>
          </aside>
      <?php  
  }?>
