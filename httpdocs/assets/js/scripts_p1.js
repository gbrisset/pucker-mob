$(document).on("pageload",function(){
	if($('body').hasClass('mobile')) {
	var $el, $ps, $up, totalHeight, parentOrgHeight = $('#article-content').outerHeight(), wishDisplayHeight = parentOrgHeight * 0.55;
	if($(".read-more")){
	$(".read-more").on('click', '.button', function(e) {
		e.preventDefault();		
		totalHeight = 0; $el = $(this); $p  = $el.parent(); $up = $p.parent(); $children = $up.children();	$shTAdHeight = $('.inarticle-ad').outerHeight();
		$children.each(function(){ totalHeight += $(this).outerHeight(); });
		totalHeight +=  $shTAdHeight;
		$up.css({ "height": $up.height(), "max-height": 9999 });
		$up.animate({ "height": "auto" },2000);
		$p.fadeOut();
		$('#grad').fadeOut();
		return false;
	});}
 }
});