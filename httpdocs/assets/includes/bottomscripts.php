<div id="evolve_footer"></div>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/foundation.min.js"></script>
<?php if (!$local){?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.min.js" ></script>
  <?php if (!$local){
      if(get_magic_quotes_gpc()) echo stripslashes($mpArticle->data['article_page_analytics']);
      else echo $mpArticle->data['article_page_analytics'];
  } ?>
  <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
    <?php if ( $detect->isMobile() ) { ?>
    <script src="<?php echo $config['this_url']; ?>assets/js/jquery.scrolldepth.min.js"></script>
    <script>
    $(function() {
      $.scrollDepth({
          elements:['#header-social-buttons', '#inarticle2-ad', '#inarticle5-ad', '#inarticle9-ad' , '#inarticle15-ad' ],
          userTiming: false,
          pixelDepth: false,
          nonInteraction: false
      });
    });
    </script>
    <?php } ?>
  <?php } ?>
<?php }else {?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/plugins.js" ></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/js_scroll.js" ></script>
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<?php }?>

<!-- DESKTOP -->
<?php if ( !$detect->isMobile() ) { ?>

    <!-- IFRAME RESIZER -->
    <script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/iframeResizer.min.js"></script>

    <!--[if !IE]>
    <script type="text/javascript" src="http://uac.advertising.com/wrapper/aceFIF.js "></script>
    <![endif]-->

    <!-- SPOUTABLE -->
    <script type='text/javascript'>
    (function(){
      spoutjs=document.createElement('script'),firstjs=document.getElementsByTagName('script')[0];
      spoutjs.async=1;
      spoutjs.src='//cdn.spoutable.com/1deb0b13-48fb-4eec-8af0-a5e05f8b6272/spoutable.js';
      firstjs.parentNode.insertBefore(spoutjs,firstjs)
    })();
    </script>

    <!-- NETSEER AD IN-IMAGE-->
    <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
        
      <?php if( $articleInfoObj['article_id'] != 4653 && $articleInfoObj['article_id'] != 4664 ){?>
        <script type="text/javascript">
          netseer_tag_id="19129";
          netseer_task="in-image";
        </script>
        <script type="text/javascript" src="http://ps.ns-cdn.com/dsatserving2/scripts/netseerads.js"></script>
      <?php } ?>

    <?php } 

    if( isset($promotedArticle) && !$promotedArticle ){ ?>
      <!-- SHARETHROUNG -->
      <script type="text/javascript" src="//native.sharethrough.com/assets/tag.js"></script>
    <?php }?>

<!-- MOBILE -->
<?php }else{ ?>

  
<!-- Nativo -->
<script type="text/javascript" src="//s.ntv.io/serve/load.js" async></script>

  <?php if( isset($promotedArticle) && !$promotedArticle ){ 
  
    if(isset($articleInfoObj) && $articleInfoObj){ ?>

      <!-- SHARETHROUNG -->
      <script type="text/javascript" src="//native.sharethrough.com/assets/tag.js"></script>

      <!-- ADSPARC -->
      <script type="text/javascript" src="//static.adsnative.com/static/js/render.v1.js"></script>
  

      <?php if( $articleInfoObj['article_id'] != 4653 && $articleInfoObj['article_id'] != 4664 ){?>
          <!-- NETSEER AD IN-IMAGE -->
           <script type="text/javascript">
            netseer_tag_id="20429";
            netseer_task="in-image";
           </script>
           <script type="text/javascript" src="http://ps.ns-cdn.com/dsatserving2/scripts/netseerads.js"></script>
        <?php } ?>
        
    <?php  } 
  }?>  

  <?php if(isset($articleInfoObj) && $articleInfoObj['article_id'] == 7615 ){ ?>  
    <!-- INFO LINK MOBILE -->
      <script type="text/javascript">
      var infolinks_pid = 2431692;
      var infolinks_wsid = 0;
      </script>
      <script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>
  <?php  } ?>
  <!-- Sprockester Airpush Unit : Oct 6, 4:17PM - REMOVED OCT 12 2015, 10:13 AM
   <script id="airpushScript" type="text/javascript" 
    src="http://ab.airpush.com/apportal/client/airpush.js?siteid=269236&testmode=0&banner360=1&banner=0&placementid=0&tp=0" >
  </script>-->
<?php }?>

<!-- DESKTOP & MOBILE SCRIPT -->
<?php if(isset($articleInfo) && $articleInfo){ ?>
  <!-- Addthis -->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c4498040efc634" async ></script>
  <script type="text/javascript">
    $(document).ready(function(){
      if(addthis) addthis.init();
    });
  </script>
<?php }?>
  

<!-- cloudfront tracker -->
<script>
  !function(g,s,q,r,d){r=g[r]=g[r]||function(){(r.q=r.q||[]).push(
  arguments)};d=s.createElement(q);q=s.getElementsByTagName(q)[0];
  d.src='//d1l6p2sc9645hc.cloudfront.net/tracker.js';q.parentNode.
  insertBefore(d,q)}(window,document,'script','_gs');
  _gs('GSN-829786-N');
</script>

<script type="text/javascript">
    loadScript("<?php echo $config['this_url']; ?>assets/js/ads.js", function(){ });
</script>

<?php if( !$detect->isMobile() && isset($articleInfoObj) /*&& $articleInfoObj['article_id'] == 8225 */){?>
  <!-- BEGIN JS TAG - puckermob.com - IV < - DO NOT MODIFY -->
  <SCRIPT SRC="http://adsvr2.adsparc.net/ttj?id=5423729&cb=[CACHEBUSTER]" TYPE="text/javascript"></SCRIPT>
  <!-- END TAG -->
<?php }?>
<!-- TotallyHer comscore tags -->
<script>var _comscore = _comscore || [];_comscore.push({ c1: "2", c2: "6036161" });(function() {var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";el.parentNode.insertBefore(s, el);})();</script><noscript><img src="http://b.scorecardresearch.com/p?c1=2&c2=6036161&cv=2.0&cj=1" /></noscript>



<!-- ADSUPPLY -->
<script data-cfasync="false" type="text/javascript">(function(s,o,l,v,e,d){if(s[o]==null&&s[l+e]){s[o]="loading";s[l+e](d,l=function(){s[o]="complete";s[v+e](d,l,!1)},!1)}})(document,"readyState","add","remove","EventListener","DOMContentLoaded");(function(){var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="//cdn.engine.4dsply.com/Scripts/infinity.js.aspx?guid=ce106c14-9ffe-4f0b-8cb8-c965d9d04213";s.id="infinity";s.setAttribute("data-guid","ce106c14-9ffe-4f0b-8cb8-c965d9d04213");s.setAttribute("data-version","async");var e=document.getElementsByTagName('script')[0];e.parentNode.insertBefore(s,e)})();</script>



