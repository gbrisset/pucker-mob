<aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print">

    <?php 

    if( !isset($isVideoPage)  && isset($cat_name) ){
          $videoPlayer = false;
          switch($cat_name){
            case "hot-topics":
              $videoPlayer = "<script type='text/javascript' id='a226a2a6d15d3ede1b8b58a654153588'>try{ var s=document.createElement('script'); s.type='text/javascript'; s.src='http://www.mefeedia.com/newestentry/mf3.0.1.php?playerID=a226a2a6d15d3ede1b8b58a654153588'; document.body.appendChild(s);}catch(e){}</script>";
              break;

            case "relationships":
              $videoPlayer = "<script type='text/javascript' id='3df7d9a9e3aa77e7814948ca284a27d6'>try{ var s=document.createElement('script'); s.type='text/javascript'; s.src='http://www.mefeedia.com/newestentry/mf3.0.1.php?playerID=3df7d9a9e3aa77e7814948ca284a27d6'; document.body.appendChild(s);}catch(e){}</script>";
              break;

            case "entertainment":
              $videoPlayer = "<script type='text/javascript' id='5415aef0454ea1b1738927f50e6b0ffd'>try{ var s=document.createElement('script'); s.type='text/javascript'; s.src='http://www.mefeedia.com/newestentry/mf3.0.1.php?playerID=5415aef0454ea1b1738927f50e6b0ffd'; document.body.appendChild(s);}catch(e){}</script>";
              break;

            case "style":
              $videoPlayer = "<script type='text/javascript' id='12d86eab82f880c7f114132147d075c7'>try{ var s=document.createElement('script'); s.type='text/javascript'; s.src='http://www.mefeedia.com/newestentry/mf3.0.1.php?playerID=12d86eab82f880c7f114132147d075c7'; document.body.appendChild(s);}catch(e){}</script>";
              break;

            case "money":
              $videoPlayer = "<script type='text/javascript' id='c93fd061bc0b606a99feb96d19baaf23'>try{ var s=document.createElement('script'); s.type='text/javascript'; s.src='http://www.mefeedia.com/newestentry/mf3.0.1.php?playerID=c93fd061bc0b606a99feb96d19baaf23'; document.body.appendChild(s);}catch(e){}</script>";
              break;

            case "wellness":
              $videoPlayer = "<script type='text/javascript' id='f2f95855e9d44bbad9160b0592eafdfe'>try{ var s=document.createElement('script'); s.type='text/javascript'; s.src='http://www.mefeedia.com/newestentry/mf3.0.1.php?playerID=f2f95855e9d44bbad9160b0592eafdfe'; document.body.appendChild(s);}catch(e){}</script>";
              break;

            case "fun":
              $videoPlayer = "<script type='text/javascript' id='f2d9e62962e3eaa1599940fa84f3cf63'>try{ var s=document.createElement('script'); s.type='text/javascript'; s.src='http://www.mefeedia.com/newestentry/mf3.0.1.php?playerID=f2d9e62962e3eaa1599940fa84f3cf63'; document.body.appendChild(s);}catch(e){}</script>";
              break;

            default: 
              $videoPlayer = false;
              break;
          }
       } ?>

      <?php 
      $videoPlayer = false;
      if(isset($videoPlayer) && $videoPlayer){?>
        <section class="show-on-large-up"  style=" padding-bottom: 0.9rem;">
         <div class="h4-no-box-container" style="margin-bottom: 5px;">
            <h4>Featured Video</h4>
        </div>
        <div>
          <?php echo $videoPlayer; ?>
        <div>
     </section>
      <?php }?>

    <?php if ( isset($isArticle) && $isArticle ){?>
     
      <div id="atf-ad" class="ad-unit ad300 show-on-large-up"></div>
      <div id="atf1050-ad" class="ad-unit ad300 show-on-large-up"></div>

      <?php include_once($config['include_path'].'mostpopularrticles.php'); ?>
      
       <section id="sub-sidebar-2" class="sidebar shadow-on-large-up">
         <?php include_once($config['include_path'].'sidebarconnect.php'); ?>
         <?php //include_once($config['include_path'].'sistersite.php'); ?>
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
         <?php //include_once($config['include_path'].'sistersite.php'); ?>
      </section>

      <div id="btf2-ad" class="ad-unit ad300"></div>

      <section id="sub-sidebar-3" class="sidebar shadow-on-large-up show-on-large-up"  style="margin: 0.9375rem 0 !important;">
         <div class="h4-container" style="margin-bottom: 10px;"><h4 >From Our Partners</h4></div>
         <?php include_once($config['include_path'].'widget.php'); ?>
      </section>

      <div id="btf3-ad" class="ad-unit ad300 show-on-large-up padding-top"></div>

    <?php } ?>
</aside>
