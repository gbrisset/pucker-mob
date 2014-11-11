<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/modernizr.min.js"></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/foundation.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>

<!-- DESKTOP -->
<?php if ( !$detect->isMobile() ) { ?>

  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/iframeResizer.min.js"></script>
      <?php if( isset($promotedArticle) && !$promotedArticle && !$has_sponsored){ ?>

   <!--[if !IE]>
  <script type="text/javascript" src="http://uac.advertising.com/wrapper/aceFIF.js "></script>
  <![endif]-->

<?php if( !$promotedArticle ){ ?>

 <!-- GUM GUM IN-IMAGE -->
    <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
    <script type="text/javascript">ggv2id='64bad626';</script>
    <script type="text/javascript" src="http://g2.gumgum.com/javascripts/ggv2.js"></script>
    <?php } ?>


  <!-- AdsNative.com -->
  <script type="text/javascript" src="http://static.adsnative.com/static/js/render.v1.js"></script>

  <!-- Vibrant in-text Media Ads -->
  <script type="text/javascript" src="http://puckermob.us.intellitxt.com/intellitxt/front.asp?ipid=70526"></script>
 
  <!-- IS NOT VIDEO PAGE -->
    <?php if( !isset($isVideoPage) ){
      if (!$local){?>
      <!-- WAHWAH RADIO PLAYER 
      <script src="http://cdn-s.wahwahnetworks.com/00BA6A/toolbar/publishers/1730/wahwahobject.js"></script>
      -->
      <!-- End WAHWAH Radio Player -->
      <?php } 
    } ?>

    <!-- Spring Board ADs (VIDEO ON CATGORIES) -->
    <script type="text/javascript">

    var sbElementInterval = setInterval(function(){sbElementCheck()}, 50);

    function sbElementCheck() {

      var targetedElement = document.getElementById('ingageunit');
      if(targetedElement) {
        clearInterval(sbElementInterval);
        (function(d) {
          var js, s = d.getElementsByTagName('script')[0];
          js = d.createElement('script');
          js.async = true;
          js.onload = function(e) {
            SbInGageWidget.init({
              partnerId : 3809,
              widgetId : 'spld002',
              cmsPath : 'http://cms.springboardplatform.com'
            });
          }
          js.src = "http://cdn.springboardplatform.com/storage/js/ingage/apingage.min.js";
          s.parentNode.insertBefore(js, s);
        })(window.document);
      }
    }
    </script>
  <?php } ?>

   <?php } ?>

<!-- MOBILE -->
<?php }else{ ?>
  <?php if( !$promotedArticle ){ ?>
  <!-- SHARETHROUNG 
  <script type="text/javascript" src="//native.sharethrough.com/assets/tag.js"></script>-->

  <!-- GUM GUM -->
  <script src="//g2.gumgum.com/javascripts/ad.js"></script>

  <!-- Distro Scale AD Tag -->
  <script type="text/javascript" src="http://c.jsrdn.com/s/cs.js?p=22257"> </script>
  
   <!-- Vibrant Media Ads -->
   <script type="text/javascript" src="http://puckermob.us.intellitxt.com/intellitxt/front.asp?ipid=70527"></script>


  <?php }?>  
  
  <!-- Q1 Media ON MultiPage for Mobile -->
   <?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){ ?>
       <?php if( !$promotedArticle ){ ?>
       <!-- Q1 Media -->
       <script src='http://Q1MediaHydraPlatform.com/ads/video/unit_desktop_slider.php?eid=50198'></script>
       <style> #at-share-dock{ display:none !important; visibility: hidden !important;}  </style>
   <?php } }?>

  
<?php }?>

<!-- DESKTOP & MOBILE SCRIPT -->

<?php if( !$promotedArticle ){ ?>

 <!-- SHARETHROUNG -->
  <script type="text/javascript" src="//native.sharethrough.com/assets/tag.js"></script>
  
<!-- Nativo -->
<script type="text/javascript" src="http://a.postrelease.com/serve/load.js?async=true"></script>
<?php }?>
<!--Disqus Comment Box Implementation (Comments Counter)-->
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'puckermob'; // required: replace example with your forum shortname

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
  </script>
 <!--END Disqus Comment Box Implementation (Comments Counter)-->