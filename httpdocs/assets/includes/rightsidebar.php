<aside id="aside" class="fixed-width-sidebar column no-padding hide-for-print">

    <?php if( isset($cat_name) ){
       //var_dump($cat_name);
        switch ( $cat_name ){
          case 'hot-topics':
            $flexVideoPlayer = '<script language="javascript" type="text/javascript" src="http://player.grabnetworks.com/js/Player.js?id=2250547&width=280&height=225&content=pff4f0fe0db43424bfb9a235f33eae8d414e960d4"></script>';
          break;

          case 'relationships':
             $flexVideoPlayer = '<script language="javascript" type="text/javascript" src="http://player.grabnetworks.com/js/Player.js?id=2250573&width=280&height=225&content=pcb9880e3597f623c0058188005a5c3a55e4ad195"></script>';
          break;

          case 'entertainment':
            $flexVideoPlayer = ' <script language="javascript" type="text/javascript" src="http://player.grabnetworks.com/js/Player.js?id=2250521&width=280&height=225&content=pa42bc4c480c622419761177b32bca231c2e53656"></script>';
          break;

          case 'style':
             $flexVideoPlayer = '<script language="javascript" type="text/javascript" src="http://player.grabnetworks.com/js/Player.js?id=2250611&width=280&height=225&content=p4b8220a8ad36ed2f045eae9e845a465003bb8f1b"></script>';
          break;

          case 'money':
             $flexVideoPlayer = '<script language="javascript" type="text/javascript" src="http://player.grabnetworks.com/js/Player.js?id=2250633&width=280&height=225&content=pe36f16724df8dcbb352023f867032a5dd5acded7"></script>';
          break;

          case 'wellness':
             $flexVideoPlayer = '<script language="javascript" type="text/javascript" src="http://player.grabnetworks.com/js/Player.js?id=2250653&width=280&height=225&content=pcfd59417f0abf3b3a91cab4000a85ac4f3e56c39"></script>';
          break;

          case 'fun':
             $flexVideoPlayer = '<script language="javascript" type="text/javascript" src="http://player.grabnetworks.com/js/Player.js?id=2250647&width=280&height=225&content=pba7891afe8f1571d62534ba1e00c2c5e552c97f0"></script>';
          break;

          default:
             $flexVideoPlayer = false;

        }

        if( isset( $flexVideoPlayer) && $flexVideoPlayer ){?>
         <section id="sub-sidebar-3" class="sidebar shadow-on-large-up show-on-large-up"  style="margin: 0 0 0.9375rem 0 !important;">
         <div class="h4-container" style="margin-bottom: 10px;"><h4 >Featured Video</h4></div>
            <?php echo $flexVideoPlayer; ?>
         </section>
      <?php } 
    } ?>

    <?php if ( isset($isArticle) && $isArticle ){?>
     
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
