
<script type="text/javascript">
var x=0;
function rotate_ads(){
	if(x%2==0){
	document.getElementById('mbl-adstack-ad-refresh-1').style.display='block';
	document.getElementById('mbl-adstack-ad-refresh-2').style.display='none';
	 }else{
	document.getElementById('mbl-adstack-ad-refresh-1').style.display='none';
	document.getElementById('mbl-adstack-ad-refresh-2').style.display='block';
	}//end if
	x++;
}//end function
onload = function(){setInterval(rotate_ads, 30000); };
</script>
<!-- adstack ad rotation - amazon -->
<div id="mbl-adstack-ad-refresh-1" style="display: block;">

</div>
<!-- adstack ad rotation - Google-->
<div id="mbl-adstack-ad-refresh-2" style="display: none;">

</div>
