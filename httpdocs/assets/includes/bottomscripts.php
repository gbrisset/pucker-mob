<div id="evolve_footer"></div>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/foundation.min.js"></script>
<?php if (!$local){?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.min.js" ></script>
<?php }else {?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/plugins.js" ></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/js_scroll.js" ></script>
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<?php }?>

<!-- DESKTOP -->
<?php if ( !$detect->isMobile() ) { ?>

  
    <!-- SPOUTABLE -->
    <script type='text/javascript'>
    (function(){
      spoutjs=document.createElement('script'),firstjs=document.getElementsByTagName('script')[0];
      spoutjs.async=1;
      spoutjs.src='//cdn.spoutable.com/1deb0b13-48fb-4eec-8af0-a5e05f8b6272/spoutable.js';
      firstjs.parentNode.insertBefore(spoutjs,firstjs)
    })();
    </script>
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
    <?php } ?>

    
      <!-- SPRINGBOARD SLIDING VIDEO UNIT 
      <script type="text/javascript">
      var sbGlideScriptElement = document.createElement("script");
      sbGlideScriptElement.type = "text/javascript";
      sbGlideScriptElement.onload = function() {
        var glideUnit = typeof SbSlidingUnit == 'undefined' ? parent.SbSlidingUnit : SbSlidingUnit;
        glideUnit.init({
          partnerId : 5087,
          widgetId : 'puck003',
          cmsPath : 'http://cms.springboardplatform.com'
        });
      }
      sbGlideScriptElement.src = "http://www.springboardplatform.com/storage/js/sliding/sliding_unit.js";
      if (top === self)
        document.getElementsByTagName('head')[0].appendChild(sbGlideScriptElement);
      else
        parent.document.getElementsByTagName('head')[0].appendChild(sbGlideScriptElement);
      </script>-->
      <!-- SPRINGBOARD SLIDING VIDEO UNIT -->
      
    <!-- Place in head part widget:puck002 -->
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
                  partnerId : 5087,
                  widgetId : 'puck002',
                  cmsPath : 'http://cms.springboardplatform.com'
                });
              }
              js.src = "http://www.springboardplatform.com/storage/js/ingage/apingage.min.js";
              s.parentNode.insertBefore(js, s);
            })(window.document);
          }
        }
    </script>

    <?php } 

    if( isset($promotedArticle) && !$promotedArticle ){ ?>
    <!-- SHARETHROUNG -->
    <script type="text/javascript" src="//native.sharethrough.com/assets/tag.js"></script>

    <?php }?>

<!-- MOBILE -->
<?php }else{ ?>
  <?php if( isset($promotedArticle) && !$promotedArticle ){ 
  
    if(isset($articleInfoObj) && $articleInfoObj){ ?>


      <!-- SHARETHROUNG -->
      <script type="text/javascript" src="//native.sharethrough.com/assets/tag.js"></script>

      <?php if( $articleInfoObj['article_id'] == 8785 ){?>
      <!-- ADSPARC -->
      <script type="text/javascript" src="//static.adsnative.com/static/js/render.v1.js"></script>
      <?php }?>

      <?php if( $articleInfoObj['article_id'] != 4653 && $articleInfoObj['article_id'] != 4664 ){?>
          <!-- NETSEER AD IN-IMAGE -->
           <script type="text/javascript">
            netseer_tag_id="20429";
            netseer_task="in-image";
           </script>
           <script type="text/javascript" src="http://ps.ns-cdn.com/dsatserving2/scripts/netseerads.js"></script>
        <?php }

        //if($articleInfoObj['article_id'] == 7498 ){?>
        
        <?php  //}
      } 
  }?>  

  <?php if(isset($articleInfoObj) && $articleInfoObj['article_id'] == 7615 ){ ?>  
    <!-- INFO LINK MOBILE -->
      <script type="text/javascript">
      var infolinks_pid = 2431692;
      var infolinks_wsid = 0;
      </script>
      <script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>
  <?php  } ?>
    
  	
    <!-- KIXER ADHESION 
    <div id='__kx_ad_1486'></div>
    <script type="text/javascript" language="javascript">
    var __kx_ad_slots = __kx_ad_slots || [];

    (function () {
      var slot = 1486;
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


<?php //if( $articleInfoObj['article_id'] == 8670 ){?>
  <!-- Nativo -->
  <script type="text/javascript" src="//s.ntv.io/serve/load.js" async></script>
<?php //}else{ ?>
<!-- ADSUPPLY -->
  <script data-cfasync="false" type="text/javascript">(function(s,o,l,v,e,d){if(s[o]==null&&s[l+e]){s[o]="loading";s[l+e](d,l=function(){s[o]="complete";s[v+e](d,l,!1)},!1)}})(document,"readyState","add","remove","EventListener","DOMContentLoaded");(function(){var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="//cdn.engine.4dsply.com/Scripts/infinity.js.aspx?guid=ce106c14-9ffe-4f0b-8cb8-c965d9d04213";s.id="infinity";s.setAttribute("data-guid","ce106c14-9ffe-4f0b-8cb8-c965d9d04213");s.setAttribute("data-version","async");var e=document.getElementsByTagName('script')[0];e.parentNode.insertBefore(s,e)})();</script>
<?php //} ?>



