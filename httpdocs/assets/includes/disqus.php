

<?php if($detect->isMobile()){?>
    <button class="facebook-comments-button show margin-top"><label> LEAVE & READ COMMENTS</label></button>

	<section id="disqus-comments" class="sidebar-right small-12 columns hide-for-print no-padding margin-bottom"> 
    	<div class="fb-comments" id="fb-comments-box" data-href="<?php echo $article_link; ?>" data-width:"320" data-numposts="5" data-colorscheme="light"></div>
    </section>
<?php }else{?>
<section id="disqus-comments" class="sidebar-right small-12 columns hide-for-print no-padding"> 
	<h2 id="disqus-container">We'd love to hear what you have to say!</h2>
	<div class="fb-comments" data-href="<?php echo $article_link; ?>" data-width="650" data-numposts="5" data-colorscheme="light"></div>
</section>
<?php }?>

