<?php
require_once dirname(__FILE__).'/Connector.php';

class AskTheChef{

// Database Fields
	public $ask_id;
	public $ask_title;
	public $ask_image;
	public $ask_question;
	public $ask_article_id;

// Object vars
	public $article_id;
	public $article_title;
	public $article_seo_title;
	public $article_body;
	public $article_desc;
	public $parent_dir_name;
	public $cat_dir_name;

	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
	}

	public function get(){
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT article.*, 
							parent.cat_id as parent_id, parent.cat_name as parent_name, parent.cat_dir_name as parent_dir_name 

							FROM categories AS cat, categories AS parent 

							INNER JOIN ( 
								SELECT ask_the_chef.*, articles.article_id, articles.article_title, articles.article_body, articles.article_desc, articles.article_seo_title, 
								nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt, article_contributors.contributor_id, article_contributors.contributor_name, article_contributors.contributor_image
								FROM articles 

								INNER JOIN ( article_categories, categories as nc, article_contributor_articles, article_contributors, ask_the_chef) 
								ON articles.article_id = article_categories.article_id 
								AND article_categories.cat_id = nc.cat_id 
								AND articles.article_id = article_contributor_articles.article_id 
								AND article_contributor_articles.contributor_id = article_contributors.contributor_id
							 	AND ask_the_chef.ask_article_id = articles.article_id) as article 
							WHERE cat.lft BETWEEN parent.lft 
							AND parent.rgt 		

							AND cat.cat_id = article.cat_id 
							AND parent.lft > 1 ");
		$q->setFetchMode(PDO::FETCH_OBJ);
		$object = $q->fetch();
		return $object;
	}



}
?>