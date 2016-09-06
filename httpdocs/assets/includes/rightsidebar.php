
<?php 
  $has_sponsored = 0;
  if ( isset($isArticle) && $isArticle ){?>
  <aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print" style="">
    <!-- MOST POPULAR -->
    <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>

      <!-- AMAZON -->
      <div id="btf2-ad" class="ad-unit ad300"  style="height: auto;     padding-top: 1rem; margin-left: -15px;">
        <script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
        <script type="text/javascript" language="javascript">
        //<![CDATA[
        aax_getad_mpb({
          "slot_uuid":"25fba8a5-f806-45fe-82d5-718e86f3d9f2"
        });
        //]]>
        </script>
      </div>
      
</aside>
<?php }else{ ?>
<aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print home">
    <!-- MOST POPULAR -->
    <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>
    
    <!-- AMAZON -->
    <div id="btf2-ad" class="ad-unit ad300 catcher"  style="height: auto; padding-top:1rem; ">
      <script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
      <script type="text/javascript" language="javascript">
      //<![CDATA[
      aax_getad_mpb({
        "slot_uuid":"25fba8a5-f806-45fe-82d5-718e86f3d9f2"
      });
      //]]>
      </script>
    </div>
    
  
    <section id="sub-sidebar-2" class="sidebar sticky"">
      <a href="https://www.facebook.com/puckermob" target="_blank"> <img src="http://www.puckermob.com/assets/img/homepage/likeuson.jpg" style="margin-bottom: 8px;"></a>
      <a href="http://www.puckermob.com/login"> <img src="http://www.puckermob.com/assets/img/homepage/WriteForPuckerMob.jpg" style="margin-bottom:15px;"></a>
      <a href="#" class="back-to-top btn"> Back to top  &#8682; </a>
    </section>
</aside>
<?php  }?>
