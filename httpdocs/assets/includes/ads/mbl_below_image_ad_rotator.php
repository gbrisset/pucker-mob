<script>
// $(document).ready(function(){setTimeout(mbl_below_img_replace_ad, 60000); });// end $(document)...
// window.onload(function(){setTimeout(mbl_below_img_replace_ad, 60000); });

function mbl_below_img_replace_ad(){
	var	s2 = '<!-- below img ad rotation - Google --><sc'+'ript async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></scr'+'ipt> <ins class="adsbygoogle"style="display:inline-block;width:320px;height:50px"data-ad-client="ca-pub-8978874786792646"data-ad-slot="5086819785"></ins> <sc'+'ript> (adsbygoogle = window.adsbygoogle || []).push({}); </scr'+'ipt>';

	$("#mbl_below_img_ad").empty();
	$("#mbl_below_img_ad").append(s2);
	$("#mbl_below_img_ad").css('border-color: #ff0000', 'border-style: solid', '    border-width: 2px;');
}//end function
</script>

<div id="mbl_below_img_ad" style="display: block;">
<!-- below img ad rotation - Amazon -->
<script type="text/javascript" language="javascript" src="//c.amazon-adsystem.com/aax2/getads.js"></script>
<script type="text/javascript" language="javascript">
  //<![CDATA[
    aax_getad_mpb({
      "slot_uuid":"c8a8da06-2c28-4e1d-bb97-57f9642939bf"
    });
  //]]>
</script>
<script type="text/javascript">setTimeout(mbl_below_img_replace_ad, 60000);</script>
</div>
