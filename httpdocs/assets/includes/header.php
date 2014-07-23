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
      <a href="https://plus.google.com/b/112707727253651609975/112707727253651609975/posts" target="_blank" rel="publisher"><i class="fa fa-google-plus fade-in-out"></i></a>
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
          <img src="data:image/png;base64,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" alt="PuckerMob"/>
        </a>
      </li>
     <li class="toggle-topbar menu-icon"><a href="#"></a></li>
    </ul>
    <section class="top-bar-section category-colors">
      <ul class="left">
        <li><a href="<?php echo $config['this_url']; ?>hot-topics" class="hot-topics" >Hot Topics</a></li>
        <li><a href="<?php echo $config['this_url']; ?>relationships"  class="relationships" >Relationships</a></li>
        <li><a href="<?php echo $config['this_url']; ?>entertainment"  class="entertainment" >Entertainment</a></li>
        <li><a href="<?php echo $config['this_url']; ?>style"  class="style" >Style</a></li>
        <li><a href="<?php echo $config['this_url']; ?>money"  class="money" >Money</a></li>
        <li><a href="<?php echo $config['this_url']; ?>wellness"  class="wellness" >Wellness</a></li>
        <li><a href="<?php echo $config['this_url']; ?>fun"  class="fun" >Fun</a></li>
      </ul>
    </section>
  </nav>
</div>