<?php
require 'AdminControllerHelpers.php';
require 'MPAdminUserController.php';

class MPArticleAdminController extends MPArticle{
	protected $config;
	protected $con;
	protected $mpArticle;

	public $user;
	public $helpers;

	public function __construct($opts){
		$this->config = $opts['config'];
		$this->con = new Connector($this->config);
		$this->mpArticle = $opts['mpArticle'];

		$this->helpers = new AdminControllerHelpers(array('config' => $this->config));
		$this->user = new  MPAdminUserController(array('config' => $this->config, 'mpArticle' => $this->mpArticle));
	}


	/* Begin Admin Controller Get Information Functions */
	public function getSiteObjectAll($opts){
		$options = array_merge(array(
			'table' => '',
			'queryString' => '',
			'queryParams' => array(),
			'returnRowAsSingleArray' => false,
			'bypassCache' => false
		), $opts);

		if(empty($options['queryString'])) $options['queryString'] = "SELECT * FROM ".$options['table'];

		$result = $this->performQuery($options);
		if($result && count($result) == 1 && $options['returnRowAsSingleArray']){
			$result[0]['single'] = true;
			$result = $result[0];
		}

		return $result;
	}

	public function deleteArticleById($post){

		if(isset($post['article_id']) && $post['article_id'] > 0){
			$articleId = intval(filter_var($post['article_id'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));

			$params = [];
			$pairs = [];
			$unrequired = [];
			$pairs[] = "article_id = :article_id";
			$params[':article_id'] = (strlen(preg_replace('/[^0-9]/', '', $post['article_id']))) ? preg_replace('/[^0-9]/', '', $post['article_id']) : 0;

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

			$r['message'] = "Article deleted successfully!";
			$r = array_merge($this->returnStatus(200), ['hasError' => false]);
			$r['article_data'] =  $post['article_id'];
			
			return $r;

		} else {
			return array_merge($this->helpers->returnStatus(500), array('message' => 'The article_id is not set. The article was not deleted.'));
		}

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
				$r['message'] = 'Sorry, looks like something went wrong.  Please try again or contact <a href="mailto:info@sequelmediainternational.com">info@sequelmediainternational.com</a> for assitance.';
				break;
			default: 
				$r['message'] = '';
				break;
		}
		return $r;
	}

	public function getSingleArticle($opts){
		$options = array_merge(array(
			'seoTitle' => '',
			'articleId' => -1
		), $opts);


		$sql = "SELECT *, a.article_id FROM articles as a 
			LEFT JOIN (article_images as ai, article_statuses as astatus, article_moblogs_featured as af) 
			ON (a.article_id = ai.article_id AND a.article_status = astatus.status_id AND af.article_id = a.article_id ) 
			WHERE a.article_seo_title = :seoTitle OR a.article_id = :articleId";
		
		$params = array(
			'seoTitle' => filter_var($options['seoTitle'], FILTER_SANITIZE_STRING, PDO::PARAM_STR),
			'articleId' => filter_var($options['articleId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
		);

		$article = $this->performQuery(array(
			'queryString' => $sql,
			'queryParams' => $params,
			'returnRowAsSingleArray' => true
		));

		if(!$article) return false;

		$article['categories'] = $this->performQuery(array(
			'queryString' => 'SELECT * FROM article_categories as ac INNER JOIN (categories as acp) ON (ac.category_page_id = acp.category_page_id) WHERE ac.article_id = '.$article['article_id'],
			'returnRowAsSingleArray' => false
		));

		$article['contributor'] = $this->performQuery(array(
			'queryString' => 'SELECT * FROM article_contributor_articles as aca INNER JOIN (article_contributors as ac) ON (aca.contributor_id = ac.contributor_id) WHERE aca.article_id = '.$article['article_id']
		));

			return $article;
	}
	/* End Admin Controller Get Information Functions */


	/* Begin Admin Controller Site Updating Functions */
	/*public function updateSiteSettings($post){
		//$siteCategoryUpdate = $this->performUpdate(array(
			//'updateString' => "UPDATE article_pages SET cat_id = :cat_id WHERE article_page_id = ".$this->config['articlepageid'],
			//'updateParams' => array(':cat_id' => (strlen(preg_replace('/[^0-9]/', '', $post['cat_id']))) ? preg_replace('/[^0-9]/', '', $post['cat_id']) : 0)
		//));

		$siteStatusUpdate = $this->performUpdate(array(
			'updateString' => "UPDATE article_pages SET article_page_live = :article_page_live WHERE article_page_id = ".$this->config['articlepageid'],
			'updateParams' => array(':article_page_live' => (isset($post['article_page_live']) && $post['article_page_live'] == "article_page_live_live") ? 1 : 0)
		));

		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_pages SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));
		if($result === true) return array('hasError' => false, 'message' => 'Site information updated successfully!');
		else return $result;
	}*/

/*	public function updateSiteFeautedObject($opts){
		$options = array_merge(array(
			'table' => 'articles_featured',
			'column' => '',
			'additionalWhere'=> '',
			'post' => array(),
			'successMessage' => ''
		), $opts);
	
		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE ".$options['table']." SET ".$options['column']." = :".$options['column']." WHERE cat_id = 1".$options['additionalWhere'],
			'post' => $options['post']
		));
		if($result === true) return array('hasError' => false, 'message' => $options['successMessage']);
		else return $result;
	}*/

/*	public function updateSiteSearch($post){
		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_page_social_settings SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));
		if($result === true) return array('hasError' => false, 'message' => 'Search settings updated successfully!');
		else return $result;	
	}*/

	/*public function updateSocialSettings($post){
		$post = array_merge(array(
			'articles_have_facebook-n' => (isset($post['articles_have_facebook'])) ? 1 : 0,
			'articles_have_twitter-n' => (isset($post['articles_have_twitter'])) ? 1 : 0,
			'articles_have_pinterest-n' => (isset($post['articles_have_pinterest'])) ? 1 : 0,
			'articles_have_googleplus-n' => (isset($post['articles_have_googleplus'])) ? 1 : 0,
			'articles_have_linkedin-n' => (isset($post['articles_have_linkedin'])) ? 1 : 0,
			'articles_have_ziplist-n' => (isset($post['articles_have_ziplist'])) ? 1 : 0
		), $post);

		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_page_social_settings SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));
		if($result === true) return array('hasError' => false, 'message' => 'Social settings updated successfully!');
		else return $result;
	}*/

	/*public function updateAdCodes($post){
		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_page_ads SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));
		if($result === true) return array('hasError' => false, 'message' => 'Ad placement settings updated successfully!');
		else return $result;
	}*/

	/*public function updateAdTiming($post){
		$post = array_merge(array(
			'ads_rotate-n' => (isset($post['ads_rotate']) && $post['ads_rotate'] == "ads_rotate_enabled") ? 1 : 0
		), $post);

		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_page_ads SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));
		if($result === true) return array('hasError' => false, 'message' => 'Ad timing settings updated successfully!');
		else return $result;
	}*/

/*	public function updateStylingSettings($post){
		$params = $this->helpers->compileParams($post);

		foreach($params as $key => $value){
			preg_match('/^#?(([a-fA-F0-9]){3}){1,2}$/', $value, $matches);
			if(strlen($value) == 0) return array_merge($this->returnStatus(400), array('field' => substr($key, 1), 'hasError' => true));
			elseif(empty($matches) || !isset($matches[1])){
				$r = array_merge($this->returnStatus(400), array('field' => substr($key, 1), 'hasError' => true));
				$r['message'] = 'Sorry, one or more fields didn\'t contain the correct input.  Please try again with the correct syntax.';
				return $r;
			}
		}

		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_page_styling SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));

		if(file_exists($this->config['shared_css'].'/articlestyling.css')) unlink($this->config['shared_css'].'/articlestyling.css');
		if(file_exists($this->config['shared_css'].'/articlestylingie78.css')) unlink($this->config['shared_css'].'/articlestylingie78.css');
		
		if($result === true) return array('hasError' => false, 'message' => 'Styling settings updated successfully!');
		else return $result;
	}

	public function updateFeautredImageLink($post){
		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_page_images SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));
		if($result === true) return array('hasError' => false, 'message' => 'Featured image link information updated successfully!');
		else return $result;
	}*/

	/*MANAGE BILLING INFORMATION*/ //ADDING THIS TO USER OBJ
	public function editBillingInformation($data){
		$email = filter_var($data['paypal-email'], FILTER_SANITIZE_EMAIL);
		$user_id = filter_var($data['user_id'],  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$w9_live = 0;//filter_var($data['w9_live'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);

		if($data['w9_live'] == 'on') $w9_live = 1;
		
		//Check if record exists
		$recordExist = $this->performQuery(array(
			'queryString' => 'SELECT * FROM user_billing_info WHERE user_id = :user_id',
			'queryParams' => array(':user_id' => $user_id)
		));

		//if(!empty($email) && $email){
			if($recordExist){
				$billing_record =  $this->performUpdate(array(
				'updateString' => "UPDATE user_billing_info SET paypal_email = '".$email."', w9_live = ".$w9_live." WHERE user_id = :userId ",
				'updateParams' => array(':userId' => $user_id)
			));
				$message = 'Email Updated Successfully';

			}else{
				$billing_record = $this->performUpdate(array(
				'updateString' => "INSERT INTO user_billing_info (paypal_email, user_id, w9_live) VALUES ('".$email."', $user_id, $w9_live) ",
				'updateParams' => array(':paypalEmail'=>$email, ':userId' => $user_id,
				'isInsert' => true)
			));
				
				$message = "Email Added Successfully";
			}
			
			if($billing_record === true) return array('hasError' => false, 'message' => $message);
			else return $result;

	}

	public function getBillingInformation($user_id){
		$user_id = filter_var($user_id,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$billingInfo = $this->performQuery(array(
			'queryString' => 'SELECT * FROM user_billing_info WHERE user_id = :user_id',
			'queryParams' => array(':user_id' => $user_id)
		));

		return $billingInfo;
	}

	/*END MANAGE BILLING INFORMATION*/


	public function updateUserInfo($post){
		
		$params = $this->helpers->compileParams($post);
		
		$this->user->data = $this->user->getUserInfo();
		$salt = $this->user->data['user_salt'];
		$post['user_name-s'] = $this->user->data['user_name'];

		//	If the emaill in post already exists...
		if($foundUser = $this->user->userAlreadyExists($post)) {
			
			if ($foundUser['user_name'] != $post['user_name-s'] && $foundUser['user_email'] == $post['user_email-e']){
				return array( 'hasError' => true, 'message' => "Oops!  Looks like that email address is already being used.");
			}
		}

		//	If the email field is left blank
		if( $params[':user_email'] == "" ) {
			return array('hasError' => true, 'message' => "Oops!  You must fill out the email field.");
		} 

		$user_post = $post;
		unset($user_post['contributor_email_address-e']);
		unset($user_post['contributor_location-s']);
		unset($user_post['contributor_twitter_handle-s']);
		unset($user_post['contributor_facebook_link-s']);
		unset($user_post['contributor_blog_link-s']);

		unset($user_post['contributor_bio-nf']);
		unset($user_post['contributor_id']);

		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE users SET {pairs} WHERE user_id = ".$this->user->data['user_id'],
			'post' => $user_post,
			'unrequired' => array('user_first_name', 'user_last_name', 'user_display_name', 'user_name')
		));


		$params[':user_email'] = filter_var($params[':user_email'], FILTER_SANITIZE_EMAIL);
		$params[':user_first_name'] = filter_var($params[':user_first_name'], FILTER_SANITIZE_STRING);
		$params[':contributor_location'] = filter_var($params[':contributor_location'], FILTER_SANITIZE_STRING);
		$params[':contributor_twitter_handle'] = filter_var($params[':contributor_twitter_handle'], FILTER_SANITIZE_EMAIL);
		$params[':contributor_facebook_link'] = filter_var($params[':contributor_facebook_link'], FILTER_SANITIZE_URL);
		$params[':contributor_blog_link'] = filter_var($params[':contributor_blog_link'], FILTER_SANITIZE_URL);
		$params[':contributor_bio'] = filter_var($params[':contributor_bio'], FILTER_SANITIZE_STRING);
		
		if ($result){
			$result_cont = $this->updateSiteObject(array(
				'updateString' => "UPDATE article_contributors 
									SET contributor_email_address = '".$params[':user_email']."', 
									contributor_name = '".$params[':user_first_name']."',
									contributor_location = '".$params[':contributor_location']."',
									contributor_twitter_handle = '".$params[':contributor_twitter_handle']."', 
									contributor_facebook_link = '".$params[':contributor_facebook_link']."', 
									contributor_blog_link = '".$params[':contributor_blog_link']."',
									contributor_bio = '".$params[':contributor_bio']."'
									
									WHERE contributor_email_address = '".$this->user->data['user_email']."' 
									AND contributor_id = ".$post['c_i'],
				'post' => $post,
				'unrequired' => array('contributor_location', 'contributor_twitter_handle', 
									'contributor_facebook_link', 'contributor_blog_link', 'contributor_bio', 'user_name')
			));			
		}

		if($result_cont === true) return array('hasError' => false, 'message' => 'Your user information has been successfully updated');
		else return $result;
	}

	public function updateUserPassword($post){
		$current_password = filter_var($post['user_password_current-s'], FILTER_SANITIZE_URL);
		$password_1 = filter_var($post['user_password1-s'], FILTER_SANITIZE_URL);
		$password_2 = filter_var($post['user_password2-s'], FILTER_SANITIZE_URL);

		unset($post['user_password_current-s']);
		unset($post['user_password1-s']);
		unset($post['user_password2-s']);

		$params = $this->helpers->compileParams($post);
		
		$this->user->data = $this->user->getUserInfo();
		$salt = $this->user->data['user_salt'];
		
		//	If the user has the password change form open, check to make sure they have filled out the pasword fields...
		if( $post['pwd_change'] == "true" &&  ($current_password == "" || $password_1 == "" || $password_2 == "") ){
			return array('hasError' => true, 'message' => "Oops!  You must fill out ALL of the password fields.");
		}

		if($password_1 != $password_2){
			return array('hasError' => true, 'message' => "Oops!  Your passwords do not match.");
		}

		//	Make sure the current password is correct
		if ($this->user->checkPassword($this->user->data['user_name'], $current_password) == false){
			return array('hasError' => true, 'message' => 'You have not entered the current password correctly.');
		}

		//	Change the password
		$hashed_password = crypt($password_2, '$2a$12$' . $salt);
		$params = array(":user_hashed_password" => $hashed_password) + $params;
		$post = array("user_hashed_password-s" => $hashed_password) + $post;

		$user_post = $post;

		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE users SET {pairs} WHERE user_id = ".$this->user->data['user_id'],
			'post' => $user_post,
			'unrequired' => array('user_last_name', 'user_last_name', 'contributor_location', 'contributor_twitter_handle', 
									'contributor_facebook_link', 'contributor_blog_link', 'contributor_bio')
		));

		if($result === true) return array('hasError' => false, 'message' => 'Your password has been successfully updated');
		else return $result;
	}

	public function updateBioInfo($post){
		
		$params = $this->helpers->compileParams($post);
		
		$this->user->data = $this->user->getUserInfo();
		$post['user_name-s'] = $this->user->data['user_name'];

		//	If the emaill in post already exists...
		$user_post = $post;
		
		unset($user_post['contributor_bio-nf']);
		
		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE users SET {pairs} WHERE user_id = ".$this->user->data['user_id'],
			'post' => $user_post,
			'unrequired' => array('user_last_name', 'user_last_name', 'contributor_location', 'contributor_twitter_handle', 
									'contributor_facebook_link', 'contributor_blog_link', 'contributor_bio')
		));

		$params[':contributor_bio'] = filter_var($params[':contributor_bio'], FILTER_SANITIZE_STRING);

		if ($result){
			$result_cont = $this->updateSiteObject(array(
				'updateString' => "UPDATE article_contributors 
									SET contributor_bio = '".$params[':contributor_bio']."'
									WHERE contributor_email_address = '".$this->user->data['user_email']."' 
									AND contributor_id = ".$post['c_i'],
				'post' => $post,
				'unrequired' => array('user_last_name', 'contributor_location', 'contributor_twitter_handle', 
									'contributor_facebook_link', 'contributor_blog_link', 'contributor_bio')
			));			
		}

		if($result_cont === true) return array('hasError' => false, 'message' => 'Your Bio has been successfully updated');
		else return $result;
	}
	/* End Admin Controller Site Updating Functions */

	public function getContributorUserType( $contributor_id ){
		 $contributor_id = filter_var($contributor_id, FILTER_SANITIZE_NUMBER_INT);

		 $s = " SELECT users.user_type FROM article_contributors INNER JOIN ( users ) ON ( users.user_email = article_contributors.contributor_email_address ) WHERE  article_contributors.contributor_id =  :contributor_id";

		 $q = $this->performQuery(array(
			'queryString' => $s,
			'queryParams' => array( ':contributor_id' => $contributor_id )
		));

		 return $q;
	}

	/* Begin Article Creation Functions */
	
	public function addArticle($post){ 
		
		//Validate
		if(!isset($post['article_title-s']) || empty($post['article_title-s'])) 
			return array_merge($this->helpers->returnStatus(500), array('field'=>'article_title', 'message' => 'Title Required'));
		if(!isset($post['article_tags-nf']) || empty($post['article_tags-nf'])) 
			return array_merge($this->helpers->returnStatus(500), array('field'=>'article_tags-s', 'message' => 'Tags Required'));
		if(!isset($post['article_desc-s']) || empty($post['article_desc-s'])) 
			return array_merge($this->helpers->returnStatus(500), array('field'=>'article_desc-s', 'message' => 'Description Required'));
		if(!isset($post['article_categories']) || $post['article_categories'] === "0" ) 
			return array_merge($this->helpers->returnStatus(500), array('field'=>'article_categories', 'message' => 'You must select at least one category for an article.'));		
		if(!isset($post['article_contributor']) || $post['article_contributor'] == -1) 
			return array_merge($this->helpers->returnStatus(500), array('field'=>'article_contributor', 'message' => 'You must select a contributor for this article.'));

		//Unrequired Fields
		$unrequired = array( 'article_body', 'article_img_credits', 'article_img_credits_url', 'article_additional_comments' );

		//Generate SEO Title
		if(!isset($post['article_seo_title-s'])) $post['article_seo_title-s'] = $this->helpers->generateName(array('input' => $post['article_title-s']));
		
		//Get User Info
		$user =  $this->user->data;
		$user_type = isset($user) ? $user['user_type'] : 0;

		//IF IS AN STARTER BLOGGER
		//if($user_type == 30 ){
		//	$post['article_status-s'] = 2; //PENDING FOR REVIEW
		//}

		$params = $this->helpers->compileParams($post);
		$pairs = array_unique($this->helpers->compilePairs($post));
		
		$params[':article_seo_title'] = $post['article_seo_title-s'];
		$pairs[] = "date_updated = :date_updated";
		$params[':date_updated'] =  date("Y-m-d H:i:s");

		$valid = $this->helpers->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		//Check for same seo-name
		$seoTitleCheck = $this->performQuery(array(
			'queryString' => 'SELECT * FROM articles WHERE article_seo_title = :seoTitle',
			'queryParams' => array(':seoTitle' => $params[':article_seo_title'])
		));

		//Duplicate Title
		if($seoTitleCheck !== false) 
			return array_merge($this->helpers->returnStatus(500), array('message' => 'This Title is already in use.  Please try again with a new title.', 'field' => 'article_title'));

		//Insert article, get new article id
		$articleId = $this->performUpdate(array(
			'updateString' => str_replace('{pairs}', join(', ', $pairs), "INSERT INTO articles SET {pairs}"),
			'updateParams' => $params,
			'isInsert' => true
		));

		if($articleId === false) return $this->helpers->returnStatus(500);

		//Insert article images row, check for success
		$articleImageId = $this->performUpdate(array(
			'updateString' => "INSERT INTO article_images SET article_id = :articleId",
			'updateParams' => array(':articleId' => $articleId),
			'isInsert' => true
		));

		//Article image insertion failed, delete article and error out
		if($articleImageId === false){
			$this->performUpdate(array(
				'updateString' => "DELETE FROM articles WHERE article_id = :articleId",
				'updateParams' => array(':articleId' => $articleId)
			));
			return $this->helpers->returnStatus(500);
		}

		//Give the new article some love in the ratings department
		for($i =0; $i < 5; $i++){
			//Garauntees a rating anywhere from 4 - 5 starts to start out
			$rand = rand(3, 5);
			$this->performUpdate(array(
				'updateString' => "INSERT INTO article_ratings SET article_id = :articleId, rating = :rating",
				'updateParams' => array(':articleId' => $articleId, ':rating' => $rand)
			));
		}
		
		//Add to each category
		if(isset($post['article_categories']) && $post['article_categories'] != 0){
		//foreach($post['article_categories'] as $category => $on){
			//$categoryId = intval(str_replace('category-', '', $category));
			$categoryId = $post['article_categories'];

			$this->performUpdate(array(
				'updateString' => "INSERT INTO article_categories SET article_id = :articleId, cat_id = :categoryPageId",
				'updateParams' => array(':articleId' => $articleId, ':categoryPageId' => filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT))
			));
		}
		
		//Add to contributor's list of articles
		if(isset($post['article_contributor']) && $post['article_contributor'] != -1){
			$contributorId = intval(filter_var($post['article_contributor'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));
			$this->performUpdate(array(
				'updateString' => "INSERT INTO article_contributor_articles SET article_id = :articleId, contributor_id = :contributorId",
				'updateParams' => array(':articleId' => $articleId, ':contributorId' => $contributorId)
			));
		}
		
		$post['a_i'] = $articleId;
		$this->updateArticleAdsInfo($post);

		//MOVE and rename image from the temp folder if exists.
			$img_temp = 'temp_u_'.$_POST['u_i'].'_'.substr($_POST['c_t'], 0, 7).'_tall.jpg';
			$img_temp_path =   $this->config['image_upload_dir'].'articlesites/puckermob/temp/'.$img_temp;

			$img_name = $articleId.'_tall.jpg';
			$img_path = $this->config['image_upload_dir'].'articlesites/puckermob/large/'.$img_name;

			$imageExists = false;
			//	Verify if the usr has ever SELECTED an image
			if(isset($img_temp)){
				$imageExists = file_exists($img_temp_path);
			}
			//var_dump($img_temp, $img_temp_dir,$img_name, $imgDir, $imageExists  ); die;

			if($imageExists){
				copy($img_temp_path, $img_path);
				unlink($img_temp_path);
				unlink($this->config['image_upload_dir'].'articlesites/puckermob/large/'.$img_temp);
			}
		//END

		//$article_prev_content = $this->getPreviewRecipe(array('articleId' => $articleId ));
		
		//Return status
		return array_merge($this->helpers->returnStatus(200), array(
			'articleInfo' => $params,
			'articleID' => $articleId,
			'message' => 'Next Step: Add an Image.',
			'article_prev_content' => ''
		));
	}
	/* End Article Creation Functions */

	public function updateArticleAdsInfo($post){
		$mobile_1 = isset($post['mobile_1']) ? $post['mobile_1'] : 2;
		$mobile_2 = isset($post['mobile_2']) ? $post['mobile_2'] : 5;
		$mobile_3 = isset($post['mobile_3']) ? $post['mobile_3'] : 9;
		$mobile_4 = isset($post['mobile_4']) ? $post['mobile_4'] : 15;
		$mobile_5 = isset($post['mobile_5']) ? $post['mobile_5'] : -1;
		$desktop_1 = isset($post['desktop_1']) ? $post['desktop_1'] : 2;
		$desktop_2 = isset($post['desktop_2']) ? $post['desktop_2'] : 5;

		//Check if article already has ads set
		$ads = $this->performQuery( array(
			'queryString' => 'SELECT * FROM article_ads WHERE article_id = :articleId',
			'queryParams' => array(':articleId' => $post['a_i'])
		) );

		if($ads !== false){ 
			$this->performUpdate(array(
				'updateString' => "UPDATE article_ads SET  
				mobile_1 = $mobile_1, 
				mobile_2 = $mobile_2, 
				mobile_3 = $mobile_3, 
				mobile_4 = $mobile_4, 
				mobile_5 = $mobile_5, 
				desktop_1 = $desktop_1, 
				desktop_2 = $desktop_2
				WHERE article_id = :articleId",
				'updateParams' => array(':articleId' => $post['a_i'])
			));
		}else{
			$this->performUpdate(array(
				'updateString' => "INSERT INTO article_ads SET article_id = :articleId, 
				mobile_1 = $mobile_1, 
				mobile_2 = $mobile_2, 
				mobile_3 = $mobile_3, 
				mobile_4 = $mobile_4, 
				mobile_5 = $mobile_5, 
				desktop_1 = $desktop_1, 
				desktop_2 = $desktop_2",
				'updateParams' => array(':articleId' => $post['a_i'])
			));
		}

	}

	/* Begin Article Updating Function */
	public function updateArticleInfo($post){
		if(!isset($post['article_categories'])) return array_merge($this->helpers->returnStatus(500), array('message' => 'You must select at least one category.'));
		
		//Get User Info
		$user =  $this->user->data;
		$user_type = isset($user) ? $user['user_type'] : 0;

		//IF IS AN STARTER BLOGGER
		if($user_type == 30 &&  $post['article_status-s'] != 2 ){
			$post['article_status-s'] = 3; //DRAFT
		}
		
		$params = $this->helpers->compileParams($post);

		$seoTitleCheck = $this->performQuery(array(
			'queryString' => 'SELECT * FROM articles WHERE article_seo_title = :seoTitle AND article_id != :articleId',
			'queryParams' => array(':seoTitle' => $params[':article_seo_title'], ':articleId' => $post['a_i'])
		));

		if($seoTitleCheck !== false) return array_merge($this->helpers->returnStatus(500), array('message' => 'This Title is already in use.  Please try again with a new title.', 'field' => 'article_seo_title'));

		$statusUpdate = $this->updateArticleStatus($post);
		if($statusUpdate !== true) return $statusUpdate;

		//Delete all category, contributor, and video entries
		$this->performUpdate(array('updateString' => 'DELETE FROM article_categories WHERE article_id = '.$post['a_i']));
		$this->performUpdate(array('updateString' => 'DELETE FROM article_contributor_articles WHERE article_id = '.$post['a_i']));


		//Insert Category
		if(isset($post['article_categories']) && $post['article_categories'] != 0){
			$categoryId = $post['article_categories'];
				$this->performUpdate(array(
				'updateString' => "INSERT INTO article_categories SET article_id = :articleId, cat_id = :categoryPageId",
				'updateParams' => array(':articleId' => $post['a_i'], ':categoryPageId' => filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT))
			));
		}

		//Insert Contributor
		if(isset($post['article_contributor']) && $post['article_contributor'] != -1){
			$contributorId = intval(filter_var($post['article_contributor'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));
			$this->performUpdate(array(
				'updateString' => "INSERT INTO article_contributor_articles SET article_id = :articleId, contributor_id = :contributorId",
				'updateParams' => array(':articleId' => $post['a_i'], ':contributorId' => $contributorId)
			));
		}

		//Add Related Articles if any
		$this->performUpdate(array('updateString' => 'DELETE FROM related_articles WHERE main_article_id = '.$post['a_i'] ));
		$related_article_1 = $related_article_2 = $related_article_3 = -1;
		if(isset($post['related_article_1']) && $post['related_article_1'] != '-1' ) $related_article_1 = $post['related_article_1'];
		if(isset($post['related_article_2']) && $post['related_article_2'] != '-1' ) $related_article_2 = $post['related_article_2'];
		if(isset($post['related_article_3']) && $post['related_article_3'] != '-1' ) $related_article_3 = $post['related_article_3'];

		$this->performUpdate(array(
			'updateString' => "INSERT INTO related_articles SET  main_article_id = :articleId,  related_article_id_1= :related_article_1, 
			 related_article_id_2 = :related_article_2, related_article_id_3 = :related_article_3 ",
			'updateParams' => array(
				':articleId' => $post['a_i'], 
				':related_article_1'=>$related_article_1,
				':related_article_2'=>$related_article_2,
				':related_article_3'=>$related_article_3 
			)
		));
		
		
		//Update Featured Article
		/*if(isset($post['feature_article']) && $post['feature_article'] > 0){
			$this->performUpdate(array('updateString' => 'DELETE FROM featured_article '));
			$featureArticle = intval(filter_var($post['feature_article'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));
			$this->performUpdate(array(
				'updateString' => "INSERT INTO featured_article SET  article_id = :articleId, category_id = 1",
				'updateParams' => array(':articleId' => $post['a_i'])
			));
		}else{
			$this->performUpdate(array('updateString' => 'DELETE FROM featured_article WHERE article_id = '.$post['a_i']));
		}*/

		//FEATURED THIS ARTICLE ON LEFT SIDE BAR MOBILE TAP SECTION

		if(isset($post['article_featured']) &&  $post['article_featured'] !== "-1" ){
			$this->featuredArticle( $post );
		}


		//Show in homepage moblog article
		/*if(isset($post['featured_hp']) ){
			$this->performUpdate(array('updateString' => 'DELETE FROM article_moblogs_featured WHERE article_id = '.$post['a_i']));
			$featureArticleHp = intval(filter_var($post['featured_hp'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));
			$featureArticleId = intval(filter_var($post['a_i'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));

			$this->performUpdate(array(
				'updateString' => "INSERT INTO article_moblogs_featured SET  article_id = :articleId, article_cat = 'moblog', article_featured_hp = :articleHPFeature ",
				'updateParams' => array(':articleId' => $featureArticleId, ':articleHPFeature'=> $featureArticleHp )
			));
		}*/

		//UPDATE / INSERT ARTICLE ADS SETTINGS
		$this->updateArticleAdsInfo($post);

		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE articles SET {pairs} WHERE article_id = ".$post['a_i'],
			'post' => $post,
			'unrequired' => array('article_tags', 'article_yield', 'article_prep_time', 'article_cook_time', 
				'article_body', 'article_keywords', 'article_img_credits', 'article_img_credits_url', 'article_additional_comments', 
				'article_poll_id', 'article_desc', 'featured_hp')
		));
		
		if($result === true) {
			$user = $this->user->getUserInfo();
			if ($user['user_permission_show_global_settings']){
				return array('hasError' => false, 'message' => 'Article information updated successfully!', 'article_prev_content' => '' );
			} else {
				return array('hasError' => false, 'message' => 'Your changes have been saved', 'article_prev_content' => '');				
			}
		}
		else return $result;
	}
	
	public function updateArticleStatus($post){
		$articleId = filter_var($post['a_i'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$articleInfo = $this->getSingleArticle(array('articleId' => $articleId));

		if(!$articleInfo) return $this->helpers->returnStatus(500);

		$articleStatus = filter_var($post['article_status'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);

		
		$statusChange = $this->performUpdate(array(
			'updateString' => "UPDATE articles SET article_status = ".$articleStatus." WHERE article_id = ".$articleId
		));

		if($statusChange === true) return true;
		return $statusChange;
	}

	public function republishArticle($data){
		$articleId = filter_var($data['a_i'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);	
		$status = $data['status'];
		$currentDate = date("Y-m-d H:i:s");
		

		//	Set the paths to the image
		$image = $articleId.'_tall.jpg';
		$imageDir =   $this->config['image_upload_dir'].'articlesites/puckermob/large/'.$image;
		$imageExists = false;
		//	Verify if the usr has ever SELECTED an image
		if(isset($image)){
			$imageExists = file_exists($imageDir);
		}

		if( $status === "3" || $status === "2"){

			$statusChange = $this->performUpdate(array(
				'updateString' => "UPDATE articles SET article_status = $status, date_updated = '".$currentDate."'  WHERE article_id = ".$articleId
			));
			
		}else if( $status === "1"){
			if($imageExists){
				$statusChange = $this->performUpdate(array(
					'updateString' => "UPDATE articles SET article_status = 1, date_updated = '".$currentDate."'  WHERE article_id = ".$articleId
				));
			}
		}
		

		if($statusChange === true) return true;
		return false;
	}

	//FEATURED THIS ARTICLE 
	public function featuredArticle($data){
	
		$is_featured = filter_var($data['article_featured'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$status = $data['article_status'];
		$result = false;
		if( $status != 1){ //Make sure this article is already life
			return array_merge($this->helpers->returnStatus(500), array('message' => 'Error!. This article is not live.'));
		}else{//INSERT TO FEATURED_ARTICLE TABLE
			if($is_featured){
				$dup = $this->checkDupFeaturedArticle($data);
			
				if( $dup == false ){
					//Insert Into articles_featured table
					$result = $this->insertFeaturedArticle($data);
				}
			}else{
				//Delete from articles_featured table
				$result = $this->deleteFeaturedArticle($data);
			}
		}

		return $result;
	}

	public function getFeaturedArticle( $article_id = 1 ){
		$article_id = filter_var($article_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		
		$s = " SELECT articles_featured.article_id, articles.article_title, articles.article_seo_title, categories.cat_dir_name, article_contributors.contributor_name, article_contributors.contributor_seo_name  
			FROM articles_featured 
			INNER JOIN ( articles, article_categories, categories, article_contributors, article_contributor_articles )
			ON articles_featured.article_id=articles.article_id 
			AND articles.article_id=article_categories.article_id 
			AND article_categories.cat_id=categories.cat_id 
			AND articles_featured.article_id = article_contributor_articles.article_id
			AND article_contributor_articles.contributor_id = article_contributors.contributor_id
			WHERE articles_featured.article_id = $article_id ";
		
			$q = $this->performQuery(['queryString' => $s]);

			if(isset($q[0])) $q = $q[0];

			return $q;
	}

	private function checkDupFeaturedArticle( $data ){
		$article_id = filter_var($data['a_i'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);	

		$s = " SELECT * FROM articles_featured WHERE article_id = $article_id ";

		$q = $this->performQuery(['queryString' => $s]);

		return $q;

	}
	
	private function insertFeaturedArticle( $data ){
		$article_id = filter_var($data['a_i'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);	
		$category= filter_var($data['article_categories'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);	
		$is_featured = filter_var($data['article_featured'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$feature_type = 1; //For now only one type of feature. This will be on the tap left bar on mobile
		$status = $data['article_status'];

		$s = " INSERT INTO articles_featured (featured_id, cat_id, article_id, feature_type) VALUES (null, :category, :article_id, :feature_type) ";
		
		$queryParams = [
		':category' => $category, 
		':article_id' => $article_id, 
		':feature_type' => $feature_type
		];

		$pdo = $this->con->openCon();
			
		$q = $pdo->prepare($s);
		$row = $q->execute($queryParams);

		$this->con->closeCon();
		
		return $row ; 
	}

	private function deleteFeaturedArticle( $data ){
		$article_id = filter_var($data['a_i'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);	

		$s = " DELETE FROM articles_featured WHERE article_id = $article_id ";

		$pdo = $this->con->openCon();
			
		$q = $pdo->prepare($s);
		$row = $q->execute(array());

		$this->con->closeCon();
		return $row ; 
	}

	/* End Featured Article Function */

	/* End Article Updating Fucntion */


	/* Begin Admin Image Uploading Functions */
	public function updateImageRecord($files, $opts){
		$options = array_merge(array(
			// Set defaults
			'allowedExtensions' => 'png,jpg,jpeg,gif',
			'currentImage' => 'unset',
			'updatingDatabase' => false,
			'placement' => '',
			'table' => '',
			'column' => '',
			'uploadDirectory' => $this->config['image_upload_dir'].'articlesites/',
			'updateString' => "UPDATE {table} SET {column} = :uploadedImage WHERE ",
			'whereClause' => '',
			'articleId' => '',
			'successMessage' => '',
			'resizeImage' => false,
			'newImageHeight' => '',
			'newImageWidth' => ''
		), $opts);
		
			$options['updateString'] = $options['updateString'].$options['whereClause'];
			$result = $this->uploadImage($files, $options);
			if($result === true) {
				return array_merge($this->helpers->returnStatus(200), array('message' => $options['successMessage']));
			}else {

				return $result;
			}
	}

	protected function performUpdate($opts){
		if (isset($opts['updatingDatabase']) && $opts['updatingDatabase'] == false ) { return true; }
		$options = array_merge(array(
			'updateString' => '',
			'updateParams' => array(),
			'isInsert' => false
		), $opts);

		$pdo = $this->con->openCon();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$q = $pdo->prepare($options['updateString']);

		try{
			$q->execute($options['updateParams']);

		}catch(PDOException $e){
			$r = false;
		}
		$this->con->closeCon();
		$r = ($options['isInsert']) ? $pdo->lastInsertId() : true;
		return $r;
	}

	function getImageObj($ext, $file) {   
		//'png,jpg,jpeg,gif'
		
		if( $ext == 'jpg' || $ext == 'jpeg' ) {   
			$image = imagecreatefromjpeg($file); 
		} 
		elseif( $ext == 'gif' ) {   
			$image = imagecreatefromgif($file); 
		} 
		elseif( $ext == 'png' ) {
		   $image = imagecreatefrompng($file); 
		} 
		return $image;
	}

	private function getWidth($img) {   
		return imagesx($img); 
	} 

	private function getHeight($img) {   
		return imagesy($img); 
	}

	private function createImageServer($extension, $imgObj, $fullPathToFile, $quality){
		if( $extension == 'jpeg'  || $extension == 'jpg') {
		   	imagejpeg($imgObj, $fullPathToFile, $quality); 
		} 
					  
		elseif( $extension == 'gif' ) {
		    imagegif($imgObj, $fullPathToFile, $quality); 
		} 

		elseif( $extension == 'png' ) {
		    imagepng($imgObj, $fullPathToFile, $quality); 
		} 
	}

	private function getFileName($articleId, $placement,  $extension){
		return $articleId.'_'.$placement.'.'.$extension;
	}

	private function  getFullPathFile($uploadDirectory, $placement, $basename){
		return $uploadDirectory.$placement.'/'.$basename;
	}

	private function uploadImage($files, $opts){
		$opts['allowedExtensions'] = explode(',', $opts['allowedExtensions']); //No leading periods
		
		foreach($files as $file){
			if(!$this->helpers->validateName(array(
				'fileName' => $file['name'],
				'fileType' => $file['type'],
				'fileSize' => $file['size'],
				'allowedExtensions' => $opts['allowedExtensions']
			))) return array_merge($this->helpers->returnStatus(500), array('message' => '1-Sorry, no valid files were found.  Please try again.'));

			//Hack to keep image uploads under 500kb
			if($file['size'] > 512000) return array_merge($this->helpers->returnStatus(500), array('message' => 'This image appears to be too large in file size for mobile devices.  Please try again with a smaller file.'));
			
			if ($opts['updatingDatabase'] == true ){
				// We are updating the DB, so perform update

				if(!is_uploaded_file($file['tmp_name']) || empty($opts['table']) || empty($opts['column'])) return array_merge($this->helpers->returnStatus(500), array('message' => '2-Sorry, no valid files were found.  Please try again.'));

				$fileName = explode('.', $file['name']);
				$extension = $fileName[count($fileName) - 1];
				unset($fileName[count($fileName) - 1]);
				$fileName = preg_replace('/[^A-Za-z0-9]/', '_', join($fileName, '')).'.'.$extension;

				if($opts['currentImage'] == $fileName) return array_merge($this->helpers->returnStatus(500), array('message' => '1-This is already the default image!  Please try again with a new file.'));

				$opts['table'] = filter_var($opts['table'], FILTER_SANITIZE_STRING, PDO::PARAM_STR);
				$opts['column'] = filter_var($opts['column'], FILTER_SANITIZE_STRING, PDO::PARAM_STR);

				$uploadFile = $opts['uploadDirectory'].basename($fileName);

				$opts['updateString'] = str_replace('{table}', $opts['table'], $opts['updateString']);
				$opts['updateString'] = str_replace('{column}', $opts['column'], $opts['updateString']);
				$opts['updateParams'] = array(':uploadedImage' => $fileName);
				if(file_exists($uploadFile)) return $this->performUpdate($opts);
				if(move_uploaded_file($file['tmp_name'], $uploadFile)) return $this->performUpdate($opts);

			} else if ($opts['updatingDatabase'] == false) {
				// We are not running the update on the database, so we do not need the table or column info
				if(!is_uploaded_file($file['tmp_name'])) {
					return array_merge($this->helpers->returnStatus(500), array('message' => '3-Sorry, no valid files were found.  Please try again.'));
				}

				$fileName = explode('.', $file['name']);
				$extension = $fileName[count($fileName) - 1];
				unset($fileName[count($fileName) - 1]);
				$placement = $opts['placement'];
				$articleId = $opts['articleId'];
			

				if($opts['resizeImage']){
					$placementObj = ['wide', 'tall', 'preview'];

					foreach($placementObj as $imgplacement){
						$fileName = $this->getFileName($articleId, $imgplacement,  $extension);

						$fullPathToFile = $this->getFullPathFile($opts['uploadDirectory'], $imgplacement, basename($fileName));
						
						/*Creating 3 versions of the same image for articles if applicable*/
						//1- Create new Image Object base on the extension type
						$img = $this->getImageObj($extension, $file['tmp_name']);

						//2- Resize the new Image
						$newImg = $this->resizeImage($img, $this->getNewWidth($imgplacement), $this->getNewHeight($imgplacement));

						//3- Creates a file from the given image. 
						$this->createImageServer($extension, $newImg, $fullPathToFile, 100);

						if($imgplacement == 'preview'){
							$opts['updatingDatabase'] = true;
							$opts['table'] = filter_var('article_images', FILTER_SANITIZE_STRING, PDO::PARAM_STR);
							$opts['column'] = filter_var('article_preview_img', FILTER_SANITIZE_STRING, PDO::PARAM_STR);
			
							$opts['updateString'] = str_replace('{table}', $opts['table'], $opts['updateString']);
							$opts['updateString'] = str_replace('{column}', $opts['column'], $opts['updateString']);
							$opts['updateParams'] = array(':uploadedImage' => $fileName);
							
							if(file_exists($fullPathToFile)) return $this->performUpdate($opts);
						}else{
							if (file_exists($fullPathToFile)){
							//	unlink($fullPathToFile);
							}
						}
					}
				}
				else{
					$fileName = $articleId.$placement.'.'.$extension;
					$fullPathToFile = $opts['uploadDirectory'].basename($fileName);
					// If the file already exists, just update the DB
					//if(file_exists($uploadFile)) return $this->performUpdate($opts);
					if (file_exists($fullPathToFile)){
						unlink($fullPathToFile);
					}

					if(move_uploaded_file($newImg, $fullPathToFile)) {
						unset($file);
						unset($fileName);
						unset($fullPathToFile);
						return $this->performUpdate($opts);
					}
				}
			}		
			return $this->helpers->returnStatus(500);
		}
		unset($files);
	}

	/* Begin Admin Controller Helper Functions */
	public function getFileExtension($name){

		$name = glob ($name."*");

		if ($name){
			$ext = pathinfo($name[0], PATHINFO_EXTENSION);
			return $ext;
		} else {
			return false;
		}
	}

	protected function updateSiteObject($opts){

		$options = array_merge(array(
			'updateString' => '',
			'post' => array(),
			'unrequired' => array()
		), $opts);

		$options['updateParams'] = $this->helpers->compileParams($options['post']);
		$updatePairs = $this->helpers->compilePairs($options['post']);

		$valid = $this->helpers->validateRequired($options['updateParams'], $options['unrequired']);
		if($valid !== true) return $valid;

		$options['updateString'] = str_replace('{pairs}', join(', ', $updatePairs), $options['updateString']);

		$q = $this->performUpdate($options);

		if(!$q) return false;
		else return true;
	}

	public function checkCSRF($post){
		return $this->helpers->checkCSRF($post);
	}

	public function getPagination($opts){
		return $this->helpers->getPagination($opts);
	}

	public function redirectTo($location = ''){
		header('Location: '.$this->config['this_admin_url'].$location);
	}
	/* End Admin Controller Helper Functions */
}

?>