
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/foundation.min.js"></script>

<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/plugins.js" ></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/js_scroll.js" ></script>


<!-- DESKTOP -->
<?php if ( !$detect->isMobile() ) { ?>

<!-- IFRAME RESIZER -->
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/iframeResizer.min.js"></script>

 <!--[if !IE]>
 <script type="text/javascript" src="http://uac.advertising.com/wrapper/aceFIF.js "></script>
 <![endif]-->

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

<!-- Vibrant in-text Media Ads 
 <script type="text/javascript" src="http://puckermob.us.intellitxt.com/intellitxt/front.asp?ipid=70526"></script>
-->
  
<!-- IS NOT VIDEO PAGE -->
<?php //if (!$local){?>
   <!-- WAHWAH RADIO PLAYER 
  <script src="http://cdn-s.wahwahnetworks.com/00BA6A/toolbar/publishers/1730/wahwahobject.js"></script>-->
<?php //} ?>

<!-- MOBILE -->
<?php }else{ ?>

  <?php if( isset($promotedArticle) && !$promotedArticle ){ ?>


  <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
      <!-- NETSEER AD IN-IMAGE -->
      <?php if( $articleInfoObj['article_id'] != 4653 && $articleInfoObj['article_id'] != 4664 ){?>
       <script type="text/javascript">
        netseer_tag_id="20429";
        netseer_task="in-image";
       </script>
       <script type="text/javascript" src="http://ps.ns-cdn.com/dsatserving2/scripts/netseerads.js"></script>
    <?php }?>
    
    <!-- KIXER -->
    <!-- Start Puckermob Adhesion -->
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
        s.src = '//cdn.kixer.com/ad/load.js';
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
    </script>
    <!-- End Puckermob Adhesion -->
  <?php } ?>

  <!-- INFO LINK -->
  <script type="text/javascript">
    var infolinks_pid = 2431692;
    var infolinks_wsid = 0;
  </script>
  <script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>

  <!-- POPUNDERS -->
  <script data-cfasync="false" type="text/javascript">(function(s,o,l,v,e,d){if(s[o]==null&&s[l+e]){s[o]="loading";s[l+e](d,l=function(){s[o]="complete";s[v+e](d,l,!1)},!1)}})(document,"readyState","add","remove","EventListener","DOMContentLoaded");(function(){var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="//cdn.engine.4dsply.com/Scripts/infinity.js.aspx?guid=ce106c14-9ffe-4f0b-8cb8-c965d9d04213";s.id="infinity";s.setAttribute("data-guid","ce106c14-9ffe-4f0b-8cb8-c965d9d04213");s.setAttribute("data-version","async");var e=document.getElementsByTagName('script')[0];e.parentNode.insertBefore(s,e)})();</script>

  <!-- Vibrant Media Ads 
    <script type="text/javascript" src="http://puckermob.us.intellitxt.com/intellitxt/front.asp?ipid=70527"></script>
  -->
   <?php }?>  
    
<?php }?>

<!-- DESKTOP & MOBILE SCRIPT -->
<!-- TWITTER SELECTOR -->
<?php if(isset($articleInfo) && $articleInfo){ ?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/selectshare.js"></script>

    <!-- [ === TOOLTIP init === ] -->
    <script>var twitterAccount = "Puckermob";</script><!-- [ <-- NOTE: YOUR TWITTER ACCOUNT GOES HERE ! (without "@" !) ] -->
    <div class="shareTooltip" id="shareTooltip">
         <div class="tooltipContainer"><a id="sendToTwitter" href="" class="sharingLink twitter"><span></span></a></div>
     </div>
     <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
  
  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c4498040efc634" ></script>

  <script type="text/javascript">
    $(document).ready(function(){
      if(addthis) addthis.init();
    })
  </script>
<?php }?>
  
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

<!-- Nativo -->
<script type="text/javascript" src="http://a.postrelease.com/serve/load.js?async=true"></script>

<!-- TotallyHer comscore tags -->
<script>var _comscore = _comscore || [];_comscore.push({ c1: "2", c2: "6036161" });(function() {var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";el.parentNode.insertBefore(s, el);})();</script><noscript><img src="http://b.scorecardresearch.com/p?c1=2&c2=6036161&cv=2.0&cj=1" /></noscript>

<!-- POPUNDERS 
<script data-cfasync="false" type="text/javascript">(function(s,o,l,v,e,d){if(s[o]==null&&s[l+e]){s[o]="loading";s[l+e](d,l=function(){s[o]="complete";s[v+e](d,l,!1)},!1)}})(document,"readyState","add","remove","EventListener","DOMContentLoaded");(function(){var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="//cdn.engine.4dsply.com/Scripts/infinity.js.aspx?guid=ce106c14-9ffe-4f0b-8cb8-c965d9d04213";s.id="infinity";s.setAttribute("data-guid","ce106c14-9ffe-4f0b-8cb8-c965d9d04213");s.setAttribute("data-version","async");var e=document.getElementsByTagName('script')[0];e.parentNode.insertBefore(s,e)})();</script>
-->