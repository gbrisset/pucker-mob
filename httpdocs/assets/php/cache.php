<?php
	class CacheFiles{
	
		private $ttl = 3600;
		private $cache_folder = '';
		public $cache_file;
		public $isCached = false;
		public $config;
		
		public function __construct( $filename, $config ){
			$this->config = $config;
			$this->cache_file = $filename.".cache";
			$this->cache_folder = $config['cache_url'];
			$this->isCached = $this->is_cached( $this->cache_file ); 
			if ( $this->isCached ) { 
				 echo $this->read_cache($this->cache_file );
				return null;
			}
			else{
				
			}
		}
		
		public function __get($prop){
			if(property_exists($this, $prop)) return $this->$prop;
			return null;
		}
	
		public function __set($prop, $value){
			if(property_exists($this, $prop)) $this->$prop = $value;
			return $this;
		}
		
		private function is_cached() {
			 $cachefile = $this->cache_folder . $this->cache_file;
			 $cachefile_created = (file_exists($cachefile)) ? @filemtime($cachefile) : 0;
			 return ((time() - $this->ttl) < $cachefile_created);
		}
		
		public function read_cache() {
		    $cachefile = $this->cache_folder . $this->cache_file;
			return file_get_contents($cachefile);
		}
		
		public function write_cache($file, $out) {
			 $cachefile = $this->cache_folder . $file;
			 $fp = fopen($cachefile, 'w'); var_dump($fp);
			 fwrite($fp, $out);
			 fclose($fp);
		}
	}
?>