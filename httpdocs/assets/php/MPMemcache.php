<?php
	class MPMemcache{
		private $config;

		private $ttl;
		private $memcachedCon = null;

		public $memcachedEnabled = false;
		
		public function __construct($config){
			$this->config = $config;
			$this->ttl = $this->config['memcachettl'];
			if(class_exists('Memcache')){
				$this->memcachedCon = new Memcache();				
				$this->config['memcachehost'] = explode(',', $this->config['memcachehost']);
				foreach($this->config['memcachehost'] as $server){
					$server = trim($server);
					if($this->memcachedCon->connect($server, $this->config['memcacheport'])){
						$this->memcachedEnabled = true;
						break;
					}
				}
			}
		}

		public function getData($key){
			if(!$this->memcachedEnabled) return false;
			$cachedData = $this->memcachedCon->get($this->getKey($key));
			return (false === $cachedData) ? false : $cachedData;
		}

		public function setData($key, $cacheData){
			if(!$this->memcachedEnabled) return false;
			return $this->memcachedCon->set($this->getKey($key), $cacheData, MEMCACHE_COMPRESSED, $this->ttl);
		}

		public function deleteData($key){
			if(!$this->memcachedEnabled) return false;
			return $this->memcachedCon->delete($this->getKey($key));
		}

		private function getKey($key){
			return md5($this->config['memcacheprefix'].$key);
		}
	}
?>