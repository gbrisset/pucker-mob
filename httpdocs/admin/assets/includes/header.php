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
  <div id="nav-bar" class="sticky contain-to-grid hide-for-print">
    <nav class="top-bar" data-topbar="" data-options="scrolltop: false;">
      <ul class="title-area small-12 columns">
        <li class="name small-12 large-3  columns">
         <span class="small-2 large-1 columns align-left" id="sub-menu-button"><i class="fa fa-bars no-margin"></i></span>
         <h1  class="small-10 large-11 columns no-padding">
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

  <div id="myDiv"></div>
