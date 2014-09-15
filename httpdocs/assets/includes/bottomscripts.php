<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>

<!-- DESKTOP -->
<?php if ( !$detect->isMobile() ) { ?>
    <!-- AdsNative.com -->
    <script type="text/javascript" src="http://static.adsnative.com/static/js/render.v1.js"></script>

    <!-- GUM GUM 
    <script type="text/javascript" src="http://g2.gumgum.com/javascripts/ggv2.js"></script>-->

    <!-- Vibrant in-text Media Ads -->
    <script type="text/javascript" src="http://puckermob.us.intellitxt.com/intellitxt/front.asp?ipid=70526"></script>

    <!-- TLV POP UNDER TAG 
    <script type="text/javascript">t_sec=280000013;</script>
    <script type="text/javascript" src="http://t.cttsrv.com/pt.js"></script>-->

    <!-- IS NOT VIDEO PAGE -->
    <?php if( !isset($isVideoPage) ){
      if (!$local){?>
      <!-- WAHWAH RADIO PLAYER -->
      <script src="http://cdn-s.wahwahnetworks.com/00BA6A/toolbar/publishers/1730/wahwahobject.js"></script>
      <!-- End WAHWAH Radio Player -->
    <?php } } ?>

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

    <!-- QuDaBra 
    <script type="text/javascript" >var qadserve_width  = "160";var qadserve_height = "600";var qadserve_pid = "bf101924-f70d-4cea-863c-cdff9a5a336f";var qadserve_direction = "left";var qadserve_from_top = 60;</script>
    <script type="text/javascript"  src="http://mmrm.qadserve.com/qadserve_slider.min.js"></script>-->

<!-- MOBILE -->
<?php }else{ ?>
    
    <!-- GUM GUM 
    <script src="//g2.gumgum.com/javascripts/ad.js"></script>-->

    <!-- Distro Scale AD Tag -->
    <script type="text/javascript" src="http://c.jsrdn.com/s/cs.js?p=22257"> </script>
    
    <!-- Q1 Media 
    <script src='http://Q1MediaHydraPlatform.com/ads/video/unit_desktop_slider.php?eid=50198'></script> -->

    <!-- Vibrant Media Ads -->
    <script type="text/javascript" src="http://puckermob.us.intellitxt.com/intellitxt/front.asp?ipid=70527"></script>
<?php }?>

<!-- DESKTOP & MOBILE SCRIPT -->

<!-- IF ARTICLE PAGE -->
  <?php if(isset($articleInfo) && $articleInfo){ ?>
  <!-- PO.ST SOCIAL MEDIA ADS 
  <script>
    (function () {
      var s = document.createElement('script'); 
      s.type = 'text/javascript'; 
      s.async = true; s
      s.src = ('https:' == document.location.protocol ? 'https://s' : 'http://i') + '.po.st/share/script/post-widget.js';
      var x = document.getElementsByTagName('script')[0];
      x.parentNode.insertBefore(s, x);
      })();
      
    var pwidget_config = {
      publisherKey: 'vb2fp4ggidsu7tl0b82a',
      defaults: {
        sharePopups: true,
          services: {
            twitter: {
            via: 'puckermob'
          }
        }
      } 
    };
  </script>-->
  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#async=1"></script>
  <script type="text/javascript">
    var addthis_config = addthis_config||{};
    addthis_config.pubid = 'ra-53c4498040efc634';
  </script>
  
  <?php }?>

<!-- COMSCORE -->
<script>
  var _comscore = _comscore || [];
  _comscore.push({ c1: "2", c2: "18667744" });
  (function() {
    var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
    s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
    el.parentNode.insertBefore(s, el);
  })();
</script>
<noscript>
  <img src="http://b.scorecardresearch.com/p?c1=2&c2=18667744&cv=2.0&cj=1" />
</noscript>
<!-- End COMSCORE Tag -->

<!-- Quantcast Tag -->
<script type="text/javascript">
var _qevents = _qevents || [];

(function() {
var elem = document.createElement('script');
elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
elem.async = true;
elem.type = "text/javascript";
var scpt = document.getElementsByTagName('script')[0];
scpt.parentNode.insertBefore(elem, scpt);
})();

_qevents.push({
qacct:"p-B2Jsd5NDNU3Qq"
});
</script>

<noscript>
<div style="display:none;">
<img src="//pixel.quantserve.com/pixel/p-B2Jsd5NDNU3Qq.gif" border="0" height="1" width="1" alt="Quantcast"/>
</div>
</noscript>
<!-- End Quantcast tag -->

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