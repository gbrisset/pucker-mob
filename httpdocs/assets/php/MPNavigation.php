<?php
require_once dirname(__FILE__).'/Connector.php';

class MPNavigation{
	protected $config;
	protected $con;

	public $categories;
	public $navigationLinks;
	public $othersites;
	public $parentsWithChildren;

	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
		$this->navigationLinks = $this->getNavigationPageLinks();

		$this->mainCategories = $this->getArticlePageMainCategories();
		$this->categories = $this->getAllCategories(1);
	}


	public function getCategoryDepths(){
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT cat.*, (COUNT(parent.cat_name) - 2) AS depth
							FROM categories AS cat, categories AS parent
							WHERE cat.lft BETWEEN parent.lft AND parent.rgt
							GROUP BY cat.cat_name
							ORDER BY cat.lft;"
						);
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$categorySet = $q->fetchAll();
		return $categorySet;
	}
	public function getFeaturedArticle($catID){
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT article_title, cat_dir_name, article_seo_title, article_id FROM articles INNER JOIN categories ON articles.article_id = categories.cat_dropdown_article_id WHERE categories.cat_id = {$catID}");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$recipeDetails = $q->fetch();
		return $recipeDetails;
	}
	public function getFeaturedArticleCategorySlug($articleID){
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT cat_dir_name FROM categories INNER JOIN article_categories ON categories.cat_id = article_categories.cat_id WHERE article_categories.article_id = {$articleID} LIMIT 1");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$categorySlug = $q->fetch();
		return $categorySlug;
	}
	public function getCategoryInfoById($catId){
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT parent.* 
							FROM categories AS cat,
							        categories AS parent
							WHERE cat.lft BETWEEN parent.lft 
							AND parent.rgt 
							AND cat.cat_id = {$catId} 

							ORDER BY parent.lft ASC"
						);
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$categorySet = $q->fetchAll();
		return array_shift($categorySet);
	}

	private function getLinkToCategoryByCatId($catId){
				$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT parent.* 
							FROM categories AS cat,
							        categories AS parent
							WHERE cat.lft BETWEEN parent.lft 
							AND parent.rgt 
							AND cat.cat_id = {$catId} 
							AND parent.lft > 1

							ORDER BY parent.lft ASC"
						);
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$categorySet = $q->fetchAll();
		return $categorySet;
	}

	private function getDropDownArticle($id = null){
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT article.*, parent.cat_id as parent_id, parent.cat_name as parent_name, parent.cat_dir_name as parent_dir_name
							FROM categories AS cat, categories AS parent
							INNER JOIN (
								SELECT articles.*, i.article_post_img, i.article_preview_img, nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt
								FROM articles 

								INNER JOIN (article_images as i, article_categories, categories as nc)
								ON articles.article_id = i.article_id
								AND articles.article_id = article_categories.article_id
								AND article_categories.cat_id = nc.cat_id		
								WHERE articles.article_id = {$id}
							) as article
							WHERE cat.lft BETWEEN parent.lft 
							AND parent.rgt 
							AND cat.cat_id = article.cat_id 
							AND parent.lft > 1

							ORDER BY parent.lft ASC
							LIMIT 1"
						);
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$articleSet = $q->fetch();
		return $articleSet;		
	}


	private function displayDropDownArticle($article){
		$text_helper = new MPHelpers;
		$parentDirName = $article['parent_dir_name'];
		$catDirName = $article['cat_dir_name'];
		if ($parentDirName == $catDirName){
			$link = $this->config['this_url'].$catDirName.'/'.$article['article_seo_title'];
		} else {
			$link = $this->config['this_url'].$parentDirName.'/'.$catDirName.'/'.$article['article_seo_title'];
		}
		$articleString = '<h2>Featured Recipe</h2>';
		$articleString .= '<div class="article-info" data-title="'.$article['article_title'].'"  data-desc="'.$article["article_desc"].'">';
		$articleString .= '<div id="image-recipe">';
			$articleString .='<a href="'.$link.'" >';
				$articleString .= '<img src="'.$this->config['image_url'].'/articlesites/simpledish/tall/'.$article['article_id'].'_tall.jpg'.'" alt="'.$article['article_title'].' Preview Image" />';
			$articleString .='</a>';
		$articleString .= '</div>';

		$articleString .= '<div id="info-recipe">';
		$articleString .= '<h2><a href="'.$link.'">';
		$articleString .= $article['article_title'];
		$articleString .= '</a></h2>';
		$articleString .= '<label class="get-recipe">';
		$articleString .= '<a href="'.$link.'">';
		$articleString .= 'GET RECIPE</a>';
		$articleString .= '</label>';
		$articleString .= '</div>';
		$articleString .= '</div>';
	
		return $articleString;

	}

	private function displayShopDropdown(){
		$result = '';
		$result.='<li class="parent" id="c901">';
	        $result.='<label class="parent-title">';
	       	 	$result.='<a class="isParent" href="#">SHOP</a>';
	        $result.='</label>';
	        $result.='<div style="display: none;" class="submenu-wrapper">';
		        $result.='<div class="left">';
			        $result.='<ul class="submenu" style="display: block;">';
			        	$result.='<li id="c902"><a target="_blank" href="http://shop.simpledish.com/collections/apparel">Apparel</a>	</li>';
			        	$result.='<li id="c903"><a target="_blank" href="http://shop.simpledish.com/collections/coffee-mugs">Coffee Mugs</a></li>';
			        	$result.='<li id="c904"><a  target="_blank" href="http://shop.simpledish.com/collections/art-decor">Art & Decor</a></li>';
			        $result.='</ul>';
				$result.='</div>';
				$result.='<div class="right">';
					$result.='<h2>Gift Sale !</h2>';
					$result.='<div data-desc="20% OFF all gift items! Use Code: GIVETHANKS Ends 11/28" data-title="20% OFF all gift items! Use Code: GIVETHANKS Ends 11/28" class="article-info">';
						$result.='<div id="image-recipe">';
							$result.='<a target="_blank" href="http://shop.simpledish.com"><img alt="Shop Simpledish Preview Image" src="';
								$result.=$this->config['image_url'].'articlesites/simpledish/campaign/Drop-Down-Ad.jpg">';
							$result.='</a>';
						$result.='</div>';
						$result.='<div id="info-recipe">';
							$result.='<h2><a target="_blank" href="http://shop.simpledish.com">20% OFF all gift items! Use Code: GIVETHANKS Ends 11/28</a></h2>';
							$result.='<label class="get-recipe"><a target="_blank" href="http://shop.simpledish.com">SHOP NOW</a></label>';
						$result.='</div>';
					$result.='</div>';
				$result.='</div>';
			$result.='</div>';
			$result.='</li>';

			return $result;
	}


	public function renderNavigation( $categories = array(array('name' => '', 'depth' => '', 'lft' => '', 'rgt' => '')) ) {
        $currentDepth = 0;
        $counter = 0;
        $found = false;
        $nextSibling = false;
        $result = '';
        $parentName = '';
        
        foreach ($categories as $cat) {
            $catDepth = $cat['depth'];
            $catName = $cat['cat_name'];
            $catId = $cat['cat_id'];

            if($cat['cat_menu_visible']){

            if ($catDepth < 0) {
                // show root items only if no childern is selected
                continue;
            }
            if ($catDepth == $currentDepth) {
                //if ($counter > 0)
               //     $result .= '</li>';
            }
            elseif ($catDepth > $currentDepth) {

				$result .= '<div class="submenu-wrapper" style="display: none;">';
				$result .= '<div class="left">';
                $result .= '<ul style="display: block;" class="submenu">';
                $currentDepth = $currentDepth + ($catDepth - $currentDepth);
            } elseif ($catDepth < $currentDepth) {
            	$afterSubMenu = '</li></ul><!-- end of submenu list -->';
            	$afterSubMenu .= '</div>';
            	$afterSubMenu .= '<div class="right">';
            	$afterSubMenu .= $this->displayDropDownArticle($dropDownArticle);
            	$afterSubMenu .= '</div><!-- end of div class right--><div>';

                $result .= str_repeat($afterSubMenu, $currentDepth - $catDepth) . '</li>';
                $currentDepth = $currentDepth - ($currentDepth - $catDepth);
            }
            if ($catDepth < 1 && $cat['has_children']) {
            	$parentName = $cat['cat_dir_name'];
            	// If catDepth < 1 and has_children = true, This category is a parent
				$dropDownArticleId = $cat['cat_dropdown_article_id'];
				$dropDownArticle = $this->getDropDownArticle($dropDownArticleId);
            	$result .= '<li id="c' . $catId . '" class="parent">';
            	$result .= '<label class="parent-title">';
            	$result .= '<a href="#" class="isParent">' . $catName .'</a>';
				$result .= '</label>';
            } else {
            	if ($catId != 900){
            		// If this is the nilla wafers link, do NOT display the li tag
		        	$result .= '<li id="c' . $catId . '" ';
				}
	            // Testing...
	            // $result .= ($catDepth < 1 && $cat['has_children']) ?' class="parent"':'';
	            // $result .= $catDepth == 1 ?' class="depth1"':'';

	            // If this is a subcategory ($catDepth == 1)...put the parentName on the link
	            if ($catDepth == 1){
	            	// If this is the nilla wafers link, do NOT display the a tag
	            	if ($catId == 900){
	            		$result .= '';	            		
	            	} else {
	            		$result .= '><a href="'.$this->config['this_url'].$parentName.'/'.$cat['cat_dir_name'].'">' . $catName .'</a>';
	            	}
	            } else {
	            	$result .= '><a href="'.$this->config['this_url'].$cat['cat_dir_name'].'">' . $catName .'</a>';
	            }
        	}
        }

            ++$counter;
        }
        unset($found);
        unset($nextSibling);
        $result .= $this->displayShopDropdown();
        return $result;
    }

	 public function getNavigationPageLinks($id = null){
		$pdo = $this->con->openCon();
		$id = (is_null($id)) ? $this->config['articlepageid'] : $id;
		$q = $pdo->query("SELECT * FROM article_page_navigation_links INNER JOIN (article_pages_navigation_links) ON (article_page_navigation_links.navigation_link_id = article_pages_navigation_links.article_link_id) WHERE article_pages_navigation_links.article_page_id = $id ORDER BY article_pages_navigation_links.article_link_order DESC");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeCon();
		return $r;
	}
	 

	// private function getSubCategories($id=null){ 
	// 	$pdo = $this->con->openCon();
	// 	$id = (is_null($id)) ? 1 : $id;
	// 	$q = $pdo->query("SELECT *, category_page_name, category_page_visible_name, category_page_directory 
	// 						FROM article_category_pages
	// 						INNER JOIN (article_page_main_categories) 
	// 						ON (article_page_main_categories.child_category_id =  article_category_pages.category_page_id)
	// 						WHERE parent_category_id = $id
	// 						ORDER BY parent_child_rel_id ASC");
	// 	$q->setFetchMode(PDO::FETCH_ASSOC);
	// 	if($q && $q->rowCount()){
	// 		while($row = $q->fetch()){
	// 			$r[] = $row;
	// 		}
	// 		$q->closeCursor();
	// 	}else $r = false;
	// 	$this->con->closeCon();
	// 	return $r;
	// }

	public function getAllCategoriesWithArticles(){
		$pdo = $this->con->openCon();

		$q = $pdo->query("SELECT 
		   cat_id, cat_name, cat_dir_name
		FROM 
		    categories 
		WHERE lft>1
		AND has_children = 0 
		AND cat_id != 2 
		AND cat_id != 8
		ORDER BY 
		    cat_name ASC");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeCon();
		return $r;
	}

// begin outdated methods
	private function getArticlePageMainCategories(){ 
		$pdo = $this->con->openCon();
		// Get all categories that are either 'stand-alone' or 'parents', but not the homepage (id = -1)
		$q = $pdo->query("SELECT 
   *,
   (SELECT 
      cat_id
    FROM 
       categories AS t2
    WHERE 
       t2.lft  < t1.lft AND 
       t2.rgt > t1.rgt
    ORDER BY 
       t2.rgt-t1.rgt ASC 
    LIMIT 
       1) AS parent_id, 
   (SELECT 
      cat_name
    FROM 
       categories AS t2
    WHERE 
       t2.lft  < t1.lft AND 
       t2.rgt > t1.rgt
    ORDER BY 
       t2.rgt-t1.rgt ASC 
    LIMIT 
       1) AS parent_name,
   (SELECT 
      cat_dir_name
    FROM 
       categories AS t2
    WHERE 
       t2.lft  < t1.lft AND 
       t2.rgt > t1.rgt
    ORDER BY 
       t2.rgt-t1.rgt ASC 
    LIMIT 
       1) AS parent_dir_name

FROM 
    categories AS t1
WHERE lft>1
ORDER BY 
    rgt-lft DESC");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}

			foreach($r as $cat){
				//$cat['subcategories'] = $this->getSubCategories($cat['cat_id']);
				if ($cat['parent_id'] == 1){
					$categories[] = $cat;
				}	
			}
			$q->closeCursor();
		}else $categories = false;
		$this->con->closeCon();
		return $categories;
	}

	private function getAllCategories($id = null){ 

		$pdo = $this->con->openCon();
		$id = (is_null($id)) ? $this->config['articlepageid'] : $id;
		$q = $pdo->query("SELECT 
						   *,
						   (SELECT 
						      cat_id
						    FROM 
						       categories AS t2
						    WHERE 
						       t2.lft  < t1.lft AND 
						       t2.rgt > t1.rgt
						    ORDER BY 
						       t2.rgt-t1.rgt ASC 
						    LIMIT 
						       1) AS parent_id, 
						   (SELECT 
						      cat_name
						    FROM 
						       categories AS t2
						    WHERE 
						       t2.lft  < t1.lft AND 
						       t2.rgt > t1.rgt
						    ORDER BY 
						       t2.rgt-t1.rgt ASC 
						    LIMIT 
						       1) AS parent_name,
						   (SELECT 
						      cat_dir_name
						    FROM 
						       categories AS t2
						    WHERE 
						       t2.lft  < t1.lft AND 
						       t2.rgt > t1.rgt
						    ORDER BY 
						       t2.rgt-t1.rgt ASC 
						    LIMIT 
						       1) AS parent_dir_name

						FROM 
						    categories AS t1
						WHERE lft>1
						ORDER BY 
						    rgt-lft DESC");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeCon();
		return $r;
	}	

	public function generateSiteMap(){
		$pdo = $this->con->openCon();
		$mpHelpers = new MPHelpers;
		$r = [array('url' => $this->config['this_url'], 'priority' => 0.8, 'change' => 'weekly')];
		$allCategories = $this->categories;
		if($allCategories && count($allCategories)){
			// get links to all of the categories pages
			foreach($allCategories as $category ){
				if ($category['parent_dir_name'] == 'categories-root'){
					$r[] = array('url' => $this->config['this_url'].$category['cat_dir_name'].'/', 'priority' => 0.8, 'change' => 'weekly');
				} else {
					$r[] = array('url' => $this->config['this_url'].$category['parent_dir_name'].$category['cat_dir_name'].'/', 'priority' => 0.8, 'change' => 'weekly');
				}
			}

			$q = $pdo->query("SELECT article.*, parent.cat_id as parent_id, parent.cat_name as parent_name, parent.cat_dir_name as parent_dir_name 

			FROM categories AS cat, categories AS parent 

			INNER JOIN ( 
				SELECT articles.*, nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt
				FROM articles  

				INNER JOIN (article_categories, categories as nc) 
				ON articles.article_id = article_categories.article_id  
				AND article_categories.cat_id = nc.cat_id 

				WHERE articles.article_status = 1 
				GROUP BY articles.article_id 

				ORDER BY articles.article_id DESC 
				) as article  

			WHERE (parent.lft > 1
			AND article.lft BETWEEN (parent.lft+1) 
			AND (parent.rgt -1))
			
			OR (article.cat_id IN (115, 3, 4))

			AND cat.cat_id = article.cat_id 
			
			GROUP BY article.article_id 

			ORDER BY article.article_id DESC ");
			if($q && $q->rowCount()){
				while($row = $q->fetch()){
					if (isset($row['parent_dir_name']) && $row['parent_dir_name'] != 'categories-root'){ 
						$link = $this->config['this_url'].$mpHelpers::linkToArticle($row['cat_dir_name'], $row['parent_dir_name']).$row['article_seo_title'];
					} else {
						$link = $this->config['this_url'].$mpHelpers::linkToArticle($row['cat_dir_name']).$row['article_seo_title'];
					}
					$r[] = array('url' => $link, 'priority' => 1, 'change' => 'monthly');
				}
			}else $r = false;

		}else $r = serialize($pdo->errorInfo());
		
		$this->con->closeCon();
		return $r;
	}

	public function getCategoryById($id = null){
		$pdo = $this->con->openCon();
		$id = (is_null($id)) ? 1 : $id;
		$q = $pdo->query("SELECT categories.*, categories.cat_dir_name as parent_dir_name  
							FROM categories
							WHERE cat_id = $id");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;

		$this->con->closeCon();

		if($r) return array_shift($r);
		else return $r;
	}
}
?>