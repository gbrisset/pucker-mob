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
<header id="top-banner" class="hide-for-print show-for-large-up">
  <div class="row">
    <div id="header-social" class="small-6 columns half-padding-right">FOLLOW US <a href="<?php echo $mpArticle->data['article_page_facebook_url'];?>" target="_blank"><i class="fa fa-facebook fade-in-out"></i></a>
      <a href="<?php echo $mpArticle->data['article_page_twitter_url'];?>" target="_blank"><i class="fa fa-twitter fade-in-out"></i></a><a href="<?php echo $mpArticle->data['article_page_pinterest_url'];?>" target="_blank"><i class="fa fa-pinterest fade-in-out"></i></a>
      <a href="<?php echo $mpArticle->data['article_page_googleplus_url'];?>" target="_blank" rel="publisher"><i class="fa fa-google-plus fade-in-out"></i></a>
    </div>
    <div id="topbar-container">
      <input id="topbar-search-contents" type="search" placeholder="SEARCH">
      <button id="topbar-search-submit" class="alert button expand"><i class="fa fa-search"></i></button>
    </div>

  </div>
</header>

<div id="nav-bar" class="sticky contain-to-grid hide-for-print">
  <nav class="top-bar" data-topbar="" data-options="scrolltop: false;">
    <ul class="title-area">
      <li class="name">
        <a href="<?php echo $config['this_url']; ?>">
          <img src="data:image/png;base64,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" alt="PuckerMob">
        </a>
      </li>
      <li class="toggle-topbar menu-icon"></li>
    </ul>
    <section class="top-bar-section">
      <ul class="left">
        <li><a href="<?php echo $config['this_url']; ?>issues">Issues</a></li>
        <li><a href="<?php echo $config['this_url']; ?>love">Love</a></li>
        <li><a href="<?php echo $config['this_url']; ?>entertainment">Entertainment</a></li>
        <li><a href="<?php echo $config['this_url']; ?>style">Style</a></li>
        <li><a href="<?php echo $config['this_url']; ?>money">Money</a></li>
        <li><a href="<?php echo $config['this_url']; ?>wellness">Wellness</a></li>
        <li><a href="<?php echo $config['this_url']; ?>fun">Fun</a></li>
      </ul>
    </section>
  </nav>
</div>