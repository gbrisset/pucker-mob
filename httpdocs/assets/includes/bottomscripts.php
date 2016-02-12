

<script type="text/javascript" src="http://www.puckermob.com/assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/foundation.min.js"></script>
<?php if (!$local){?>
  <script type="text/javascript" src="http://www.puckermob.com/assets/js/app.min.js" ></script>

  <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
    
  <?php } ?>
<?php }else {?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/plugins.js" ></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/js_scroll.js" ></script>
<?php }?>

<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/ads.js" ></script>

<!-- DESKTOP -->
<?php if ( !$detect->isMobile() ) { ?>

    <!--[if !IE]>
    <script type="text/javascript" src="http://uac.advertising.com/wrapper/aceFIF.js "></script>
    <![endif]-->

    <div id="evolve_footer"></div>

    <!-- NETSEER AD IN-IMAGE-->
    <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
        
       <script type="text/javascript">
          netseer_tag_id="19129";
          netseer_task="in-image";
        </script>
        <script type="text/javascript" src="http://ps.ns-cdn.com/dsatserving2/scripts/netseerads.js"></script>

    <?php } 

    if( isset($promotedArticle) && !$promotedArticle ){ ?>
      <!-- SHARETHROUNG -->
      <script type="text/javascript" src="//native.sharethrough.com/assets/tag.js"></script>
    <?php }?>


    <!-- TABOOLA -->
    <script type="text/javascript">
    window._taboola = window._taboola || [];
    _taboola.push({flush: true});
  </script>


<!-- MOBILE -->
<?php }else{ ?>
<?php if(isset($article_id) && $article_id == 9397 ){?>
<div id="evolve_footer"></div>
<?php } ?>


<?php if( isset($promotedArticle) && !$promotedArticle ){ 
  

  if(isset($articleInfoObj) && $articleInfoObj){ ?>
    
     <!-- ANSWERS -->
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
                incontent_desktop_id: "",
                target_type: "mobile",
                        });
        </script>
        
      <!-- NETSEER AD IN-IMAGE -->
           <script type="text/javascript">
            netseer_tag_id="20429";
            netseer_task="in-image";
           </script>
           <script type="text/javascript" src="http://ps.ns-cdn.com/dsatserving2/scripts/netseerads.js"></script>
        
    <?php  } ?>

      <?php if(isset($article_id) && $article_id == 12134 ){?>


      <?php } ?>

  <?php } ?>  
  
<?php } ?>

<!-- cloudfront tracker -->
<script>
  !function(g,s,q,r,d){r=g[r]=g[r]||function(){(r.q=r.q||[]).push(
  arguments)};d=s.createElement(q);q=s.getElementsByTagName(q)[0];
  d.src='//d1l6p2sc9645hc.cloudfront.net/tracker.js';q.parentNode.
  insertBefore(d,q)}(window,document,'script','_gs');
  _gs('GSN-829786-N');
</script>


<!-- TotallyHer comscore tags -->
<script>var _comscore = _comscore || [];_comscore.push({ c1: "2", c2: "6036161" });(function() {var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";el.parentNode.insertBefore(s, el);})();</script><noscript><img src="http://b.scorecardresearch.com/p?c1=2&c2=6036161&cv=2.0&cj=1" /></noscript>


<!-- ADSUPPLY -->
<script data-cfasync="false" type="text/javascript">(function(s,o,l,v,e,d){if(s[o]==null&&s[l+e]){s[o]="loading";s[l+e](d,l=function(){s[o]="complete";s[v+e](d,l,!1)},!1)}})(document,"readyState","add","remove","EventListener","DOMContentLoaded");(function(){var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="//cdn.engine.4dsply.com/Scripts/infinity.js.aspx?guid=ce106c14-9ffe-4f0b-8cb8-c965d9d04213";s.id="infinity";s.setAttribute("data-guid","ce106c14-9ffe-4f0b-8cb8-c965d9d04213");s.setAttribute("data-version","async");var e=document.getElementsByTagName('script')[0];e.parentNode.insertBefore(s,e)})();</script>