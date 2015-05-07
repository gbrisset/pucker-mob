<?php
require_once dirname(__FILE__).'/Connector.php';

class MPArticleAdmin{
	private $config;
	private $mpArticle;
	private $mpAdminArticle;
	private $mpVideoShows;
	private $con;
	private $escapes;
	private $helper;

	public function __construct($c, $mpA, $mpvs, $mpAdminA){
		$this->config = $c;
		$this->mpArticle = $mpA;
		$this->mpAdminArticle = $mpAdminA;
		$this->mpVideoShows = $mpvs;
		$this->con = new Connector($this->config);
		$this->helpers = new AdminControllerHelpers(array('config' => $this->config));
		
		$this->escapes = [
			'e' => [FILTER_SANITIZE_EMAIL, PDO::PARAM_STR],
			'n' => [FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT],
			's' => [FILTER_SANITIZE_STRING, PDO::PARAM_STR],
			'u' => [FILTER_SANITIZE_URL, PDO::PARAM_STR]
		];
		
		$this->dropDownInfo = [
			[
				'id' => 1,
				'label' => 'Newest',
				'shortname' => 'mr'
			],
			[
				'id' => 2,
				'label' => 'Title: A-Z',
				'shortname' => 'az'
			],
			[
				'id' => 3,
				'label' => 'Title: Z-A',
				'shortname' => 'za'
			],
			[
				'id' => 4,
				'label' => 'Status: Pending',
				'shortname' => '2'
			],
			[
				'id' => 5,
				'label' => 'Status: Draft',
				'shortname' => '3'
			],
			[
				'id' => 6,
				'label' => 'Name',
				'shortname' => 'az'
			],
		];
	}

	public static function displayArticleStatus($status){
		switch ($status) {
			case 1:
				//	Live
				//return '<p class="live">LIVE</span></p>';
				return 'LIVE';
				break;
			case 2:
				//	Pending Review
				//return '<p class="pending">Pending Review</span></p>';
				return 'PENDING';
				break;
			case 3:
				//	Draft
				//return '<p class="draft">Draft</span></p>';
				return 'DRAFT';
				break;
			default:
				//	Draft
				//return '<p class="live">Draft</span></p>';
				return 'DRAFT';
				break;
		}
	}

	public function getSortOrder($getVariable){
		if (isset($getVariable)){
			$sortingMethod = $getVariable;
			switch ($sortingMethod) {

				case 'pending':
					$sortArray = array('articleStatus'=>'2', 'order'=>'', 'filterLabel'=>'Articles Pending Review');
					break;
				case 'draft':
		
				case '2':
					$sortArray = array('articleStatus'=>'2', 'order'=>'', 'filterLabel'=>'Articles Pending Review');
					break;
				case '3':
					$sortArray = array('articleStatus' => '3', 'order'=>'', 'filterLabel' => 'Article Drafts');
					break;
				case 'az':
					$sortArray = array('articleStatus' => '1, 2, 3', 'order'=>'az', 'filterLabel' => 'Articles A-Z');
					break;
				case 'za':
					$sortArray = array('articleStatus' => '1, 2, 3', 'order'=>'za', 'filterLabel' => 'Articles Z-A');
					break;
				default:
					$sortArray = array('articleStatus' => '1, 2, 3', 'order'=>'', 'filterLabel' => 'Recent Articles');
					break;
			}
			return $sortArray;
		}
		//return 'default';
	}

	/* Begin Admin Site Information Gathering Functions */
	public function getMainCategories(){
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT * FROM categories WHERE cat_id != -1");
		if($q && $q->rowCount()){
			$q->setFetchMode(PDO::FETCH_ASSOC);
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = serialize($pdo->errorInfo());
		$this->con->closeCon();
		return $r;
	}

	public function getFullCategoryInfo($categoryInfo){
		if(!isset($categoryInfo)) return false;
		$pdo = $this->con->openCon();
		
		$q = $pdo->prepare("SELECT *, categories.cat_id 
							FROM categories 
							LEFT JOIN (articles) ON (categories.cat_dropdown_article_id = articles.article_id)
							WHERE categories.cat_id = :categoryPageId LIMIT 0, 1");
		$params = [
			':categoryPageId' => $categoryInfo['cat_id']
		];
		
		$q->execute($params);

		if($q && $q->rowCount()){
			$r = $q->fetch(PDO::FETCH_ASSOC);
			$this->con->closeCon();
			
			return $r;

		}else return false;
	}

	public function getAllContributors($args){
		$options = array_merge([
			'sortType' => 1,
			'limit' => 10,
			'offset' => 0,
			'condition' => ''
		], $args);

		$orderClause = [
			" ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC",//Most Recent
			" ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC",//Most Popular
			" ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC",//Most Visited
			" ORDER BY article_contributors.contributor_name ASC, article_contributors.contributor_id DESC",//Alpha A-Z
			" ORDER BY article_contributors.contributor_name DESC, article_contributors.contributor_id DESC"//Alpha Z-A
		];
		$s = "SELECT * FROM article_contributors";

		if($options['condition']) $s.=" WHERE ".$options['condition'];

		$s .= is_array($orderClause) ? isset($orderClause[$options['sortType'] - 1]) ? $orderClause[$options['sortType'] - 1] : $orderClause[0] : $orderClause;
		$s .= " LIMIT ". $options['limit'] ." OFFSET ".$options['offset'];
		$pdo = $this->con->openCon();
		$q = $pdo->query($s);
		if($q){
			$r = [];
			while($row = $q->fetch(PDO::FETCH_ASSOC)){
				$r[] = $row;
			}
			
		}else $r = false;
		$this->con->closeCon();

		return $r;
	}
	/* End Admin Site Information Gathering Functions */


	/* Begin Site Generic Update Functions */
	public function updateSidebarArticles($post){
		$params = [];
		$pairs = [];
		$articleIds = [];
		$pairs[] = "article_id = :article_page_featured_articles_sidebar_1";
		$pairs[] = "article_id = :article_page_featured_articles_sidebar_2";
		$pairs[] = "article_id = :article_page_featured_articles_sidebar_3";
		$pairs[] = "article_id = :article_page_featured_articles_sidebar_4";
		foreach($post as $key => $value){
			if($key !== "submit") $articleIds[] = $value;
		}
		foreach($articleIds as $i => $id){
			$dupTest = $this->dupTest($id, $articleIds);
			if($dupTest !== $i){
				$r = array_merge($this->returnStatus(400), ['field' => key(array_slice($post, $i, 1)), 'hasError' => true]);
				$r['message'] = 'You\'ve selected duplicate articles for the sidebar section!  Please select four unique articles and try again.';
				return $r;
			}
		}
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$i = 0;
		foreach($pairs as $pair){
			$q = $pdo->prepare("UPDATE article_page_featured_articles SET ".$pair." WHERE article_page_id = ".$this->mpArticle->data['article_page_id']." AND feature_type = 1 AND feature_position = ".(3 - $i++));
			$params = [':article_page_featured_articles_sidebar_'.$i => (strlen(preg_replace('/[^0-9]/', '', $post['article_page_featured_articles_sidebar_'.$i]))) ? preg_replace('/[^0-9]/', '', $post['article_page_featured_articles_sidebar_'.$i]) : 0];
			try{
				$q->execute($params);
			}catch(PDOException $e){
				$this->con->closeCon();
				return array_merge($this->returnStatus(500), ['hasError' => true]);
			}
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Sidebar Articles', $r['message']);
		return $r;
	}

	public function updateSponsoredBy($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post);
		$unrequired = ['sponsored_by_image', 'sponsored_super_banner', 'sponsored_by_url', 'sponsored_super_banner_url'	];
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE article_page_ads SET ".join(', ', $pairs)." WHERE article_page_id = ".$post['c_p_i']);
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Sponsored By', $r['message']);
		return $r;
	}

	public function updateAskTheChef($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post);
		$unrequired = ['ask_title', 'ask_image', 'ask_question', 'ask_article_id'];
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE ask_the_chef SET ".join(', ', $pairs)." WHERE ask_id = ".$post['c_p_i']);
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Ask the Chef', $r['message']);
		return $r;
	}

	public function updateTodaysFavorites($post){
		$params = [];
		$pairs = [];
		$articleIds = [];
		$pairs[] = "article_id = :article_page_featured_articles_sidebar_1";
		$pairs[] = "article_id = :article_page_featured_articles_sidebar_2";
		$pairs[] = "article_id = :article_page_featured_articles_sidebar_3";
		$pairs[] = "article_id = :article_page_featured_articles_sidebar_4";
		$pairs[] = "article_id = :article_page_featured_articles_sidebar_5";
		$pairs[] = "article_id = :article_page_featured_articles_sidebar_6";

		foreach($post as $key => $value){
			if($key !== "submit") $articleIds[] = $value;
		}
		foreach($articleIds as $i => $id){
			$dupTest = $this->dupTest($id, $articleIds);
			if($dupTest !== $i){
				$r = array_merge($this->returnStatus(400), ['field' => key(array_slice($post, $i, 1)), 'hasError' => true]);
				$r['message'] = 'You\'ve selected duplicate articles for the sidebar section!  Please select four unique articles and try again.';
				return $r;
			}
		}

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$i = 0;
		foreach($pairs as $pair){

			$q = $pdo->prepare("UPDATE article_todays_favorites SET ".$pair." WHERE slot = ".(++$i));
			$params = [':article_page_featured_articles_sidebar_'.$i => (strlen(preg_replace('/[^0-9]/', '', $post['article_page_featured_articles_sidebar_'.$i]))) ? preg_replace('/[^0-9]/', '', $post['article_page_featured_articles_sidebar_'.$i]) : 0];
			try{
				$q->execute($params);
			}catch(PDOException $e){
				$this->con->closeCon();
				return array_merge($this->returnStatus(500), ['hasError' => true]);
			}
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Sidebar Articles', $r['message']);
		return $r;
	}
	/* End Site Generic Update Functions */


	/* Begin Site Styling Update Functions */
	public function uploadSiteImage($files, $get){
		$allowedExtensions = explode(',', $get['allowedExtensions']); //No leading periods
		$uploadDir = $this->config['image_upload_dir'].'articlesites/logos/';
		foreach($files as $file){
			$fileName = $file['name'];
			$fileType = $file['type'];
			$fileTempName = $file['tmp_name'];
			$fileError = $file['error'];
			$fileSize = $file['size'];
			
			$columnName = '';
			$get['imgType'] = (isset($get['imgType'])) ? $get['imgType'] : '';
			switch($get['imgType']){
				case 'headerlogo':
					$columnName = 'article_page_logo';
					break;
				case 'footerlogo':
					$columnName = 'article_page_footer_logo';
					break;
				case 'playerlogo':
					$columnName = 'article_page_player_logo';
					break;
				case 'featured':
					$columnName = 'featured_img';
					$uploadDir = $this->config['image_upload_dir'].'articlesites/featured/';
					break;
			}
			
			if(!$this->validateName([
				'fileName' => $fileName, 'fileType' => $fileType, 'fileSize' => $fileSize, 'allowedExtensions' => $allowedExtensions
			])) return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];

			if(!is_uploaded_file($fileTempName) || empty($columnName)) return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];

			$fileName = explode('.', $fileName);
			$extension = $fileName[count($fileName) - 1];
			unset($fileName[count($fileName) - 1]);
			$fileName = preg_replace('/[^A-Za-z0-9]/', '_', join($fileName, '')).'.'.$extension;
			
			if($get['currentImage'] == $fileName) return ['hasError' => true, 'message' => 'This is already the '.$get['imgType'].' image!  Please try again with a new file.'];

			$uploadFile = $uploadDir.basename($fileName);

			$updateArr = [
				'table' => 'article_page_images',
				'column' => $columnName,
				'value' => $fileName,
				'label' => 'Site '.ucwords($get['imgType']).' Image'
			];
			
			if(file_exists($uploadFile)) return $this->updateImageRecord($updateArr);

			if(move_uploaded_file($fileTempName, $uploadFile)) return $this->updateImageRecord($updateArr);

			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
	}

	private function updateImageRecord($args){
		if(!isset($args['table']) || !isset($args['column']) || !isset($args['value'])) return array_merge($this->returnStatus(500), ['hasError' => true]);
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE ".$args['table']." SET ".$args['column']." = :".$args['column']." WHERE article_page_id = ".$this->mpArticle->data['article_page_id']);
		$params[':'.$args['column']] = filter_var(trim($args['value']), FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		return ['hasError' => false, 'message' => $args['label']." updated successfully!"];
	}
	/* End Site Styling Update Functions */


	/* Begin Category Update Functions */
	public function updateCategoryInfo($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post);
		$unrequired = ['category_page_tags', 'category_page_desc'];
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE categories SET ".join(', ', $pairs)." WHERE cat_id = ".$post['c_p_i']);
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Category Information', $r['message']);
		return $r;
	}

	public function updateCategoryFeautedContributor($post){
		$params = [];
		$pairs = [];
		$unrequired = [];
		$pairs[] = "contributor_id = :contributor_id";
		$params[':contributor_id'] = (strlen(preg_replace('/[^0-9]/', '', $post['article_category_page_featured_contributor']))) ? preg_replace('/[^0-9]/', '', $post['article_category_page_featured_contributor']) : 0;
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->query("SELECT * FROM article_category_page_featured_contributors WHERE category_page_id = ".$post['c_p_i']." LIMIT 0, 1");
		try{
			if($q->rowCount()) $q = $pdo->prepare("UPDATE article_category_page_featured_contributors SET contributor_id = :contributor_id WHERE category_page_id = ".$post['c_p_i']);
			else $q = $pdo->prepare("INSERT INTO article_category_page_featured_contributors (category_page_id, contributor_id) VALUES (".$post['c_p_i'].", :contributor_id)");
			try{
				$q->execute($params);
			}catch(PDOException $e){
				$this->con->closeCon();
				return array_merge($this->returnStatus(500), ['hasError' => true]);
			}
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Featured Contributor', $r['message']);
		return $r;
	}

	public function updateCategoryFeautedArticle($post){
		$params = [];
		$pairs = [];
		$unrequired = [];
		$pairs[] = "article_id = :article_id";
		$params[':article_id'] = (strlen(preg_replace('/[^0-9]/', '', $post['article_category_page_featured_article']))) ? preg_replace('/[^0-9]/', '', $post['article_category_page_featured_article']) : 0;
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;
		
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE categories SET cat_dropdown_article_id = :article_id WHERE cat_id = ".$post['c_p_i']);
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Featured Article', $r['message']);
		return $r;
	}

	public function insertCategorySlideshowArticles($post){

		$params = [];
		$pairs = [];
		$unrequired = [];
		$pairs[] = "article_id = :article_id";
		$params[':article_id'] = (strlen(preg_replace('/[^0-9]/', '', $post['article_category_page_featured_article']))) ? preg_replace('/[^0-9]/', '', $post['article_category_page_featured_article']) : 0;
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;
		
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("INSERT INTO articles_featured (cat_id, article_id, feature_type, feature_position) VALUES( ".$post['c_p_i'].", :article_id, 3, 0)");
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = "Article added successfully!";
		return $r;
	}

	public function deleteCatgorySlideshowArticles($post){
		$params = [];
		$pairs = [];
		$unrequired = [];
		$pairs[] = "article_id = :article_id";
		$params[':article_id'] = (strlen(preg_replace('/[^0-9]/', '', $post['article_id']))) ? preg_replace('/[^0-9]/', '', $post['article_id']) : 0;
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;
		
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("DELETE FROM articles_featured WHERE articles_featured.article_id = :article_id");
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r['message'] = "Article deleted successfully!";
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['article_data'] =  $post['article_id'];
		
		return $r;
	}
	/* End Category Update Function */

	/*Begin Collection Information*/
	public function updateCollectionInfo($post){

		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post);
		$unrequired = ['collections_tags', 'collections_desc'];

		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE collections SET ".join(', ', $pairs)." WHERE collections_id = ".$post['co_i']);

		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Collection Information', $r['message']);
		return $r;
	}

	public function addCollection($post){
		$post['collections_seoname-s'] = $post['collections_name-s'];

		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post, true);
		$unrequired = ['collections_desc', 'collections_tags'];

		if(isset($params[':collections_seoname'])) $params[':collections_seoname'] = join(explode(' ', strtolower(preg_replace('/[^A-Za-z0-9- ]/', '', $params[':collections_seoname']))), '-');

		$dupCheck = $this->mpArticle->getCollectionInfo( $params[':collections_seoname']);
		if($dupCheck) return ['hasError' => true, 'message' => "This collection already exists!"];
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$keys = [];
		$values = [];
		foreach($pairs as $key => $value){
			$keys[] = $key;
			$values[] = $value;
		}

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("INSERT INTO collections (".join(', ', $keys).") VALUES (".join(', ', $values).")");

		try{
			$q->execute($params);
			$collection_id = $pdo->lastInsertId();
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = "Collection added successfully!  You will be redirected momentarily.";
		$r['collectionDetails'] = $params;
		return $r;
	}

	public function deleteCollection($post){
		$params = $this->compileParams($post);
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("DELETE FROM collections WHERE collections_id = ".$post['collection_id']);
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = "Collection deleted successfully!  You will be redirected momentarily to Collections page.";
		$r['article_data'] =  $post['collection_id'];
		return $r;
	}

	/*End Collection Information*/


	/* Begin Contributor Update Functions */
	public function addContributor($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post, true);
		$unrequired = ['contributor_location', 'contributor_blog_link', 'contributor_email_address', 'contributor_twitter_handle', 'contributor_bio', 'contributor_facebook_link'];

		if(isset($params[':contributor_seo_name'])) $params[':contributor_seo_name'] = join(explode(' ', strtolower(preg_replace('/[^A-Za-z0-9- ]/', '', $params[':contributor_seo_name']))), '-');

		$dupCheck = $this->mpArticle->getContributors(['contributorSEOName' => $params[':contributor_seo_name']]);
		if(count($dupCheck['contributors']) > 0) return ['hasError' => true, 'message' => "This contirbutor already exists!"];
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$keys = [];
		$values = [];
		foreach($pairs as $key => $value){
			$keys[] = $key;
			$values[] = $value;
		}

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("INSERT INTO article_contributors (".join(', ', $keys).") VALUES (".join(', ', $values).")");

		try{
			$q->execute($params);
			$contributorId = $pdo->lastInsertId();
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = "Contributor added successfully!  You will be redirected momentarily.";
		$r['contributorDetails'] = $params;
		return $r;
	}

	public function updateContributorInfo($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post);
		$unrequired = ['contributor_location', 'contributor_blog_link', 'contributor_twitter_handle', 'contributor_bio', 'contributor_facebook_link'];

		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE article_contributors SET ".join(', ', $pairs)." WHERE contributor_id = ".$post['c_i']);
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'User Information', $r['message']);
		return $r;
	}

	public function updateContributorPasswordInfo($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post);
		$unrequired = [];

		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE article_contributors SET ".join(', ', $pairs)." WHERE contributor_id = ".$post['c_i']);
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Password Information', $r['message']);
		return $r;
	}

	public function updateContributorBioInfo($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post);
		$unrequired = [];

		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE article_contributors SET ".join(', ', $pairs)." WHERE contributor_id = ".$post['c_i']);
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Biography Information', $r['message']);
		return $r;
	}

	public function deleteContributorInfo($post){
		$params = $this->compileParams($post);
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("DELETE FROM article_contributors WHERE article_contributors.contributor_id = ".$post['c_i']);
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = "Contributor deleted successfully!  You will be redirected momentarily to contributos page.";
		
		return $r;
	}

	private function getArticleList($contributor_id){

		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT article_id FROM article_contributor_articles WHERE contributor_id = ".$contributor_id);
		if($q && $q->rowCount()){
			$q->setFetchMode(PDO::FETCH_ASSOC);
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = serialize($pdo->errorInfo());
		$this->con->closeCon();
		return $r;
	}

	public function deleteArticles($ids){

		if( isset($ids) && $ids){
			$params = [];
			$pairs = [];
			$unrequired = [];
			$pairs[] = "article_id = :article_id";
			
			foreach($ids as $article){
				$articleId = $article['article_id'];
				
				$articleId = intval(filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));

				$params[':article_id'] = (strlen(preg_replace('/[^0-9]/', '', $articleId))) ? preg_replace('/[^0-9]/', '', $articleId) : 0;

				if(isset($articleId) && !empty($articleId) && $articleId!= 0 ){
					$tablesArray = ['articles', 'article_images', 'article_ratings', 'article_categories', 'article_contributor_articles', 'article_videos'];
					
					$pdo = $this->con->openCon();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					foreach ($tablesArray as $table){
						$q = $pdo->prepare("DELETE FROM {$table} WHERE article_id = :article_id");
						
						try{
							$q->execute($params);
						}catch(PDOException $e){
							$this->con->closeCon();
							return array_merge($this->returnStatus(500), ['hasError' => true]);
						}

					}

					$this->con->closeCon();
				}
			}
			$r['message'] = "Article deleted successfully!";
			$r = array_merge($this->returnStatus(200), ['hasError' => false]);
			$r['article_data'] =  '';
			
			return $r;

		} else {
			return array_merge($this->helpers->returnStatus(500), array('message' => 'The article_id is not set. The article was not deleted.'));
		}

	}

	public function deleteUserAccount($post){
		$params = $this->compileParams($post);
		$user_id = intval(filter_var($post['u_i'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));
		$contributor_id = intval(filter_var($post['c_i'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));
		
		$user_id = (strlen(preg_replace('/[^0-9]/', '', $user_id))) ? preg_replace('/[^0-9]/', '', $user_id) : 0;
		
		$articles = $this->getArticleList($contributor_id);
		
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("DELETE FROM users WHERE user_id = ".$user_id);
				
		if(isset($user_id) && $user_id ){
			try{
				$user = $q->execute($params);

				if($user){
					$this->deleteContributorInfo($post);
					$this->deleteArticles($articles);
				}else{
					return array_merge($this->returnStatus(500), ['hasError' => true, 'message'=>"Error Deleting Account!"]);
				}
			}catch(PDOException $e){
				$this->con->closeCon();
				return array_merge($this->returnStatus(500), ['hasError' => true]);
			}
		}
		
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = "Account deleted successfully!";
		
		return $r;
	}

	private function updateContributorImageRecord($args){
		
		if(!isset($args['table']) || !isset($args['column']) || !isset($args['value']) || !isset($args['contributorId'])) return array_merge($this->returnStatus(500), ['hasError' => true]);
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE ".$args['table']." SET ".$args['column']." = :".$args['column']." WHERE contributor_id = ".$args['contributorId']);
		$params[':'.$args['column']] = filter_var(trim($args['value']), FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		return ['hasError' => false, 'message' => $args['label']." updated successfully!", 'filename' => $args['value']];
	}
	
	
	/* End Contributor Update Functions */

	/* Begin Image Upload Functions */
	public function uploadContributorImage($files, $get){

		$allowedExtensions = explode(',', $get['allowedExtensions']); //No leading periods
		$uploadDir = $this->config['image_upload_dir'].'articlesites/contributors_redesign/';
		
		foreach($files as $file){

			$fileName = $file['name'];
			$fileType = $file['type'];
			$fileTempName = $file['tmp_name'];
			$fileError = $file['error'];
			$fileSize = $file['size'];
			
			$columnName = '';
			$get['imgType'] = (isset($get['imgType'])) ? $get['imgType'] : '';
			switch($get['imgType']){
				case 'wide':
					$columnName = 'contributor_image';
					break;
				}
			
			if(!$this->validateName([
				'fileName' => $fileName, 'fileType' => $fileType, 'fileSize' => $fileSize, 'allowedExtensions' => $allowedExtensions
			])) return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];

			if(!is_uploaded_file($fileTempName) || empty($columnName)) return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];

			$fileName = explode('.', $fileName);
			$extension = $fileName[count($fileName) - 1];
			unset($fileName[count($fileName) - 1]);
			$fileName = preg_replace('/[^A-Za-z0-9]/', '_', join($fileName, '')).'.'.$extension;
		
			//if($get['currentImage'] == $fileName) return ['hasError' => true, 'message' => 'This is already the '.$get['imgType'].' image!  Please try again with a new file.'];

			$uploadFile = $uploadDir.basename($fileName);

			$updateArr = [
				'table' => 'article_contributors',
				'column' => $columnName,
				'value' => $fileName,
				'contributorId' => $get['contributorId'],
				'label' => 'Contributor '.ucwords($get['imgType']).' Image'
			];
			
			if(file_exists($uploadFile)) return $this->updateContributorImageRecord($updateArr);

			if(move_uploaded_file($fileTempName, $uploadFile)) return $this->updateContributorImageRecord($updateArr);

			return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];
		}
	}

	public function uploadW2Form( $files, $data){
		if ($files['file']['error'] !== UPLOAD_ERR_OK) {
    		die("Upload failed with error " . $_FILES['file']['error']);
		}
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $files['file']['tmp_name']);
		$ok = false;
		//var_dump($mime); die;
		switch ($mime) {
		   case 'image/jpeg':
		   case 'application/pdf':
		   //case etc....
		        //$ok = true;
		   default:
		       die("Unknown/not permitted file type");
		}
		//move_uploaded_file(...);
	}

	public function uploadNewImage($files, $data){

		$allowedExtensions = explode(',', $data['allowedExtensions']); //No leading periods
		$uploadDir = $data['uploadDirectory'];
		$columnName = '';


		// destination image dimensions
		$desWidth = $data['desWidth'];
		$desHeight = $data['desHeight']; 

		//Get New Values
		if(isset($data['imgData'])){
			$src_w = $data['imgData']['w'];
			$src_h = $data['imgData']['h'];
			$src_x = $data['imgData']['x1'];
			$src_y = $data['imgData']['y1'];
			$currentDimWidth = $data['imgData']['dimWidth'];
			$currentDimHeight = $data['imgData']['dimHeight'];
		}

		foreach($files as $file){

			$fileType = $file['type'];
			$fileTempName = $file['tmp_name'];
			$fileError = $file['error'];
			$fileSize = $file['size'];
			
			$data['imgType'] = (isset($data['imgType'])) ? $data['imgType'] : '';

			switch($data['imgType']){
				case 'contributor':
					$fileName = explode('.', $file['name']);
					$extension = $fileName[count($fileName) - 1];
					$fileName = $data['contributorId'].'_contributor.'.$extension;
					$fileDestName = $fileName;
					$columnName = 'contributor_image';
					break;
				case 'article':
					$fileName = explode('.', $file['name']);
					$extension = $fileName[count($fileName) - 1];
					$fileName = $data['articleId'].'_tall'.'.'.$extension;
					$fileDestName = $data['articleId'].'_tall.jpg';
					$columnName = 'article_preview_img';
					break;
			}

			//Validations
			if($fileError) return ['hasError' => true, 'message' => 'Sorry, this file is not valid.  Please try again.'];
			
			//Validate Name
			if(!$this->validateName([
				'fileName' => $fileName, 'fileType' => $fileType, 'fileSize' => $fileSize, 'allowedExtensions' => $allowedExtensions
			])) return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];

			if(!is_uploaded_file($fileTempName) || empty($columnName)) return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];

			$fileName = explode('.', $fileName); 
			$extension = $fileName[count($fileName) - 1];
			unset($fileName[count($fileName) - 1]);
			$fileName = preg_replace('/[^A-Za-z0-9]/', '_', join($fileName, '')).'.'.$extension;
		
			$uploadFile = $uploadDir.basename($fileName);

			// define a result image filename
            $iDestFileName = $uploadDir.'/'.$fileDestName;

			switch($data['imgType']){
				case 'contributor':
					$updateArr = [
						'table' => 'article_contributors',
						'column' => $columnName,
						'value' => $fileName,
						'contributorId' => $data['contributorId'],
						'label' => ucwords($data['imgType']).' Image'
					];

					if(file_exists($uploadFile)) $this->updateContributorImageRecord($updateArr);

					break;
				case 'article':
					//Update Record on Article Images Prev. Table
					$updateArr = [
						'table' => 'article_images',
						'column' => $columnName,
						'value' => $fileDestName,//'preview_'.$fileDestName,
						'articleId' => $data['articleId'],
						'label' => ucwords($data['imgType']).' Image'
					];

					break;
			}
		//	var_dump(is_writable($uploadFile)); die;
			if(move_uploaded_file($fileTempName, $uploadFile)){
				
				if($data['imgType'] == 'contributor'){
					$this->createContributorImage($extension, $uploadFile,  $iDestFileName, $updateArr['value'], $src_w, $src_h, $src_x, $src_y);

        	    	return $this->updateContributorImageRecord($updateArr);
            	}elseif($data['imgType'] == 'article'){
            		
            		$this->createArticleLargeImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
            		//$this->createArticlePreviewImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
					$this->createArticleTallImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
					$this->createArticleMediumImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
					$this->createArticleSquareImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
            		
            		return ['hasError' => false, 'message' => "", 'filename' => $uploadFile];
            		
            	}
			}
			
			return array_merge($this->returnStatus(500), ['hasError' => true], ['filename'=> $fileName]);
		}
	}

	public function uploadTempImage($files, $data){

		$allowedExtensions = explode(',', $data['allowedExtensions']); //No leading periods
		$uploadDir = $data['uploadDirectory'];
		$columnName = '';


		// destination image dimensions
		$desWidth = $data['desWidth'];
		$desHeight = $data['desHeight']; 

		//Get New Values
		if(isset($data['imgData'])){
			$src_w = $data['imgData']['w'];
			$src_h = $data['imgData']['h'];
			$src_x = $data['imgData']['x1'];
			$src_y = $data['imgData']['y1'];
			$currentDimWidth = $data['imgData']['dimWidth'];
			$currentDimHeight = $data['imgData']['dimHeight'];
		}

		foreach($files as $file){

			$fileType = $file['type'];
			$fileTempName = $file['tmp_name'];
			$fileError = $file['error'];
			$fileSize = $file['size'];
			
			$data['imgType'] = (isset($data['imgType'])) ? $data['imgType'] : '';

			switch($data['imgType']){
				case 'contributor':
					$fileName = explode('.', $file['name']);
					$extension = $fileName[count($fileName) - 1];
					$fileName = $data['contributorId'].'_contributor.'.$extension;
					$fileDestName = $fileName;
					$columnName = 'contributor_image';
					break;
				case 'article':
					$fileName = explode('.', $file['name']);
					$extension = $fileName[count($fileName) - 1];
					$fileName = $data['articleId'].'_tall'.'.'.$extension;
					$fileDestName = $data['articleId'].'_tall.jpg';
					$columnName = 'article_preview_img';
					break;
			}

			//Validations
			if($fileError) return ['hasError' => true, 'message' => 'Sorry, this file is not valid.  Please try again.'];
			
			//Validate Name
			if(!$this->validateName([
				'fileName' => $fileName, 'fileType' => $fileType, 'fileSize' => $fileSize, 'allowedExtensions' => $allowedExtensions
			])) return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];

			if(!is_uploaded_file($fileTempName) || empty($columnName)) return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];

			$fileName = explode('.', $fileName); 
			$extension = $fileName[count($fileName) - 1];
			unset($fileName[count($fileName) - 1]);
			$fileName = preg_replace('/[^A-Za-z0-9]/', '_', join($fileName, '')).'.'.$extension;
		
			$uploadFile = $uploadDir.basename($fileName);

			// define a result image filename
            $iDestFileName = $uploadDir.'/'.$fileDestName;

			switch($data['imgType']){
				case 'article':
					//Update Record on Article Images Prev. Table
					$updateArr = [
						'table' => 'article_images',
						'column' => $columnName,
						'value' => $fileDestName,//'preview_'.$fileDestName,
						'articleId' => $data['articleId'],
						'label' => ucwords($data['imgType']).' Image'
					];

					break;
			}

			if(move_uploaded_file($fileTempName, $uploadFile)){
				if($data['imgType'] == 'article'){
            		
            		$this->createArticleLargeImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
            		//$this->createArticlePreviewImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
					//$this->createArticleTallImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
					//$this->createArticleMediumImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
					//$this->createArticleSquareImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
            		
            		return ['hasError' => false, 'message' => "", 'filename' => $uploadFile];
            		
            	}
			}
			
			return array_merge($this->returnStatus(500), ['hasError' => true], ['filename'=> $fileName]);
		}
	}

	public function uploadTempImageFromLib($data, $hasId){
		$allowedExtensions = explode(',', $data['allowedExtensions']); //No leading periods
		if(!$hasId){
			
			$currentFileName = $data['imgName'];
			$libraryDir = $data['libraryDirectory'];
			$img_lib_path = $libraryDir.$currentFileName;
			
			$destDir = $data['uploadDirectory'];
			$newfileName = $data['articleId'].'_tall.jpg'; 
			$img_temp_path = $destDir.$newfileName;

			if(	copy($img_lib_path, $img_temp_path) ) return ['hasError' => false, 'filename' => $newfileName, 'directory' => 'temp'];
	       	else return ['hasError' => true, 'filename'=> $newfileName];
	    }else{

	    	$currentFileName = $data['imgName'];
			$libraryDir = $data['libraryDirectory'];
			$img_lib_path = $libraryDir.$currentFileName;
			
			$destDir = $data['uploadDirectory'];
			$newfileName = $data['articleId'].'_tall.jpg'; 
			$img_temp_path = $destDir.$newfileName;

			if(	copy($img_lib_path, $img_temp_path) ) return ['hasError' => false, 'filename' => $newfileName, 'directory' => 'large'];
	       	else return ['hasError' => true, 'filename'=> $newfileName];
	    }
	
	}

	public function uploadNewImageDropZone($files, $data){

		$allowedExtensions = explode(',', $data['allowedExtensions']); //No leading periods
		$uploadDir = $data['uploadDirectory'];
		$columnName = '';


		// destination image dimensions
		$desWidth = 784;
		$desHeight = 431; 

		//Get New Values
		if(isset($data['imgData'])){
			$src_w = $data['imgData']['w'];
			$src_h = $data['imgData']['h'];
			$src_x = $data['imgData']['x1'];
			$src_y = $data['imgData']['y1'];
			$currentDimWidth = $data['imgData']['dimWidth'];
			$currentDimHeight = $data['imgData']['dimHeight'];
		}

		foreach($files as $file){

			$fileType = $file['type'];
			$fileTempName = $file['tmp_name'];
			$fileError = $file['error'];
			$fileSize = $file['size'];
			
			$data['imgType'] = (isset($data['imgType'])) ? $data['imgType'] : '';
			
			switch($data['imgType']){
				case 'contributor':
					$fileName = explode('.', $file['name']);
					$extension = $fileName[count($fileName) - 1];
					$fileName = $data['contributorId'].'_contributor.'.$extension;
					$fileDestName = $fileName;
					$columnName = 'contributor_image';
					break;
				case 'article':
					$fileName = explode('.', $file['name']);
					$extension = $fileName[count($fileName) - 1];
					$fileName = $data['articleId'].'_tall'.'.'.$extension;
					$fileDestName = $data['articleId'].'_tall.jpg';
					$columnName = 'article_preview_img';
					break;
			}

			//Validations
			if($fileError) return ['hasError' => true, 'message' => 'Sorry, this file is not valid.  Please try again.'];
			
			//Validate Name
			if(!$this->validateName([
				'fileName' => $fileName, 'fileType' => $fileType, 'fileSize' => $fileSize, 'allowedExtensions' => $allowedExtensions
			])) return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];

			if(!is_uploaded_file($fileTempName) || empty($columnName)) return ['hasError' => true, 'message' => 'Sorry, no valid files were found.  Please try again.'];

			$fileName = explode('.', $fileName); 
			$extension = $fileName[count($fileName) - 1];
			unset($fileName[count($fileName) - 1]);
			$fileName = preg_replace('/[^A-Za-z0-9]/', '_', join($fileName, '')).'.'.$extension;
		
			$uploadFile = $uploadDir.basename($fileName);

			// define a result image filename
            $iDestFileName = $uploadDir.'/'.$fileDestName;

			switch($data['imgType']){
				case 'contributor':
					$updateArr = [
						'table' => 'article_contributors',
						'column' => $columnName,
						'value' => $fileName,
						'contributorId' => $data['contributorId'],
						'label' => ucwords($data['imgType']).' Image'
					];

					if(file_exists($uploadFile)) $this->updateContributorImageRecord($updateArr);

					break;
				case 'article':
					//Update Record on Article Images Prev. Table
					$updateArr = [
						'table' => 'article_images',
						'column' => $columnName,
						'value' => $fileDestName,//'preview_'.$fileDestName,
						'articleId' => $data['articleId'],
						'label' => ucwords($data['imgType']).' Image'
					];

					break;
			}
		//	var_dump(is_writable($uploadFile)); die;
			if(move_uploaded_file($fileTempName, $uploadFile)){
				
				if($data['imgType'] == 'contributor'){
					$this->createContributorImage($extension, $uploadFile,  $iDestFileName, $updateArr['value'], $src_w, $src_h, $src_x, $src_y);

        	    	return $this->updateContributorImageRecord($updateArr);
            	}elseif($data['imgType'] == 'article'){
            		
            		$this->createArticleLargeImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
            		//$this->createArticlePreviewImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
					//$this->createArticleTallImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
					//$this->createArticleMediumImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
					$this->createArticleSquareImage($extension, $uploadFile, $fileTempName, $updateArr['value'], $src_w, $src_h);
            		
            		return ['hasError' => false, 'message' => "", 'filename' => $uploadFile];
            		
            	}
			}
			
			return array_merge($this->returnStatus(500), ['hasError' => true], ['filename'=> $fileName]);
		}
	}

	private function getImageObj($extension, $uploadFile){
		
		switch($extension) {
			// create a new image from existing file
            case 'jpg': case 'jpeg':
                return @imagecreatefromjpeg( $uploadFile );
                break;
            case 'png':
                return @imagecreatefrompng( $uploadFile );
                break;
            case 'gif':
                return @imagecreatefromgif( $uploadFile );
                break;
            default:
                @unlink( $uploadFile );
                return;
        }
	}

	private function createNewImageContributor($extension, $uploadFile, $iDestFileName,  $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h){
            // create a new true color image

            $vDstImg = @imagecreatetruecolor( $dst_w, $dst_h );
            $vSrcImg = $this->getImageObj($extension, $uploadFile);
    
            // copy and resize part of an image with resampling
            if( $vDstImg && $vSrcImg ){
            	
            	imagecopyresampled($vDstImg, $vSrcImg, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
               	imagejpeg( $vDstImg, $iDestFileName, 85 );

             	return  true;
            }
            else
            	return ['hasError' => true, 'message' => 'Sorry, looks like something went wrong creating your image. Please try again or contact info@sequelmediagroup.com for assitance.'];

    }
    
    private function createNewImage($extension, $uploadFile, $iDestFileName,  $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h){
            // create a new true color image
            $vDstImg = @imagecreatetruecolor( $dst_w, $dst_h );

            $vSrcImg = $this->getImageObj($extension, $uploadFile);
    

            // copy and resize part of an image with resampling
            if( $vDstImg && $vSrcImg ){
            	imagecopyresampled($vDstImg, $vSrcImg, 0, 0, (int)$src_x, (int)$src_y, (int)$dst_w, (int)$dst_h, (int)$src_w, 431);
               	imagejpeg( $vDstImg, $iDestFileName, 85 );

             	return  true;
            }
            else
            	return ['hasError' => true, 'message' => 'Sorry, looks like something went wrong creating your image. Please try again or contact info@sequelmediagroup.com for assitance.'];

            // output image to file
    }

    /* End Image Upload Functions */

	
	/* Controbutor Image Upload */
	private function createContributorImage($extension, $uploadFile, $fileTempName, $fileName, $src_w, $src_h, $src_x, $src_y){
		$destPathToFile = $this->config['image_upload_dir'].'articlesites/contributors_redesign/'.$fileName;

		return $this->createNewImageContributor($extension, $uploadFile, $destPathToFile,  $src_x, $src_y, 140, 143, $src_w, $src_h);
	
	}
	/* Article Preview Update Functions */
	private function createArticlePreviewImage($extension, $uploadFile, $fileTempName, $fileName, $src_w, $src_h){
		$destPathToFile = $this->config['image_upload_dir'].'articlesites/puckermob/preview/'.$fileName;

		return $this->createNewImage($extension, $uploadFile, $destPathToFile,  0, 0, 250, 225, $src_w, $src_h);
	}

	private function createArticleLargeImage($extension, $uploadFile, $fileTempName, $fileName, $src_w, $src_h){
		$destPathToFile = $this->config['image_upload_dir'].'articlesites/puckermob/large/'.$fileName;

		return $this->createNewImage($extension, $uploadFile, $destPathToFile,  0, 0, 784, 431, 784, 431);
	}

	private function createArticleTallImage($extension, $uploadFile, $fileTempName, $fileName, $src_w, $src_h){
		$destPathToFile = $this->config['image_upload_dir'].'articlesites/puckermob/tall/'.$fileName;

		return $this->createNewImage($extension, $uploadFile, $destPathToFile,  0, 0, 415, 405, $src_w, $src_h);
	}

	private function createArticleMediumImage($extension, $uploadFile, $fileTempName, $fileName, $src_w, $src_h){
		$destPathToFile = $this->config['image_upload_dir'].'articlesites/puckermob/medium/'.$fileName;

		return $this->createNewImage($extension, $uploadFile, $destPathToFile,  0, 0, 235, 185, $src_w, $src_h);
	}

	private function createArticleSquareImage($extension, $uploadFile, $fileTempName, $fileName, $src_w, $src_h){
		$destPathToFile = $this->config['image_upload_dir'].'articlesites/puckermob/square/'.$fileName;

		return $this->createNewImage($extension, $uploadFile, $destPathToFile,  0, 0, 167, 167, $src_w, $src_h);
	}

	private function createArticleMicroSideBarImage($extension, $uploadFile, $fileTempName, $fileName, $src_w, $src_h){
		$destPathToFile = $this->config['image_upload_dir'].'articlesites/puckermob/microsidebar/'.$fileName;

		return $this->createNewImage($extension, $uploadFile, $destPathToFile,  0, 0, 65, 65, $src_w, $src_h);
	}

	private function updateArticlePreviewImageRecord($args){
		
		if(!isset($args['table']) || !isset($args['column']) || !isset($args['value']) || !isset($args['articleId'])) return array_merge($this->returnStatus(500), ['hasError' => true]);
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$q = $pdo->prepare("UPDATE ".$args['table']." SET ".$args['column']." = :".$args['column']." WHERE article_id = ".$args['articleId']);
		$params[':'.$args['column']] = filter_var(trim($args['value']), FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();

		$article_prev_content = $this->mpAdminArticle->getPreviewRecipe(array('articleId' => $args['articleId']));
		
		return ['hasError' => false, 'message' => "", 'filename' => $args['value'], 'article_prev_content' => $article_prev_content];
	}
	/* End Article Preview Update Functions */
	
	/*BEGIN MANAGING IMAGES ON LIBRARY*/
	public function getImagesCategories(){
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT * FROM image_library INNER JOIN (category_library) ON (category_library.seo_name = image_library.category) GROUP BY category ");
		if($q && $q->rowCount()){
			$q->setFetchMode(PDO::FETCH_ASSOC);
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = serialize($pdo->errorInfo());
		$this->con->closeCon();
		return $r;
	}


	public function getImagesPerCategory($data){

		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT * FROM image_library WHERE category = '".$data['category']."' ");
		if($q && $q->rowCount()){
			$q->setFetchMode(PDO::FETCH_ASSOC);
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = serialize($pdo->errorInfo());
		$this->con->closeCon();
	
		return $r;
	}
	/*END MANAGING IMAGES ON LIBRARY*/
	

	public function getArticleAds($data){

		$article_id = filter_var($data['article_id'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT );

		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT * FROM article_ads WHERE article_id = ".$article_id);
		
		if($q && $q->rowCount()){
			$q->setFetchMode(PDO::FETCH_ASSOC);
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeCon();

		return $r;

	}
	/*Begin Video Add Function*/
	public function addVideoMediaInfo($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post, true);
		$unrequired = ['syn_video_tags'];

		if(isset($params[':syn_video_filename'])) $params[':syn_video_filename'] = join(explode(' ', preg_replace('/[^A-Za-z0-9- ]/', '', $params[':syn_video_filename'])), '');
		
		$dupCheck = $this->mpArticle->getSyndicationVideos(['videoFileName' => $params[':syn_video_filename']]);
		
		if($dupCheck) return ['hasError' => true, 'message' => "This video file already exists!"];
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$keys = [];
		$values = [];
		foreach($pairs as $key => $value){
			$keys[] = $key;
			$values[] = $value;
		}

		$pdo = $this->con->openSynCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("INSERT INTO syndication_videos (".join(', ', $keys).") VALUES (".join(', ', $values).")");
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeSynCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = "Video added successfully!  You will be redirected momentarily.";
		$r['videoDetails'] = $params;
		return $r;
	}

	public function updateVideoMediaInfo($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post);
		$unrequired = ['syn_video_tags', 'article_video', ''];

		if(isset($params[':syn_video_filename'])) $params[':syn_video_filename'] = join(explode(' ', preg_replace('/[^A-Za-z0-9- ]/', '', $params[':syn_video_filename'])), '');
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE syndication_videos SET ".join(', ', $pairs)." WHERE syn_video_id = ".$post['v_i']);
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Contributor Information', $r['message']);
		return $r;
	}

	public function deleteVideoMediaInfo($post){
		$params = $this->compileParams($post);
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("DELETE FROM syndication_videos WHERE syn_video_id = ".$post['v_i']);
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = "Video deleted successfully!  You will be redirected momentarily to contributos page.";
		
		return $r;
	}

	public function addSeries($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post, true);
		$unrequired = ['article_page_series_tags'];

		$post['article_page_series_tags-s'] = $this->helpers->generateName(array('input' => $post['article_page_series_tags-s']));

		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		//Check for same seo-name
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$seoTitleCheck = $pdo->query("SELECT * FROM article_page_series WHERE article_page_series_seo = '".$params[':article_page_series_seo']."'");

		if($seoTitleCheck->rowCount() != 0) return array_merge($this->helpers->returnStatus(500), array('message' => 'This SEO Title is already in use.  Please try again with a new SEO title.', 'field' => 'article_page_series_seo'));

		$keys = [];
		$values = [];
		foreach($pairs as $key => $value){
			$keys[] = $key;
			$values[] = $value;
		}

		
		$q = $pdo->prepare("INSERT INTO article_page_series (".join(', ', $keys).") VALUES (".join(', ', $values).") ");
		//var_dump($q ); die;
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
			$r['message'] = "Series added successfully!  You will be redirected momentarily.";
		$r['seriesDetails'] = $params;
		return $r;
	}

	public function updateSeriesMediaInfo($post){
		$params = $this->compileParams($post);
		$pairs = $this->compilePairs($post);
		$unrequired = ['article_page_series_tags'];

		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE article_page_series SET ".join(', ', $pairs)." WHERE article_page_series_id = ".$post['s_i']);
		//var_dump($q );
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = preg_replace('/\{formname\}/', 'Series Information', $r['message']);
		return $r;
	}

	public function updateSeriesPlaylist($post){
		$params = [];
		$pairs = [];
		$unrequired = [];
		
		$pairs[] = "article_page_series_id = :article_page_series_id";
		$params[':article_page_series_id'] = (strlen(preg_replace('/[^0-9]/', '', $post['series_id-s']))) ? preg_replace('/[^0-9]/', '', $post['series_id-s']) : 0;
		$params[':article_page_series_video_prev_img'] = $post['series_id-s']."-video-wide.jpg";
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;
		
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("INSERT INTO article_page_series_playlist (article_page_series_id, syn_video_id, article_page_series_featured_video, article_page_series_video_prev_img) VALUES( :article_page_series_id, ".$post["series_video"].", 0, :article_page_series_video_prev_img )");
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = "Article added successfully!";
		return $r;
	}

	public function deleteSeriesVideo($post){
		$params = [];
		$pairs = [];
		$unrequired = [];
		$pairs[] = "video_id = :video_id";
		$params[':video_id'] = (strlen(preg_replace('/[^0-9]/', '', $post['v_i']))) ? preg_replace('/[^0-9]/', '', $post['v_i']) : 0;
		
		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;
		
		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("DELETE FROM article_page_series_playlist WHERE article_page_series_playlist.syn_video_id = :video_id AND article_page_series_playlist.article_page_series_id = ".$post['s_i']);
	
		try{
			$q->execute($params);
		}catch(PDOException $e){//var_dump($e);
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r['message'] = "Article deleted successfully!";
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['article_data'] =  $post['v_i'];
		
		return $r;
	}

	public function updateVideoArticleInfo( $post ){
			
		$params = $this->compileParams($post); 
		$unrequired = [];

		$valid = $this->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		$dupCheck = $this->mpVideoShows->getArticleInfoPerVideo($post['syn_video_id-s']);
		
		if($dupCheck) 
			$pairs = $this->compilePairs($post);
		else 
			$pairs = $this->compilePairs($post, true);

		$keys = [];
		$values = [];
		foreach($pairs as $key => $value){
			$keys[] = $key;
			$values[] = $value;
		}

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if($dupCheck){
			$q = $pdo->prepare("UPDATE article_videos SET ".join(', ', $pairs)." WHERE syn_video_id = ".$post['syn_video_id-s']);
		}else{
			$q = $pdo->prepare("INSERT INTO article_videos (".join(', ', $keys).") VALUES (".join(', ', $values).")");
		}
		
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = 'Article added successfully';
		return $r;	
	}

	public function addRemoveSlideshowSeriesList($post){
		$params = [];
		$unrequired = [];
		
		$featured_value = 0;
		
		if($post['action'] == 'series-video-add-slideshow-link'){
			$featured_value = 2;
		}else{
			$featured_value = 0;
		}

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare("UPDATE  article_page_series_playlist SET article_page_series_featured_video = ".$featured_value." WHERE article_page_series_id = ".$post['s_i']." AND syn_video_id = ".$post['v_i']);
		//var_dump($q);
		try{
			$q->execute($params);
		}catch(PDOException $e){
			$this->con->closeCon();
			return array_merge($this->returnStatus(500), ['hasError' => true]);
		}
		$this->con->closeCon();
		$r = array_merge($this->returnStatus(200), ['hasError' => false]);
		$r['message'] = "Video added to the slideshow successfully!";
		return $r;
	}

	/* Begin Helper Functions */
	private function validateName($args){
		if(!isset($args['fileName']) || !isset($args['fileType']) || !isset($args['fileSize'])) return false;
		$extension = explode('.', $args['fileName']);
		$extension = $extension[count($extension) - 1];
		$postSize = $this->toBytes(ini_get('post_max_size'));
		$uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
		preg_match('/^image/', $args['fileType'], $typeMatches);
		if(!in_array($extension, $args['allowedExtensions']) || !count($typeMatches) || $postSize < $args['fileSize'] || $uploadSize < $args['fileSize']) return false;		
		return true;
	}

	private function validateRequired($params, $unrequired){
		foreach($params as $key => $value){
			if(!in_array(substr($key, 1), $unrequired) && strlen($value) == 0){
				return array_merge($this->returnStatus(400), ['field' => substr($key, 1), 'hasError' => true]);
			}
		}
		return true;
	}

	private function compilePairs($post, $isInsert = false){
		$pairs = [];
		foreach($post as $field => $value){
			preg_match('/(\w+[^-])-([\w]+)/', $field, $matches);
			if($field !== "submit" && isset($matches[1])){
				if(!$isInsert) $pairs[] = "$matches[1] = :$matches[1]";
				else $pairs[$matches[1]] = ":$matches[1]";
			}
		}
		return $pairs;
	}

	private function compileParams($post){
		$params = [];
		foreach($post as $field => $value){
			preg_match('/(\w+[^-])-([\w]+)/', $field, $matches);
			if($field !== "submit" && isset($matches[1])){
				$params[":$matches[1]"] = ($matches[2] == "nf") ? trim($value) :  filter_var(trim($value), $this->escapes[$matches[2]][0], $this->escapes[$matches[2]][1]);
			}
		}
		return $params;
	}

	private function dupTest($needle, $haystack){
		$len = count($haystack);
		$lastIndex = -1;
		for($i = 0; $i < $len; $i++){
			if($haystack[$i] == $needle) $lastIndex = $i;
		}
		return $lastIndex;
	}

	/**
	* Compares one timestamp ($a) to another ($b) plus a time-to-live ($tll)
	*
	* @param TIMESTAMP $a			Time to be compared to range (after having passed through strtotime)
	* @param TIMESTAMP $b			Time to be used for comparision within range (after having passed through strtotime)
	* @param int $ttl			Time to live, to be added to param $b for range.  In minutes
	*
	* @return boolean				Returns true if $a is within range, false if $a is outside of range
	*/
	private function compareTimes($a, $b, $ttl){
		$ttl = $ttl * 60;
		if($a > $b && $a < ($b + $ttl)) return true;
		return false;
	}

	private function toBytes($str){
		$val = floatval(substr(trim($str), 0, -1));
		$last = strtolower($str[strlen($str)-1]);
		switch($last){
			case 'g': 
				$val *= pow(1024, 3);
				break;
			case 'm': 
				$val *= pow(1024, 2);
				break;
			case 'k': 
				$val *= 1024;
				break;
		}
		return $val;
	}

	public function returnStatus($code){
		$r = ['statusCode' => $code];
		switch($code){
			case 200:
				$r['message'] = '{formname} updated successfully!';
				break;
			case 400:
				$r['message'] = "Sorry, one or more required fields were missing.  Please fill in all required fields and try again.";
				break;
			case 500:
				$r['message'] = 'Sorry, looks like something went wrong.  Please try again or contact <a href="mailto:info@simpledish.com">info@simpledish.com</a> for assitance.';
				break;
			default: 
				$r['message'] = '';
				break;
		}
		return $r;
	}

	private function subValSort($a, $type = 'high', $value = 'rating'){
		$b = [];
		foreach($a as $k=>$v){
			$b[$k] = strtolower($v[$value]);
		}
		if($type == "high") arsort($b);
		else asort($b);
		$c = [];
		foreach($b as $k=>$v) {
			$c[] = $a[$k];
		}
		return $c;
	}
	/* End Helper Functions */
}
?>
