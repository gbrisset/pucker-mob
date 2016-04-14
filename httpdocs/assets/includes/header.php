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
<div id="nav_bar">

  <header id="top-banner" class="hide-for-print show-for-large-up top-header-logout <?php echo  $login_header; ?>" style="" >
    <div class="row" style="max-width: 69.5rem">
      <div id="header-social" class="small-12 columns no-padding">
        <?php if($user_type == 5){?>
          <ul style="">
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
          <ul style="">
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
  
  <header id="top-banner" class="hide-for-print show-for-large-up top-header-login <?php echo  $logout_header; ?>" style="" >
    <div class="row" style="<?php if($has_sponsored && $isHomepage) echo 'max-width: 56rem !important'; else echo 'max-width: 69.5rem'; ?>">
      <div id="header-social" class="small-12 columns no-padding">
        <ul style="<?php if($has_sponsored && $isHomepage) echo 'min-width: 56rem !important'; ?>">
            <li style="margin-left: 1px;"> <a class="my-account-header-link" href="https://www.facebook.com/puckermob" target="_blank"><i class="fa fa-facebook fade-in-out"></i></a></li>
            <li> <a class="my-account-header-link" href="https://twitter.com/Puckermob" target="_blank"><i class="fa fa-twitter fade-in-out"></i></a></li>
            <li class="empty-list "></li>
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
   
     <div id="social-media-container-header" class="row" style="display:none; z-index:99999999 !important;"> 

        <div class="columns social-media-container  padding-bottom " style=" display:block !important; z-index:99999999 !important;">
            <?php //if($article_id == 13516){?>
            <style>span.a2a_count {
                font-size: 20px !important;
                padding: 5px;
                height: 45px !important;
            }</style>
              <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                  <a class="a2a_button_facebook a2a_counter" style="width: 100%; margin-top: 7px;"><label class="label-social-button-2-mobile left" style="padding:8px; width:73%; background: #3b5998;"><i class="fa fa-facebook-square" ></i>SHARE</label></a>
              </div>
            <?php //}else {?>
            <!--<a class="addthis_button_facebook small-6 left">
              <label class="label-social-button-2-mobile left" style="font-size: 1rem; font-family: OsloBold !important; text-align: center; padding: 0.5rem 0.5rem 0.5rem 0.25rem;     top: 4px;" ><i class="fa fa-facebook-square" style="font-size: 1.5rem; "></i>SHARE</label>
            </a> 

        
          <div class="addthis_jumbo_share  small-4 right hide-for-print social-buttons-top" style="height: 2.2rem !important;"></div>-->
          <?php //}?>
      </div>  
     </div>

  <?php }?>

  <?php if(!$detect->isMobile()){?>
    <div id="nav-bar" class="contain-to-grid hide-for-print" style=" background-color:white !important">
  <?php }else{?>
   <div id="nav-bar" class="contain-to-grid hide-for-print column no-padding">
  <?php }?>
  
  
    <nav id="top-bar-header-cont" class="top-bar" data-topbar="" data-options="scrolltop: false;"  style="<?php if($has_sponsored && $isHomepage) echo 'max-width: 56rem !important; '?>">
      <ul class="title-area">
      <?php if(!$detect->isMobile()){?>
           <li class="name" style="background-color:white;">
             <a href="<?php echo $config['this_url']; ?>">
             <h2 style="color:green; margin-top:-2px;">PUCKER<span style="color:black; font-weight: 900;">MOB</span></h2> 
           <?php }else{?>
             <li class="name">
             <a href="<?php echo $config['this_url']; ?>">
             <img style="width: 75%; " src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMsAAAAdCAMAAAAzQmgzAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAADNQTFRFAAAAIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8gIx8g8D4fWgAAABB0Uk5TABAgMEBQYHCAj5+vv8/f7yMagooAAAROSURBVFjD3ZhJluwoDEUFlo2MMbz9r7YGdAJ3kTX8TPIkJgQX9RD9S2OTMjZbZqzIvGRT/5nNBwDh2EyZ4eG7E1mIiEWPcStWy9vXPnhaQryHiBR827H+UERE1jYb0IbPNAyMsgNCJ5HU1qdyCFHfyQM+T+oxbZWk7m8AgMf9IgDFt8ab3xEp6cdSDxpFRCQkIC1fLEsEknfM7A4Ap5lZKgoJMOslIIiI+LP9kogB6KuoU43F+OFS4nLDAmzTQR0QzTvLBqBdjT2AZWJpKCSzFKJQT2gP4FAHhx2XKRZzAgDOXSSrNS2dJYVQdJ3sdOlb5ntmWVIXRUS0xcnGfDvjKwvRUc+fWbxaZQEAe5cIhKXYNwAk01hCdu+2XjtDxPHGYuKIQmRHlq3bzgeLBZxi0YrJNlUkriMpJ7TbGheFmWVHfGMRYL0LhZVFo3ywULWiNbP0DwaaJU5K4x4qlJ/FEl00S97/icWkyUknlgHlV5YS7pK+A6R6zBXFh9V1VzjFEm5Y/Ktetge1FJYR5YPFaJa9BSIiSsAZ6jG9/tLVdqOX+Dd/8Uj0zDKhfLBICYEkAEwqZymRcmssCYAZhfhqZJ2Fq64Ui3uPY7HFqBuWGeWdZQXOblIkaCqPQGw2Y7unE+m0oFmMSzV4NBYj5XaeWIZkPLFcUEgAbmNkWX1PEzsAsu2OGYCQLyyM655LDcAlv8QhV+a8f3zm/ReWmC6FiFxKGF0uBTu4rUexuQDAZGU9sDR9aPn+Wo8ZemdxTyxDQm6ToY1pK78MSb5bvM1/Ncv6CwvOchMphBBCr5P/h15wcip1xKu/eGYWHYEpZM8J2eSLfr70clQmETlCakE9XJLGM8v+aGOGlp/j2KIduoSs7NGm3LmUWMW47snK90UV0v5PLOdDqvxzftH1Qw2/EUimxjNRcfechDgUW9cFaIndv7Psl1h/zfu/xeTY0kmzfgdgq3lmrSznXEPnqWVioT3/4JaFp5/vZd69sdCua6c3lq1LalmitHiu2hGPFYs2sUgzy/rEYqe6odUbUTvtDYvqXj5yZdCV+6HK4zzdWCyqFrRa5MLinlgojlNbFbfOlzSzkO/yX1m4+XQ7kVWJoscvj9ELfa9DNUvIyDcsMhiZ6dZ9zJWeTCzmbCt+7MX6iY7ex3QWm1ryaP2ym24hT8fbOEZGt4/m6FHHnGOM9Hlv1SN3mM9e7JgyCGNonLtr1eRqXdSdGQDPzLzusXZANyy09heP9dSGZU4glpcds8WSHvXbhanVzEf/Ij2DSHcFpvnOC8ylXJny/rWv7C6SAITDhzQFErMDwBkkhF62DG9K9U1gfFPimaU0dprFMtOVhThqQUK3LDs9spBtLzmB5y9pfqwaWCrMB0tpMG4rLhXdcgFfaZK3dMNy7mV64eU2aRgeHjOHGO9ExHVGO4qwzJbIsh4mb6WlMVsiU79NO/Akch13LGuYmdnSPzj+AyWmaBwhuQUYAAAAAElFTkSuQmCC" alt="PuckerMob Logo"> 
           <?php }?>
           </a>
          </li>
       <li class="toggle-topbar menu-icon"><a href="#"></a></li>
      </ul>
      <section class="top-bar-section category-colors" style="background-color:white;">
        <?php if(!$detect->isMobile()){?>
          <ul class="left" style="margin-left: 185px;">
        <?php }else{?>
           <ul class="left">
        <?php }?>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="<?php echo $config['this_url']; ?>most-recent"  class="entertainment" ></i>RECENT</a></li>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="<?php echo $config['this_url']; ?>trending"  class="money" ></i>TRENDING</a></li>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="<?php echo $config['this_url']; ?>most-popular"  class="wellness" >POPULAR</a></li>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="<?php echo $config['this_url']; ?>contributors"  class="fun" >CONTRIBUTORS</a></li>
          <?php if(!$detect->isMobile()){?>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><i class="fa fa-info-circle fa-lg info"></i></a></li>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a>|</a></li>
          <?php }?>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="<?php echo $config['this_url']; ?>moblog"  class="relationships" >THE MOB</a></li>
            <?php if($detect->isMobile()){?>
          <li style="<?php if( $has_sponsored && $isHomepage ) echo 'padding: 0 0 0 1.2rem !important; ' ?>"><a href="http://www.sequelmediainternational.com"  target="_blank" class="relationships" >Info & About Us</a></li>
            <?php } ?>
        </ul>
      </section>
    </nav>
    
  </div>
  </div>
  <?php 


  if($detect->isMobile() ){
    /*  Highlight Article */
    //include_once($config['include_path'].'highlightarticle.php');
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


          <div id="light" class="white_content">
            <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><i class="fa fa-times-circle fa-lg"></i></a>
            <center>
            
            <ul class="info-list">
               <h1 style="width:50%;">INFO</h1>
               <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 50px;" href="http://www.sequelmediainternational.com/"><i class="fa fa-book"></i>Publications</a></li>
               <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 73px;" href="http://www.puckermob.com/policy/#privacy"><i class="fa fa-shield"></i>Privacy</a></li>
               <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 77px;" href="http://www.puckermob.com/policy/"><i class="fa fa-gavel"></i>Legal</a></li>
               <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 60px;" href="http://www.sequelmediainternational.com/"><i class="fa fa-briefcase"></i>Advertise</a></li>
               <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 67px;" href="http://www.sequelmediainternational.com/"><i class="fa fa-phone-square"></i>Contact</a></li>
            </ul>
            </center>
            <ul class="social-links">
               <li class="pop-up-links"><a href="https://www.facebook.com/puckermob"><i class="fa fa-facebook-square"></i></a></li>
               <li class="pop-up-links"><a href="https://twitter.com/Puckermob"><i class="fa fa-twitter"></i></a></li>
               <li class="pop-up-links"><a href="https://www.pinterest.com/puckermob/"><i class="fa fa-pinterest"></i></a></li>
               <li class="pop-up-links"><a href="https://plus.google.com/112707727253651609975/posts"><i class="fa fa-google-plus-square"></i></a></li>
            </ul>
            </center>
        </div>

        <div id="fade" class="black_overlay" href= "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"></div>