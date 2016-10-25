<?php

  $loginActive = isset($_SESSION['login_hash']) || isset($_SESSION['user_id']);

  $has_sponsored = false;//$mpArticle->data['has_sponsored_by'];
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
}

 ?>

 
 <!-- Social Media Icons -->
<div id="nav_bar" style="z-index:1000000000 !important;"> 
   <nav id="top-bar-header-cont" class="new-header" data-topbar role="navigation">
        <div class="row inner-div">
          
          <div class="columns small-4 large-3 logo">
             <h1 class="above hide-for-large-up">  
              <a style="font-size: 1.4rem;" href="<?php echo $config['this_url']; ?>">PUCKERMOB</a>
            </h1>
            <h1 class="above show-for-large-up">  
              <a href="<?php echo $config['this_url']; ?>">PUCKER <br class="show-for-large-up">
              <span class="below">MOB</span></a>
            </h1>
          </div>
          <div class="columns small-8 large-9 " style="margin-top: 11px;">
          <?php if($loginActive) { ?>
            <!-- LOGIN ACTIVE -->
              <div class="columns small-12 no-padding-right " style="margin-top: 2px;">
                  <ul class="inline-list right icons show-for-large-up">
                    <li class="warning hide-for-readers" style=" margin-right: 10px;">
                        <i class=" fa fa-exclamation-triangle" style="color: #ccc; position:relative; top:4px;" id="warning-icon"></i>
                        <div id="dd-shares-content" class="mobile-12 small-12">
                          <div>
                              <p style="margin-bottom:0;  color: #ccc;"><?php echo $warnings[0]['notification_msg']?></p>
                          </div>
                        </div>
                    </li>
                    <li class="fb-li my-account-header-link" style="margin-left: 1px;"> <a class="my-account-header-link" id="my-account-header-link" href="<?php echo $config['this_admin_url'].'/'; ?>">My Dashboard</a></li>
                    <li class="my-account-header-link tw-li " style=""><a  class="my-account-header-link" href="<?php echo $config['this_admin_url']; ?>/logout/">LOG OUT </a></li>
                      <?php if($user_type != 6 && $user_type != 1 && $user_type != 7){?>
                        <li class="tw-li hide-for-readers"> <p style="margin-bottom:0; color: #ccc;" class="earnings-this-month">Earnings (this month): <?php echo '$'.number_format($this_month_earnigs, 2, '.', ','); ?></p></li>
                      <?php }?>
                      <li class="hide-for-readers" style=" margin-left: 9px;"> <p style="margin-bottom:0; color: #ccc;">Your rank: <?php echo $your_rank; ?></p> </li>
                      <?php if( $warnings && $warnings[0]['notification_live']){?>
                      
                  </ul>
               </div>

            <?php }
          }else{ ?>
            <!-- LOGIN INACTIVE -->
              <div class="columns small-12 no-padding-right " style="margin-top: 2px;">
                  <ul class="inline-list right icons">
                    <li> <a class="my-account-header-link show-for-large-up" href="<?php echo $config['this_url']; ?>login">LOGIN</a></li>
                    <li class="show-for-large-up"> <a class="my-account-header-link" href="<?php echo $config['this_url']; ?>login">REGISTER</a></li>
                    <li class="fb-li show-for-large-up"><a href="https://www.facebook.com/puckermob" target="_blank" ><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li class="tw-li show-for-large-up"><a href="https://twitter.com/Puckermob" target="_blank" ><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li class="info-li show-for-large-up">
                      <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                    </li>
                  </ul>
               </div>
             
          <?php } ?>
 <div class="columns small-12 no-padding menu show-for-large-up">
                <ul class="inline-list no-margin right">
                  <li><a href="<?php echo $config['this_url']; ?>most-recent" ></i>RECENT</a></li>
                  <li><a href="<?php echo $config['this_url']; ?>trending" ></i>TRENDING</a></li>
                  <li><a href="<?php echo $config['this_url']; ?>most-popular" >POPULAR</a></li>
                  <li><a href="<?php echo $config['this_url']; ?>contributors" >CONTRIBUTORS</a></li>
                  <li><a href="<?php echo $config['this_url']; ?>moblog" >THE MOB</a></li>
                </ul>
              </div>
          </div>
        </div>
    </nav>

<!-- INFO POPUP -->
<div id="light" class="white_content">
  <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><i class="fa fa-times-circle fa-lg"></i></a>
  <center>
  
  <ul class="info-list">
     <h1 style="width:50%;">INFO</h1>
     <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 50px; position:relative !important;" href="http://www.sequelmediainternational.com/">Publications</a></li>
     <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 73px; position:relative !important;" href="http://www.puckermob.com/privacy/">Privacy</a></li>
      <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 30px; position:relative !important;" href="http://www.puckermob.com/policy/">Terms Of Service</a></li>
     <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 77px; position:relative !important;" href="http://www.puckermob.com/policy/">Legal</a></li>
     <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 60px; position:relative !important;" href="http://www.sequelmediainternational.com/">Advertise</a></li>
     <li class="pop-up-link"><a class="action-button shadow animate red" style="padding: 5px 67px; position:relative !important;" href="http://www.sequelmediainternational.com/">Contact</a></li>
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
<!-- END INFO POPUP -->

<!-- SEARCH -->
<div id="mobilesearchbox" style="top:8px;"></div>

<?php if(!$detect->isMobile() ){?>
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
</div>