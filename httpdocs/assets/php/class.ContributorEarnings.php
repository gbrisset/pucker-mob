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
		public $rate;
		public $month_label;
		public $pageviews;


		//	Object Vars
		protected static $db_fields = array('id', 'contributor_id', 'month', 'year', 'total_article_rate', 'share_rate', 'total_us_pageviews', 'total_earnings', 'to_be_pay', 'paid', 'updated_date' );

		public function __construct( $contributor = null){ 
			$this->contributor = $contributor;
		}

		public function getEarnings( $limit = 99999999 ){

			$limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);

			$contributor_id = $this->contributor->contributor_id;
			
			//	Set the params to be bound
			$params_to_bind = [ ':contributor_id' => $contributor_id ];
			
			$earnings = static::find_by_sql( "SELECT * FROM contributor_earnings WHERE contributor_id = :contributor_id  ORDER BY id DESC LIMIT $limit ", $params_to_bind );

			return  $earnings;
		}

		public function getEarningsPerMonthYear( $month, $year ){

			$contributor_id = $this->contributor->contributor_id;
			$query =  " SELECT * FROM contributor_earnings WHERE contributor_id = $contributor_id  AND month IN (".$month.") AND year = ".$year." ORDER BY id DESC ";
			//	Set the params to be bound
			$params_to_bind = [ ':contributor_id' => $contributor_id ];
			$earnings = static::find_by_sql( $query, $params_to_bind );
			return  $earnings;
		}	

		public function getPageviews(){
			return $pageviwes;
		}

		public function getRate( $month, $year, $user_type ){
			
			//	Set the params to be bound
			$params_to_bind = [ 
				':month' => $month,
				':year' => $year,
				':user_type' => $user_type
			];

			$rate = static::find_by_sql( "SELECT * FROM user_rate WHERE user_type = $user_type and month = $month and year = $year LIMIT 1", $params_to_bind );
			$this->rate = $rate[0]->rate;
			$this->month_label = $rate[0]->month_label;

			return  $rate;

		}

		public function getEarningsPerUserType( $user_type, $conditions = null ){
			
			$query = "SELECT sum(contributor_earnings.total_us_pageviews) as pageviews, contributor_earnings.contributor_id, contributor_name, user_type, month, year, user_email, total_earnings, updated_date  
				FROM `contributor_earnings` 
				inner join (article_contributors, users )  
				on article_contributors.contributor_id =  contributor_earnings.contributor_id and article_contributors.contributor_email_address = users.user_email ";
				
				if($user_type){
					$query .= " WHERE user_type IN ( $user_type )";
				}
				if($conditions){
					$query .= " ".$conditions." ";
				}

				$query .= " group by contributor_earnings.contributor_id ";
				$earnings = static::find_by_sql( $query );

			return  $earnings;


		}

		public function getEarningsPerUser( $contributor_id, $conditions = null ){
			
			$query = "SELECT sum(contributor_earnings.total_us_pageviews) as pageviews, contributor_earnings.contributor_id, contributor_name, user_type, month, year, user_email, total_earnings, updated_date  
				FROM `contributor_earnings` 
				inner join (article_contributors, users )  
				on article_contributors.contributor_id =  contributor_earnings.contributor_id and article_contributors.contributor_email_address = users.user_email  WHERE article_contributors.contributor_id = $contributor_id ";
				
				if($conditions){
					$query .= " ".$conditions." ";
				}

				$query .= " group by contributor_earnings.contributor_id ";
				$earnings = static::find_by_sql( $query );

			return  $earnings;


		}

	}
?>