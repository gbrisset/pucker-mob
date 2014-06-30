<?php
/**
   * List
   * 
   * This is a collection of List Items
   * 
   * @package    DatabaseObject
   * @author     Michael Mrnak <mmrnak@sequelmediagroup.com.com>
   */

class PageList extends DatabaseObject{

	protected static $table_name = "page_lists";

	// Database Fields
	public $page_list_id;
	public $page_list_title;
	public $page_list_seo_title;
	public $page_list_desc;

	//	Object Vars
	// public static $list_count;

	protected static $db_fields = array('page_list_id', 'page_list_title', 'page_list_seo_title', 'page_list_desc');

	public static function get_by_seo_title($seo_title){
		//	Set the params to be bound
		$params_to_bind = [':page_list_seo_title' => $seo_title];
		$data_set = static::find_by_sql("SELECT * FROM page_lists WHERE page_list_seo_title = :page_list_seo_title;", $params_to_bind);
		return array_shift($data_set);
	}




}


?>