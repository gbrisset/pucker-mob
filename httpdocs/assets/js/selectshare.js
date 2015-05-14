/* =====================================
 * :: Select Text to Share JS
 * 
 * @ Author: Hadrien Boyer
 * @ Website: http://hadrien-boyer.fr
 * @ v.0.1 - Last update : 2014/06/29
 * ===================================== */

<!------- Initialize Document ------->
$(document).ready(function() {
	// Parameters
	textToShare='';
		$(document).mousemove(function(m) { // if mouse move, we recalculate Tooltip's position
			// tooltip position
			generateTooltipPosition();
		});
});

<!------- Search for MouseUp ------->
$(document).mouseup(function() {
		$(document).mousemove(function(m) { // if mouse move, we recalculate Tooltip's position
			// Calcul if too far, too high ?
			generateTooltipPosition()				//	<-- TO DO : SUPPRIMER ?
		});
	
 var textToShare=getTextToShare();
 var shareTooltip=document.getElementById("shareTooltip");

	if (textToShare!='')showMeTooltip(); // if we have text to share… show me Tooltip !

});

<!------- Document Click on page ------->
$(document).click(function() {
 
 var textToShare=getTextToShare();

 var tooltipTitle = null;
 var newTooltipTitle = $("#shareTooltip").attr("title");
 	
	if (newTooltipTitle == "") return; // if no Tooltip content, goodbye!
	if (newTooltipTitle !== tooltipTitle) $('#shareTooltip').animate({ opacity: 0 }, 30); // if no new content is selected, Hide Tooltip with animation	  
	// if we have a Text to share, show Tooltip !
	if (textToShare != "") showMeTooltip();
});

<!------- Window Resize ------->
$(window).resize(function() {
	if ($('#shareTooltip').show()){ // if Tooltip exist, close it on window resize
		  $('#shareTooltip').animate({ opacity: 0 }, 30);
	}
});

<!------- INITIALIZE showMeTooltip Function - Rock & Roll ! ------->
function showMeTooltip() {
	var pageURL = window.location.toString(); // URL of current Page
	var twitterLink = "https://twitter.com/intent/tweet?text="+getTextToShare()+"&via="+twitterAccount+"&url="+pageURL;
	
	$('#shareTooltip').show(); // Show Tooltip
	$('#shareTooltip').animate({ opacity: 1 }, 30); // Launch CSS animation
	$('#sendToTwitter').attr('href', twitterLink ); // Create the Twitter Link
}

<!------- INITIALIZE getTextToShare Function ------->
function getTextToShare(){
		
		shareTxt = '';
		if(window.getSelection) { // let's try two different methods
                shareTxt = window.getSelection();
				generateTooltipPosition();
            }
            else if(document.getSelection) {
				shareTxt = document.getSelection();
				generateTooltipPosition();
            }
			return shareTxt;
}

<!------- INITIALIZE generateTooltipPosition Function ------->
function generateTooltipPosition(){

	var selection = window.getSelection && window.getSelection();
	if (selection && selection.rangeCount > 0) { // if Selection ?…
			// calcul Range, Position, etc…
			range = selection.getRangeAt(0);
			pos = $(window).scrollTop();
			selection_text = selection.toString(),
			rect = range.getBoundingClientRect();
				// Calculate Tooltip Position
				$('#shareTooltip').css({
						top: (rect.top + pos - 20) - 32 + 'px', // 10 = margin-Top of the Tooltip, and 32 = Tooltip height (px)
						left: rect.left + (rect.width/2) + 'px',
					});
		} // end of if Selection
}
