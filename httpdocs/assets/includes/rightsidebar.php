<aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print">

    <?php if ( isset($isArticle) && $isArticle ){?>
    <div id="social_widget" style="width: 300px; height: 250px; position: relative; overflow: hidden; left: -10000px;"></div>
    <script type="text/javascript" src="http://cdn.springboardplatform.com/storage/js/social_widget/sw.js" ></script>
    <script type="text/javascript">
    SbSocialWidget.init({
        partnerId : 3809,
        width : 300,
        height : 250,
        widgetId : 'spld004',
        cmsPath : 'http://cms.springboardplatform.com'
    });</script>

    <div id="atf-ad" class="ad-unit ad300 show-on-large-up"></div>
    <div id="atf1050-ad" class="ad-unit ad300 show-on-large-up"></div>

    <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>
    
     <section id="sub-sidebar-2" class="sidebar shadow-on-large-up">
       <?php include_once($config['include_path'].'sidebarconnect.php'); ?>
       <?php include_once($config['include_path'].'sistersite.php'); ?>
     </section>

     <div id="btf1-ad" class="ad-unit ad300"></div>
     <section id="sub-sidebar-3" class="sidebar shadow-on-large-up show-on-large-up"  style="margin: 0.9375rem 0 !important;">
       <div class="h4-container" style="margin-bottom: 10px;"><h4 >From Our Partners</h4></div>
       <?php include_once($config['include_path'].'widget.php'); ?>
     </section>
     <div id="btf2-ad" class="ad-unit ad300"></div>

    <?php }else{ ?>
   
    <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>

    <div id="btf1-ad" class="ad-unit ad300 show-on-large-up"></div>
    <div id="atf1050-ad" class="ad-unit ad300 show-on-large-up"></div>
    
    <section id="sub-sidebar-2" class="sidebar shadow-on-large-up">
       <?php include_once($config['include_path'].'sidebarconnect.php'); ?>
       <?php include_once($config['include_path'].'sistersite.php'); ?>
    </section>

    <div id="btf2-ad" class="ad-unit ad300"></div>

    <section id="sub-sidebar-3" class="sidebar shadow-on-large-up show-on-large-up"  style="margin: 0.9375rem 0 !important;">
       <div class="h4-container" style="margin-bottom: 10px;"><h4 >From Our Partners</h4></div>
       <?php include_once($config['include_path'].'widget.php'); ?>
    </section>

    <div id="btf3-ad" class="ad-unit ad300 show-on-large-up padding-top"></div>

    <?php } ?>
</aside>
