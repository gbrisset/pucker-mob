<?php
require_once dirname(__FILE__).'/Connector.php';

class FollowAuthor{
	protected $config;
	protected $con;


	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
	}

	//Execute Query
	protected function performQuery($opts){
		$options = array_merge(array(
			'queryString' => '',
			'queryParams' => array(),
			'returnRowAsSingleArray' => true,
			'bypassCache' => false,
				'returnCount' => false  //	true: performQuery will only return a count of rows
				), $opts);
		$cachedData = false;
		if($cachedData === false || $options['bypassCache'] === true){
			$pdo = $this->con->openCon();
			$q = $pdo->prepare($options['queryString']);
			$q->execute($options['queryParams']);
			if($q && $q->rowCount()){
				$r = array();
				while($row = $q->fetch(PDO::FETCH_ASSOC)){
					$r[] = $row;
				}
			}else $r = false;
			if($options['returnRowAsSingleArray'] === true && $r && count($r) == 1) $r = $r[0];
			$this->con->closeCon();

			if($options['returnCount'] === true){
					//	Return a count of the rows returned by the query
				return $q->rowCount();
			}

			return $r;
		}else return $cachedData;
	}

	public function getReaderInfo(){
		
		if(!isset($_SESSION['user_id'])) return false;
		
		$s = "SELECT * FROM users as u
		 	  INNER JOIN ( user_logins as ul, user_types as ut, user_permissions as up )
		 	  ON ( u.user_id = ul.user_id 
				AND u.user_type = ut.user_type 
				AND ut.user_type = up.user_type ) 
			WHERE u.user_id = ".$_SESSION['user_id']." 
			 AND ul.user_login_valid = 1 LIMIT 1 "; 

		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);

		if ($q && isset($q[0])){
			return $q[0];
		} else if ($q && !isset($q[0])){
			//$q = array($q);
			return $q;
		}else return false;

	}
	public function getFollowingAuthors( $reader_email ){

		$reader_email = filter_var($reader_email, FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$s =" SELECT * FROM readers_authors 
				INNER JOIN ( article_contributors ) ON ( readers_authors.author_id = article_contributors.contributor_id ) WHERE reader_email = '".$reader_email."' "; 

		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);

		if ($q && isset($q[0])){
			return $q;
		} else if ($q && !isset($q[0])){
			$q = array($q);
			return $q;
		}else return false;

	}

	public function getArticlesPerAuthor( $author_id ){
		$author_id = filter_var($author_id,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$s =" SELECT * FROM article_contributor_articles 
				INNER JOIN ( articles, article_categories, categories ) 
				ON ( articles.article_id = article_contributor_articles.article_id )
				AND ( article_categories.article_id = articles.article_id)
				AND (categories.cat_id = article_categories.cat_id)
				WHERE articles.article_status = 1 AND  article_contributor_articles.contributor_id = ".$author_id ." ORDER BY articles.creation_date DESC LIMIT 3 "; 

		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);

		if ($q && isset($q[0])){
			return $q;
		} else if ($q && !isset($q[0])){
			$q = array($q);
			return $q;
		}else return false;
	}

	public function mostFollowedWriters( $limit = 5 ){

		$s = "SELECT count(*) as total, contributor_name, contributor_seo_name, contributor_id  
				FROM readers_authors 
				INNER JOIN ( article_contributors )
				ON ( article_contributors.contributor_id = readers_authors.author_id)  
				GROUP BY author_id ORDER BY total DESC LIMIT $limit ";

		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);

		if ($q && isset($q[0])){
			return $q;
		} else if ($q && !isset($q[0])){
			$q = array($q);
			return $q;
		}else return false;

	}

	public function mostSharedWriters(){

	}

}
?>