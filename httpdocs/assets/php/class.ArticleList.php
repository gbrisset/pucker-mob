<?php
/**
   * List
   * 
   * This is a collection of List Items
   * 
   * @package    DatabaseObject
   * @author     Michael Mrnak <mmrnak@sequelmediagroup.com.com>
   */

class ArticleList extends DatabaseObject{

	protected static $table_name = "lists";

	// Database Fields
	public $list_id;
	public $list_title;
	public $list_seo_title;
	public $list_desc;

	//	Object Vars
	// public static $list_count;

	protected static $db_fields = array('list_id', 'list_title', 'list_seo_title', 'list_desc');

	public static function get_by_seo_title($seo_title){
		//	Set the params to be bound
		$params_to_bind = [':list_seo_title' => $seo_title];
		$data_set = static::find_by_sql("SELECT * FROM lists WHERE list_seo_title = :list_seo_title;", $params_to_bind);
		return $data_set;
	}


}


?>