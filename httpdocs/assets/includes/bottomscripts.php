

<script type="text/javascript" src="http://www.puckermob.com/assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/foundation.min.js"></script>
<?php if (!$local){?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.min.js?ver_5575" ></script>

<?php }else {?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/plugins.js" ></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/js_scroll.js" ></script>
<?php }?>

<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/ads.js?ver_35599" ></script>

  <!--[if !IE]>
    <script type="text/javascript" src="http://uac.advertising.com/wrapper/aceFIF.js "></script>
    <![endif]-->

<?php if ( !$detect->isMobile() ) { ?>
    <!-- DESKTOP -->

    <!-- NETSEER AD IN-IMAGE-->
    <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
     	
      <!-- LELO -->
      <?php if(isset($article_id) && $article_id != 16562 &&  $article_id != 17425 && $article_id != 14479 && $article_id != 14576  && $article_id != 8560 && $article_id != 14472 && $article_id != 15109 && $article_id != 15271  && $article_id != 15488 &&  $article_id  != 17286){?>
        <!-- NET SEER 
        <script type="text/javascript">
         netseer_tag_id="26742"; 
        </script>
        <script src="http://ps.ns-cdn.com/dsatserving2/scripts/ns_vmtag.js" type="text/javascript"></script>-->
      <?php } ?>
    <?php }  ?>

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

  <?php if($article_id == 11655 ){ ?>
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
<?php } ?>

<?php if($article_id == 14597){ ?>
  <SCRIPT TYPE="text/javascript">
    (function(){
        var data = {
            CM8Server       : "web2.checkm8.com",
            CM8Static       : "ch2lb.checkm8.com",
            CM8Cat          : "Will.Will_Category",
            CM8Id           : 874101,
            CM8Profile      : "",
            CM8Redir        : { click: "", ad_play: ""},
            CM8Req          : 'x',
            CM8NoBustIFrame : false,
            CM8RemoveIFrame : true,
            CM8IFrameBuster : ''
    };
    function auto(event, url, test) { if (! test.test(url)) data.CM8Redir[event] = data.CM8Redir[event] || url; }
    auto('click', '%%CLICK_URL_UNESC%%', /^%%/); auto('ad_play', '%%VIEW_URL_UNESC%%', /^%%/); /* DFP */
    auto('click', '%c', /^%[c]/); auto('ad_play', '%i', /^%[i]/); /* DFP Legacy */
    auto('click', '${clickurl}', /^\$/); /* Yahoo APT */
    auto('click', '{clickurl}', /^{/); /* OpenX */
    function callUrl(url) {
        var tag = document.createElement('script');
            tag.src = ((document.location.protocol=='https:')?'https':'http') + '://' + (data.CM8Static || data.CM8Server) + '/adam/' + url;
            var tagParent = document.body || document.head || document.documentElement;
            tagParent.insertBefore(tag, tagParent.firstChild);
    }
    if ((! data.CM8NoBustIFrame) && (top != window)) {
        var alone = window.CM8Cat;
        for (var p in data) window[p + (alone ? '_' + data.CM8Id : '')] = data[p];
        callUrl('cm8adam_iframe_buster' + (alone ? '_alone.js?' + data.CM8Id : '.js'));
    }
    else {
        if (document.currentScript && (document.currentScript.tagName == 'SCRIPT'))
            var anchor1 = document.currentScript;
        var scripts = document.getElementsByTagName('script');
        for (var i = 0; i < scripts.length; i++) {
            var text = (scripts[i].text || '').replace(/\s/g, '');
            if ((text.match(/[{,]CM8Id:([0-9]+)[,}]/) || {})[1] == data.CM8Id)
                var anchor2 = scripts[i];
            if ((text.match(/[{,]CM8Server:["']([^"']+)["'][,}]/) || {})[1] == data.CM8Server)
                var anchor3 = scripts[i];
        }
        var anchor = anchor1 || anchor2 || anchor3 || scripts[scripts.length - 1];
        var ph = document.createElement('div');
        ((anchor && anchor.parentNode) || document.body).insertBefore(ph, anchor || null);
        for (var p in data) ph[p] = data[p];
        window.CM8AjaxPH = window.CM8AjaxPH || [];
        window.CM8AjaxPH.push(ph);
        callUrl('cm8_detect_ad_ajax.js');
    }
    })();
    </SCRIPT>
<?php } ?>


<?php }else{ ?>
  <!-- MOBILE -->

  <?php if(  isset($promotedArticle) && !$promotedArticle ){ 
      
      if(isset($articleInfoObj) && $articleInfoObj){ ?>
        <!-- LELO -->
        <?php if(isset($article_id) && $article_id != 16562  &&  $article_id != 17425 && $article_id != 14479 && $article_id != 14576  && $article_id != 8560 
        && $article_id != 14613 && $article_id != 15104  && $article_id != 14873 && $article_id != 15271 && $article_id != 15284 
        && $article_id != 15488 &&  $article_id != 17286) { ?>
           <!-- NET SEER --> 
            <?php //if( $detect->is('iOS') == "1" ){?>
           
            <!--<script type="text/javascript">
            netseer_tag_id="26742"; 
            </script>
            <script src="http://ps.ns-cdn.com/dsatserving2/scripts/ns_vmtag.js" type="text/javascript"></script>-->
          <?php //} ?>
      <?php 
            $current_time = new DateTime(); // Today
            $start_time = new DateTime('3:00pm');
            $end_time  = new DateTime('11:59pm');
          
           // if ( $current_time->getTimestamp() > $start_time->getTimestamp() && $current_time->getTimestamp() < $end_time->getTimestamp()){ 
           
            ?>
            <!-- kixer adhesion -->
            <!-- Start Pucker Mob - Adhesion - iframe buster code 
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
            </script>-->
            <!-- End Pucker Mob - Adhesion - iframe buster code -->
            <?php  //} 
            ?>
       
      <?php  } ?>
    <?php  } ?>
      <?php if( $article_id != 16562  &&  $article_id != 17425 && $article_id != 14330 && $article_id != 11339 && $article_id != 14613 && $article_id != 8560 && $article_id != 15104 && $article_id != 15284 && $article_id != 15488 &&  $article_id  != 17286){ ?>
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
