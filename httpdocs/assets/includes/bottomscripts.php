

<script type="text/javascript" src="http://www.puckermob.com/assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/foundation.min.js"></script>
<?php if (!$local){?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.min.js?ver_55898" ></script>

<?php }else {?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/plugins.js" ></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/js_scroll.js" ></script>
<?php }//end if (!$local)?>

<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/ads.js?ver_3769" ></script>

  <!--[if !IE]>
    <script type="text/javascript" src="http://uac.advertising.com/wrapper/aceFIF.js "></script>
    <![endif]-->

<?php if ( !$detect->isMobile() ) { 
// DESKTOP ************************************************************** 
 if(isset($articleInfoObj) && $articleInfoObj){ ?>
      <div id="vm_inline"></div>
      <script>
           window._videomosh = window._videomosh || []; 
           !function (e, f, u) { 
               e.async = 1; 
               e.src = u; 
               f.parentNode.insertBefore(e, f); 
           }//end function
           (document.createElement('script'), 
           document.getElementsByTagName('script')[0], 
           "http://player.videomosh.com/players/loader/loader_final4.js"); 
           
           _videomosh.push({ 
               publisher_key: "sequelmedia", 
               mode: "slider", 
               container: "vm_inline", 
               incontent_mobile_id: "23002", 
               incontent_desktop_id: "42300", 
               target_type: "mix"
               //backfill: "<script async src='http://ads.allscreen.tv/embed?placement=181' ><\/scr"+"ipt>"
           }// end  _videomosh.push);
      </script>
    <?php }//end  if(isset($articleInfoObj) ...  ?>

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

  <?php } 

   }else{ 
    
// MOBILE ************************************************************** 
  if( isset($promotedArticle) && !$promotedArticle ){ 
      
      if(isset($articleInfoObj) && $articleInfoObj){ 
        //LELO
        if(isset($article_id) && $article_id != 16562  &&  $article_id != 17425 && $article_id != 14479 && $article_id != 14576  && $article_id != 8560 
        && $article_id != 14613 && $article_id != 15104  && $article_id != 14873 && $article_id != 15271 && $article_id != 15284 
        && $article_id != 15488 &&  $article_id != 17286 ){ 

               //     $current_time = new DateTime(); // Today
              //      $start_time = new DateTime('3:00pm');
              //      $end_time  = new DateTime('11:59pm');
              
               // if ( $current_time->getTimestamp() > $start_time->getTimestamp() && $current_time->getTimestamp() < $end_time->getTimestamp()){ 
           
            ?>
            <?php if( $articleInfoObj['article_id'] == 27296){?>
            <!-- TEST PAGE - article #27296 http://www.puckermob.com/moblog/what-time-doesnt-heal-you-have-to-heal-yourself  -->
            
                    <!-- Start Pucker Mob - Adhesion - iframe buster tag -->
                    <div id='__kx_ad_4915'></div>
                    <img id='__kx_ad_4915_px' src='%%VIEW_URL_UNESC%%http://cdn.kixer.com/img/transparent.gif?cb=%%CACHEBUSTER%%' />
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
                        if (top == self) {
                          var s = doc.createElement('script');
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
                        } else {
                          var tag = doc.getElementById('__kx_tag_'+slot);
                          var win = window.parent;
                          doc = win.document;
                          var top_div = doc.createElement("div");
                          top_div.id = '__kx_ad_'+slot;
                          doc.body.appendChild(top_div);
                          var top_tag = doc.createElement("script");
                          top_tag.id = '__kx_top_tag_'+slot;
                          top_tag.innerHTML = tag.innerHTML;
                          doc.body.appendChild(top_tag);
                        }
                      }
                    })();
                    </script>
                    <!-- End Pucker Mob - Adhesion - iframe buster code -->
      


            <!-- END OF TEST PAGE - article #27296 http://www.puckermob.com/moblog/what-time-doesnt-heal-you-have-to-heal-yourself  -->
            <?php  }else{ ?>

           <!-- ----- This ad is suspended until Adhesion figures out the test page above -- GB 2017-01-16 ----  -->
                  <!-- /73970039/UT_Adhesion -->
               <!--    <div id='div-gpt-ad-1481648465857-0' style='height:1px; width:1px;'>
                  <script>
                  googletag.cmd.push(function() { googletag.display('div-gpt-ad-1481648465857-0'); });
                  </script>
                  </div>  -->
          <!-- ----- END OF - This ad is suspended until Adhesion figures out the test page above -- GB 2017-01-16 ----  -->
           
              <!-- Start Pucker Mob - Adhesion -->

              <div id='__kx_ad_4915'></div>
              <img id='__kx_ad_4915_px' src='%%VIEW_URL_UNESC%%http://cdn.kixer.com/img/transparent.gif?cb=%%CACHEBUSTER%%' />
              <script type="text/javascript" language="javascript">
              var __kx_ad_slots = __kx_ad_slots || [];
              (function () {
                var slot = 4915;
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
 
              <!-- End Pucker Mob - Adhesion -->



             <?php  }// end if( $articleInfoObj['article_id'] == 27296 ?> 

               
              <!-- /73970039/UT_Adhesion_1x1 -->
           <!--  NOT sure if that is any use anymore - GB 01-10-2017
              <div id='div-gpt-ad-1483989302416-0' style='height:1px; width:1px;'>
              <script>
              googletag.cmd.push(function() { googletag.display('div-gpt-ad-1483989302416-0'); });
              </script>
              </div>                
 -->


            <?php if( $articleInfoObj['article_id'] == 22475){?>

              <!-- SPOUTABLE REPLACE ADHESION -->
              <script type='text/javascript'>
              (function(){
                var spoutjs=document.createElement('script'),firstjs=document.getElementsByTagName('script')[0];
                spoutjs.async=1;
                spoutjs.src='//cdn.spoutable.com/1deb0b13-48fb-4eec-8af0-a5e05f8b6272/spoutable.js';
                firstjs.parentNode.insertBefore(spoutjs,firstjs)
              })();
              </script>
           <?php  }// end if( $articleInfoObj['article_id'] == 22475 

            } //end  if(isset($article_id) ... 
       }//end if(isset($articleInfoObj) && $articleInfoObj) 

    if( $article_id != 16562  &&  $article_id != 17425 && $article_id != 14330 && $article_id != 11339 && $article_id != 14613 && $article_id != 8560 && $article_id != 15104 && $article_id != 15284 && $article_id != 15488 &&  $article_id  != 17286  &&  $article_id != 18521 && $article_id != 23564 ){ ?>
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

          

      <?php  } // enf if( $article_id != 16562 ... 

      } //end  if( isset($promotedArticle) 

   }// end if ( !$detect->isMobile() ) ?>

<!-- SHARETHROUGH -->
<script type="text/javascript" src="//native.sharethrough.com/assets/tag.js" async="true"></script>
