<?php
	/**
   * Promote Articles
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
   */

	class PromoteArticles extends DatabaseObject{
		protected static $table_name = "promote_articles";

		// Database Fields
		public $promote_articles_id;
		public $article_id;
		public $facebook_page_id;
		public $promoted;
		public $facebook_page_name;
		public $facebook_page_url;
		public $article_title;
		public $article_seo_title;
		public $cat_dir_name;
		public $usa_pageviews;
		public $contributor_name;
		public $contributor_seo_name;
		public $contributor_email_address;
		public $user_type;

		public $article_status;
		public $creation_date;


		//	Object Vars
		public static $bug_count;

		protected static $db_fields = array('promote_articles_id', 'article_id', 'facebook_page_id', 'promoted');


		// GET ALL RECORDS ON THIS TABLE
		public function all(){

			$result = static::find_by_sql("SELECT * FROM $table_name INNER JOIN (articles");
		
		return  $result;
		}

		// GET RECORDS DEPENDING ON THE CONDITIONAL WHERE
		public function getObj( $fields = ' * ', $conditions = false ){
			if( $where ){
				return static::find_by_sql("SELECT $fields FROM $table_name $conditions ");
			}
			return $this->all();
		}

		//Update, Delete or Save Records into table dependen on user action
		public function promoteArticles( $data = false ){
			$result = false;
			if($data){
				$article_id = $data['article_id'];
				$facebook_page_id = $data['facebook_page_id'];
				$promoted = $data['promoted'];
				
				
				//Get article info 
				$article =  static::find_by_sql("SELECT * FROM promote_articles WHERE article_id = $article_id ");
				$row_id = isset($article) ? $article[0]->promote_articles_id : 0 ;
				
				if(count($article) > 0 ){
					$data = [ 
						"article_id" => $article_id,
						"promoted" => $promoted,
						"facebook_page_id" => $facebook_page_id,
						"promote_articles_id" => $row_id 
					];

					//Check if delete
					if($facebook_page_id === "0" ){
						$result = static::delete( $data );
					}else{
						$result = static::update($data);
					}
				}else{

					$result = static::create($data);
				}
								
			}

			return $result;
		}

		//Get promote info per article
		public function promotedInfo( $article_id ){
			$article =  static::find_by_sql("SELECT * FROM promote_articles WHERE article_id = $article_id ");
			return $article;
		}

		public function promoteThisArticle( $data ){
			$article_id =  filter_var($data['article_id'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
			$promoted =  $data['promoted'];	

			if($promoted == "true") $promoted = 1;
			else $promoted = 0;

			$article =  static::find_by_sql("SELECT * FROM promote_articles WHERE article_id = $article_id ");
			$row_id = isset($article) ? $article[0]->promote_articles_id : 0 ;
			$facebook_page_id = isset($article) ? $article[0]->facebook_page_id : 0 ;

			$info = [ 
						"article_id" => $article_id,
						"promoted" => $promoted,
						"facebook_page_id" => $facebook_page_id,
						"promote_articles_id" => $row_id 
					];
			
			$result = static::update($info);

			return $result;

		}

		public function getArticlesToPromote( $where = false, $filters = ''){

			if( $where ){
				return  static::find_by_sql("SELECT * FROM articles_list_admin  WHERE $where $filters");
			}
			return  static::find_by_sql("SELECT * FROM articles_list_admin  $filters");
		}

		//List all facebook pages
		public function getAllFacebookPages(){
			return static::find_by_sql("SELECT * FROM facebook_pages ");
		}
	}

?>