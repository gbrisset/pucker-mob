

<script type="text/javascript" src="http://www.puckermob.com/assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/foundation.min.js"></script>
<?php if (!$local){?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.min.js?ver_345678808e" ></script>

  <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
    
  <?php } ?>
<?php }else {?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/plugins.js" ></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/js_scroll.js" ></script>
<?php }?>

<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/ads.js?ver_345679998e" ></script>

  <!--[if !IE]>
    <script type="text/javascript" src="http://uac.advertising.com/wrapper/aceFIF.js "></script>
    <![endif]-->

<!-- DESKTOP -->
<?php if ( !$detect->isMobile() ) { ?>


  <?php if($article_id != 8560 && $article_id != 14472 && $article_id != 15284 && $article_id != 15488 ){?>
    <!--
    <div id="mb_container"></div> 
    <div id="mb_video_sponso"></div> 
    <script type="text/javascript"> (function(){ var sc = document.createElement('script'); sc.src = 'http://player.mediabong.net/se/924.js?url='+encodeURIComponent(document.location.href); sc.type = 'text/javascript'; sc.async = true; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sc, s); })(); </script>
 -->
 <?php } ?>
<?php //if( !$sponsored_aricle ){?>
    
    <div id="evolve_footer"></div>

    <!-- NETSEER AD IN-IMAGE-->
    <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
     
      <!-- LELO -->
      <?php if(isset($article_id) && $article_id != 14479 && $article_id != 14576  && $article_id != 8560 && $article_id != 14472 && $article_id != 15109 && $article_id != 15271  && $article_id != 15488 ){?>
       <!-- <script type="text/javascript">
        netseer_tag_id="19129"; 
        </script>
        <script src="http://ps.ns-cdn.com/dsatserving2/scripts/ns_vmtag.js" type="text/javascript"></script>-->
      <?php } ?>
    <?php }  ?>

 <?php //} ?>


   <!--Puckermob.com CORNERSTREAM Validation Test Tag 
  <section id="content-ad-around-the-web" class="sidebar-right small-12 columns hide-for-print no-padding" style="padding-bottom:0;">
    <script type="text/javascript" src="http://video.bnmla.com/video?vzid=5938&vast=0&jstype=7&vWidth=501&vHeight=282&closeable=false&automute=false&skipTime=5"></script>
  </section>-->
 
 <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
   <!--SHAREBUTTONS BAR VERTICAL-->
    <div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style" style="left:0px; top:150px;">
        <a class="a2a_button_facebook a2a_button_facebook"></a>
        <a class="a2a_button_twitter"></a>
        <a class="a2a_button_google_plus"></a>
        <a class="a2a_button_pinterest"></a>
        <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
    </div>
    <script async src="//static.addtoany.com/menu/page.js" async></script>
<?php } ?>

<!-- MOBILE -->
<?php }else{ ?>
  
  <?php if( isset($promotedArticle) && !$promotedArticle ){ 
      
      if(isset($articleInfoObj) && $articleInfoObj){ ?>
        <!-- LELO -->
        <?php if(isset($article_id) && $article_id != 14479 && $article_id != 14576  && $article_id != 8560 && $article_id != 14613 && $article_id != 15104  && $article_id != 14873 && $article_id != 15271 && $article_id != 15284 && $article_id != 15488){ ?>
        
          <script type="text/javascript" src="http://video.bnmla.com/video?vzid=5959&vast=0&jstype=7&vWidth=501&vHeight=282&closeable=false&automute=false&skipTime=5"></script>

             
           <div id="vm_inline"></div>
          <script>
              window._videomosh = window._videomosh || [];
              !function (e, f, u) {
                  e.async = 1;
                  e.src = u;
                  f.parentNode.insertBefore(e, f);
              }(document.createElement('script'),
                      document.getElementsByTagName('script')[0],
                      'http://player.videomosh.com/players/loader/loader_final4.js');
              _videomosh.push({
                  publisher_key: "sequelmedia",
                  mode: "slider",
                  container: "vm_inline",
                  incontent_mobile_id: "23002",
                  incontent_desktop_id: "42300",
                  target_type: "mix"
                          });
          </script>

          <?php //if($article_id == 15754 ){ ?>
          <!-- AIRPUSH MOBILE -->
          <script type="text/javascript">
		    this.airpushConfig = {
		        "siteid": 291995,
		        "smartwall": 1
		    };
		</script>
		<script type="text/javascript" src="//ab.airpush.com/apportal/v2/cdn/airpush.js"></script>
		<?php //} ?>

         <!-- NETSEER AD IN-IMAGE -->
            <script type="text/javascript">
            netseer_tag_id="19129"; 
            </script>
            <script src="http://ps.ns-cdn.com/dsatserving2/scripts/ns_vmtag.js" type="text/javascript"></script>
		

        <!-- kixer adhesion -->
        <!-- Start Pucker Mob - Adhesion - iframe buster code -->
        <div id='__kx_ad_4915'></div>
        <script type="text/javascript" language="javascript" id="__kx_tag_4915">
        var __kx_ad_slots = __kx_ad_slots || [];

        (function () {
          var slot = 4915;
          var h = false;
          var doc = document;
          __kx_ad_slots.push(slot);
          if (typeof __kx_ad_start == 'function') {
            __kx_ad_start();
          } else {
            if (top == self) {      var s = doc.createElement('script');
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
              var x = doc.getElementsByTagName('script')[0];
              x.parentNode.insertBefore(s, x);
            } else {        var tag = doc.getElementById('__kx_tag_'+slot);       var win = window.parent;
              doc = win.document;       var top_div = doc.createElement("div");       top_div.id = '__kx_ad_'+slot;
              doc.body.appendChild(top_div);
              var top_tag = doc.createElement("script");      top_tag.id = '__kx_top_tag_'+slot;
              top_tag.innerHTML = tag.innerHTML;
              doc.body.appendChild(top_tag);
            }
          }
        })();
        </script>
        <!-- End Pucker Mob - Adhesion - iframe buster code -->
      <?php  } ?>
<?php  } ?>
      <?php if( $article_id != 14330 && $article_id != 11339 && $article_id != 14613 && $article_id != 8560 && $article_id != 15104 && $article_id != 15284 && $article_id != 15488 ){ ?>
          <script>
            (function() 
            { 
               var tagqa = '';
               var playerId = '';
               var playerContainerId = 'ad' + Math.round(Math.random()*1000000000).toString();
               var playerWidth = '300';
               var playerHeight = '250';
               var controls = '';
               var render = '';
               var tracki = '';
               var trackc = '';
               var custom1 = '';
               var custom2 = '';
               var custom3 = '';
               var videourl = '';
               var viewMode = 'normal';
               var companionId = '';
               var pubMacros = '';
               try { if (document.readyState && document.readyState != 'complete') { document.write('<div id="' + playerContainerId + '"></div>'); } } catch (e) {} 

               var lkqdVPAID;
               var lkqdId = new Date().getTime().toString() + Math.round(Math.random()*1000000000).toString();
               var environmentVars = { slot: document.getElementById(playerContainerId), videoSlot: document.getElementById(playerId), videoSlotCanAutoPlay: true };
               var creativeData = '';

               function onVPAIDLoad()
               {
                    lkqdVPAID.subscribe(function() { lkqdVPAID.startAd(); }, 'AdLoaded');
               }
               var vpaidFrame = document.createElement('iframe');
               vpaidFrame.id = lkqdId;
               vpaidFrame.name = lkqdId;
               vpaidFrame.style.display = 'none';
               vpaidFrame.onload = function() {
               vpaidLoader = vpaidFrame.contentWindow.document.createElement('script');
                    vpaidLoader.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//ad.lkqd.net/serve/pure.js?format=1&vpaid=true&apt=auto&ear=0&pid=85&sid=28814&tagqa=' + tagqa + '&elementid=' + encodeURIComponent(playerId) + '&containerid=' + encodeURIComponent(playerContainerId) + '&render=' + render + '&controls=' + controls + '&width=' + playerWidth + '&height=' + playerHeight + '&mode=' + viewMode + '&companionid=' + encodeURIComponent(companionId) + '&tracki=' + encodeURIComponent(tracki) + '&trackc=' + encodeURIComponent(trackc) + '&c1=' + encodeURIComponent(custom1) + '&c2=' + encodeURIComponent(custom2) + '&c3=' + encodeURIComponent(custom3) + '&videourl=' + encodeURIComponent(videourl) + '&rnd=' + Math.floor(Math.random() * 100000000) + '&m=' + encodeURIComponent(pubMacros);
                    vpaidLoader.onload = function() {
                          lkqdVPAID = vpaidFrame.contentWindow.getVPAIDAd();
                          lkqdVPAID.handshakeVersion('2.0');
                          onVPAIDLoad();
                          lkqdVPAID.initAd(playerWidth, playerHeight, viewMode, 600, creativeData, environmentVars);
                    };
                    vpaidFrame.contentWindow.document.body.appendChild(vpaidLoader);
               };
               document.documentElement.appendChild(vpaidFrame);
            })();
          </script>
      <?php  } ?>

  <?php } ?>

<?php } ?>

<!-- SHARETHROUNG -->
<script type="text/javascript" src="//native.sharethrough.com/assets/tag.js" async="true"></script>
    
<!-- TotallyHer comscore tags 
<script>var _comscore = _comscore || [];_comscore.push({ c1: "2", c2: "6036161" });(function() {var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";el.parentNode.insertBefore(s, el);})();</script><noscript><img src="http://b.scorecardresearch.com/p?c1=2&c2=6036161&cv=2.0&cj=1" /></noscript>
-->
<!-- ADSUPPLY 
<script data-cfasync="false" type="text/javascript">(function(s,o,l,v,e,d){if(s[o]==null&&s[l+e]){s[o]="loading";s[l+e](d,l=function(){s[o]="complete";s[v+e](d,l,!1)},!1)}})(document,"readyState","add","remove","EventListener","DOMContentLoaded");(function(){var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="//cdn.engine.4dsply.com/Scripts/infinity.js.aspx?guid=ce106c14-9ffe-4f0b-8cb8-c965d9d04213";s.id="infinity";s.setAttribute("data-guid","ce106c14-9ffe-4f0b-8cb8-c965d9d04213");s.setAttribute("data-version","async");var e=document.getElementsByTagName('script')[0];e.parentNode.insertBefore(s,e)})();</script>
-->
