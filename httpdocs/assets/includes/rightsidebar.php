
<?php 
  $has_sponsored = 0;
  if ( isset($isArticle) && $isArticle ){?>
  <aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print" style="">
      <!-- LELO -->
      <?php if(isset($articleInfoObj['article_id']) &&  $articleInfoObj['article_id'] != 17425 &&  $articleInfoObj['article_id'] != 16562 &&   $articleInfoObj['article_id'] != 14479 && $articleInfoObj['article_id'] != 14576 && $articleInfoObj['article_id'] != 15109 && $articleInfoObj['article_id'] != 15271 && $articleInfoObj['article_id']  != 17286){?>
        <?php if( $articleInfoObj['article_id'] != 14613){?>     
           <?php if(   $articleInfoObj['article_id'] != 15284 && $articleInfoObj['article_id'] != 15488){?>
              <div id="atf-ad" class="ad-unit ad300 show-on-large-up" style="height:auto;">
                <style> a#adContent-clickOverlay{z-index: 9 !important;}</style>
                <script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
                <script type="text/javascript" language="javascript">
                //<![CDATA[
                aax_getad_mpb({
                  "slot_uuid":"ad4fe546-5060-4729-89ff-0bcae94681e2"
                });
                //]]>
                </script>
              </div>
            <?php }?> 
        <?php }else{ ?>
         <!-- /73970039/UT_P -->
          <div id='div-gpt-ad-1461622964696-1' style='height:1050px; width:300px;'>
            <script type='text/javascript'>
            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1461622964696-1'); });
            </script>
          </div>
       <?php } ?>
      <?php }else{?>
          <div id="atf-ad" class="ad-unit ad300 show-on-large-up" style="height:auto;">
              <a href="https://www.lelo.com/hex-condoms-original?utm_source=publisher_puckermob.com&utm_medium=banner&utm_content=&utm_campaign=hex_display" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>
          </div>
      <?php }?>
   
    
    <!-- MOST POPULAR -->
    <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>

    <!-- LELO -->
    <?php if(isset($articleInfoObj['article_id']) &&   $articleInfoObj['article_id'] != 17425  && $articleInfoObj['article_id'] != 16562 && $articleInfoObj['article_id'] != 14479 && $articleInfoObj['article_id'] != 14576 && $articleInfoObj['article_id'] != 15109 && $articleInfoObj['article_id'] != 15271 &&   $articleInfoObj['article_id']  != 17286){?>
      <?php if($articleInfoObj['article_id'] != 8560 &&  $articleInfoObj['article_id'] != 14613){ ?>
        <?php if(  $articleInfoObj['article_id'] != 15284  && $articleInfoObj['article_id'] != 15488){?>
            <div id="btf1-ad" class="ad-unit ad300" style="height:auto;">
              <script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
              <script type="text/javascript" language="javascript">
              //<![CDATA[
              aax_getad_mpb({
                "slot_uuid":"25fba8a5-f806-45fe-82d5-718e86f3d9f2"
              });
              //]]>
              </script>
            </div>
        <?php } ?>
      <?php } ?>
    <?php }else{ ?>
      <div id="btf1-ad" class="ad-unit ad300" style="height:auto;">
          <a href="https://www.lelo.com/hex-condoms-original?utm_source=publisher_puckermob.com&utm_medium=banner&utm_content=&utm_campaign=hex_display" target="_blank"><img style="width: 100%;" src="http://www.puckermob.com/assets/img/campaing/LELO_HEX_PuckerMob_300x250_white.jpg" /></a>
      </div>
    <?php } ?>
      
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
   
    <div id="btf1-ad" class="ad-unit ad300 show-on-large-up" style="height: auto;">
      <script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
      <script type="text/javascript" language="javascript">
      //<![CDATA[
      aax_getad_mpb({
        "slot_uuid":"ad4fe546-5060-4729-89ff-0bcae94681e2"
      });
      //]]>
      </script>
    </div>
    
     <!-- MOST POPULAR -->
    <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>
    
    <div id="btf2-ad" class="ad-unit ad300"  style="height: auto;">
      <script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
      <script type="text/javascript" language="javascript">
      //<![CDATA[
      aax_getad_mpb({
        "slot_uuid":"25fba8a5-f806-45fe-82d5-718e86f3d9f2"
      });
      //]]>
      </script>
    </div>
    
    <!--<div id="btf3-ad" style="margin-top: 1rem !important; " class="ad-unit ad300"  style="height: auto;">
    </div>-->

    <section id="sub-sidebar-2" class="sidebar sticky" style="padding-top:10px; ">
      <a href="https://www.facebook.com/puckermob" target="_blank"> <img src="http://www.puckermob.com/assets/img/homepage/likeuson.jpg" style="margin-bottom: 8px;"></a>
      <a href="http://sequelmediainternational.com/contact" target="_blank"> <img src="http://www.puckermob.com/assets/img/homepage/WriteForPuckerMob.jpg" style="margin-bottom:15px;"></a>
      <a href="#" class="back-to-top btn"> Back to top  &#8682; </a>
    </section>
</aside>
<?php  }?>
