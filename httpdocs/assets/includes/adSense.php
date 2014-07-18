<?php 
    $query = $_SERVER['PHP_SELF'];
    $path = pathinfo( $query );
    $pageName = $path['basename'];
    echo "<!--".$pageName."-->"; 
?> 
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>


  <div id="ad1_footer" style="display: none;">
    <!-- 300x250 ATF -->      
    <?php 
      if ($local){ 
        echo '<img src="'.$config["image_url"].'articlesites/simpledish/campaign/ad_mock.jpg"  />';
      } else { ?> 
      
        <!-- Gourmet Ads -->
        <!-- BEGIN JS TAG - 300x250 inc 300x600 - ATF - Run of Site - topRight < - DO NOT MODIFY -->
        <script src="http://ib.adnxs.com/ttj?id=1302317&size=300x250&promo_sizes=300x600&promo_alignment=none&position=above&referrer=simpledish.com" type="text/javascript"></script>
        <!-- END TAG --><div style="text-align:right; width:300px; padding:5px 0;">
           <img src="http://publishers.gourmetads.com/images/gourmetads-logo.jpg" alt="logo" style="float:right; border:none;" />
           <div style="width:auto; padding:4px 5px 0 0; float:right; display:inline-block; font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#333;">
              <a href="http://www.gourmetads.com/" target="_blank" title="Food Advertising" style="text-decoration:none; color:#333;">Food Advertising</a> by
           </div>
        </div>

      <?php } ?>
  </div>


  <div id="ad2_footer" style="display: none;">
    <!-- 300x250 BTF 1 -->  
    <?php 
      if ($local){ 
        echo '<img src="'.$config["image_url"].'articlesites/simpledish/campaign/ad_mock2.jpg"  />'; 
      } else { ?>

        <!-- BEGIN TECHNORATI MEDIA TAG -->
        <script type="text/javascript">
        document.write('<scri' + 'pt type="text/javascript" src="'
        + (document.location.protocol == 'https:' ? 'https://uat-secure' : 'http://ad-cdn')
        + '.technoratimedia.com/00/17/43/uat_34317.js?ad_size=300x250"></scri' + 'pt>');
        </script>
        <!-- END TECHNORATI MEDIA TAG -->

      <?php } ?>
      
  </div>


  <div id="ad3_footer" style="display: none;">
    <!-- 300x250 BTF 2 -->
    <?php 
      if ($local){ 
        echo '<img src="'.$config["image_url"].'articlesites/simpledish/campaign/ad_mock.jpg"  />'; 
      } else { ?>
        <!-- BEGIN Media Net / Yahoo ad, may show blank locally -->
        <script id="mNCC" language="javascript">  medianet_width='300';  medianet_height= '250';  medianet_crid='207627524';  </script>
        <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CUCXD4TF" language="javascript"></script> 

      <?php } ?>
      <!-- <p class="adsbygoogle_caption">Ads by Google</p> -->  
  </div>


  <div id="ad4_footer" style="display: none;">
    <!-- 300x250 BTF 3 -->
    <?php 
      if ($local){ 
        echo '<img src="'.$config["image_url"].'articlesites/simpledish/campaign/ad_mock.jpg"  />'; 
      } else { ?>
      
      <!-- BEGIN TECHNORATI MEDIA TAG -->
      <script type="text/javascript">
      document.write('<scri' + 'pt type="text/javascript" src="'
      + (document.location.protocol == 'https:' ? 'https://uat-secure' : 'http://ad-cdn')
      + '.technoratimedia.com/00/77/40/uat_34077.js?ad_size=300x250"></scri' + 'pt>');
      </script>
      <!-- END TECHNORATI MEDIA TAG -->

      <?php } ?>
      <!-- <p class="adsbygoogle_caption">Ads by Google</p> -->  
    </div>


<!--BEGIN 728s-->


  <div id="ad5_footer" style="display: none;">
    <!-- 728 ATF -->
    <?php 
      if ($local){ 
        //  If we're working locally, show an image
        echo '<img src="'.$config["image_url"].'articlesites/simpledish/campaign/ad_mock_728atf.gif"  />'; 
      } elseif($pageName == 'openxtest-noads.php' || $pageName == 'openxtest.php'){
        //  If we are on the openX testpage, show nothing
        echo "";

      //  show the ad
      }else { ?>
<!-- BEGIN JS TAG - 728x90 inc 970s - ATF - Run of Site - topCenter < - DO NOT MODIFY -->
<SCRIPT SRC="http://ib.adnxs.com/ttj?id=1918767&size=728x90&promo_sizes=970x90,970x250,970x415&promo_alignment=none&position=above&referrer=simpledish.com" TYPE="text/javascript"></SCRIPT>
<!-- END TAG --><div style="text-align:right; width:728px; padding:5px 0;">
   <img src="http://publishers.gourmetads.com/images/gourmetads-logo.jpg" alt="logo" style="float:right; border:none;" />
   <div style="width:auto; padding:4px 5px 0 0; float:right; display:inline-block; font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#333;">
      <a href="http://www.gourmetads.com/" target="_blank" title="Food Advertising" style="text-decoration:none; color:#333;">Food Advertising</a> by
   </div>
</div>
      <?php } ?>
  </div>


  <div id="ad6_footer" style="display: none;">
    <!-- 728 BTF1 -->
    <?php
      if ($local){ 
        echo '<img src="'.$config["image_url"].'articlesites/simpledish/campaign/ad_mock_728.jpg"  />'; 
      } elseif($pageName == 'openxtest-noads.php' || $pageName == 'openxtest.php'){
        echo "";
      }else { ?>
      <!-- google -->
      <ins class="adsbygoogle"
           style="display:inline-block;width:728px;height:90px"
           data-ad-client="ca-pub-8978874786792646"
           data-ad-slot="5341630183"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
      <p class="adsbygoogle_caption">Ads by Google</p>
      <?php } ?>
  </div>


  <div id="ad7_footer" style="display: none;">
    <!-- 728 BTF3 -->
    <?php
      if ($local){ 
        echo '<img src="'.$config["image_url"].'articlesites/simpledish/campaign/ad_mock_728.jpg"  />'; 
      } elseif($pageName == 'openxtest-noads.php' || $pageName == 'openxtest.php'){
        echo "";
      }else { ?>
        <a href="http://pinchofsugar.com" target="_blank" title="Go to pinchofsugar.com!"><img src="<?php echo $config['image_url'].'articlesites/simpledish/campaign/pinch_of_sugar_super_banner_728x90-_3.jpg';?>" alt=""></a>


      <?php } ?>
  </div>