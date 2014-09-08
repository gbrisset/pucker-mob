<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>
<?php if ( !$detect->isMobile() ) { ?>
<?php /* AdsNative.com */ ?>
<script type="text/javascript" src="http://static.adsnative.com/static/js/render.v1.js"></script>

<!-- GUM GUM -->

<script type="text/javascript" src="http://g2.gumgum.com/javascripts/ggv2.js"></script>

    <!-- Vibrant Media Ads -->
    <script type="text/javascript" src="http://puckermob.us.intellitxt.com/intellitxt/front.asp?ipid=70526"></script>

<?php }else{ ?>
<!-- SHARETHROUNG -->
    <script type="text/javascript" src="//native.sharethrough.com/assets/tag.js"></script>

    <!-- Vibrant Media Ads -->
    <script type="text/javascript" src="http://puckermob.us.intellitxt.com/intellitxt/front.asp?ipid=70527"></script>
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