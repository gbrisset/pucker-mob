
<script type="text/javascript">
var x=0;
function rotate_ads(){
	if(x%2==0){
	document.getElementById('smf-ad-refresh-1').style.display='block';
	document.getElementById('smf-ad-refresh-2').style.display='none';
	 }else{
	document.getElementById('smf-ad-refresh-1').style.display='none';
	document.getElementById('smf-ad-refresh-2').style.display='block';
	}//end if
	x++;
}//end function
onload = function(){setInterval(rotate_ads, 30000); };
</script>
<div id="smf-ad-refresh-1" style="display: block;">
<!-- below img amazon -->
<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
<script type="text/javascript" language="javascript">
  //<![CDATA[
    aax_getad_mpb({
      "slot_uuid":"c8a8da06-2c28-4e1d-bb97-57f9642939bf"
    });
  //]]>
</script>	
</div>
<div id="smf-ad-refresh-2" style="display: none;">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- PM Mobile Below Picture -->
	<ins class="adsbygoogle"
	style="display:inline-block;width:320px;height:50px"
	data-ad-client="ca-pub-8978874786792646"
	data-ad-slot="5086819785"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
</div>
