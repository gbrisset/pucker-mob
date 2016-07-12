<?php

class MPHelpers{

	public function __construct(){

	}

	public function stripUrls($url, $appendWith){
		$url = explode('/', $url);

		if(strtolower($url[0]) == "http:"){
			unset($url[0]);
			unset($url[1]);
			$url = array_values($url);
		}
		$stringBits = array_slice($url, 1);
		$stringBits = join($stringBits, '/');
		$url = $url[0];
		$url = explode('.', $url);
		unset($url[0]);
		$url = array_values($url);
		$url = join($url, '.');
		if(strlen($appendWith) > 0) $url = "http://".$appendWith.".".$url;
		if(strlen($stringBits) > 0) $url .= '/'.$stringBits;
		if(substr($url, -1) !== '/') $url .= '/';
		return $url;
	}

	public function truncate($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
		if ($considerHtml){
			if(strlen(preg_replace('/<.*?>/', '', $text)) <= $length) return $text;
			
			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';
			foreach($lines as $line_matchings){
				if (!empty($line_matchings[1])){
					if(preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])){
						// do nothing
					}else if(preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)){
						$pos = array_search($tag_matchings[1], $open_tags);
						if($pos !== false) unset($open_tags[$pos]);
					}else if(preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) array_unshift($open_tags, strtolower($tag_matchings[1]));
					$truncate .= $line_matchings[1];
				}
				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				if($total_length + $content_length> $length){
					$left = $length - $total_length;
					$entities_length = 0;
					if(preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)){
						foreach($entities[0] as $entity){
							if($entity[1]+1-$entities_length <= $left){
								$left--;
								$entities_length += strlen($entity[0]);
							}else break;
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
					break;
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}
				if($total_length>= $length) break;
			}
		}else{
			if(strlen($text) <= $length) return $text;
			else $truncate = substr($text, 0, $length - strlen($ending));
		}
		
		if(!$exact){
			$spacepos = strrpos($truncate, ' ');
			if(isset($spacepos)) $truncate = substr($truncate, 0, $spacepos);
		}
		
		$truncate .= $ending;
		if($considerHtml){
			foreach($open_tags as $tag){
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}

	/*public function newTruncate($string, $length, $ending = '...', $isHTML = false){
		$i = 0;
		$tags = array();
		if($isHTML){
			preg_match_all('/<[^>]+>([^<]*)/', $string, $match, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
			foreach($match as $o){
				if($o[0][1] - $i >= $length)
					break;
				$tag = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
				if($tag[0] != '/')
					$tags[] = $tag;
				elseif(end($tags) == substr($tag, 1))
					array_pop($tags);
				$i += $o[1][1] - $o[0][1];
			}
		}
		return substr($string, 0, $length = min(strlen($string),  $length + $i)).(count($tags = array_reverse($tags)) ? (strlen($string) > $length ? $ending : '').'</'.implode('></', $tags).'>' : '');
	}*/

	//NOT IN USE
	public function roundToNearestHalf($n){
		return round($n * 2) / 2;
	}
	
	//NOT IN USE
	public function getEmails(){
		$emails = "fguzman@sequelmediainternational.com";

		return $emails;
	}

	public function checkSpam($n, $e){
		$r = true;
		$blockedNames = array(
			"Mr. Lee",
			"Bill Laurance"
		);
		$blockedEmails = array(
			"noreply@crushyourcompetition.com",
			"no-reply@postingshowcase.com",
			"no-reply@reviewshowcase.com"
		);
		if(in_array($n, $blockedNames)) $r = false;
		if(in_array($e, $blockedEmails)) $r = false;
		return $r;
	}

	/**
	* Returns an array with page numbers for pagination systems
	*
	* @param int		$curPage		The current page
	* @param int		$totalPages 		The total number of pages
	* @param int		$pagesToShow 	The number of pages to return
	*
	* @return array 	$r 			Array containing numbers for pages and possibly '...' to indicated there are more pages than currently shown
	*/
	public function getPages($curPage, $totalPages, $pagesToShow = 3){
		if(!isset($curPage) || !isset($totalPages)) return false;
		$topReached = false;
		$r = array($curPage);
		if(($curPage - ($pagesToShow / 2)) >= 1){
			$cD = ($pagesToShow / 2);
			$temp = $curPage - 1;
			while($cD-- >= 1){
				array_unshift($r, $temp--);
			}
		}else{
			$cD = $curPage - 1;
			while($cD >= 1){
				array_unshift($r, $cD);
				$cD--;
			}
		}

		while(count($r) < ($pagesToShow + 1)){
			if($curPage + 1 <= $totalPages){
				$r[] = ++$curPage;
			}else{
				$topReached = true;
				$r = $this->pageTopHelper($r, $pagesToShow);
				break;
			}
		}

		if(!$topReached && !in_array($totalPages, $r)){
			$r[] = '...';
			$r[] = $totalPages;
		}

		return $r;
	}

	/**
	* Returns an array with page numbers for pagination systems
	* Used when the current page is high enough that more numbers below must be added to the array
	*
	* @param array	$r			Array of page numbers to be prepended
	* @param int		$pagesToShow 	The number of pages to return
	*
	* @return array 	$r 			Array containing numbers for pages and possibly '...' to indicated there are more pages than currently shown
	*/
	protected function pageTopHelper($r, $pagesToShow){
		while(count($r) < ($pagesToShow + 1)){
			if(($r[0] - 1) > 0) array_unshift($r, $r[0] - 1);
			else break;
		}
		return $r;
	}

	/**
	* Returns an array with page numbers for pagination systems
	* 
	* @return string 	$pageURL 		String containing the current page's URL
	*/
	public function curPageURL(){
		$pageURL = 'http';
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		else $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		return $pageURL;
	}

	public function start_session(){
		session_name('mpssess'); 
		session_start();
	}

		//NOT IN USE

	public function getNextPermutation($i){
		$len = strlen($i);
		if($len < 2) return false;
		while($len > 0){
			$a = substr($i, $len - 1, 1);
			$b = substr($i, $len - 2, 1);
			if($b < $a){
				$l = substr($i, 0, $len - 1);
				$r = substr($i, ($len - 1));
				$len = strlen($r);
				$lowest = null;
				while($len > 0){
					$a = substr($r, $len -1, 1);
					if($a > $b && (is_null($lowest) || $a < $lowest)){
						$lowest = $a;
						$r = explode(' ', trim(chunk_split(substr_replace($r, $b, $len - 1, 1), 1, ' ')));
						asort($r);
						$r = join($r);
						$l = substr_replace($l, $lowest, strlen($l) - 1, 1);
					}
					$len --;
				}
				break;
			}
			$len--;
		}
		return $l.$r;
	}

	public static function linkToArticle($childCategory='', $parentCategory=''){
		if (strlen($parentCategory)){
			// Parent category is set
			$link =  $parentCategory."/".$childCategory."/";
			return $link;
		} else {
			// Parent category is NOT set
			$link = $childCategory."/";
			return $link;
		}

	}


	public function geotargeting(){
		$ip = $_SERVER [ 'REMOTE_ADDR' ]; 
		$country_code = 'US';
		$city = 'New York';

		//if( !isset( $_COOKIE['country_code'] ) ) {
			try{
				$geo_details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

				 $country_code = $geo_details->country;
				 $region = $geo_details->region;
				 $city = $geo_details->city;

			}catch (Exception $e) {
				$country_code = "US";
				$region = 'New York';
				$city = 'New York';
			}
			setcookie('country_code', $country_code, time()+60*60*24*30); //A YEAR
			setcookie('region' ,$region, time()+60*60*24*30); //A YEAR
			setcookie('city' ,$city, time()+60*60*24*30); //A YEAR

			
	//	}

			
	}

}
?>