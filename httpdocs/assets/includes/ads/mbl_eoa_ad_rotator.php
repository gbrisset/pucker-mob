
<script type="text/javascript">
var x=0;
function rotate_ads(){
	if(x%2==0){
	document.getElementById('mbl-eoa-ad-refresh-1').style.display='block';
	document.getElementById('mbl-eoa-ad-refresh-2').style.display='none';
	 }else{
	document.getElementById('mbl-eoa-ad-refresh-1').style.display='none';
	document.getElementById('mbl-eoa-ad-refresh-2').style.display='block';
	}//end if
	x++;
}//end function
onload = function(){setInterval(rotate_ads, 30000); };
</script>
<!-- EOA ad rotation - amazon -->
<div id="mbl-eoa-ad-refresh-1" style="display: block;">

	<!-- Amazon-4 -->
	<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
	<script type="text/javascript" language="javascript">
	//<![CDATA[
	aax_getad_mpb({
	"slot_uuid":"03f85f04-b643-46d8-8e87-66735eac98f4"
	});
	//]]>
	</script>

</div>
<!-- EOA ad rotation - Google-->
<div id="mbl-eoa-ad-refresh-2" style="display: none;">

	<!--GOOGLE EOA --> 
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<ins class="adsbygoogle"
	     style="display:block"
	     data-ad-format="autorelaxed"
	     data-ad-client="ca-pub-8978874786792646"
	     data-ad-slot="4242068983"></ins>
	<script>
	     (adsbygoogle = window.adsbygoogle || []).push({});
	</script>


</div>
