<?php
require_once dirname(__FILE__).'/Connector.php';

class MPPlaylist{
	private $config;
	private $con;
	public $data;
	
	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
		$this->data = [];
	}

	public function getPlaylist($dir, $key){
		$playlistDir = filter_var($dir, FILTER_SANITIZE_STRING);
		$apiKey = filter_var($key, FILTER_SANITIZE_STRING);

		if(!strlen($playlistDir) || !strlen($apiKey)) return false;

		$pdo = $this->con->openCon();

		$q = $pdo->prepare("SELECT *, syndication_videos.syn_video_id, COUNT(syndication_video_views.syn_view_id) AS syn_video_views FROM syndication_videos INNER JOIN (syndication_playlist_videos, syndication_playlists, syndication_sites_playlist, syndication_sites) ON (syndication_videos.syn_video_id = syndication_playlist_videos.syn_video_id AND syndication_playlist_videos.syn_playlist_id = syndication_playlists.syn_playlist_id AND syndication_playlists.syn_playlist_id = syndication_sites_playlist.syn_playlist_id AND syndication_sites_playlist.syn_id  = syndication_sites.syn_id) LEFT JOIN (syndication_video_views) ON (syndication_video_views.syn_video_id = syndication_videos.syn_video_id) WHERE syndication_playlists.syn_playlist_directory = :playlistDir AND syndication_sites.syn_api_key = :apiKey GROUP BY syndication_videos.syn_video_id ORDER BY syndication_videos.creation_date DESC");
		$q->bindParam(':playlistDir', $playlistDir, PDO::PARAM_STR);
		$q->bindParam(':apiKey', $apiKey, PDO::PARAM_STR);
		$q->execute();
		
		if($q && $q->rowCount()){
			$r = [];
			while($row = $q->fetch(PDO::FETCH_ASSOC)){
				$r[] = $this->replaceMacros($row);
			}
		}else return false;

		return $r;
	}

	private function replaceMacros($row){
		$macros = [
			'{videoid}' => $row['syn_video_id']
		];
		foreach($row as $key => $value){
			foreach($macros as $macro => $replaceWith){
				$value = preg_replace('/'.$macro.'/', $replaceWith, $value);
			}
			$row[$key] = $value;
		}
		return $row;
	}
}
?>