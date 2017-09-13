
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script>
$(document).ready(function(){setInterval(rotate_ads, 3000); });// end $(document)...
</script>

<script>
var	s2 = '<!-- below img ad rotation - Google --><sc'+'ript async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></scr'+'ipt> <ins class="adsbygoogle"style="display:inline-block;width:320px;height:50px"data-ad-client="ca-pub-8978874786792646"data-ad-slot="5086819785"></ins> <sc'+'ript> (adsbygoogle = window.adsbygoogle || []).push({}); </scr'+'ipt>';

$("#mbl-below-img-ad-refresh").css('border-color: #006600', 'border-style: solid', '    border-width: 2px;');
var x=0;
function rotate_ads(){
	if(x%2==0){

	$("#mbl-below-img-ad-refresh").empty();
	$("#mbl-below-img-ad-refresh").append(s2);
	$("#mbl-below-img-ad-refresh").css('border-color: #ff0000', 'border-style: solid', '    border-width: 2px;');

	 }else{

	}//end if
	x++;
}//end function

</script>
  
</head>
<body>

<div id="mbl-below-img-ad-refresh" style="display: block;">

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


<div>QWERTY</div>

</body>
</html>
