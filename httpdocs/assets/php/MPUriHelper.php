<?php
	class MPUriHelper{
		
		private $siteUrl;
		
		public function __construct( $site ){
			$this->siteUrl = $site;
		}

		/**
		* Compares the string passed to currentUrl against the string passed to siteUrl and returns the difference (the URI) as an array
		*
		* @param (string) $currentUrl 				A string containing the current page's url
		* @param (string) $siteUrl 				A string containing the site's url for comparison
		*
		* @return (array) $uri 					An array containing the uri bits of the $currentUrl variable, minus any get parameters
		*
		*/
		
		public function getURI($currentUrl){
			//Explode the uri string on slashes, getting an array of uri bits
			$uri = explode('/', 
				//Removes escaped site url from input
				preg_replace('/'.
					//Escapes slashes in site url
					preg_replace('/\//', 
						'\/', 
						$this->siteUrl
					).'/', 
					'', 
					$currentUrl
				)
			);
			//Handle get parameters gracefully
			foreach($uri as $index => $uriStr){
				//Remove everything after and including the first question mark, denoting a $_GET string start
				$uri[$index] = preg_replace('/\?(.*)/', '', $uriStr);
				//Match everything after the first question mark, denoting a $_GET string start
				preg_match('/\?(.*)/', $uriStr, $matches);
				//Check if there is $_GET string
				if(isset($matches) && isset($matches[1])){
					//Break apart $_GET string on & symbols
					$getStr = explode('&', $matches[1]);
					foreach($getStr as $getParam){
						//Grab key/value pairs
						$getParts = explode('=', $getParam);
						//Assign to $_GET array
						if(isset($getParts[0])) $_GET[$getParts[0]] = '';
						if(isset($getParts[1])) $_GET[$getParts[0]] = $getParts[1];
					}
				}
				
			}
			return $uri;
		}

		public static function getMainCategoryArray($mainCategories){
			foreach($mainCategories as $category){
				if ($category['has_children'] == 0 ){
					$mainCategoryArray[]=$category['cat_dir_name'];
				}
			}
			return $mainCategoryArray;
		} 







	}
?>