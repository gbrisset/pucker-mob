
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

<!-- sidebar-01 ad rotation - amazon -->
<div id="dsk-sidebar-01-ad-refresh-1" style="display: block;">
	<!-- Amazon-1 -->
	<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
	<script type="text/javascript" language="javascript">
	//<![CDATA[
	aax_getad_mpb({
	"slot_uuid":"07cc8194-4eca-4036-8ef3-43e0a582fdbd"
	});
	//]]>
	</script>
</div>

<!-- sidebar-01 ad rotation - Google-->
<div id="dsk-sidebar-01-ad-refresh-2" style="display: none;">



</div>
