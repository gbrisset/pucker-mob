
<script type="text/javascript">
var x=0;
function rotate_ads(){
	if(x%2==0){
	document.getElementById('mbl-featured-ad-refresh-1').style.display='block';
	document.getElementById('mbl-featured-ad-refresh-2').style.display='none';
	 }else{
	document.getElementById('mbl-featured-ad-refresh-1').style.display='none';
	document.getElementById('mbl-featured-ad-refresh-2').style.display='block';
	}//end if
	x++;
}//end function
onload = function(){setInterval(rotate_ads, 30000); };
</script>
<!-- featured ad rotation - amazon -->

</div>
<!-- featured ad rotation - Google-->
<div id="mbl-featured-ad-refresh-2" style="display: none;">

</div>
