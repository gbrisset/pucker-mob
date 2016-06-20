<?php 

	class ContributorEarnings  extends DatabaseObject{

		protected static $table_name = "contributor_earnings";

		// Database Fields
		public $contributor_id;
		public $share_rate;
		public $pageviews;
		public $earnings;


		//	Object Vars
		protected static $db_fields = array('id', 'contributor_id', 'month', 'year', 'total_article_rate', 'share_rate', 'total_us_pageviews', 'total_earnings', 'to_be_pay', 'paid', 'updated_date' );

		public function __construct( $contributor = null){ 
			var_dump($contributor);
		}	

	}
?>