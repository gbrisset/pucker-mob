

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
    
        case 11237: //  /moblog/girl-whos-just-his-friend
          // echo $smf_adManager->display_tags("mbl_overlay_bottom", $article_id);
          break;
      
        default:
             // include($config['include_path'] . 'ads/answer_tout.php');
             // include($config['include_path'] . 'ads/btmscript_videomosh.php');
              echo $smf_adManager->display_tags("mbl_overlay_bottom", $article_id);


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

            case 29816: //  how-to-heal-your-broken-heart-based-on-your-zodiac  
            // // DO NOTHING 
            
            break;
            
            default:
              echo $smf_adManager->display_tags("mbl_overlay_bottom", $article_id);
              
           }//end switch ($article_id)

      } //end  if( isset($promotedArticle) 

    }//end  if(isset($articleInfoObj) && $articleInfoObj)

   }// end if ( !$detect->isMobile() ) ?>

