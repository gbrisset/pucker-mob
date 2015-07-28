<aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print" style="<?php if( $has_sponsored && $isHomepage ) echo 'right: -5px !important; ' ?>">
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
        <div id="atf-ad" class="ad-unit ad300 show-on-large-up" style="height:auto;"></div>
      <?php } ?>

      <!-- MOST POPULAR -->
      <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>

       <div id="btf1-ad" class="ad-unit ad300" style="height:auto;">
          <!-- puckermob.com/ros_btf -->
          <script type="text/javascript">
            var ord = window.ord || Math.floor(Math.random() * 1e16);
            document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/ros_btf;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
          </script>
          <noscript>
            <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/ros_btf;sz=300x250;ord=[timestamp]?">
              <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/ros_btf;sz=300x250;ord=[timestamp]?" width="300" height="250" />
            </a>
          </noscript>
       </div>
       
       <section id="sub-sidebar-3" class="sidebar show-on-large-up"  style="margin: 0.9375rem 0 !important;">
         <div class="h4-container" style="margin-bottom: 10px;"><h4 >From Our Partners</h4></div>
         <?php include_once($config['include_path'].'widget.php'); ?>
       </section>
        
       <div id="btf2-ad" class="ad-unit ad300" style="height:auto;">
          <!-- puckermob.com/ros_btf2 -->
          <script type="text/javascript">
            var ord = window.ord || Math.floor(Math.random() * 1e16);
            document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/ros_btf2;sect=ros_btf2;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=' + ord + '?"><\/script>');
          </script>
          <noscript>
          <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/ros_btf2;sect=ros_btf2;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=[timestamp]?">
          <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/ros_btf2;sect=ros_btf2;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=[timestamp]?" width="300" height="250" />
          </a>
          </noscript>
       </div>

  <?php }else{ ?>
      
      <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>

      <?php if(isset($has_sponsored) && $has_sponsored){ /*DO NOTHING*/ }
      else{?>
         <div id="btf1-ad" class="ad-unit ad300 show-on-large-up" style="height: auto;">
            <!-- puckermob.com/home -->
            <script type="text/javascript">
            var ord = window.ord || Math.floor(Math.random() * 1e16);
            document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home;sect=home;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
            </script>
            <noscript>
              <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home;sect=home;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
                <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home;sect=home;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" width="300" height="250" />
              </a>
            </noscript>
          </div>
        
          <!--<div id="atf1050-ad" class="ad-unit ad300 show-on-large-up"></div>-->
      <?php }?>

       <?php if(isset($has_sponsored) && $has_sponsored){ /*DO NOTHING*/ }
            else{?>
            <div id="btf2-ad" class="ad-unit ad300"  style="height: auto;">
              <!-- puckermob.com/home_BTF -->
              <script type="text/javascript">
                var ord = window.ord || Math.floor(Math.random() * 1e16);
                document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home_BTF;sect=home_BTF;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
             </script>
              <noscript>
                <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home_BTF;sect=home_BTF;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
                  <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home_BTF;sect=home_BTF;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" width="300" height="250" />
                </a>
              </noscript>
            </div>
      <?php }?>


      <?php if( !isset($isHomepage) ){ ?>
        <section id="sub-sidebar-3" class="sidebar show-on-large-up"  style="margin: 0.9375rem 0 !important;">
           <div class="h4-container" style="margin-bottom: 10px;"><h4 >From Our Partners</h4></div>
           <?php include_once($config['include_path'].'widget.php'); ?>
        </section>
        <div id="btf3-ad" class="ad-unit ad300"  style="height: auto;">
            <!-- puckermob.com/home_btf3 -->
            <script type="text/javascript">
              var ord = window.ord || Math.floor(Math.random() * 1e16);
              document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home_btf3;sect=home_btf3;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=' + ord + '?"><\/script>');
            </script>
            <noscript>
            <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home_btf3;sect=home_btf3;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=[timestamp]?">
              <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home_btf3;sect=home_btf3;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=[timestamp]?" width="300" height="250" />
            </a>
            </noscript>
        </div>
      <?php }else{ ?>
        <?php if(isset($has_sponsored) && $has_sponsored){ /*DO NOTHING*/ }
        else{?>
          <div id="btf3-ad" style="margin-top: 1rem !important; " class="ad-unit ad300"  style="height: auto;">
              <!-- puckermob.com/home_btf3 -->
              <script type="text/javascript">
                var ord = window.ord || Math.floor(Math.random() * 1e16);
                document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home_btf3;sect=home_btf3;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=' + ord + '?"><\/script>');
              </script>
              <noscript>
              <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home_btf3;sect=home_btf3;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=[timestamp]?">
                <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home_btf3;sect=home_btf3;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=[timestamp]?" width="300" height="250" />
              </a>
              </noscript>
          </div>

          <section id="sub-sidebar-2" class="sidebar sticky">
            <a href="https://www.surveymonkey.com/r/QMXVYTC"> <img src="https://s3.amazonaws.com/pucker-mob/images/midnight.png"></a>
            <a href="http://www.puckermob.com/admin/register/"> <img src="https://s3.amazonaws.com/pucker-mob/images/themob.png"></a>
          </section>
        <?php }
      } 
  }?>
</aside>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script>
/*$(document).ready(function() {
        function isScrolledTo(elem) {
            var docViewTop = $(window).scrollTop(); //num of pixels hidden above current screen
            var docViewBottom = docViewTop + $(window).height();
 
            var elemTop = $(elem).offset().top; //num of pixels above the elem
            var elemBottom = elemTop + $(elem).height();
 
            return ((elemTop <= docViewTop));
        }
 
        var catcher = $('.catcher');
        var sticky = $('.sticky');
 
        $(window).scroll(function() {
            if(isScrolledTo(sticky)) {
                sticky.css('position','fixed');
                sticky.css('top','0px');
            }
            var stopHeight = catcher.offset().top + catcher.height();
            if ( stopHeight > sticky.offset().top) {
                sticky.css('position','absolute');
                sticky.css('top',stopHeight);
            }
        });
    });*/
</script>




