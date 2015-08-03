  <?php

  $loginActive = isset($_SESSION['login_hash']) || isset($_SESSION['user_id']);

    $has_sponsored = $mpArticle->data['has_sponsored_by'];
 $user_type = 5;
  if(isset($_SESSION['user_id']) && $_SESSION['user_id']){
    $user_info = $mpArticle->getUserInfo();
    $user_first_name = "";
    $user_type = 5;
    $contributor_id = 0;
   
    if(isset($user_info) && $user_info){
      $user_first_name = $user_info["user_first_name"]; 
      $user_type = $user_info["user_type"];
      $contributor_id = $user_info["contributor_id"];
    }

    if($user_type == 5){
      $user_info = $follow->getReaderInfo();
    }
  }

 if(!$detect->isMobile()){

  $login_header = ' hide-header ';
  $logout_header = ' show-header ';
  $current_month = date('n');
  $current_year = date('Y');
 

  if($loginActive){
      $login_header = ' show-header ';
      $logout_header = ' hide-header ';
  }

  $this_month_earnigs = 0;
  $your_rank = 0;
  if($loginActive){

    $ManageDashboard = new ManageAdminDashboard( $config );
    //THIS MONTH EARNINGS
    $this_month_earnigs_info =  $ManageDashboard->getLastMonthEarnings($contributor_id, $current_month, $current_year);
    if($this_month_earnigs_info && $this_month_earnigs_info['total_earnings'] && !empty($this_month_earnigs_info['total_earnings']) ) $this_month_earnigs = $this_month_earnigs_info['total_earnings'];
  
    //WARNINGS
    $warnings = $ManageDashboard->getWarningsMessages(); 

    
    //Top Shared Writers
    $writers_arr = $ManageDashboard->getTopShareWritesRankHeader($current_month);
    
   if(isset($writers_arr) && $writers_arr){
    foreach ($writers_arr as $writer) {
       
       if($writer['contributor_id'] == $contributor_id ){
          break;
       }
       $your_rank++;
     } 
    }
 
  }

 ?>

 <!-- Social Media Icons -->
  
  <header id="top-banner" class="hide-for-print show-for-large-up top-header-logout <?php echo  $login_header; ?>" style="<?php if($has_sponsored && $isHomepage) echo 'max-width: 56.8rem !important'; ?>" >
    <div class="row" style="<?php if($has_sponsored && $isHomepage) echo 'max-width: 56rem !important'; else echo 'max-width: 69.5rem'; ?>">
      <div id="header-social" class="small-12 columns no-padding">
        <?php if($user_type == 5){?>
          <ul style="<?php if($has_sponsored && $isHomepage) echo 'max-width: 56rem !important'; ?>">
              <li><a class="my-account-header-link" id="my-account-header-link" href="<?php echo $config['this_admin_url'].'following/'; ?>">My Account</a></li>
              <li class="empty-list "></li>
              <li><a  class="my-account-header-link" href="<?php echo $config['this_admin_url']; ?>/logout/">LOG OUT </a></li>
              <li></li>
              <li class="right">
                <div id="topbar-container">
                  <input id="topbar-search-contents" class="topbar-search-contents" type="search" placeholder="SEARCH">
                  <button id="topbar-search-submit" class="alert button expand" style="background-color: #10580d;"><i class="fa fa-search"></i></button>
                </div>
              </li>
            </ul>
        <?php }else {?>
          <ul style="<?php if($has_sponsored && $isHomepage) echo 'min-width: 56rem !important'; ?>">
            <li style="margin-left: 1px;"> <a class="my-account-header-link" id="my-account-header-link" href="<?php echo $config['this_admin_url'].'/'; ?>">My Dashboard</a></li>
            <?php if($user_type != 6 && $user_type != 1 && $user_type != 7){?>
              <li class="empty-list "></li>
              <li class="hide-for-readers"> <p class="earnings-this-month">Earnings (this month): <?php echo '$'.number_format($this_month_earnigs, 2, '.', ','); ?></p></li>
            <?php }?>
            <li class="empty-list hide-for-readers"></li>
            <li class="hide-for-readers"> <p>Your rank: <?php echo $your_rank; ?></p> </li>
            <?php if( $warnings && $warnings[0]['notification_live']){?>
            <li class="warning hide-for-readers">
              <i class="fa fa-exclamation-triangle" id="warning-icon"></i>
              <div id="dd-shares-content" class="mobile-12 small-12">
                <div>
                    <p><?php echo $warnings[0]['notification_msg']?></p>
                </div>
              </div>
            </li>
            <?php }?>
            <li><a  class="my-account-header-link" href="<?php echo $config['this_admin_url']; ?>/logout/">LOG OUT </a></li>
            <li></li>
            <li class="right">
              <div id="topbar-container">
                <input id="topbar-search-contents-login"  value="" class="topbar-search-contents" type="search" placeholder="SEARCH">
                <button id="topbar-search-submit-login" class="alert button expand" style="background-color: #10580d;"><i class="fa fa-search"></i></button>
              </div>
            </li>
          </ul>
        <?php }?>
    </div>
  </div>
  </header>
  
  <header id="top-banner" class="hide-for-print show-for-large-up top-header-login <?php echo  $logout_header; ?>" style="<?php if($has_sponsored && $isHomepage) echo 'max-width: 56.8rem !important'; ?>" >
    <div class="row" style="<?php if($has_sponsored && $isHomepage) echo 'max-width: 56rem !important'; else echo 'max-width: 69.5rem'; ?>">
      <div id="header-social" class="small-12 columns no-padding">
        <ul style="<?php if($has_sponsored && $isHomepage) echo 'min-width: 56rem !important'; ?>">
            <li style="margin-left: 1px;"> <a class="my-account-header-link" href="https://www.facebook.com/puckermob" target="_blank"><i class="fa fa-facebook fade-in-out"></i></a></li>
            <li> <a class="my-account-header-link" href="https://twitter.com/Puckermob" target="_blank"><i class="fa fa-twitter fade-in-out"></i></a></li>
            <li class="empty-list "></li>
            <!--<li id="info-icon"><i class="fa fa-info-circle"></i></li>
            <li class="empty-list "></li>-->
            <li class="registration-link">
              <a class="my-account-header-link" href="http://www.puckermob.com/admin/register">REGISTER</a>
            </li>
            <li class="login-link">
              <a class="my-account-header-link" href="http://www.puckermob.com/admin/login">LOGIN</a>
            </li>
            <li class="right">
              <div id="topbar-container">
                <input id="topbar-search-contents" value="" class="topbar-search-contents" type="search" placeholder="SEARCH">
                <button id="topbar-search-submit" class="alert button expand" style="background-color: #10580d;"><i class="fa fa-search"></i></button>
              </div>
            </li>
        </ul>
    </div>
    </div>
  </header>
   
  <?php }?>
   
   <?php if($detect->isMobile()){?>
     <div id="social-media-container-header" class="row" style="display:none;"> 
        <div class="columns social-media-container  padding-bottom " style=" display:block !important;">
        <a class="addthis_button_facebook small-4 left">
          <label class="label-social-button-2-mobile left" ><i class="fa fa-facebook-square" ></i>SHARE</label>
        </a> 
        <a class="addthis_button_twitter  small-2 left">
          <label class="label-social-button-2-mobile left"><i class="fa fa-twitter"></i></label>
        </a> 
        <div class="addthis_jumbo_share  small-4 right hide-for-print social-buttons-top" style="height: 2.2rem !important;"></div>
    
      </div>  
     </div>  

  <!--  <div id="mobile-top-header-ad" class="top-header-ad row"></div> -->
  <?php }?>

  <?php if(!$detect->isMobile()){?>
    <div id="nav-bar" class="contain-to-grid hide-for-print" style="<?php if($has_sponsored && $isHomepage) echo 'max-width: 56.8rem !important'; ?>">
  <?php }else{?>
   <div id="nav-bar" class="contain-to-grid hide-for-print column no-padding">
  <?php }?>
  
  
    <nav id="top-bar-header-cont" class="top-bar" data-topbar="" data-options="scrolltop: false;"  style="<?php if($has_sponsored && $isHomepage) echo 'max-width: 56rem !important; '?>">
      <ul class="title-area">
        <li class="name">
          <a href="<?php echo $config['this_url']; ?>">
                <h2 style="color:green;">PUCKER<span style="color:white; font-weight: 900;">MOB</span></h2>
           </a>
        </li>
       <li class="toggle-topbar menu-icon"><a href="#"></a></li>
      </ul>
      <section class="top-bar-section category-colors">
        <?php if(!$detect->isMobile()){?>
           <ul class="left" style="margin-left: 245px;">
        <?php }else{?>
           <ul class="left">
        <?php }?>
          
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="<?php echo $config['this_url']; ?>most-recent"  class="entertainment" ><i class="fa fa-bolt fa-lg"></i>RECENT</a></li>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="<?php echo $config['this_url']; ?>trending"  class="money" ><i class="fa fa-line-chart fa-lg"></i>TRENDING</a></li>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="<?php echo $config['this_url']; ?>most-popular"  class="wellness" ><i class="fa fa-star fa-lg"></i>POPULAR</a></li>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="<?php echo $config['this_url']; ?>contributors"  class="fun" ><i class="fa fa-users"></i>CONTRIBUTORS</a></li>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="#" ><i class="fa fa-info-circle fa-lg info"></i></a></li>
          <?php if(!$detect->isMobile()){?>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a>|</a></li>
          <?php }?>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="<?php echo $config['this_url']; ?>moblog"  class="relationships" >THE MOB</a></li>

        </ul>
      </section>
    </nav>
    
  </div>
  <?php 


  if($detect->isMobile() ){
    /*  Highlight Article */
    include_once($config['include_path'].'highlightarticle.php');
  }else{?>
  <!-- FACEBOOK COMMENTS SCRIPT -->
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=1473110846264937";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
  <?php }?>

