    
    <div class="clear padding-bottom" style="text-align: center;">
    <?php if ( $detect->isMobile() ) { ?>

    <?php }else{ 
      if(isset($has_sponsored) && $has_sponsored){ /*DO NOTHING*/ }
      else{?>
          <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
             <div id="footer-ad" class="ad-unit hide-for-print " style="max-width: 46rem; margin: 0 auto;">
                <!-- puckermob.com/ros_btf -->
                <script type="text/javascript">
                  var ord = window.ord || Math.floor(Math.random() * 1e16);
                  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/ros_btf;sz=728x90;dcopt=ist;type=pop;type=int;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
                </script>

                <noscript>
                  <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/ros_btf;sz=728x90;ord=[timestamp]?">
                    <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/ros_btf;sz=728x90;ord=[timestamp]?" width="728" height="90" />
                  </a>
                </noscript>
              </div>
           <?php }else{ ?>
            <div id="footer-ad" class="ad-unit"  style="max-width: 46rem; margin: 0 auto;">
              <!-- puckermob.com/home_BTF -->
              <script type="text/javascript">
               var ord = window.ord || Math.floor(Math.random() * 1e16);
                document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home_BTF;sect=home_BTF;sz=728x90;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
              </script>

              <noscript>
                <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home_BTF;sect=home_BTF;sz=728x90;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
                  <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home_BTF;sect=home_BTF;sz=728x90;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" width="728" height="90" />
                </a>
              </noscript>
          </div>
           <?php }?>
    <?php }
    } ?>
     </div>
    
    <footer class="hide-for-print">
      <div class="row">
      <div class="small-5 large-2 columns category-colors">
      </div>
        <div class="small-5 large-2 columns category-colors">
        </div>

        <div id="footer-right" class="large-6 columns">
        <div class="row">
          <ul class="inline-list">
            <li><h4>Connect with Us!</h4></li>
            <li> <a href="<?php echo $mpArticle->data['article_page_facebook_url'];?>" target="_blank"><i class="fa fa-facebook fade-in-out"></i></a></li>
            <li><a href="<?php echo $mpArticle->data['article_page_twitter_url'];?>" target="_blank"><i class="fa fa-twitter fade-in-out"></i></a></li>
            <li><a href="<?php echo $mpArticle->data['article_page_pinterest_url'];?>" target="_blank"><i class="fa fa-pinterest fade-in-out"></i></a></li>
            <li><a href="https://plus.google.com/b/112707727253651609975/112707727253651609975/posts" target="_blank" rel="publisher"><i class="fa fa-google-plus fade-in-out"></i></a></li>
          </ul>
        </div>
      
        </div>
      </div>
      <div class="row">
      <hr style="margin:  0.5rem 0 0.8rem; border-bottom: 1px solid #777; border-top: none; ">
      <div id="footer-logo" class="large-4 columns">
        <a href="http://sequelmediainternational.com/" target="_blank"><img src="data:image/png;base64,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" alt="Sequel Media Group" /></a>
      </div>
      <div id="legal-links" class="large-8 columns">
          <ul class="inline-centered translate-fix">
            <li>© 2014 <a href="http://sequelmediainternational.com/" target="_blank">Sequel Media Group</a>. All Rights Reserved.</li>
            <li><a href="http://sequelmediainternational.com" target="_blank">Publications</a></li>
            <li><a href="http://www.puckermob.com/policy/#privacy">Privacy</a></li>
            <li><a href="http://www.puckermob.com/policy">Legal</a></li>
            <li><a href="http://www.sequelmediainternational.com" target="_blank">Advertise</a></li>
          </ul>
      </div>
      </div>
    </footer>

    <?php include_once($config['include_path'].'ads_to_load.php');?>
