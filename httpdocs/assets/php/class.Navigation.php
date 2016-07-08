<?php
require_once dirname(__FILE__).'/Connector.php';

class Navigation{
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


	
	public function getFeaturedArticle($catID){
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT article_title, cat_dir_name, article_seo_title, article_id FROM articles INNER JOIN categories ON articles.article_id = categories.cat_dropdown_article_id WHERE categories.cat_id = {$catID}");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$recipeDetails = $q->fetch();
		$this->con->closeCon();
		return $recipeDetails;
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
		$this->con->closeCon();
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

		$this->con->closeCon();
		return $categorySet;
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


	private function getArticlePageMainCategories(){ 
		$pdo = $this->con->openCon();
		// Get all categories that are either 'stand-alone' or 'parents', but not the homepage (id = -1)
		$q = $pdo->query("SELECT *, '1' as parent_id FROM categories WHERE lft>1 ORDER BY rgt-lft DESC");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}

			foreach($r as $cat){
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
		$q = $pdo->query("SELECT * FROM categories WHERE lft>1 ");
		

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