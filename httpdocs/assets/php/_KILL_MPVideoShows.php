<?php
require_once dirname(__FILE__).'/Connector.php';

class MPVideoShows{
	protected $config;
	protected $con;

	public $series;
	
	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
		$this->series = $this->getSeriesList(1);
	}




	private function getSeriesList(){ 
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT * 
							FROM article_page_series
							WHERE article_page_series_active = 1
							ORDER BY  `article_page_series_order` ASC");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}
			foreach($r as $serie){
				$serie['playlist'] = $this->getSeriesPlaylist($serie['article_page_series_id']);
				$serie_arr[]=$serie;
			}
			$q->closeCursor();
		}else $serie_arr = false;

		$this->con->closeCon();
		return $serie_arr;
	}

	public function getSerieShow($serie_seo_title = null){ 
		$pdo = $this->con->openCon();
		$q = $pdo->query("SELECT * 
							FROM article_page_series
							WHERE article_page_series_seo = '$serie_seo_title'");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r['serie_info'] = $row;

				$r['playlist'] = $this->getSeriesPlaylist($r['serie_info']['article_page_series_id']);
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeCon();
		
		return $r;
	}

	private function getSeriesPlaylist($id = null){ 
		$pdo = $this->con->openCon();
		//$pdosyn = $this->con->openSynCon();
		$id = (is_null($id)) ? 1 : $id;

		$q = $pdo->query("SELECT * 
							FROM simpledish_network.article_page_series_playlist
							INNER JOIN (mypod_network.syndication_videos)
							ON( simpledish_network.article_page_series_playlist.syn_video_id =  mypod_network.syndication_videos.syn_video_id)
							WHERE simpledish_network.article_page_series_playlist.article_page_series_id = $id");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeCon();
		return $r;
	}

	public function getFeaturedVideos($count = null, $featured_id = null){ 
		$pdo = $this->con->openCon();
		$count = (is_null($count)) ? 1 : $count;
		$featured_id = (is_null($featured_id)) ? 1 : $featured_id;

		$q = $pdo->query("SELECT * 
							FROM article_page_series_playlist
							INNER JOIN (syndication_videos, article_page_series)
							ON( article_page_series_playlist.syn_video_id =  syndication_videos.syn_video_id) 
							AND (article_page_series_playlist.article_page_series_id = article_page_series.article_page_series_id)
							WHERE article_page_series_featured_video = $featured_id LIMIT $count");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeCon();
		return $r;
	}

	public function getArticleInfoPerVideo($id=null){
		$pdo = $this->con->openCon();
		$id = (is_null($id)) ? 1 : $id;	

		$q = $pdo->query("SELECT article_videos.article_id, article_videos.visible_on_article
							FROM article_videos
							WHERE article_videos.syn_video_id = $id");
		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeCon();

		return $r;
	}

	public function getVideoInfo($params){
		$pdo = $this->con->openSynCon();
		
		$q = $pdo->query('SELECT *
							FROM syndication_videos
							WHERE syndication_videos.syn_video_filename = "'.$params['videoSeoName'].'" ORDER BY creation_date DESC LIMIT 1');
		
		$q->setFetchMode(PDO::FETCH_ASSOC);

		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeCon();

		return $r;
	}

	public function getAllVideos($params){
		$pdo = $this->con->openSynCon();
		$offset = '';
		$limit = '';

		if(isset($params['limit']) && $params['limit']) $limit = " LIMIT ".$params['limit'];
		if(isset($params['offset']) && $params['offset']) $offset = " OFFSET ".$params['offset'];
		
		$q = $pdo->query("SELECT * FROM syndication_videos ORDER BY syndication_videos.creation_date DESC".$limit.$offset);

		$q->setFetchMode(PDO::FETCH_ASSOC);
		if($q && $q->rowCount()){
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeSynCon();

		return $r;
	}

}

?>