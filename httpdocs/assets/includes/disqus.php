
<section id="disqus-comments" class="sidebar-right small-12 columns hide-for-print no-padding"> 
   
<h2 id="disqus-container">We'd love to hear what you have to say!</h2>

<?php if($detect->isMobile()){?>
  <!--  <button class="facebook-comments-button show">FACEBOOK COMMENTS</button>-->
    <div class="fb-comments" data-href="<?php echo $article_link; ?>" data-width:"320" data-numposts="5" data-colorscheme="light"></div>
<?php }else{?>
<div class="fb-comments" data-href="<?php echo $article_link; ?>" data-width="650" data-numposts="5" data-colorscheme="light"></div>
<?php }?>


</section>