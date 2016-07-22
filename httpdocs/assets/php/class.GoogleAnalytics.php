<?php
/**
   * User
   * Manage Google Analytics Data  - Table
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

//require 'config.php';

class GoogleAnalytics extends DatabaseObject{

	protected static $table_name = "google_analytics_data_new";

	// Database Fields
	public $article_id;
	public $pageviews;
	public $usa_pageviews;
	public $pct_pageviews;
	public $month;
	public $year;
	public $updated_date;


	//	Object Vars
	protected static $db_fields = array('article_id', 'pageviews', 'usa_pageviews', 'pct_pageviews', 'month', 'year', 'updated_date');

	public function __construct(  ){ 
		
	}

	//GET ALL ANALYTICS AND PASS OPTIONAL PARAMETERS
	public function all( $groupby = null, $orderby = null ){
		$query = " SELECT google_analytics_data_new.*
					FROM google_analytics_data_new ";
		
		if( $where ){
			$query .= $where;
		}

		if( $groupby ){
			$query .= " GROUP BY $groupby ";
		}
		if( $orderby ){
			$query .= " ORDER BY $orderby ";
		}

		$analytics = static::find_by_sql($query);

		return $analytics;
	}

	//GET ANALYTICS PER ARTICLE
	public function article( $article_id, $month=0, $year=0 ){
		
		$query = " SELECT google_analytics_data_new.*
					FROM google_analytics_data_new where article_id = $article_id ";

		if( $month > 0){
			$query .= " and month = $month ";
		}
		if($year > 0){
			$query .= " and year = $year ";
		}

		if( $groupby ){
			$query .= " GROUP BY $groupby ";
		}
		if( $orderby ){
			$query .= " ORDER BY $orderby ";
		}

		$analytics = static::find_by_sql($query);

		return $analytics;

	}

	public function where( $where ){
		$query = " SELECT google_analytics_data_new.*
					FROM google_analytics_data_new ";
		
		if($where ){
			$query .= " ". $where." ";
		}

		$analytics = static::find_by_sql($query);

		return $analytics;
	}


}