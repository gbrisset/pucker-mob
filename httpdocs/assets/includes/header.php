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
         <!-- <img src="data:image/png;base64,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" alt="PuckerMob">
        -->
        <img src="data:image/png;base64,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" />
        </a>
      </li>
      <li class="toggle-topbar menu-icon"></li>
    </ul>
    <section class="top-bar-section">
      <ul class="left">
        <li><a href="<?php echo $config['this_url']; ?>hot-topics">Hot Topics</a></li>
        <li><a href="<?php echo $config['this_url']; ?>relationships">Relationships</a></li>
        <li><a href="<?php echo $config['this_url']; ?>entertainment">Entertainment</a></li>
        <li><a href="<?php echo $config['this_url']; ?>style">Style</a></li>
        <li><a href="<?php echo $config['this_url']; ?>money">Money</a></li>
        <li><a href="<?php echo $config['this_url']; ?>wellness">Wellness</a></li>
        <li><a href="<?php echo $config['this_url']; ?>fun">Fun</a></li>
      </ul>
    </section>
  </nav>
</div>