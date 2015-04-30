
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="http://cdn-assets.puckermob.com/assets/js/foundation.min.js"></script>

<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/plugins.js" ></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/js_scroll.js" ></script>


<!-- DESKTOP -->
<?php if ( !$detect->isMobile() ) { ?>

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
      
  <!-- End WAHWAH Radio Player -->
  <?php //} ?>

<!-- MOBILE -->
<?php }else{ ?>

<?php if( isset($promotedArticle) && !$promotedArticle ){ ?>

  <!-- INFO LINK -->
  <script type="text/javascript">
    var infolinks_pid = 2431692;
    var infolinks_wsid = 0;
  </script>
  <script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>

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

<?php }?>

<!-- DESKTOP & MOBILE SCRIPT -->
<!-- [ === TOOLTIP init === ] -->
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

  <!-- ADDTHIS -->
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
  <!-- Begin comScore Tag -->
<script>var _comscore = _comscore || [];_comscore.push({ c1: "2", c2: "6036161" });(function() {var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";el.parentNode.insertBefore(s, el);})();</script><noscript><img src="http://b.scorecardresearch.com/p?c1=2&c2=6036161&cv=2.0&cj=1" /></noscript>
<!-- End comScore Tag -->


<!-- POPUNDERS 
<script data-cfasync="false" type="text/javascript">(function(s,o,l,v,e,d){if(s[o]==null&&s[l+e]){s[o]="loading";s[l+e](d,l=function(){s[o]="complete";s[v+e](d,l,!1)},!1)}})(document,"readyState","add","remove","EventListener","DOMContentLoaded");(function(){var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="//cdn.engine.4dsply.com/Scripts/infinity.js.aspx?guid=ce106c14-9ffe-4f0b-8cb8-c965d9d04213";s.id="infinity";s.setAttribute("data-guid","ce106c14-9ffe-4f0b-8cb8-c965d9d04213");s.setAttribute("data-version","async");var e=document.getElementsByTagName('script')[0];e.parentNode.insertBefore(s,e)})();</script>
-->