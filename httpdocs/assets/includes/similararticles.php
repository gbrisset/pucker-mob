<?php
$padding = " half-padding ";
$paddingTop = " ";
if($detect->isMobile()) $paddingTop = " padding-top bottom-border"; ?>

<?php if(isset($relatedArticles) && $relatedArticles){ ?>
<section id="similar-results" class="columns small-12 hide-for-print sidebar-right <?php echo $padding; ?>">
<hr class="show-for-xxlarge-only hr-hidden">
<hr>
	<h2 style="margin-top:30px;">Also in <span>PUCKERMOB:</span></h2>
	
</section>
<?php } ?>