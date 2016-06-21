<?php


class Contributor extends DatabaseObject{

	protected static $table_name = "article_contributors";

	// Database Fields
	public $contributor_id;
	public $contributor_name;
	public $contributor_email_address;
	public $contributor;
	
	//	Object Vars
	// 
	protected static $db_fields = array('contributor_id', 'contributor_name', 'contributor_seo_name', 'contributor_email_address', 'contributor_location', 'contributor_image', 'contributor_blog_link', 'contributor_twitter_handle', 'contributor_facebook_link', 'creation_date');

	public function __construct( $email = null){ 
		$this->contributor = $this->getContributor($email);
		$this->contributor_email_address = $email;
	}

	public static function getContributor($email){
		//	Set the params to be bound
		$params_to_bind = [':contributor_email_address' => $email];
		
		$contributor = static::find_by_sql("SELECT * FROM article_contributors WHERE contributor_email_address = :contributor_email_address;", $params_to_bind);

		return  array_shift($contributor);
	}

	public function getContributorName(){
		return $this->contributor->contributor_name;
	}

	public function getContributorId(){
		return $this->contributor->contributor_id;
	}

	public function getContributorEmail(){
		return $this->contributor->contributor_email_address;
	}

	public function getContributorEarnings( Contributor $contributor, $limit = 99999){

		$contributor_earnings = new ContributorEarnings( $contributor);

		if( !is_null( $contributor_earnings )) 	return $contributor_earnings->getEarnings( $limit );
		else return false;

	}

}
?>