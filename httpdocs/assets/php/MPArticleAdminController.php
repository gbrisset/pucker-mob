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
				$r['message'] = 'Sorry, looks like something went wrong.  Please try again or contact <a href="mailto:info@simpledish.com">info@simpledish.com</a> for assitance.';
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

		$sql = "SELECT *, a.article_id FROM articles as a LEFT JOIN (article_images as ai, article_statuses as astatus) ON (a.article_id = ai.article_id AND a.article_status = astatus.status_id) WHERE a.article_seo_title = :seoTitle OR a.article_id = :articleId";
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

		$article['video'] = $this->performQuery(array(
			'queryString' => 'SELECT * FROM article_videos as av INNER JOIN (syndication_videos as sv) ON (av.syn_video_id = sv.syn_video_id) WHERE av.article_id = '.$article['article_id']
		));
		return $article;
	}
	/* End Admin Controller Get Information Functions */


	/* Begin Admin Controller Site Updating Functions */
	public function updateSiteSettings($post){
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
	}

	public function updateSiteFeautedObject($opts){
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
	}

	public function updateSiteSearch($post){
		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_page_social_settings SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));
		if($result === true) return array('hasError' => false, 'message' => 'Search settings updated successfully!');
		else return $result;	
	}

	public function updatePlayerSettings($post){
		$post = array_merge(array(
			'player_setting_debug-n' => (isset($post['player_setting_debug']) && $post['player_setting_debug'] == "player_setting_debug_on") ? 1 : 0,
			'player_setting_autoplay-n' => (isset($post['player_setting_autoplay']) && $post['player_setting_autoplay'] == "player_setting_autoplay_on") ? 1 : 0,
			'player_setting_randomize_playlist-n' => (isset($post['player_setting_randomize_playlist']) && $post['player_setting_randomize_playlist'] == "player_setting_randomize_playlist_on") ? 1 : 0,
			'player_setting_countoff_start-n' => (isset($post['player_setting_countoff_start']) && $post['player_setting_countoff_start'] == "player_setting_countoff_start_on") ? 1 : 0,
			'player_setting_withads-n' => (isset($post['player_setting_withads']) && $post['player_setting_withads'] == "player_setting_withads_on") ? 1 : 0,
			'player_setting_prerolls-n' => (isset($post['player_setting_prerolls']) && $post['player_setting_prerolls'] == "player_setting_prerolls_on") ? 1 : 0,
			'player_setting_postrolls-n' => (isset($post['player_setting_postrolls']) && $post['player_setting_postrolls'] == "player_setting_postrolls_on") ? 1 : 0,
			'player_setting_ad_server_key-s' => preg_replace('/[\s]/', '', $post['player_setting_ad_server_key-s']),
			'player_setting_ad_server_keywords-s' => preg_replace('/[\s]/', '', $post['player_setting_ad_server_keywords-s']),
			'player_setting_ad_server_categories-s' => preg_replace('/[\s]/', '', $post['player_setting_ad_server_categories-s']),
		), $post);

		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_page_player_settings SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));
		if($result === true) return array('hasError' => false, 'message' => 'Player settings updated successfully!');
		else return $result;
	}

	public function updateSocialSettings($post){
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
	}

	public function updateAdCodes($post){
		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_page_ads SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));
		if($result === true) return array('hasError' => false, 'message' => 'Ad placement settings updated successfully!');
		else return $result;
	}

	public function updateAdTiming($post){
		$post = array_merge(array(
			'ads_rotate-n' => (isset($post['ads_rotate']) && $post['ads_rotate'] == "ads_rotate_enabled") ? 1 : 0
		), $post);

		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE article_page_ads SET {pairs} WHERE article_page_id = ".$this->config['articlepageid'],
			'post' => $post
		));
		if($result === true) return array('hasError' => false, 'message' => 'Ad timing settings updated successfully!');
		else return $result;
	}

	public function updateStylingSettings($post){
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
	}

	public function updateUserInfo($post){
		$current_password = filter_var($post['user_password_current-s'], FILTER_SANITIZE_URL);
		$password_1 = filter_var($post['user_password1-s'], FILTER_SANITIZE_URL);
		$password_2 = filter_var($post['user_password2-s'], FILTER_SANITIZE_URL);

		unset($post['user_password_current-s']);
		unset($post['user_password1-s']);
		unset($post['user_password2-s']);

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

		//	If the user has the password change form open, check to make sure they have filled out the pasword fields...
		if( $post['pwd_change'] == "true" &&  ($current_password == "" || $password_1 == "" || $password_2 == "") ){
			return array('hasError' => true, 'message' => "Oops!  You must fill out ALL of the password fields.");
		}

		if ($post['pwd_change'] == "true"){
			//	Handle the password change
			//	Make sure the new passwords match...
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
		} 



		// $result_cont = $this->updateSiteObject(array(
		// 	'updateString' => "UPDATE article_contributors SET contributor_email_address = '".$params[':user_email']."' WHERE contributor_email_address = '".$this->user->data['user_email']."'",
		// 	'post' => $post,
		// 	'unrequired' => array('user_last_name')
		// ));

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
			'unrequired' => array('user_last_name', 'user_last_name', 'contributor_location', 'contributor_twitter_handle', 
									'contributor_facebook_link', 'contributor_blog_link', 'contributor_bio')
		));

		$params[':user_email'] = filter_var($params[':user_email'], FILTER_SANITIZE_EMAIL);
		$params[':contributor_location'] = filter_var($params[':contributor_location'], FILTER_SANITIZE_STRING);
		$params[':contributor_twitter_handle'] = filter_var($params[':contributor_twitter_handle'], FILTER_SANITIZE_EMAIL);
		$params[':contributor_facebook_link'] = filter_var($params[':contributor_facebook_link'], FILTER_SANITIZE_URL);
		$params[':contributor_blog_link'] = filter_var($params[':contributor_blog_link'], FILTER_SANITIZE_URL);
		$params[':contributor_bio'] = filter_var($params[':contributor_bio'], FILTER_SANITIZE_STRING);

		if ($result){
			$result_cont = $this->updateSiteObject(array(
				'updateString' => "UPDATE article_contributors 
									SET contributor_email_address = '".$params[':user_email']."', 
									contributor_location = '".$params[':contributor_location']."',
									contributor_twitter_handle = '".$params[':contributor_twitter_handle']."', 
									contributor_facebook_link = '".$params[':contributor_facebook_link']."', 
									contributor_blog_link = '".$params[':contributor_blog_link']."',
									contributor_bio = '".$params[':contributor_bio']."'
									
									WHERE contributor_email_address = '".$this->user->data['user_email']."' 
									AND contributor_id = ".$post['c_i'],
				'post' => $post,
				'unrequired' => array('user_last_name', 'contributor_location', 'contributor_twitter_handle', 
									'contributor_facebook_link', 'contributor_blog_link', 'contributor_bio')
			));			
		}

		if($result_cont === true) return array('hasError' => false, 'message' => 'Your user profile has been successfully updated');
		else return $result;
	}

	/* End Admin Controller Site Updating Functions */



	/* Begin Article Creation Functions */
	
	public function addArticle($post){ 
		
		if(!isset($post['article_categories'])) return array_merge($this->helpers->returnStatus(500), array('message' => 'You must select at least one category for an article.'));
		
		//Check for prep and cook time and conver values enter by the user in minutes to insert into the db fields.
		/*if(isset($post['article_prep_time_hr-s']) && isset($post['article_prep_time_min-s'])){
			$prep_in_mins = ($post['article_prep_time_hr-s']*60) + $post['article_prep_time_min-s'];
			$post['article_prep_time-s'] = $prep_in_mins;
			unset($post['article_prep_time_hr-s']);
			unset($post['article_prep_time_min-s']);
		}

		if(isset($post['article_cook_time_hr-s']) && isset($post['article_cook_time_min-s'])){
			
			//	If the user hasn't selected a cook time, $post['article_cook_time_min-s'] will be equal to '-', let's set it to 0...
			if ($post['article_cook_time_min-s'] == '-') $post['article_cook_time_min-s'] = 0;
			
			$cook_in_mins = ($post['article_cook_time_hr-s']*60) + $post['article_cook_time_min-s'];
			$post['article_cook_time-s'] = $cook_in_mins;
			unset($post['article_cook_time_hr-s']);
			unset($post['article_cook_time_min-s']);
		}
		//END
*/
		$unrequired = array(
			'article_tags', 'article_yield', 'article_prep_time', 'article_cook_time', 'article_body', 'article_keywords', 'article_ingredients', 'article_instructions', 'article_additional_comments'
		);

		/*Ingredients And Instructions*/
		//Get the ingredients and instructions value and convert into a string object
		//$ingredients =  $this->helpers->getElementList($post, 'article_ingredients');
		//$instructions = $this->helpers->getElementList($post, 'article_instructions');

		//Clean the $post array and remove the ingredients and instructions to avoid conflic between fields
		//foreach( $post as $key => $val ){
			//if(strpos($key, 'article_ingredients') !== false || strpos($key, 'article_instructions') !== false){
			//	unset($post[$key]);
			//} 
		//}

		//Set the right key for ingredients and instructions value
		//$post['article_ingredients-nf'] = $ingredients;
		//$post['article_instructions-nf'] = $instructions;

		/*END Ingredients And Instructions*/

		if(!isset($post['article_seo_title-s'])) $post['article_seo_title-s'] = $this->helpers->generateName(array('input' => $post['article_title-s']));
	
		$params = $this->helpers->compileParams($post);
		$pairs = array_unique($this->helpers->compilePairs($post));

		$params[':article_seo_title'] = $post['article_seo_title-s'];

		$valid = $this->helpers->validateRequired($params, $unrequired);
		if($valid !== true) return $valid;

		//Check for same seo-name
		$seoTitleCheck = $this->performQuery(array(
			'queryString' => 'SELECT * FROM articles WHERE article_seo_title = :seoTitle',
			'queryParams' => array(':seoTitle' => $params[':article_seo_title'])
		));

		if($seoTitleCheck !== false) return array_merge($this->helpers->returnStatus(500), array('message' => 'This SEO Title is already in use.  Please try again with a new SEO title.', 'field' => 'article_seo_title'));

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
		foreach($post['article_categories'] as $category => $on){
			$categoryId = intval(str_replace('category-', '', $category));
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
		
		//Add a related video
		if(isset($post['article_video']) && $post['article_video'] != -1){
			$videoId = intval(filter_var($post['article_video'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));
			$this->performUpdate(array(
				'updateString' => "INSERT INTO article_videos SET article_id = :articleId, syn_video_id = :videoId",
				'updateParams' => array(':articleId' => $articleId, ':videoId' => $videoId)
			));
		}

		$article_prev_content = $this->getPreviewRecipe(array('articleId' => $articleId ));
		
		//Return status
		return array_merge($this->helpers->returnStatus(200), array(
			'articleInfo' => $params,
			'articleID' => $articleId,
			'message' => 'Next Step: Add an Image.',
			'article_prev_content' => $article_prev_content

		));
	}
	/* End Article Creation Functions */


	/* Begin Article Updating Fucntion */
	public function updateArticleInfo($post){
		if(!isset($post['article_categories'])) return array_merge($this->helpers->returnStatus(500), array('message' => 'You must select at least one category for an article.'));
		
		//Check for prep and cook time and conver values enter by the user in minutes to insert into the db fields.
	/*	if(isset($post['article_prep_time_hr-s']) && isset($post['article_prep_time_min-s'])){
			$prep_in_mins = ($post['article_prep_time_hr-s']*60) + $post['article_prep_time_min-s'];
			if($prep_in_mins == 0){
				return array_merge($this->helpers->returnStatus(500), array('message' => 'The recipe\'s prep time cannot be set to 0 minutes.'));
			}			
			$post['article_prep_time-s'] = $prep_in_mins;
			unset($post['article_prep_time_hr-s']);
			unset($post['article_prep_time_min-s']);
		}

		if(isset($post['article_cook_time_hr-s']) && isset($post['article_cook_time_min-s'])){
			$cook_in_mins = ($post['article_cook_time_hr-s']*60) + $post['article_cook_time_min-s'];
			$post['article_cook_time-s'] = $cook_in_mins;
			unset($post['article_cook_time_hr-s']);
			unset($post['article_cook_time_min-s']);
		}

		if(isset($post['article_cook_time_hr-s']) && isset($post['article_cook_time_min-s'])){
			$cook_in_mins = ($post['article_cook_time_hr-s']*60) + $post['article_cook_time_min-s'];
			$post['article_cook_time-s'] = $cook_in_mins;
			unset($post['article_cook_time_hr-s']);
			unset($post['article_cook_time_min-s']);
		}*/
		//END

		//Check for same seo-name
		if(isset($post['article_seo_title-s'])) $post['article_seo_title-s'] = $this->helpers->generateName(array('input' => $post['article_seo_title-s']));

		/*Ingredients And Instructions*/
		//Get the ingredients and instructions value and convert into a string object
		//$ingredients =  $this->helpers->getElementList($post, 'article_ingredients');
		//$instructions = $this->helpers->getElementList($post, 'article_instructions');

		//Clean the $post array and remove the ingredients and instructions to avoid conflic between fields
		foreach( $post as $key => $val ){
			if(strpos($key, 'article_ingredients') !== false || strpos($key, 'article_instructions') !== false){
				unset($post[$key]);
			} 
		}

		//Set the right key for ingredients and instructions value
		//$post['article_ingredients-nf'] = $ingredients;
		//$post['article_instructions-nf'] = $instructions;

		/*END Ingredients And Instructions*/


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
		$this->performUpdate(array('updateString' => 'DELETE FROM article_videos WHERE article_id = '.$post['a_i']));
		

			$this->performUpdate(array(
				'updateString' => "DELETE FROM article_categories WHERE article_id = :articleId",
				'updateParams' => array(':articleId' => $post['a_i'])
			));

		//Add to each category
		foreach($post['article_categories'] as $category => $on){
			$categoryId = intval(str_replace('category-', '', $category));
			// $this->performUpdate(array(
			// 	'updateString' => "DELETE FROM article_categories WHERE article_id = :articleId AND cat_id = :categoryPageId",
			// 	'updateParams' => array(':articleId' => $post['a_i'], ':categoryPageId' => filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT))
			// ));

			$this->performUpdate(array(
				'updateString' => "INSERT INTO article_categories SET article_id = :articleId, cat_id = :categoryPageId",
				'updateParams' => array(':articleId' => $post['a_i'], ':categoryPageId' => filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT))
			));
		}

		//Add contributor if desired
		if(isset($post['article_contributor']) && $post['article_contributor'] != -1){
			$contributorId = intval(filter_var($post['article_contributor'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));
			$this->performUpdate(array(
				'updateString' => "INSERT INTO article_contributor_articles SET article_id = :articleId, contributor_id = :contributorId",
				'updateParams' => array(':articleId' => $post['a_i'], ':contributorId' => $contributorId)
			));
		}

		//Add videos if desired
		if(isset($post['article_video']) && $post['article_video'] != -1){
			$videoId = intval(filter_var($post['article_video'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));
			$this->performUpdate(array(
				'updateString' => "INSERT INTO article_videos SET article_id = :articleId, syn_video_id = :videoId",
				'updateParams' => array(':articleId' => $post['a_i'], ':videoId' => $videoId)
			));
		}

		//Update Feature Article
		if(isset($post['feature_article']) && $post['feature_article'] > 0){
			$this->performUpdate(array('updateString' => 'DELETE FROM featured_article '));
			$featureArticle = intval(filter_var($post['feature_article'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT));
			$this->performUpdate(array(
				'updateString' => "INSERT INTO featured_article SET  article_id = :articleId, category_id = 1",
				'updateParams' => array(':articleId' => $post['a_i'])
			));
		}

		$result = $this->updateSiteObject(array(
			'updateString' => "UPDATE articles SET {pairs} WHERE article_id = ".$post['a_i'],
			'post' => $post,
			'unrequired' => array('article_tags', 'article_yield', 'article_prep_time', 'article_cook_time', 'article_body', 'article_keywords', 'article_ingredients', 'article_instructions', 'article_additional_comments', 'article_poll_id')
		));

		$article_prev_content = $this->getPreviewRecipe(array('articleId' => $post['a_i']));
		
		if($result === true) {
			$user = $this->user->getUserInfo();
			if ($user['user_permission_show_global_settings']){
				return array('hasError' => false, 'message' => 'Article information updated successfully!', 'article_prev_content' => $article_prev_content );
			} else {
				return array('hasError' => false, 'message' => 'Your changes have been saved', 'article_prev_content' => $article_prev_content);				
			}
		}
		else return $result;
	}
	
	public function updateArticleStatus($post){
		$articleId = filter_var($post['a_i'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$articleInfo = $this->getSingleArticle(array('articleId' => $articleId));

		if(!$articleInfo) return $this->helpers->returnStatus(500);

		$articleStatus = filter_var($post['article_status'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);

		switch($articleStatus){
			case 3:
				//Draft
				//No constraints on this
				break;
			case 2:
				//Pending Review
				//No constraints on this -- perhaps a permission check
				break;
			case 1:
				//Live
				//if(is_null($articleInfo['article_post_img']) || is_null($articleInfo['article_preview_img'])) return array_merge($this->helpers->returnStatus(500), array('message' => 'Sorry, an article must have both an inline and preview image in order to be set "live".'));
				break;

		}
		
		$statusChange = $this->performUpdate(array(
			'updateString' => "UPDATE articles SET article_status = ".$articleStatus." WHERE article_id = ".$articleId
		));

		if($statusChange === true) return true;
		return $statusChange;
	}
	/* End Article Updating Fucntion */


	/* Begin Navigation Item Creation Functions */
	public function makeSingleNavItem($opts){
		$template = '<li class="{current}" ><a href="{link}">{label}</a></li>';
		foreach($opts as $optionKey => $optionValue){
			$template = str_replace('{'.$optionKey.'}', $optionValue, $template);
		}
		return $template;
	}

	public function makeNavItemGroup($opts){
		$template = '<li class="parent {shown}"><a href="{link}">{label}</a></li><ul class="{shown}"><h2>{label}</h2>{childElements}</ul>';
		$childTemplate = '<li class="{current}" id="{childId}"><a href="{childLink}">{childLabel}</a></li>';
		$children = '';
		
		foreach($opts['childElements'] as $childObj){
			$child = $childTemplate;
			foreach($childObj as $childKey => $childValue){
				$child = str_replace('{'.$childKey.'}', $childValue, $child);
			}
			$children .= $child;
		}
		
		$opts['childElements'] = $children;
		
		foreach($opts as $optionKey => $optionValue){
			$template = str_replace('{'.$optionKey.'}', $optionValue, $template);
		}
		
		return $template;
	}
	/* End Navigation Item Creation Functions */


	/* Begin Admin Image Uploading Functions */
	// Updates the database with the new name
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
		// if ($options['currentImage'] == 'unset'){
		// 	$options['column'][] = 'article_preview_img';
		// 	$options['updateString'] = $options['addString'];
		// 	$result = $this->uploadImage($files, $options);
		// 	if($result === true) return array_merge($this->helpers->returnStatus(200), array('message' => $options['successMessage']));
		// 	else return $result;
		// } else {
			$options['updateString'] = $options['updateString'].$options['whereClause'];
			$result = $this->uploadImage($files, $options);
			if($result === true) {
				return array_merge($this->helpers->returnStatus(200), array('message' => $options['successMessage']));
			}else {

				return $result;
			}
		//}
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
		//echo json_encode( array('resp' => $options['updateString']) );
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
				// Create the new filename by joining article ID, and wide/tall, and the extension
				//$fileName = $articleId.$placement.'.'.$extension;


				//echo json_encode( array('resp' => $file['name']) );
				// if($opts['currentImage'] == $fileName) return array_merge($this->helpers->returnStatus(500), array('message' => '2-This is already the default image!  Please try again with a new file.'));

				//$fullPathToFile = $opts['uploadDirectory'].basename($fileName);
				// If the file already exists, just update the DB
				//if(file_exists($uploadFile)) return $this->performUpdate($opts);
				//if (file_exists($fullPathToFile)){
				//	unlink($fullPathToFile);
				//}

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


	public function getPreviewRecipe($opts){
		$options = array_merge(array(
			'articleId' => -1
		), $opts);

		$config = $this->config;
		$articleId = filter_var($opts['articleId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$article = $this->getSingleArticle(array('articleId' => $articleId));
			
		include_once($this->config['include_path_admin'].'preview.php');

		return $preview_article;

	}




	// private function uploadImage($files, $opts){
	// 	$opts['allowedExtensions'] = explode(',', $opts['allowedExtensions']); //No leading periods

	// 	foreach($files as $file){
	// 		if(!$this->helpers->validateName(array(
	// 			'fileName' => $file['name'],
	// 			'fileType' => $file['type'],
	// 			'fileSize' => $file['size'],
	// 			'allowedExtensions' => $opts['allowedExtensions']
	// 		))) return array_merge($this->helpers->returnStatus(500), array('message' => 'Sorry, no valid files were found.  Please try again.'));

	// 		if ($opts[''] == ){

	// 		}
	// 		//Hack to keep image uploads under 500kb
	// 		if($file['size'] > 512000) return array_merge($this->helpers->returnStatus(500), array('message' => 'This image appears to be too large in file size for mobile devices.  Please try again with a smaller file.'));
			
	// 		if(!is_uploaded_file($file['tmp_name']) || empty($opts['table']) || empty($opts['column'])) return array_merge($this->helpers->returnStatus(500), array('message' => 'Sorry, no valid files were found.  Please try again.'));

	// 		$fileName = explode('.', $file['name']);
	// 		$extension = $fileName[count($fileName) - 1];
	// 		unset($fileName[count($fileName) - 1]);
	// 		$fileName = preg_replace('/[^A-Za-z0-9]/', '_', join($fileName, '')).'.'.$extension;

	// 		if($opts['currentImage'] == $fileName) return array_merge($this->helpers->returnStatus(500), array('message' => 'This is already the default image!  Please try again with a new file.'));

	// 		$opts['table'] = filter_var($opts['table'], FILTER_SANITIZE_STRING, PDO::PARAM_STR);
	// 		$opts['column'] = filter_var($opts['column'], FILTER_SANITIZE_STRING, PDO::PARAM_STR);

	// 		$uploadFile = $opts['uploadDirectory'].basename($fileName);

	// 		$opts['updateString'] = str_replace('{table}', $opts['table'], $opts['updateString']);
	// 		$opts['updateString'] = str_replace('{column}', $opts['column'], $opts['updateString']);
	// 		$opts['updateParams'] = array(':uploadedImage' => $fileName);
	// 		if(file_exists($uploadFile)) return $this->performUpdate($opts);
	// 		if(move_uploaded_file($file['tmp_name'], $uploadFile)) return $this->performUpdate($opts);
			
	// 		return $this->helpers->returnStatus(500);
	// 	}
	// }
	/* End Admin Image Uploading Functions */


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