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
		public $promote_articles_id
		public $article_id;
		public $facebook_page;
		public $facebook_page_url;
		public $promoted;

		//	Object Vars
		public static $bug_count;

		protected static $db_fields = array('promote_articles_id', 'article_id', 'facebook_page', 'facebook_page_url', 'promoted');


		// GET ALL RECORDS ON THIS TABLE
		public function all(){

			$result = static::find_by_sql("SELECT * FROM $table_name ");
		
		return  $result;
		}

		// GET RECORDS DEPENDING ON THE CONDITIONAL WHERE
		public function get( $fields = ' * ', $where = false ){
			if( $where ){
				return static::find_by_sql("SELECT $fields FROM $table_name WHERE $where ");
			}
			return $this->all();
		}

		//SAVE RECORDS TO TABLE
		public function saveObj( $data ){
			$save = static::create($data);

			return $save;
		}

		//Update Existing Record
		public function updateObj( $data ){
			$update = static::update($data);

			return $update;
		}
	}

?>