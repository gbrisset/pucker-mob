<?php
require_once dirname(__FILE__).'/Connector.php';

class MPSyndication{
	private $config;
	private $con;
	public $data;
	
	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
		$this->data = [];
	}

	public function checkReferrer($key, $ip, $url){
		$apiKey = filter_var($key, FILTER_SANITIZE_STRING);

		if(empty($apiKey) || empty($ip) || empty($url)) return false;
		
		$pdo = $this->con->openSynCon();

		$q = $pdo->prepare("SELECT * FROM syndication_whitelists INNER JOIN (syndication_sites_whitelist, syndication_sites) ON (syndication_whitelists.syn_whitelist_id = syndication_sites_whitelist.syn_whitelist_id AND syndication_sites_whitelist.syn_id = syndication_sites.syn_id) WHERE syndication_sites.syn_api_key = :apiKey ORDER BY syndication_whitelists.syn_whitelist_id DESC");
		$q->bindParam(':apiKey', $apiKey, PDO::PARAM_STR);
		$q->execute();

		if($q && $q->rowCount()){
			$referralIp = $ip;
			$referralUrl = $url;
			while($row = $q->fetch(PDO::FETCH_ASSOC)){
				$entry = $row['syn_whitelist_entry'];
				$entryIsIP = $row['syn_whitelist_ip_match'];
				
				if($entryIsIP && $entry == $referralIp) return true;
				else if($entryIsIP) continue;

				$entryBits = explode('/', $entry);
				$tempReferrerBits = explode('/', $referralUrl);
				$referrerBits = [];

				foreach($tempReferrerBits as $bit){
					$bit = preg_replace('/^(http|https):/', '', $bit);
					if(!empty($bit)) $referrerBits[] = $bit;
				}

				if(!count($entryBits) || !count($referrerBits)){
					continue;
				}
				
				$entryTLDBits = explode('.', $entryBits[0]);
				$referrerTLDBits = explode('.', $referrerBits[0]);

				$tldOk = true;

				if(count($referrerTLDBits) != count($entryTLDBits)){
					if($entryTLDBits[0] !== '*') continue;

					$entryTLDCount = count($entryTLDBits) - 1;
					$j = count($referrerTLDBits) - 1;
					for($i = $entryTLDCount; $i >= 0; $i--){
						$entryTLDBit = $entryTLDBits[$i];
						$referrerTLDBit = (isset($referrerTLDBits[$j])) ? $referrerTLDBits[$j] : '';

						if(!isset($referrerTLDBit) || ($referrerTLDBit !== $entryTLDBit && $entryTLDBit !== '*')){
							$tldOk = false;
							break;
						}
						$j--;
					}
				}else{
					$entryTLDCount = count($entryTLDBits);
					for($i = 0; $i < $entryTLDCount; $i++){
						$entryTLDBit = $entryTLDBits[$i];
						$referrerTLDBit = $referrerTLDBits[$i];
						if(!isset($referrerTLDBit) || ($referrerTLDBit !== $entryTLDBit && $entryTLDBit !== '*')){
							$tldOk = false;
							break;
						}
					}
				}

				if(!$tldOk) continue;

				$entryBits = array_slice($entryBits, 1);
				$referrerBits = array_slice($referrerBits, 1);
				
				$entryBitsCount = count($entryBits);
				for($i = 0; $i < $entryBitsCount; $i++){
					$entryBit = $entryBits[$i];
					$referrerBit = isset($referrerBits[$i]) ? $referrerBits[$i] : '';
					if(!isset($referrerBit) || ($referrerBit !== $entryBit && $entryBit !== '*')) break;
					else if($entryBit == '*') return true;
				}
			}
		}

		return false;
	}
}
?>