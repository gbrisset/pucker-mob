

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


           <?php include($config['include_path'] . 'ads/Answers_CrossPixel_Puckermob.php');?>

  <!--[if !IE]>
    <script type="text/javascript" src="http://uac.advertising.com/wrapper/aceFIF.js "></script>
    <![endif]-->

<?php if ( !$detect->isMobile() ) { 
// DESKTOP ************************************************************** 
 if(isset($articleInfoObj) && $articleInfoObj){

      $article_id = 1*$articleInfo['article_id'] ;

       switch ($article_id) {
        case 27296: // moblog/what-time-doesnt-heal-you-have-to-heal-yourself
        case 23319: // moblog/15-open-letters-to-leave-your-boyfriend
        case 25829: // moblog/what-do-you-do-when-you-feel-like-youre-parents-are-happy-for-everyone-else-but-you
        case 4019: // TEST PAGE DEDICATED TO BETHANY FOR DFP TESTING /relationships/how-to-date-when-you-are-broke
          //do nothing - we do not want other ads to interfer with the test page
          break;
    
      
        default:
             // include($config['include_path'] . 'ads/answer_tout.php');
             // include($config['include_path'] . 'ads/btmscript_videomosh.php');


       }//end switch ($article_id)

?>
     <!--SHAREBUTTONS BAR VERTICAL-->
      <div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style" style="left:0px; top:150px;">
          <a class="a2a_button_facebook a2a_button_facebook"></a>
          <a class="a2a_button_twitter"></a>
          <a class="a2a_button_google_plus"></a>
          <a class="a2a_button_pinterest"></a>
          <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
      </div>
      <script async src="//static.addtoany.com/menu/page.js" async></script>

  <?php }//end  if(isset($articleInfoObj) ...  

   }else{ 
    
// MOBILE ************************************************************** 
    

 
 if(isset($articleInfoObj) && $articleInfoObj){

      $article_id = 1*$articleInfo['article_id'] ;

  if( isset($promotedArticle) && !$promotedArticle ){ 



           switch ($article_id) {
          // To test EPOM  -  - delete after august 31 2017
            // case  10855 : //  to-the-person-who-loves-me-next
            // case  18850 : //  im-not-the-girl-i-was-last-year-and-thats-okay
            // case  29271 : //  heres-your-daily-reminder-that-youre-not-an-option
            // case  30324 : //  he-doesnt-love-you-he-just-loves-the-idea-of-you
            // case  32372 : //  to-the-right-person-i-met-at-the-wrong-time-i-hope-one-day-itll-be-the-right-time
            // case  32860 : //  this-is-what-youll-miss-when-shes-had-enough
            // case  33885 : //  what-its-like-to-finally-be-narcissist-free
            // case  33890 : //  im-not-afraid-to-fight-with-you-because-i-would-fight-for-you-every-second-of-everyday
            // case  34146 : //  what-happened-to-dating-relationships-and-titles
            // case  34921 : //  the-type-of-douche-canoe-you-attract-based-on-your-zodiac-sig
            // case  35703 : //  8-qualities-you-should-be-looking-for-in-your-potential-partner
            // case  35839 : //  i-think-it-was-you-but-our-timing-was-off
            // case  36553 : //  to-the-guy-who-couldnt-decide-what-he-wanted
            // case  36574 : //  to-the-girl-who-needs-to-find-herself-again
            // case  36724 : //  to-the-girl-he-chose-over-me-heres-what-you-need-to-know
              // include($config['include_path'] . 'ads/epom_catfish.php');
              // break;

            case 29816: //  how-to-heal-your-broken-heart-based-on-your-zodiac  
            // // DO NOTHING 
            
            break;
            
            default:
              echo $smf_adManager->display_tags("mbl_overlay_bottom", $article_id);
              
           }//end switch ($article_id)





      } //end  if( isset($promotedArticle) 

    }//end  if(isset($articleInfoObj) && $articleInfoObj)

   }// end if ( !$detect->isMobile() ) ?>

