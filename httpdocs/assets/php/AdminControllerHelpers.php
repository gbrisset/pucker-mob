<?php

class AdminControllerHelpers{
	private $config;
	private $escapes;

	public function __construct($opts){
		$this->config = $opts['config'];
		$this->escapes = [
			'e' => [FILTER_SANITIZE_EMAIL, PDO::PARAM_STR],
			'n' => [FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT],
			's' => [FILTER_SANITIZE_STRING, PDO::PARAM_STR],
			'u' => [FILTER_SANITIZE_URL, PDO::PARAM_STR]
		];
	}

	public function getPagination($opts){
		$options = array_merge(array(
			'pageUrl' => '',
			'currentPage' => 1,
			'resultsPerPage' => 5,
			'results' => array()
		), $opts);

		$options['totalPages'] = ceil(count($options['results']) / $options['resultsPerPage']);

		$options['currentPage'] = (isset($options['currentPage']) && !empty($options['currentPage'])) ? intval(preg_replace('/[\D]/', '', $options['currentPage'])) : 1;
		
		if($options['currentPage'] > $options['totalPages']) $options['currentPage'] = 1;

		if($options['totalPages'] && $options['totalPages'] > 1){
			$offSet = ($options['currentPage'] - 1) * $options['resultsPerPage'];
			$options['results'] = array_slice($options['results'], $offSet, $options['resultsPerPage']);
		}

		$options['pages'] = $this->getPages($options['currentPage'], $options['totalPages']);

		return $options;
	}

	private function getPages($currentPage, $totalPages, $pagesToShow = 3){
		if(!isset($currentPage) || !isset($totalPages) || $currentPage > $totalPages) return false;

		$allNumbers = array();
		for($i = 0; $i < $totalPages; $i++){
			$allNumbers[] = ($i + 1);
		}

		$pagesToShow = ($pagesToShow % 2 !== 0) ? $pagesToShow : ($pagesToShow + 1);
		$pagesBelow = $pagesAbove = $pagesOnEachSide = ($pagesToShow - 1) / 2;

		$tempCurrentPage = $currentPage;
		while($tempCurrentPage - $pagesOnEachSide <= 0){
			$pagesBelow--;
			$pagesAbove++;
			$tempCurrentPage++;
		}

		$tempCurrentPage = $currentPage;
		while($tempCurrentPage + $pagesOnEachSide > $totalPages){
			$pagesBelow++;
			$pagesAbove--;
			$tempCurrentPage--;
		}

		$r = array();

		if($currentPage - $pagesBelow > 0){
			for($i = ($currentPage - $pagesBelow) - 1; $i < $currentPage - 1; $i++){
				if(isset($allNumbers[$i])) $r[] = $allNumbers[$i];
			}
		}

		if(!in_array(($currentPage), $r)) $r[] = $allNumbers[$currentPage - 1];

		if(!in_array(1, $r)){
			if($r[0] - 1 > 1) array_unshift($r, '...');
			array_unshift($r, 1);
		}

		for($i = $currentPage; $i < $currentPage + $pagesAbove; $i++){
			if(isset($allNumbers[$i])) $r[] = $allNumbers[$i];
		}

		if(!in_array($totalPages, $r)){
			if($totalPages - $r[count($r) - 1] > 1) $r[] = '...';
			$r[] = $totalPages;
		}

		return $r;
	}

	public function getURI($currentUrl, $siteUrl = null){
		$uri = explode('/', 
			preg_replace('/'.preg_replace('/\//', 
					'\/', 
					(!is_null($siteUrl)) ? $siteUrl : $this->config['this_admin_url']
				).'/', 
				'', 
				$currentUrl
			)
		);
		foreach($uri as $index => $uriStr){
			$uri[$index] = preg_replace('/\?(.*)/', '', $uriStr);
			preg_match('/\?(.*)/', $uriStr, $matches);
			if(isset($matches) && isset($matches[1])){
				$getStr = explode('&', $matches[1]);
				foreach($getStr as $getParam){
					$getParts = explode('=', $getParam);
					if(isset($getParts[0])) $_GET[$getParts[0]] = '';
					if(isset($getParts[1])) $_GET[$getParts[0]] = $getParts[1];
				}
			}
			
		}
		return $uri;
	}


	public function compilePairs($post, $isInsert = false){
		$pairs = array();
		foreach($post as $field => $value){

			preg_match('/(\w+[^-])-([\w]+)/', $field, $matches);
			if($field !== "submit" && isset($matches[1])){
				if(!$isInsert) $pairs[] = "$matches[1] = :$matches[1]";
				else $pairs[$matches[1]] = ":$matches[1]";
			}
		}
		return $pairs;
	}

	public function compileParams($post){

		$params = array();
		foreach($post as $field => $value){
			preg_match('/(\w+[^-])-([\w]+)/', $field, $matches);

			if($field !== "submit" && isset($matches[1])){ 
				$params[":$matches[1]"] = ($matches[2] == "nf") ? trim($value) :  filter_var(trim($value), $this->escapes[$matches[2]][0], $this->escapes[$matches[2]][1]);
			}
		}
		return $params;
	}

	public function validateName($opts){
		if(!isset($opts['fileName']) || !isset($opts['fileType']) || !isset($opts['fileSize'])) return false;
		$extension = explode('.', $opts['fileName']);
		$extension = $extension[count($extension) - 1];
		$postSize = $this->toBytes(ini_get('post_max_size'));
		$uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
		preg_match('/^image/', $opts['fileType'], $typeMatches);
		if(!in_array($extension, $opts['allowedExtensions']) || !count($typeMatches) || $postSize < $opts['fileSize'] || $uploadSize < $opts['fileSize']) return false;		
		return true;
	}

	public function generateName($opts){
		$options = array_merge(array(
			'input' => '',
			'regexType' => 'seoname',
			'regex' => ''
		), $opts);
		if(!isset($options['input']) || empty($options['input'])) return '';

		switch($options['regexType']){
			case 'seoname':
				$options['regex'] = '/[^A-Za-z0-9- ]/';
				break;
			case 'username':
				$options['regex'] = '/[^A-Za-z0-9-. ]/';
				break;
		}

		return join('-', explode(' ', trim( strtolower( preg_replace($options['regex'], '', $options['input']) ), '-' ) ) );
	}

	public function validateRequired($params, $unrequired){
		foreach($params as $key => $value){
			if(!in_array(substr($key, 1), $unrequired) && strlen($value) == 0){
				return array_merge(array('field' => substr($key, 1), 'hasError' => true, 'message' => "Sorry, one or more required fields were missing.  Please fill in all required fields and try again."));
			}
		}
		return true;
	}

	public function checkCSRF($post){
		if(!isset($post['c_t']) || !isset($_SESSION['csrf']) || $post['c_t'] !== $_SESSION['csrf']) return false;
		return true;
	}

	public function compareTimes($now, $then, $ttl){
		$ttl = $ttl * 60;
		if(($now > $then && $now < ($then + $ttl)) || $now == $then) return true;
		return false;
	}

	public function toBytes($str){
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
		$r = array('statusCode' => $code);
		switch($code){
			case 200:
				$r['message'] = '{formname} updated successfully!';
				$r['hasError'] = false;
				break;
			case 400:
				$r['message'] = "Sorry, one or more required fields were missing.  Please fill in all required fields and try again.";
				$r['hasError'] = true;
				break;
			case 500:
				$r['message'] = 'Sorry, looks like something went wrong.  Please try again.';
				$r['hasError'] = true;
				break;
			default: 
				$r['message'] = '';
				$r['hasError'] = false;
				break;
		}
		return $r;
	}

	public function getElementList($post, $prefix){

		$result = [];

		foreach($post as $key => $value ){
			
			$pieces = explode("-", $key);
			$titles = explode("-", "article_title");

			if (strpos($pieces[0], $prefix) !== false ){
				if(strlen($value) > 0){ 
					if(isset($pieces[1]) && strpos($pieces[1], 'title') !== 0){
				   		$result[] = '<li>'.$value.'</li>';
					}else{
						$result[] = '<p>'.$value.'</p>';
					}
				}
			}
		}
		$list = '';
 		foreach($result as $r){
 			$list .= $r;
 		}

 		return $list;
 	}
}

?>