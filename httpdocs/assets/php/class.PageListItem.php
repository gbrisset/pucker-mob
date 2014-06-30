<?php
/**
   * PageListItem
   * 
   * This is a collection of Page List Items
   * 
   * @package    DatabaseObject
   * @author     Michael Mrnak <mmrnak@sequelmediagroup.com.com>
   */

class PageListItem extends DatabaseObject{

	protected static $table_name = "page_list_items";

	// Database Fields
	public $page_list_item_id;
	public $page_list_item_title;
	public $page_list_item_image;
	public $page_list_item_image_source;
	public $page_list_item_youtube_embed;
	public $page_list_item_body;

	//	Object Vars
	protected static $db_fields = array('page_list_item_id', 'page_list_item_title', 'page_list_item_image', 'page_list_item_image_source', 'page_list_item_youtube_embed', 'page_list_item_body');
	public $sort_order;
	//	upload(): IMAGE_UPLOAD_DIR . $upload_dir_name . '/'
	protected static $upload_dir_name = 'list';
	protected static $upload_field_name = 'page_list_item_image';

/**
 *	Gets the current page list item, by page list id, using an offset.  
 *		Works in conjunction with the pagination object, class.Pagination.php, which defines the offset:
 *		$offset = $pagination->offset();
 *	
 *	@param 	int 				$page_list_id 		The page_list_id of the page_list
 *	@param 	int 				$offset 			The offset, given by the page number in the view
 *	@return object 				array_shift($row)	One single row of data
 */
	public static function get_current($page_list_id, $offset){
		$params_to_bind = [':page_list_id' => $page_list_id];
		$data_set = static::find_by_sql(
					"SELECT * 
					FROM page_list_items as pli
					INNER JOIN (page_lists_page_list_items as plli)
					ON pli.page_list_item_id = plli.page_list_item_id

					WHERE plli.page_list_id = :page_list_id
					ORDER BY plli.page_list_item_order ASC
					LIMIT 1
					OFFSET {$offset}; ", $params_to_bind);
		return array_shift($data_set);
	}

/**
 *		
 *	Gets all page list items in a page list
 *	
 *	@param 	int 				$page_list_id 		The page_list_id of the page_list
 *	@return array of objects 	$row				The dataset
 */
	public static function get_all_by_page_list_id($page_list_id){
		$params_to_bind = [':page_list_id' => $page_list_id];
		$data_set = static::find_by_sql(
					"SELECT *, plli.page_list_item_order as sort_order
					FROM page_list_items as pli
					INNER JOIN (page_lists_page_list_items as plli)
					ON pli.page_list_item_id = plli.page_list_item_id

					WHERE plli.page_list_id = :page_list_id
					ORDER BY plli.page_list_item_order ASC; ", $params_to_bind);
		return $data_set;
	}


/**
 *		
 *	Gets a count of all page list items in a page list
 *	
 *	@param 	int 				$page_list_id 		The page_list_id of the page_list
 *	@return array of objects 	$row				The dataset
 */
	public static function count($page_list_id){
		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();
		$q=$pdo->query("SELECT COUNT(*) as count FROM page_list_items as pli
				INNER JOIN (page_lists_page_list_items as plli)
				ON pli.page_list_item_id = plli.page_list_item_id
				WHERE plli.page_list_id = {$page_list_id}");
		if($q){
			$row = $q->fetch(PDO::FETCH_ASSOC);
			return array_shift($row);
		} else {
			return false;	
		}
	}
/*****

//	BEGIN RELATIONAL DB CRUD METHODS

******/

/**
 *		
 *	Resorts the page list, by updating the page_lists_page_list_items relational table
 *	
 *	@param 	array 				$post 				The post variable from the form submit
 *	@param 	int 				$page_list_id 		The page_list_id of the page_list
 *	@return bool 					
 */

	public static function saveOrder($post, $page_list_id){
		//	First, Delete all the existing records of the sort order...
		if(!STATIC::deleteOrder($page_list_id)){
			return array('hasError' => true, 'message' => 'The old order records could not be deleted.');
		}

		//	parse  $_POST[page_list_item_position] and $_POST[page_list_item_id] into comma separated string...
		$sql = "INSERT INTO page_lists_page_list_items ";
		$sql .= " (page_list_id, page_list_item_order, page_list_item_id) ";
		$values_array = array();
		foreach($post['page_list_item_id'] as $position => $id){
			$values_array[] = "('".$page_list_id."', '".$position."','".$id."')";
		}
		$values = implode(", ", $values_array);

		$sql .= "values ".$values.";";

		//	Add the new order to the rel table
		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();

		$q = $pdo->prepare($sql);
		//	Execute the query	
		if ($q->execute()) {
			return array('hasError' => false, 'message' => 'The sort order was successfully updated!');
		} 
		return array('hasError' => true, 'message' => 'The sort order was not successfully updated.');
	}

/**
 *		
 *	Adds a page list item to a page list
 *	
 *	@param 	int 				$page_list_id 		The page_list_id of the page_list
 *	@return array 				(hasError, message) 	
 */

	private static function deleteOrder($page_list_id){
		//	First, Delete all the existing records of the sort order...

		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();
		$q = $pdo->prepare("DELETE FROM page_lists_page_list_items 
							WHERE page_list_id = ".$page_list_id);
		if($q->execute()){
			return true;
		}
		return false;			

	}



/**
 *		
 *	Adds a page list item to a page list
 *	
 *	@param 	int 				$page_list_id 		The page_list_id of the page_list
 *	@return array 				(hasError, message) 	
 */
	public function add_to_list($list_id){
		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();
		$next_item_order = PageListItem::count($list_id) + 1;
		$q = $pdo->prepare("INSERT INTO page_lists_page_list_items (page_list_id, page_list_item_id, page_list_item_order) VALUES ({$list_id}, {$this->page_list_item_id}, {$next_item_order});");
	//	var_dump($q);
	//	Execute the query	
		if ($q->execute()) {
		} 
		return ($q->rowCount()==1) ? array('hasError' => false, 'message' => 'The item was successfully added!') : array('hasError' => true, 'message' => 'The item was NOT successfully added');	
	}

/**
 *		
 *	Delete a page list item from a page list
 *	
 *	@param 	int 				$page_list_id 		The page_list_id of the page_list
 *	@return array 				(hasError, message) 	
 */
	public function delete_from_list($post){
		$page_list_item = $post['page_list_item_id'];
		$page_list = $post['page_list_id'];

		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();
		$q = $pdo->prepare("DELETE FROM page_lists_page_list_items 
								   WHERE page_list_item_id = ".$page_list_item."
								   AND page_list_id = ".$page_list."
								   LIMIT 1");
		if($q->execute()){
			return true;
		}
		return false;						   	
	}

}
?>