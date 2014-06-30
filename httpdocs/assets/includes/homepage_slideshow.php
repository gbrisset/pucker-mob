<?php 
$slideshow = SlideShow::get_slideshow_elements();
if(isset($slideshow ) && $slideshow ){ ?>
<div class="slideshow-wrapper">
<section class="sidebar-right small-12 column">
  <ul data-orbit data-options="slide_number: false; bullets: false; timer_speed: 6000;">
    <?php foreach( $slideshow as $slide ){?>
    <li>
      <a class="prefetch" href="<?php echo $slide->slideshow_url; ?>">
        <img src="<?php echo $config['image_url'].'articlesites/simpledish/flex_test_images/'.$slide->slideshow_image; ?>" />
      </a>
      <a href="<?php echo $slide->slideshow_url; ?>">
        <div class="orbit-caption">
          <h3><?php echo $slide->slideshow_title; ?></h3>
          <?php echo $slide->slideshow_desc; ?>
        </div>
      </a>
    </li>
    <?php }?>
  </ul>
<hr>
</section>
</div>
<?php }?>