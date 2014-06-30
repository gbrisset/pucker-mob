<?php
/**
   * Bug
   * 
   * @package    DatabaseObject
   * @author     Flot Guzman <fguzman@sequelmediagroup.com.com>
   */

class Slideshow extends DatabaseObject{

	protected static $table_name = "slideshow";

	// Database Fields
	public $slideshow_id;
	public $slideshow_title;
	public $slideshow_desc;
	public $slideshow_url;
	public $slideshow_status;
	public $slideshow_image;


	//	Object Vars
	public static $slideshow_count;

	protected static $db_fields = array('slideshow_id', 'slideshow_title', 'slideshow_desc', 'slideshow_url', 'slideshow_status', 'slideshow_image');

	public static function get_slideshow_elements(){
		$params_to_bind = [':slideshow_status' => 1];
		$data_set = static::find_by_sql("SELECT * FROM slideshow WHERE slideshow_status = :slideshow_status;", $params_to_bind);
		return $data_set;
	}
	public static function get_slideshow_elements_by_cat_id($category_id){
		$params_to_bind = [':slideshow_status' => $category_id];
		$data_set = static::find_by_sql("SELECT * FROM slideshow WHERE slideshow_status = :slideshow_status LIMIT 3;", $params_to_bind);
		return $data_set;
	}

	public static function get_slideshow_elements_by_id($slideshow_id){
		$params_to_bind = [':slideshow_id' => $slideshow_id];
		$data_set = static::find_by_sql(
					"SELECT * FROM slideshow 
					 WHERE slideshow_id = :slideshow_id;", $params_to_bind
		);
		return $data_set;
	}

	public static function update_status($post){
		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();

		$id = $post['slideshow_id'];
		$slideshow_status = $post['slideshow_status'];
		$q = $pdo->prepare("UPDATE slideshow SET slideshow_status = :slideshow_status WHERE slideshow_id = {$id}");
		$q->bindParam(':slideshow_status', $slideshow_status, PDO::PARAM_STR);  // bind the variable to the statement

		if($q->execute()){}
		return ($q->rowCount()==1) ? array('hasError' => false, 'message' => 'The update was successful!') : array('hasError' => true, 'message' => 'The update was not successful.');
	}

	public function update_image_record($files, $id) {
		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();

		$file = array_shift($files);
		$filename = $file['name'];

		$q = $pdo->prepare("UPDATE slideshow SET slideshow_image = :slideshow_image WHERE slideshow_id = {$id}");
		$q->bindParam(':slideshow_image', $filename, PDO::PARAM_STR);  // bind the variable to the statement

		if($q->execute()){}
		return ($q->rowCount()==1) ? array('hasError' => false, 'message' => 'The update was successful!') : array('hasError' => true, 'message' => 'The update was not successful.');
	}

	public function upload_image($files, $opts){
		$opts['allowedExtensions'] = explode(',', $opts['allowedExtensions']); //No leading periods
		foreach($files as $file){
			//Hack to keep image uploads under 500kb
			if($file['size'] > 512000) return array_merge($this->returnStatus(500), array('message' => 'This image appears to be too large in file size for mobile devices.  Please try again with a smaller file.'));

				if(!is_uploaded_file($file['tmp_name'])) {
					return array_merge($this->helpers->returnStatus(500), array('message' => '3-Sorry, no valid files were found.  Please try again.'));
				}

				$fileName = explode('.', $file['name']);
				$extension = $fileName[count($fileName) - 1];
				unset($fileName[count($fileName) - 1]);
				$fileName = $fileName[0].'.'.$extension;
				
				$fullPathToFile = $opts['uploadDirectory'].basename($fileName);
				
				if (file_exists($fullPathToFile)){
					unlink($fullPathToFile);
				}
				if(move_uploaded_file($file['tmp_name'], $fullPathToFile)) {
					unset($file);
					//unset($fileName);
					unset($fullPathToFile);
					return array('hasError' => false, 'message' => 'The upload was successful!', 'filename'=> $fileName);
				}	
			return array('hasError' => true, 'message' => 'The upload was not successful.');

		unset($files);

		}
	}

}
?>