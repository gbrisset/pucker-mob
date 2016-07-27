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


		//	Object Vars
		public static $bug_count;

		protected static $db_fields = array('promote_articles_id', 'article_id', 'facebook_page_id', 'promoted');


		// GET ALL RECORDS ON THIS TABLE
		public function all(){

			$result = static::find_by_sql("SELECT * FROM $table_name ");
		
		return  $result;
		}

		// GET RECORDS DEPENDING ON THE CONDITIONAL WHERE
		public function getObj( $fields = ' * ', $where = false ){
			if( $where ){
				return static::find_by_sql("SELECT $fields FROM $table_name WHERE $where ");
			}
			return $this->all();
		}

		//Update, Delete or Save Records into table dependen on user action
		public function promoteArticles( $data = false ){
			if($data){
				$article_id = $data['article_id'];
				$facebook_page_id = $data['facebook_page_id'];
				$promoted = $data['promoted'];
				$result = false;
				
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

		//List all facebook pages
		public function getAllFacebookPages(){
			return static::find_by_sql("SELECT * FROM facebook_pages ");
		}
	}

?>