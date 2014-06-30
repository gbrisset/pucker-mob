<?php
require_once dirname(__FILE__).'/Connector.php';

class MPValidate{
	private $config;
	private $con;
	public $data;
	
	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
		$this->data = [];
	}

	public function getSitePlayerOptions($key){
		$apiKey = filter_var($key, FILTER_SANITIZE_STRING);

		if(!strlen($apiKey)) return [];

		$pdo = $this->con->openSynCon();

		$q = $pdo->prepare("SELECT * FROM syndication_player_configs 
			INNER JOIN (
				syndication_sites_config, 
				syndication_sites, 
				syndication_sites_playlist, 
				syndication_playlists
			) 
			ON (
				syndication_player_configs.syn_player_config_id = syndication_sites_config.syn_player_config_id 
				AND syndication_sites_config.syn_id = syndication_sites.syn_id 
				AND syndication_sites.syn_id = syndication_sites_playlist.syn_id
				AND syndication_sites_playlist.syn_id = syndication_playlists.syn_playlist_id
			) 
			WHERE syndication_sites.syn_api_key = :apiKey 
			LIMIT 0, 1");
		$q->bindParam(':apiKey', $apiKey, PDO::PARAM_STR);
		$q->execute();

		if($q && $q->rowCount()){
			$row = $q->fetch(PDO::FETCH_ASSOC);
			$r = [
				'debug' => (bool)$row['syn_player_config_debug'],
				'autoPlay' => (bool)$row['syn_player_config_auto_play'],
				'continuousPlay' => (bool)$row['syn_player_config_cont_play'],
				'loopPlayback' => (bool)$row['syn_player_config_loop_playback'],
				'defaultVolume' => (float)$row['syn_player_config_default_volume'],
				'showPlaylist' => (bool)$row['syn_player_config_show_playlist'],
				'showPlaylistItemDescriptions' => (bool)$row['syn_player_config_show_playlist_descriptions'],
				'playlist' => 'http://syndication.playlists.mypodstudios.com/'.$row['syn_playlist_directory'].'&id='.$apiKey,
				'randomizePlaylist' => (bool)$row['syn_player_config_randomize_playlist'],
				'startingVideo' => (int)$row['syn_player_config_starting_video'],
				'countoffStart' => (bool)$row['syn_player_config_countoff_start'],
				'countoffTime' => (int)$row['syn_player_config_countoff_start_time'],
				'logoImgUrl' => 'http://images.mypodstudios.com/logos/'.$row['syn_player_config_logoimg'],
				'logoImgLink' => $row['syn_player_config_logoimg_link'],
				'flashSwfUrl' => 'http://syndication.mypodstudios.com/assets/swf/'.$row['syn_player_config_flash_swf'],
				'adSwfUrl' => 'http://syndication.mypodstudios.com/assets/swf/'.$row['syn_player_config_ad_swf'],
				'withAds' => (bool)$row['syn_player_config_with_ads'],
				'preRolls' => (bool)$row['syn_player_config_pre_rolls'],
				'midRolls' => (bool)$row['syn_player_config_mid_rolls'],
				'midRollLocations' => explode(',', $row['syn_player_config_mid_roll_locations']),
				'postRolls' => (bool)$row['syn_player_config_post_rolls'],
				'adCompanionId' => $row['syn_player_config_companion_id'],
				'adServerKey' => $row['syn_player_config_ad_server_key'],
				'adServerCustomKeys' => explode(',', preg_replace('/[{}]/', '', $row['syn_player_config_ad_server_custom_keys']))
			];
			$temp = [];
			foreach($r['adServerCustomKeys'] as $objString){
				$parts = explode(':', $objString);
				$temp[$parts[0]] = trim($parts[1]);
			}
			if(count($temp)) $r['adServerCustomKeys'] = $temp;
			return $r;
		}

		return [];
	}
}
?>