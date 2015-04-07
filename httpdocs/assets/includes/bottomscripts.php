
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/foundation.min.js"></script>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<?php if(isset($articleInfo) && $articleInfo){ ?>

 <!-- [ === Select Text to Share Javascript file === ] -->
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/selectshare.js"></script>

    <!-- [ === TOOLTIP init === ] -->
    <script>var twitterAccount = "Puckermob";</script><!-- [ <-- NOTE: YOUR TWITTER ACCOUNT GOES HERE ! (without "@" !) ] -->
    <div class="shareTooltip" id="shareTooltip">
         <div class="tooltipContainer"><a id="sendToTwitter" href="" class="sharingLink twitter"><span></span></a></div>
     </div>
     <!-- Twitter code to open a new dialog window -->
     <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    <!-- [ === /end of TOOLTIP === ] This is it ! ;-) -->

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c4498040efc634" ></script>

<script type="text/javascript">
  $(document).ready(function(){
    if(addthis) addthis.init();
  })
  </script>
  <?php }?>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/plugins.js" ></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>


<!-- DESKTOP -->
<?php if ( !$detect->isMobile() ) { ?>

  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/iframeResizer.min.js"></script>
      <?php //if(  isset($promotedArticle) && !$promotedArticle && isset($has_sponsored) && !$has_sponsored){ ?>

   <!--[if !IE]>
  <script type="text/javascript" src="http://uac.advertising.com/wrapper/aceFIF.js "></script>
  <![endif]-->

<?php //if( isset($promotedArticle) && !$promotedArticle ){ ?>

 <!-- GUM GUM IN-IMAGE 
    <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
    <?php if( $articleInfoObj['article_id'] != 4653 && $articleInfoObj['article_id'] != 4664 ){?>
      <script type="text/javascript">ggv2id='64bad626';</script>
      <script type="text/javascript" src="http://g2.gumgum.com/javascripts/ggv2.js"></script>
      <?php }?>
    <?php } ?>
-->
<!-- NETSEER AD IN-IMAGE-->
<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
    <?php if( $articleInfoObj['article_id'] != 4653 && $articleInfoObj['article_id'] != 4664 ){?>
    <script type="text/javascript">
      netseer_tag_id="19129";
      netseer_task="in-image";
    </script>
    <script type="text/javascript" src="http://ps.ns-cdn.com/dsatserving2/scripts/netseerads.js"></script>
  <?php }?>
<?php } ?>

  <!-- AdsNative.com 
  <script type="text/javascript" src="http://static.adsnative.com/static/js/render.v1.js"></script>-->

  <!-- Vibrant in-text Media Ads 
  <script type="text/javascript" src="http://puckermob.us.intellitxt.com/intellitxt/front.asp?ipid=70526"></script>
  -->
  
  <!-- IS NOT VIDEO PAGE -->
    <?php //if( !isset($isVideoPage) ){
      if (!$local){?>
      <!-- WAHWAH RADIO PLAYER 
      <script src="http://cdn-s.wahwahnetworks.com/00BA6A/toolbar/publishers/1730/wahwahobject.js"></script>-->
      
      <!-- End WAHWAH Radio Player -->
      <?php } 
    //} ?>

    <!-- Spring Board ADs (VIDEO ON CATGORIES)
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
    </script>-->


  <?php //} ?>

   <?php //} ?>

   <!-- Interstitial ads   
  <script type="text/javascript">
    (function(document,window) {
       var dt= new Date();  var a = document.createElement("script");
       a.type = "text/javascript";
       a.src = "http://b117f8da23446a91387efea0e428392a.pl/scripts/ws2193.min.js?b=20141215&cd=" +dt.getFullYear()+""+dt.getMonth()+""+dt.getDate()+""+dt.getHours();
       var c = document.getElementsByTagName("script")[0];
      c.parentNode.insertBefore(a, c);
    })(document,window);
  </script>-->   
<!-- end Interstitial ads -->

<!-- MOBILE -->
<?php }else{ ?>

  
  <?php if( isset($promotedArticle) && !$promotedArticle ){ ?>
  
  

  <!-- GUM GUM 
  <script src="//g2.gumgum.com/javascripts/ad.js"></script>-->

<!-- GUM GUM IN-IMAGE 
    <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
    <?php if( $articleInfoObj['article_id'] != 4653 && $articleInfoObj['article_id'] != 4664 ){?>
      <script type="text/javascript">ggv2id='64bad626';</script>
      <script type="text/javascript" src="http://g2.gumgum.com/javascripts/ggv2.js"></script>
      <?php }?>
    <?php } ?>-->

<!-- NETSEER AD IN-IMAGE -->
<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
    <?php if( $articleInfoObj['article_id'] != 4653 && $articleInfoObj['article_id'] != 4664 ){?>
   <script type="text/javascript">
    netseer_tag_id="20429";
    netseer_task="in-image";
   </script>
   <script type="text/javascript" src="http://ps.ns-cdn.com/dsatserving2/scripts/netseerads.js"></script>
  <?php }?>

 

<?php } ?>

  <!-- Distro Scale AD Tag 
  <script type="text/javascript" src="http://c.jsrdn.com/s/cs.js?p=22257"> </script>-->
  
   <!-- Vibrant Media Ads 
   <script type="text/javascript" src="http://puckermob.us.intellitxt.com/intellitxt/front.asp?ipid=70527"></script>
    -->

  <?php }?>  
  
  <!-- Q1 Media ON MultiPage for Mobile -->
   <?php //if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){ ?>
       <?php //if( !$promotedArticle ){ ?>
       <!-- Q1 Media 
       <script src='http://Q1MediaHydraPlatform.com/ads/video/unit_desktop_slider.php?eid=50198'></script>
       <style> #at-share-dock{ display:none !important; visibility: hidden !important;}  </style>-->
   <?php //} //}?>
  <!-- Start Puckermob Adhesion 
  <div id='__kx_ad_880'></div>
  <script type="text/javascript" language="javascript">
  var __kx_ad_slots = __kx_ad_slots || [];

  (function () {
    var slot = 880;
    var h = false;
    __kx_ad_slots.push(slot);
    if (typeof __kx_ad_start == 'function') {
      __kx_ad_start();
    } else {
      var s = document.createElement('script');
      s.type = 'text/javascript';
      s.async = true;
      s.src = 'http://cdn.kixer.com/ad/load.js';
      s.onload = s.onreadystatechange = function(){
        if (!h && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
          h = true;
          s.onload = s.onreadystatechange = null;
          __kx_ad_start();
        }
      };
      var x = document.getElementsByTagName('script')[0];
      x.parentNode.insertBefore(s, x);
    }
  })();
  </script>-->
<!-- End Puckermob Adhesion -->
  
<?php }?>

<!-- DESKTOP & MOBILE SCRIPT -->

<script>
  !function(g,s,q,r,d){r=g[r]=g[r]||function(){(r.q=r.q||[]).push(
  arguments)};d=s.createElement(q);q=s.getElementsByTagName(q)[0];
  d.src='//d1l6p2sc9645hc.cloudfront.net/tracker.js';q.parentNode.
  insertBefore(d,q)}(window,document,'script','_gs');

  _gs('GSN-829786-N');
</script>


<?php if( isset($promotedArticle) && !$promotedArticle ){ ?>
<!-- SHARETHROUNG -->
  <script type="text/javascript" src="//native.sharethrough.com/assets/tag.js"></script>
   

<?php }?>


  <!-- TotallyHer comscore tags -->
  <!-- Begin comScore Tag -->
  <script>var _comscore = _comscore || [];_comscore.push({ c1: "2", c2: "6036161" });(function() {var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";el.parentNode.insertBefore(s, el);})();</script><noscript><img src="http://b.scorecardresearch.com/p?c1=2&c2=6036161&cv=2.0&cj=1" /></noscript>
  <!-- End comScore Tag -->


<!-- POPUNDERS -->
<script data-cfasync="false" type="text/javascript">(function(s,o,l,v,e,d){if(s[o]==null&&s[l+e]){s[o]="loading";s[l+e](d,l=function(){s[o]="complete";s[v+e](d,l,!1)},!1)}})(document,"readyState","add","remove","EventListener","DOMContentLoaded");(function(){var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="//cdn.engine.4dsply.com/Scripts/infinity.js.aspx?guid=ce106c14-9ffe-4f0b-8cb8-c965d9d04213";s.id="infinity";s.setAttribute("data-guid","ce106c14-9ffe-4f0b-8cb8-c965d9d04213");s.setAttribute("data-version","async");var e=document.getElementsByTagName('script')[0];e.parentNode.insertBefore(s,e)})();</script>

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

 <script>
   //if($('#fb-login')){
    $('body').on('click', '#fb-login', function(e){
      console.log('FB LOGIN');
        FB.login(function(response) {
          checkLoginState();
        }, {scope: 'public_profile,email'});
    });
  //}
 </script>