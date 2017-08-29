<?php

class Connector{
	private $config;
	private $con;
	private $conOpen;
	private $conSynOpen;

	public function __construct($c){
		$this->config = $c;
		$this->conOpen = false;
		$this->conSynOpen = false;
		$this->con = null;
	}

	public function openCon($dbToUse = ''){
		if(!$this->conOpen){
			$db = strlen($dbToUse) ? $dbToUse : $this->config['main_db'];
			$this->con = new PDO('mysql:host='.$this->config['host'].';dbname='.$db, $this->config['user'], $this->config['pass']);
			if($this->con){
				$this->conOpen = true;
				$r = $this->con;
			}else{
				$r = false;
			}
		}else{
			$r = $this->con;
		}
		return $r;
	}

	public function openSynCon($dbToUse = ''){
		if(!$this->conSynOpen){
			$db = strlen($dbToUse) ? $dbToUse : $this->config['syn_main_db'];
			$this->con = new PDO('mysql:host='.$this->config['syn_host'].';dbname='.$db, $this->config['syn_user'], $this->config['syn_pass']);
			if($this->con){
				$this->conSynOpen = true;
				$r = $this->con;
			}else{
				$r = false;
			}
		}else{
			$r = $this->con;
		}
		return $r;
	}

	public function closeCon(){
		if($this->conOpen){
			$this->conOpen = false;
			$this->con = null;
		}
	}

	public function closeSynCon(){
		if($this->conSynOpen){
			$this->conSynOpen = false;
			$this->con = null;
		}
	}
}
?>