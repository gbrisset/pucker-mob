<?php 

if( isset( $articleInfoObj ) && isset( $articleInfoObj['article_id']) && $articleInfoObj['article_id']){
    $mostReadArticlesList = $mpArticle->getMostRecentArticleList( $articleInfoObj['article_id'] );

}else{
    $mostReadArticlesList = $mpArticle->getMostRecentArticleList();
}
$image = '<img src="http://images.simpledish.com/articlesites/simpledish/recipe/4486_tall.jpg">';
if(isset($mostReadArticlesList) && $mostReadArticlesList){ ?>
    <section id="popular-articles" class="sidebar shadow-on-large-up">

        <div class="h4-container"><h4>Today on our sister site</h4></div>
        <div class="row">
            <a href="http://www.simpledish.com/"><img alt="Simple Dish Recipes" src="data:image/png;base64,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"></a>
            <p>Every day recipes</p>
        </div>
        
            <?php 
                $articleNumber = 1;
              
                foreach($mostReadArticlesList as $article){
                   
                        $articleNumber++;
                        $articleUrl = $config['this_url'].$article['cat_dir_name'].'/'.$article['article_seo_title'];
                        $mostReadArticle = '';
                        $mostReadArticle .= '<a class="prefetch" href="'.$articleUrl.'"><div id="popular-articles-top" class="columns todays-favorites fade-in-out"><div class="row" data-equalizer=""><div class="small-12 columns" data-equalizer-watch>';
                        $mostReadArticle .= $image;//'<img src="'.$config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article['a_id'].'_tall.jpg" alt="'.$article['article_title'].'" />';
                            
                        $mostReadArticle .= '</div><div class="small-12 columns" data-equalizer-watch>';
                        $mostReadArticle .= '<h5>'.$mpHelpers->truncate($article['article_title'], 80).'</h5></div></div></div></a>';
                        $mostReadArticle .= '';
                        echo $mostReadArticle;
                  
                }
            ?>

    </section>
<?php } ?>