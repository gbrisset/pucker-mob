
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

<!-- sidebar-03 ad rotation - amazon -->
<div id="dsk-sidebar-03-ad-refresh-1" style="display: block;">
	<!-- Amazon-3 -->
	<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
	<script type="text/javascript" language="javascript">
	//<![CDATA[
	aax_getad_mpb({
	"slot_uuid":"2bef2550-d479-4b9b-9aea-31455c8df746"
	});
	//]]>
	</script>
</div>

<!-- sidebar-03 ad rotation - Google-->
<div id="dsk-sidebar-03-ad-refresh-2" style="display: none;">

	<!-- GOOGLE - FEATURED -->
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<ins class="adsbygoogle"
	     style="display:inline-block;width:300px;height:250px"
	     data-ad-client="ca-pub-8978874786792646"
	     data-ad-slot="7195535385"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>

</div>
