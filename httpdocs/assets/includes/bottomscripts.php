<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js"></script>
<?php if ( !$detect->isMobile() ) { ?>
<?php /* AdsNative.com */ ?>
<script type="text/javascript" src="http://static.adsnative.com/static/js/render.v1.js"></script>
<?php /* Ad Supply */ ?>
<script data-cfasync="false" type="text/javascript">
(function(s,o,l,v,e,d){if(s[o]==null&&s[l+e]){s[o]="loading";s[l+e](d,l=function(){s[o]="complete";s[v+e](d,l,!1)},!1)}})(document,"readyState","add","remove","EventListener","DOMContentLoaded");
(function() {
var s = document.createElement("script"); s.type = "text/javascript"; s.async = true;
s.src = "http://cdn.engine.4dsply.com/Scripts/infinity.js.aspx?guid=490ee41f-4f8d-4fdf-a842-6a22653ade24";
s.id = "infinity"; s.setAttribute("data-guid", "490ee41f-4f8d-4fdf-a842-6a22653ade24"); s.setAttribute("data-version", "async");
var e = document.getElementsByTagName('script')[0]; e.parentNode.insertBefore(s, e);
})();
</script>

<?php } else { ?>
<script type="text/javascript" src="http://ads.crisppremium.com/partners/simple_dish/simple_dish.js?%param%&c=%click%&v=%view%"></script>
<?php } ?>

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