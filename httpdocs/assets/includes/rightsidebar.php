<aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print">

    <?php if ( isset($isArticle) && $isArticle ){?>
     
       <!-- SMARTIES PROMOTION -->
      <?php if($promotedArticle){?>
      <div class="padding-bottom  show-on-large-up">
        <!--JavaScript Tag // Tag for network 5470: Sequel Media Group // Website: Pucker Mob // Page: 1 pg Aritcle // Placement: 300 ATF (3243114) // created at: Oct 14, 2014 11:09:55 AM-->
        <script language="javascript"><!--
        document.write('<scr'+'ipt language="javascript1.1" src="http://adserver.adtechus.com/addyn/3.0/5470.1/3243114/0/170/ADTECH;loc=100;target=_blank;key=smarties;grp=[group];misc='+new Date().getTime()+'"></scri'+'pt>');
        //-->
        </script><noscript><a href="http://adserver.adtechus.com/adlink/3.0/5470.1/3243114/0/170/ADTECH;loc=300;key=smarties;grp=[group]" target="_blank"><img src="http://adserver.adtechus.com/adserv/3.0/5470.1/3243114/0/170/ADTECH;loc=300;key=smarties;grp=[group]" border="0" width="300" height="250"></a></noscript>
        <!-- End of JavaScript Tag -->
      </div>

      <?php }else{?> 
      
      <div id="atf-ad" class="ad-unit ad300 show-on-large-up"></div>
      <div id="atf1050-ad" class="ad-unit ad300 show-on-large-up"></div>
      
      <?php } ?>

      <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>
      
       <section id="sub-sidebar-2" class="sidebar">
         <?php include_once($config['include_path'].'sidebarconnect.php'); ?>
       </section>

       <div id="btf1-ad" class="ad-unit ad300"></div>
       
       <section id="sub-sidebar-3" class="sidebar show-on-large-up"  style="margin: 0.9375rem 0 !important;">
         <div class="h4-container" style="margin-bottom: 10px;"><h4 >From Our Partners</h4></div>
         <?php include_once($config['include_path'].'widget.php'); ?>
       </section>
        
       <div id="btf2-ad" class="ad-unit ad300"></div>

    <?php }else{ ?>
      
      <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>

      <?php if(isset($has_sponsored) && $has_sponsored){ /*DO NOTHING*/ }
      else{?>
      <div id="btf1-ad" class="ad-unit ad300 show-on-large-up"></div>
      <div id="atf1050-ad" class="ad-unit ad300 show-on-large-up"></div>
       <?php }?>


      <section id="sub-sidebar-2" class="sidebar">
         <?php include_once($config['include_path'].'sidebarconnect.php'); ?>
         <?php //include_once($config['include_path'].'sistersite.php'); ?>
      </section>
 <?php if(isset($has_sponsored) && $has_sponsored){ /*DO NOTHING*/ }
      else{?>
      <div id="btf2-ad" class="ad-unit ad300"></div>
<?php }?>
      <?php if( !isset($isHomepage) ){ ?>
      <section id="sub-sidebar-3" class="sidebar show-on-large-up"  style="margin: 0.9375rem 0 !important;">
         <div class="h4-container" style="margin-bottom: 10px;"><h4 >From Our Partners</h4></div>
         <?php include_once($config['include_path'].'widget.php'); ?>
      </section>
       <div id="btf3-ad" class="ad-unit ad300"></div>
      <?php }else{ ?>
      
      <?php if(isset($has_sponsored) && $has_sponsored){ /*DO NOTHING*/ }
      else{?>
      <div id="btf3-ad" style="margin-top: 1rem !important; " class="ad-unit ad300"></div>
<?php }?>
    <?php } }?>
</aside>
