  <?php

  $loginActive = isset($_SESSION['login_hash']) || isset($_SESSION['user_id']);

  if(isset($_SESSION['user_id']) && $_SESSION['user_id']){
    $user_info = $mpArticle->getUserInfo();
    $user_first_name = "";
    if(isset($user_info) && $user_info){
      $user_first_name = $user_info["user_first_name"]; 
    }
  }
  ?>

  <!--<header id="top-banner" class="hide-for-print show-for-large-up">
    <div class="row" style="max-width:80rem;">
      <div id="topbar-container-admin" class="left small-6"> <i class="fa fa-sign-out"></i> <a href="<?php echo $config['this_admin_url']; ?>/logout/">Sign Out</a>
    </div>
      <div id="topbar-container-admin" class="right small-6">
        <div class="right">
          <?php if($loginActive){?>
            <p class="">Welcome, <?php echo $adminController->user->data['user_email']; ?>
              <?php if(isset($adminController->user->data['user_facebook_id']) && $adminController->user->data['user_facebook_id'] && strlen($adminController->user->data['user_facebook_id']) > 0 ){?>
              <img id="image-header-profile" src="<?php echo $adminController->user->data['contributor_image'];?>" >
              <?php }else{?>
              <img id="image-header-profile" src="<?php echo 'http://images.puckermob.com/articlesites/contributors_redesign/'. $adminController->user->data['contributor_image'];?>" >
              <?php }?>
            </p>
          <?php }?>
        </div>
      </div>
    </div>
  </header>-->

  <div id="nav-bar" class="sticky contain-to-grid hide-for-print">
    <nav class="top-bar" data-topbar="" data-options="scrolltop: false;">
      <ul class="title-area small-12 columns">
        <li class="name small-12 large-3  columns">
         <span class="small-1 columns right align-right" id="sub-menu-button"><i class="fa fa-bars no-margin"></i></span>
         <h1  class="small-11 columns no-padding">
           <a href="<?php echo $config['this_url']; ?>">  PUCKERMOB  </a>
         </h1> 
        </li>
        <li class="small-10 large-9 columns show-for-large-up left">
          <div id="info-badge" class="header-position hide-for-print">
            <?php include($config['include_path_admin'].'info-badge.php');?>
          </div>
        </li>
      </ul>
    </nav>
  </div>
