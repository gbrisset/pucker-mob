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
        <div id="atf-ad" class="ad-unit ad300 show-on-large-up" style="height:auto;">
          <!-- 300x250: 300x250 --> 
          <div id="ros_1195"></div> 
        </div>
      <?php } ?>

      <!-- MOST POPULAR -->
      <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>

       <div id="btf1-ad" class="ad-unit ad300" style="height:auto;">
          <!-- puckermob.com/ros_btf 
          <script type="text/javascript">
            var ord = window.ord || Math.floor(Math.random() * 1e16);
            document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/ros_btf;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
          </script>
          <noscript>
            <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/ros_btf;sz=300x250;ord=[timestamp]?">
              <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/ros_btf;sz=300x250;ord=[timestamp]?" width="300" height="250" />
            </a>
          </noscript>-->
          <!-- 300x250 BTF: 300x250 --> 
          <div id="ros_1201"></div> 
       </div>
       
       <section id="sub-sidebar-3" class="sidebar show-on-large-up"  style="margin: 0.9375rem 0 !important;">
         <div class="h4-container" style="margin-bottom: 10px;"><h4 >From Our Partners</h4></div>
         <?php include_once($config['include_path'].'widget.php'); ?>
       </section>
        
       <div id="btf2-ad" class="ad-unit ad300" style="height:auto;">
          <!-- puckermob.com/ros_btf2 
          <script type="text/javascript">
            var ord = window.ord || Math.floor(Math.random() * 1e16);
            document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/ros_btf2;sect=ros_btf2;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=' + ord + '?"><\/script>');
          </script>
          <noscript>
          <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/ros_btf2;sect=ros_btf2;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=[timestamp]?">
          <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/ros_btf2;sect=ros_btf2;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=[timestamp]?" width="300" height="250" />
          </a>
          </noscript>-->
           <!-- 300x250 BTF: 300x250 --> 
          <div id="ros_1203"></div> 
       </div>

  <?php }else{ ?>
      
      <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>

      <?php if(isset($has_sponsored) && $has_sponsored){ /*DO NOTHING*/ }
      else{?>
         <div id="btf1-ad" class="ad-unit ad300 show-on-large-up" style="height: auto;">
            <!-- puckermob.com/home 
            <script type="text/javascript">
            var ord = window.ord || Math.floor(Math.random() * 1e16);
            document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home;sect=home;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
            </script>
            <noscript>
              <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home;sect=home;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
                <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home;sect=home;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" width="300" height="250" />
              </a>
            </noscript>-->
            <!-- 300x250 BTF: 300x250 --> 
            <div id="home_1185"></div> 
          </div>
        
      <?php }?>

       <?php if(isset($has_sponsored) && $has_sponsored){ /*DO NOTHING*/ }
            else{?>
            <div id="btf2-ad" class="ad-unit ad300"  style="height: auto;">
              <!-- 300x250 BTF2: 300x250 --> 
              <div id="home_1187"></div> 
              <!-- puckermob.com/home_BTF 
              <script type="text/javascript">
                var ord = window.ord || Math.floor(Math.random() * 1e16);
                document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home_BTF;sect=home_BTF;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
             </script>
              <noscript>
                <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home_BTF;sect=home_BTF;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
                  <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home_BTF;sect=home_BTF;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" width="300" height="250" />
                </a>
              </noscript>-->
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
              <!-- puckermob.com/home_btf3 
              <script type="text/javascript">
                var ord = window.ord || Math.floor(Math.random() * 1e16);
                document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home_btf3;sect=home_btf3;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=' + ord + '?"><\/script>');
              </script>
              <noscript>
              <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home_btf3;sect=home_btf3;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=[timestamp]?">
                <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home_btf3;sect=home_btf3;sz=300x250;dc_ref='+encodeURIComponent(location.herf)+';ord=[timestamp]?" width="300" height="250" />
              </a>
              </noscript>-->
              <!-- 300x250: 300x250 --> 
            <div id="home_1183"></div> 
          </div>
          
          <section id="sub-sidebar-2" class="sidebar sticky" style="padding-top:10px; clear:both;">
            <a href="https://www.surveymonkey.com/r/QMXVYTC"> <img src="https://s3.amazonaws.com/pucker-mob/images/midnight.png"></a>
            <a href="http://www.puckermob.com/admin/register/"> <img src="https://s3.amazonaws.com/pucker-mob/images/themob.png" style="margin-bottom:15px;"></a>
                    <a href="#" class="back-to-top btn"> Back to top  &#8682; </a>

          </section>
  
   
        
          
        <?php }
      } 
  }?>
</aside>