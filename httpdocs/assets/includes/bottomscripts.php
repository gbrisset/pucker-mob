

<script type="text/javascript" src="http://www.puckermob.com/assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="http://www.puckermob.com/assets/js/foundation.min.js"></script>

<?php if ($local){?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/plugins.js?<?php echo 'ver_' . date('Ymdgis') ?>" ></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.js?<?php echo 'ver_' . date('Ymdgis') ?>"></script>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/js_scroll.js?<?php echo 'ver_' . date('Ymdgis') ?>" ></script>
<?php }else {?>
  <script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/app.min.js?<?php echo 'ver_' . date('Ymdgis') ?>" ></script>
<?php }//end if ($local)?>



<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/ads.js?<?php echo 'ver_' . date('Ymdgis') ?>" ></script>


  <!--[if !IE]>
    <script type="text/javascript" src="http://uac.advertising.com/wrapper/aceFIF.js "></script>
    <![endif]-->

<?php if ( !$detect->isMobile() ) { 
// DESKTOP ************************************************************** 
 if(isset($articleInfoObj) && $articleInfoObj){ ?>
      <div id="vm_inline"></div>


                include($config['include_path'] . 'ads/answer_tout.php');

      <script>
           window._videomosh = window._videomosh || []; 
           !function (e, f, u) { 
               e.async = 1; 
               e.src = u; 
               f.parentNode.insertBefore(e, f); 
           }//end function
           (document.createElement('script'), 
           document.getElementsByTagName('script')[0], 
           "http://player.videomosh.com/players/loader/loader_final4.js"); 
           
           _videomosh.push({ 
               publisher_key: "sequelmedia", 
               mode: "slider", 
               container: "vm_inline", 
               incontent_mobile_id: "23002", 
               incontent_desktop_id: "42300", 
               target_type: "mix"
               //backfill: "<script async src='http://ads.allscreen.tv/embed?placement=181' ><\/scr"+"ipt>"
           }// end  _videomosh.push);
      </script>
    <?php }//end  if(isset($articleInfoObj) ...  ?>

   <?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
     <!--SHAREBUTTONS BAR VERTICAL-->
      <div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style" style="left:0px; top:150px;">
          <a class="a2a_button_facebook a2a_button_facebook"></a>
          <a class="a2a_button_twitter"></a>
          <a class="a2a_button_google_plus"></a>
          <a class="a2a_button_pinterest"></a>
          <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
      </div>
      <script async src="//static.addtoany.com/menu/page.js" async></script>

  <?php } 

   }else{ 
    
// MOBILE ************************************************************** 
    

    // disable the read more button ----------------------------------------------------------------------------------------------------------------------------

?><?php


       switch ($article_id) {
        case 23319: // moblog/15-open-letters-to-leave-your-boyfriend
        case 25829: // moblog/what-do-you-do-when-you-feel-like-youre-parents-are-happy-for-everyone-else-but-you
          
           break;
      
        default:
          // do nothing
       }//end switch ($article_id)

  if( isset($promotedArticle) && !$promotedArticle ){ 
      
        $selected_articles_lelo = array(16562 , 17425 ,14479 ,14576 ,15109 ,15271 ,17286, 8560, 14613 , 15104 ,15284 ,15488, 14873 );
        
         if(in_array($article_id, $selected_articles_lelo)){

          // do nothing - no ads to interfer with Lelo paid content

         }else{ 

      // select ads ----------------------------------------------------------------------------------------------------------------------------
             switch ($article_id) {
              case 27296: // moblog/what-time-doesnt-heal-you-have-to-heal-yourself
              case 23319: // moblog/15-open-letters-to-leave-your-boyfriend
              case 25829: // moblog/what-do-you-do-when-you-feel-like-youre-parents-are-happy-for-everyone-else-but-you
                //do nothing - we do not want other ads to interfer with the test page
                break;

              case 22475: // not sure why this is separated -- GB 2017-02-27
                include($config['include_path'] . 'ads/spoutable.php');
                break;

              default:
                // include($config['include_path'] . 'ads/adhesion_iframe_buster.php');
                include($config['include_path'] . 'ads/adhesion_kixer.php');


             }//end switch ($article_id)



             include($config['include_path'] . 'ads/lkqdVPAID_script.php'); // not sure what that does -- GB 2017-02-27

        }//end if( in_array($article_id, $selected_articles_lelo)

      } //end  if( isset($promotedArticle) 

   }// end if ( !$detect->isMobile() ) ?>

