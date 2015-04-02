  <?php

  $loginActive = isset($_SESSION['login_hash']) || isset($_SESSION['user_id']);

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
  if($loginActive){

    $ManageDashboard = new ManageAdminDashboard( $config );
    //THIS MONTH EARNINGS
    $this_month_earnigs_info =  $ManageDashboard->getLastMonthEarnings($contributor_id, $current_month, $current_year);
    if($this_month_earnigs_info && $this_month_earnigs_info['total_earnings'] && !empty($this_month_earnigs_info['total_earnings']) ) $this_month_earnigs = $this_month_earnigs_info['total_earnings'];
  
    //WARNINGS
    $warnings = $ManageDashboard->getWarningsMessages(); 

    
    //Top Shared Writers
    $writers_arr = $ManageDashboard->getTopShareWritesRankHeader($current_month);
    $your_rank = 0;
   
    foreach ($writers_arr as $writer) {
       
       if($writer['contributor_id'] == $contributor_id ){
          break;
       }
       $your_rank++;
     } 
 
 
  }

 ?>
  <header id="top-banner" class="hide-for-print show-for-large-up top-header-logout <?php echo  $login_header; ?>">
    <div class="row" style="max-width: 69.5rem;">
      <div id="header-social" class="small-12 columns no-padding">
        <?php if($user_type == 5){?>
           <a class="my-account-header-link" href="<?php echo $config['this_admin_url'].'following/'; ?>">My Account</a>
        <?php }else {?>
          <ul>
            <li> <a class="my-account-header-link" href="<?php echo $config['this_admin_url'].'/'; ?>">My Dashboard</a></li>
            <li class="empty-list"></li>
            <li> <p class="earnings-this-month">Earnings (this month): <?php echo '$'.number_format($this_month_earnigs, 2, '.', ','); ?></p></li>
            <li class="empty-list"></li>
            <li> <p>Your rank: <?php echo $your_rank; ?></p> </li>
            <?php if( $warnings && $warnings[0]['notification_live']){?>
            <li class="warning">
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
                <input id="topbar-search-contents" type="search" placeholder="SEARCH">
                <button id="topbar-search-submit" class="alert button expand" style="background-color: #10580d;"><i class="fa fa-search"></i></button>
              </div>
            </li>
          </ul>
        <?php }?>
    </div>
      <!-- <div id="topbar-container-admin" class="right small-6">
        <div class="right">
          <p class="welcome-email"><span>Welcome, <?php //echo $user_info['user_email']; ?></span>
         <?php //if(isset($user_info['user_facebook_id']) && $user_info['user_facebook_id'] && strlen($user_info['user_facebook_id']) > 0 ){?>
          <img id="image-header-profile" src="<?php //echo $user_info['contributor_image'];?>" >
          <?php //}else{?>
          <img id="image-header-profile" src="<?php// echo 'http://images.puckermob.com/articlesites/contributors_redesign/'. $user_info['contributor_image'];?>" >
          <?php //}?>
          <a href="<?php //echo $config['this_admin_url']; ?>/logout/">| Sign Out</a>
          </p>
      </div>
      </div>-->
    </div>
  </header>
  
  <header id="super-banner" class="hide-for-print show-for-large-up top-header-login <?php echo  $logout_header; ?>" style="background:#10580d !important; padding:0.4rem 0.5rem 0.1rem 0.5rem !important; text-align: center;">
  <div class="row" style="height: 1.4rem;">
     <div id="header-social" class="small-12 columns half-padding-right" style="text-align:left; font-family: OsloBold;">      
     JOIN THE MOB! EARN MONEY BY BLOGGING ON PUCKERMOB. 
      <a href="http://www.puckermob.com/admin/register" style="color: #f2ea0a !important;font-weight: bolder; font-family:OsloBold; margin-left: 8px; border-right: 2px solid #fff; padding-right: 5px;">
       REGISTER NOW!
      </a>
       <a href="http://www.puckermob.com/admin/login" style="color: #f2ea0a !important;font-weight: bolder; font-family:OsloBold; margin-left: 0; padding-left: 11px;">
       LOG IN
      </a>
   
    </div>
    <div id="topbar-container">
        <input id="topbar-search-contents" type="search" placeholder="SEARCH" style="">
        <button id="topbar-search-submit" class="alert button expand" style="background-color: #10580d;"><i class="fa fa-search"></i></button>
    </div>
    </div>
  </header>
   
  <?php }?>
   
 <!-- <header id="top-banner" class="hide-for-print show-for-large-up">
    <div class="row">
     <div id="header-social" class="small-6 columns half-padding-right">FOLLOW US 
        <a href="<?php echo $mpArticle->data['article_page_facebook_url'];?>" target="_blank"><i class="fa fa-facebook fade-in-out"></i></a>
        <a href="<?php echo $mpArticle->data['article_page_twitter_url'];?>" target="_blank"><i class="fa fa-twitter fade-in-out"></i></a>
        <a href="<?php echo $mpArticle->data['article_page_pinterest_url'];?>" target="_blank"><i class="fa fa-pinterest fade-in-out"></i></a>
        <a href="https://plus.google.com/b/112707727253651609975/112707727253651609975/posts" target="_blank" rel="publisher"><i class="fa fa-google-plus fade-in-out"></i></a>
      </div>
      <div id="topbar-container">
        <input id="topbar-search-contents" type="search" placeholder="SEARCH">
        <button id="topbar-search-submit" class="alert button expand"><i class="fa fa-search"></i></button>
      </div>


    </div>
  </header>-->

  <div id="nav-bar" class="sticky contain-to-grid hide-for-print">
    <nav class="top-bar" data-topbar="" data-options="scrolltop: false;">
      <ul class="title-area">
        <li class="name">
          <a href="<?php echo $config['this_url']; ?>">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMsAAAAdCAMAAAAzQmgzAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAADNQTFRFAAAAIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8g8D4fWgAAABB0Uk5TABAgMEBQYHCAj5+vv8/f7yMagooAAAROSURBVFjD3ZhJluwoDEUFlo2MMbz9r7YGdAJ3kTX8TPIkJgQX9RD9S2OTMjZbZqzIvGRT/5nNBwDh2EyZ4eG7E1mIiEWPcStWy9vXPnhaQryHiBR827H+UERE1jYb0IbPNAyMsgNCJ5HU1qdyCFHfyQM+T+oxbZWk7m8AgMf9IgDFt8ab3xEp6cdSDxpFRCQkIC1fLEsEknfM7A4Ap5lZKgoJMOslIIiI+LP9kogB6KuoU43F+OFS4nLDAmzTQR0QzTvLBqBdjT2AZWJpKCSzFKJQT2gP4FAHhx2XKRZzAgDOXSSrNS2dJYVQdJ3sdOlb5ntmWVIXRUS0xcnGfDvjKwvRUc+fWbxaZQEAe5cIhKXYNwAk01hCdu+2XjtDxPHGYuKIQmRHlq3bzgeLBZxi0YrJNlUkriMpJ7TbGheFmWVHfGMRYL0LhZVFo3ywULWiNbP0DwaaJU5K4x4qlJ/FEl00S97/icWkyUknlgHlV5YS7pK+A6R6zBXFh9V1VzjFEm5Y/Ktetge1FJYR5YPFaJa9BSIiSsAZ6jG9/tLVdqOX+Dd/8Uj0zDKhfLBICYEkAEwqZymRcmssCYAZhfhqZJ2Fq64Ui3uPY7HFqBuWGeWdZQXOblIkaCqPQGw2Y7unE+m0oFmMSzV4NBYj5XaeWIZkPLFcUEgAbmNkWX1PEzsAsu2OGYCQLyyM655LDcAlv8QhV+a8f3zm/ReWmC6FiFxKGF0uBTu4rUexuQDAZGU9sDR9aPn+Wo8ZemdxTyxDQm6ToY1pK78MSb5bvM1/Ncv6CwvOchMphBBCr5P/h15wcip1xKu/eGYWHYEpZM8J2eSLfr70clQmETlCakE9XJLGM8v+aGOGlp/j2KIduoSs7NGm3LmUWMW47snK90UV0v5PLOdDqvxzftH1Qw2/EUimxjNRcfechDgUW9cFaIndv7Psl1h/zfu/xeTY0kmzfgdgq3lmrSznXEPnqWVioT3/4JaFp5/vZd69sdCua6c3lq1LalmitHiu2hGPFYs2sUgzy/rEYqe6odUbUTvtDYvqXj5yZdCV+6HK4zzdWCyqFrRa5MLinlgojlNbFbfOlzSzkO/yX1m4+XQ7kVWJoscvj9ELfa9DNUvIyDcsMhiZ6dZ9zJWeTCzmbCt+7MX6iY7ex3QWm1ryaP2ym24hT8fbOEZGt4/m6FHHnGOM9Hlv1SN3mM9e7JgyCGNonLtr1eRqXdSdGQDPzLzusXZANyy09heP9dSGZU4glpcds8WSHvXbhanVzEf/Ij2DSHcFpvnOC8ylXJny/rWv7C6SAITDhzQFErMDwBkkhF62DG9K9U1gfFPimaU0dprFMtOVhThqQUK3LDs9spBtLzmB5y9pfqwaWCrMB0tpMG4rLhXdcgFfaZK3dMNy7mV64eU2aRgeHjOHGO9ExHVGO4qwzJbIsh4mb6WlMVsiU79NO/Akch13LGuYmdnSPzj+AyWmaBwhuQUYAAAAAElFTkSuQmCC" alt="PuckerMob Logo"> </a>
        </li>
       <li class="toggle-topbar menu-icon"><a href="#"></a></li>
      </ul>
      <section class="top-bar-section category-colors">
        <ul class="left">
        <!--  <li><a href="<?php echo $config['this_url']; ?>hot-topics" class="hot-topics" >Hot Topics</a></li> -->
          <li><a href="<?php echo $config['this_url']; ?>relationships"  class="relationships" >Relationships</a></li>
          <li><a href="<?php echo $config['this_url']; ?>entertainment"  class="entertainment" >Entertainment</a></li>
          <li><a href="<?php echo $config['this_url']; ?>money"  class="money" >Money</a></li>
          <li><a href="<?php echo $config['this_url']; ?>lifestyle"  class="wellness" >Lifestyle</a></li>
          <li><a href="<?php echo $config['this_url']; ?>fun"  class="fun" >Fun</a></li>
          <li><a href="<?php echo $config['this_url']; ?>moblog"  class="moblog" >MOBLOG</a></li>

        </ul>
      </section>
    </nav>
  </div>
  <?php 
  $has_sponsored = $mpArticle->data['has_sponsored_by'];

  if($detect->isMobile() ){
    /*  Highlight Article */
    include_once($config['include_path'].'highlightarticle.php');
  }?>

