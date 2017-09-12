
<script type="text/javascript">
var x=0;
function rotate_ads(){
	if(x%2==0){
	document.getElementById('dsk-sidebar-ad-refresh-1').style.display='block';
	document.getElementById('dsk-sidebar-ad-refresh-2').style.display='none';
	 }else{
	document.getElementById('dsk-sidebar-ad-refresh-1').style.display='none';
	document.getElementById('dsk-sidebar-ad-refresh-2').style.display='block';
	}//end if
	x++;
}//end function
onload = function(){setInterval(rotate_ads, 30000); };
</script>

<!-- sidebar-02 ad rotation - amazon -->
<div id="dsk-sidebar-02-ad-refresh-1" style="display: block;">
	<!-- Amazon-2 -->
	<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
	<script type="text/javascript" language="javascript">
	//<![CDATA[
	aax_getad_mpb({
	"slot_uuid":"a19421b0-d555-476b-ba63-e6b89e44cf93"
	});
	//]]>
	</script>
</div>

<!-- sidebar-02 ad rotation - Google-->
<div id="dsk-sidebar-02-ad-refresh-2" style="display: none;">

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
