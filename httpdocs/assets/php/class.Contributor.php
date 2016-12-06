<?php


class Contributor extends DatabaseObject{

	protected static $table_name = "article_contributors";

	// Database Fields
	public $contributor_id;
	public $contributor_name;
	public $contributor_email_address;
	public $contributor_seo_name;
	public $contributor_location;
	public $contributor_bio;
	public $contributor_image;
	public $contributor_blog_link;
	public $contributor_twitter_handle;
	public $contributor_facebook_link;
	public $creation_date;
	public $data;
	
	//	Object Vars
	// 
	protected static $db_fields = array('contributor_id', 'contributor_name', 'contributor_seo_name', 'contributor_email_address', 'contributor_location', 'contributor_image', 'contributor_blog_link', 'contributor_twitter_handle', 'contributor_facebook_link', 'creation_date');

	public function __construct( $email = null){ 
		$this->data = $this->getContributor($email);
		$this->contributor_email_address = $email;
	//	$this->contributor_name = $this->getContributorName();
	//	$this->contributor_id= $this->getContributorId();
		//$this->contributor_seo_name = $this->getContributorSeoName();
	}

	//Get all contributors 
	public static function all(){
		
		$contributors = static::find_by_sql("SELECT * FROM article_contributors");
		
		return  $contributors;
	}

	//Update
	public function updateObj( $data ){

		$update = static::update($data);
		
		return $update;

	}

	//Insert into notify_users table
	public function saveObj( $data ){

		$save = static::create($data);
		
		return $save;

	}


	public static function getContributor($email){
		//	Set the params to be bound
		$params_to_bind = [':contributor_email_address' => $email];
		
		$contributor = static::find_by_sql("SELECT * FROM article_contributors WHERE contributor_email_address = :contributor_email_address;", $params_to_bind);

		return  array_shift($contributor);
	}

	public static function getContributorById($id){
		//	Set the params to be bound
		$params_to_bind = [':contributor_id' => $id];
		
		$contributor = static::find_by_sql("SELECT * FROM article_contributors WHERE contributor_id = :contributor_id;", $params_to_bind);

		return  array_shift($contributor);
	}

	public function getContributorSeoName(){
		return $this->data->contributor_seo_name;
	}

	public function getContributorName(){
		return $this->data->contributor_name;
	}

	public function getContributorId(){
		return $this->data->contributor_id;
	}

	public function getContributorEmail(){
		return $this->data->contributor_email_address;
	}

	public function getContributorEarnings( Contributor $contributor, $limit = 99999){

		$contributor_earnings = new ContributorEarnings( $contributor);

		if( !is_null( $contributor_earnings )) 	return $contributor_earnings->getEarnings( $limit );
		else return false;

	}

	public function getContributorEarningsPerMonth( Contributor $contributor, $month, $year){
		$contributor_earnings = new ContributorEarnings( $contributor);

		if( !is_null( $contributor_earnings )) 	return $contributor_earnings->getEarningsPerMonthYear( $month, $year );
		else return false;

	}

	public function getContributorArticles(Contributor $contributor){

		$article = new Article( $contributor );

		
	}

}
?>