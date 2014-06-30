<?php
require_once dirname(__FILE__).'/Connector.php';

class MPShared{
	private $config;
	private $con;
	public $data;
	public $dropDownInfo;

	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
		$this->data = [];
		$this->dropDownInfo = [
			[
				'id' => 1,
				'label' => 'Most Recent',
				'shortname' => 'mr'
			],
			[
				'id' => 2,
				'label' => 'Most Popular',
				'shortname' => 'mp'
			],
			[
				'id' => 3,
				'label' => 'Most Viewed',
				'shortname' => 'mv'
			],
			[
				'id' => 4,
				'label' => 'Alphabetical: A-Z',
				'shortname' => 'az'
			],
			[
				'id' => 5,
				'label' => 'Alphabetical: Z-A',
				'shortname' => 'za'
			]
		];
	}

	// public function getCategoryPods($args = [], $attempts = 0){
	// 	$options = array_merge([
	// 		'categoryId' => 0,
	// 		'omit' => [],
	// 		'count' => 8,
	// 		'sortType' =>1 //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
	// 	], $args);
	// 	$innerJoinTables = [
	// 		'pod_categories',
	// 		'categories'
	// 	];
	// 	$innerJoinRelations = [
	// 		'pod.pod_id = pod_categories.pod_id',
	// 		'pod_categories.cat_id = categories.cat_id'
	// 	];
	// 	$whereClause = ' WHERE pod.pod_live = 1 AND (pod_categories.cat_id = :categoryId OR categories.cat_child_of = :categoryId)';
	// 	$queryParams = [':categoryId' => filter_var($options['categoryId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)];		
	// 	switch($options['sortType']){
	// 		case 2: case 3:
	// 			$orderClause = ' ORDER BY pod.pod_vid_views DESC, pod.pod_id DESC';
	// 			break;
	// 		case 4: 
	// 			$orderClause = ' ORDER BY pod.pod_name ASC, pod.pod_id DESC';
	// 			break;
	// 		case 5:
	// 			$orderClause = ' ORDER BY pod.pod_name DESC, pod.pod_id DESC';
	// 			break;
	// 		default:
	// 			$orderClause = ' ORDER BY pod.pod_creadted_dt DESC, pod.pod_id DESC';
	// 			break;
			
	// 	}
	// 	$s = "SELECT *, pod.pod_id FROM pod INNER JOIN (:joinedTables) ON (:joinRelations)";
	// 	$i = 0;
	// 	$t = '';
	// 	foreach($innerJoinRelations as $relationShip){
	// 		$t .= $relationShip;
	// 		if($i++ < count($innerJoinRelations) - 1) $t .= " AND ";
	// 	}
	// 	$s = str_replace(':joinedTables', implode(', ', $innerJoinTables), $s);
	// 	$s = str_replace(':joinRelations', $t, $s);
	// 	if(count($options['omit'])){
	// 		$i = 0;
	// 		$c = count($options['omit']);
	// 		$whereClause .= " AND pod.pod_id NOT IN (";
	// 		foreach($options['omit'] as $articleId){
	// 			$whereClause .= $articleId;
	// 			if($i++ < count($options['omit']) - 1) $whereClause .= ", ";
	// 		}
	// 		$whereClause .= ")";
	// 	}
	// 	$s .= $whereClause;
	// 	$s .= $orderClause;
	// 	$s .= " LIMIT 0, ".$options['count'];
	// 	$pdo = $this->con->openCon('mypod_pods');
	// 	$q = $pdo->prepare($s);
	// 	$q->execute($queryParams);
	// 	$q->setFetchMode(PDO::FETCH_ASSOC);
	// 	if($q && $q->rowCount()){
	// 		$r = ['ids' => [],'pods' => []];
	// 		while($row = $q->fetch()){
	// 			if(!in_array($row['pod_id'], $r['ids'])){
	// 				$r['ids'][] =$row['pod_id'];
	// 				$r['pods'][] = $row;
	// 			}
	// 		}

	// 		if(count($r['pods']) < $options['count'] && $attempts < 3){
	// 			$options['omit'] = array_merge($options['omit'], $r['ids']);
	// 			$options['count'] = $options['count'] - count($r['pods']);
	// 			$recursive = $this->getCategoryPods($options, ++$attempts);
	// 			if(is_array($recursive)){
	// 				$r['pods'] = array_merge($r['pods'], $recursive['pods']);
	// 				$r['ids'] = array_merge($r['ids'], $recursive['ids']);
	// 			}
	// 		}
	// 	}else $r = false;
	// 	return $r;
	// }

	public function getSort($sort){
		if(!isset($sort)) return 1;
		$r = 1;
		switch($sort){
			case 'mp':
				$r = 2;
				break;
			case 'mv':
				$r = 3;
				break;
			case 'az':
				$r = 4;
				break;
			case  'za':
				$r = 5;
				break;
			case 'pending':
				$r = 6;
				break;
			case 'draft':
				$r = 7;
				break;
		}
		return $r;
	}

	public function getPagination($page, $resultsPerPage = 5, $results = []){
		$totalResults = count($results);
		$totalPages = ceil($totalResults / $resultsPerPage);
		
		$currentPage = (isset($page) && strlen($page)) ? intval(preg_replace('/[\D]/', '', $page)) : 1;
		if($currentPage > $totalPages) $currentPage = 1;
		
		if($totalPages == 1) $paginatedResults = $results;
		else{
			$offSet = ($currentPage - 1) * $resultsPerPage;
			$paginatedResults = array_slice($results, $offSet, $resultsPerPage);
		}

		return [
			'currentPage' => $currentPage,
			'totalPages' => $totalPages,
			'paginatedResults' => $paginatedResults
		];
	}

	public function get404(){
		header("Location: ".$this->config['this_url'].'404.php');
	}

	public function getHome(){
		header("Location: ".$this->config['this_url'].'index.php');
	}
}
?>