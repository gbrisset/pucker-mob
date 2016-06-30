<?php 

	class ContributorEarnings  extends DatabaseObject{

		protected static $table_name = "contributor_earnings";

		// Database Fields
		public $contributor_id;
		public $share_rate;
		public $total_us_pageviews;
		public $total_earnings;
		public $contributor;
		public $month;
		public $year;
		public $to_be_pay;
		public $paid;


		//	Object Vars
		protected static $db_fields = array('id', 'contributor_id', 'month', 'year', 'total_article_rate', 'share_rate', 'total_us_pageviews', 'total_earnings', 'to_be_pay', 'paid', 'updated_date' );

		public function __construct( $contributor = null){ 
			$this->contributor = $contributor;
		}

		public function getEarnings( $limit = 99999999 ){

			$limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);

			$contributor_id = $this->contributor->contributor_id;
			
			//	Set the params to be bound
			$params_to_bind = [ 
				':contributor_id' => $contributor_id
			];
			
			$earnings = static::find_by_sql( "SELECT * FROM contributor_earnings WHERE contributor_id = :contributor_id  ORDER BY id DESC LIMIT $limit ", $params_to_bind );

			return  $earnings;
		}	

		public function getPageviews(){
			return $pageviwes;
		}

	}
?>