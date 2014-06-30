<?php
	class GoogleCustomSearch
	{
		private $mpArticle;
		private $config;

		private $client;
		private $output;
		private $cx_id;
		public $numberOfResults;
		
		private $xmlLocation;
		private $xml;
		
		public $suggestion;
		public $totalItems;
		
		public function __construct($config, $mpArticle){
			$this->config = $config;
			$this->mpArticle = $mpArticle;

			$this->client = $this->mpArticle->data['google_csclient'];
			$this->output = $this->mpArticle->data['google_csoutput'];
			$this->cx_id = $this->mpArticle->data['google_cxid'];
			$this->numberOfResults = $this->mpArticle->data['google_csnum'];
			
			$this->xmlLocation = 'http://www.google.com/search?q={searchString}&client='.$this->client.'&output='.$this->output.'&cx='.$this->cx_id.'&num='.$this->numberOfResults.'&start={start}';
		}

		public function __get($prop){
			if(property_exists($this, $prop)) return $this->$prop;
			return null;
		}
	
		public function __set($prop, $value){
			if(property_exists($this, $prop)) $this->$prop = $value;
			return $this;
		}
		
	 	public function getArticleTitleList($searchString, $offset){
			$this->xmlLocation = preg_replace('/{searchString}/', $searchString, $this->xmlLocation);
			$this->xmlLocation = preg_replace('/{start}/', $offset, $this->xmlLocation);

			$this->xml = new SimpleXMLElement(file_get_contents($this->xmlLocation));

			$this->suggestion = $this->xml->Spelling->Suggestion;

			if(!$this->xml->RES) return [];

			$this->totalItems = (isset($this->xml->RES->M)) ? intval($this->xml->RES->M) : 0;

			$r = [];
			foreach($this->xml->RES->R as $article){
				if($article->PageMap->DataObject['type'] != 'recipe') continue;
				$articleSeoTitle = explode('/', str_replace($this->config['this_url'], '', $article->U));
				$articleSeoTitle = $articleSeoTitle[count($articleSeoTitle) - 1];
				if(!empty($articleSeoTitle)) $r[] = $articleSeoTitle;
			}

			return $r;
		}
		
		public function fixSearchString($searchString){
			$searchString = str_replace(" ","+",$searchString);
			$searchString = str_replace("++","+",$searchString);
			return $searchString;
		}
	}
?>