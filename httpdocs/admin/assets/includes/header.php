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
     <div id="header-social" class="small-6 columns half-padding-right">FOLLOW US 
        <a href="<?php echo $mpArticle->data['article_page_facebook_url'];?>" target="_blank"><i class="fa fa-facebook fade-in-out"></i></a>
        <a href="<?php echo $mpArticle->data['article_page_twitter_url'];?>" target="_blank"><i class="fa fa-twitter fade-in-out"></i></a>
        <a href="<?php echo $mpArticle->data['article_page_pinterest_url'];?>" target="_blank"><i class="fa fa-pinterest fade-in-out"></i></a>
        <a href="https://plus.google.com/b/112707727253651609975/112707727253651609975/posts" target="_blank" rel="publisher"><i class="fa fa-google-plus fade-in-out"></i></a>
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
          <a href="<?php echo $config['this_admin_url']; ?>/logout/">Sign Out</a>
        </p>
        <?php }?>
      </div>
      </div>
    </div>
  </header>

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
          <!--<li><a href="<?php echo $config['this_url']; ?>hot-topics" class="hot-topics" >Hot Topics</a></li>-->
          <li><a href="<?php echo $config['this_url']; ?>relationships"  class="relationships" >Relationships</a></li>
          <li><a href="<?php echo $config['this_url']; ?>entertainment"  class="entertainment" >Entertainment</a></li>
          <li><a href="<?php echo $config['this_url']; ?>money"  class="money" >Money</a></li>
          <li><a href="<?php echo $config['this_url']; ?>lifestyle"  class="wellness" >Lifestyle</a></li>
          <li><a href="<?php echo $config['this_url']; ?>fun"  class="fun" >Fun</a></li>
           <li><a href="<?php echo $config['this_url']; ?>moblog"  class="moblog" >The Mob</a></li>
          <?php if( !$detect->isMobile()){?>
          <!--<li><a href="<?php echo $config['this_url']; ?>videos/hot-topics"  class="videos" >Videos</a></li>-->
          <?php } ?>
        </ul>
      </section>
    </nav>
  </div>
  <?php if($detect->isMobile() ){
    /*  Highlight Article */
    include_once($config['include_path'].'highlightarticle.php');
  }?>

