<?php

/**
	* DatabaseObject
	* 
	* This is the base DatabaseObject class
	* and should be extended by all items in the database
	*
	* @package    DatabaseObject
	* @author     Michael Mrnak <mmrnak@sequelmediagroup.com.com>    
	*
	* Naming conventions of child classes - 
	* 
	* $db_fields 		protected static		array 		containing the names (string) of all of the database fields		
	* $table_name 		protected static		string 		the name of the table the object refers to
	* 
	* NOTE: The name of the id index in database, must follow - 'class_name'.'_id'
	* 	example: class_name = PageList, db id fieldname: page_list_id
	* 
	* 
 */

class DatabaseObject{	
	protected static $table_name; // string
	protected static $db_fields = array();
	//	If you plan to upload any files, you ust declare this variable in your child class
	//	The "name" of the directory that is contained in the constant, IMAGE_UPLOAD_DIR,
	//	That you want to upload your file to
	protected static $upload_dir_name; //	string
/*	
*****
*****
		Begin Basic Object Construction/Instantiation methods	
*****
*****
*/

	private function has_attribute($attribute) {
		//get_object_vars returns an assoc array w/ all attributes
		//(incl. private ones!) as the keys and their current values as the
		//value
		$object_vars = get_object_vars($this);
		return array_key_exists($attribute, $object_vars);
	}

	private static function instantiate($record) {
		//instantiate new object, self (Article)
		$class_name = get_called_class();
		$object = new $class_name;
		foreach ($record as $attribute=>$value) {
			if ($object->has_attribute($attribute)) {
					$object->$attribute = $value;
			}
		}			
		return $object;
	}	

	protected function attributes() {
		//return an array of SQL attribute names (keys) and their values
		//return get_object_vars($this);
		$fields_array = static::$db_fields;
		foreach($fields_array as $field) {
			if (property_exists($this, $field)) {
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}

	private function apply_colon($value) {
		return(":".$value);
	}

/*	
	End	
*/

/*------------------------------------------*/

/*	
*****
*****
		Begin READ (SELECT) methods	
*****
*****
*/

/**
 *		
 *	Gets a record from the database, by an sql string
 *	
 *	@param 	string 				$sql 			The query string
 *	@param 	array 				$params_array 	The array of params to be bound by the pdo object
 *	@return array of objects 					The dataset
 */

	public static function find_by_sql($sql, $params_array = []) {
		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();
		$q = $pdo->prepare($sql);
		if(!empty($params_array)){
			foreach ($params_array as $param => $value) {
				switch (true) {
					case is_int($value):
						$q->bindParam($param, $value, PDO::PARAM_INT);
						break;
					case is_string($value):
						$q->bindParam($param, $value, PDO::PARAM_STR);
						break;
					default:
						$q->bindParam($param, $value, PDO::PARAM_STR);
						break;
				}
			}
		}
		$q->execute();
		$object_array = array();
		foreach ($q as $row) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}

/**
 *	Gets a count of rows in a table 
 *	
 *	@return string 		The count
 */

	public static function count_all() {
		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();
		$q=$pdo->query("SELECT COUNT(*) FROM ".static::$table_name);
		if($q){
			$row = $q->fetch(PDO::FETCH_ASSOC);
			return array_shift($row);
		} else {
			return false;	
		}
			
	}

/**
 *	Gets all
 *	
 *	@return array of objects 	The dataset
 */

	public static function get($limit="") {
		$id_fieldname = static::get_id_fieldname(get_called_class());
		//	Set the limit sql string...
		(!empty($limit)) ? $limit_string = " LIMIT ".$limit : $limit_string = "";
		$data_set = static::find_by_sql("SELECT * FROM ".static::$table_name." ORDER BY  ".$id_fieldname." DESC ".$limit_string.";");
		return $data_set;
	}

/*
	SELECTS Used in site paginations
*/

/**
 *		
 *	Gets a filtered list of database objects, used in pagination ie. the bug/reporting page
 *	
 *	@param 	integer 	$limit 	The number of bugs returned per page
 *	@param 	string 		$order 	The order string, used in the SQL
 *	@param 	integer 	$offset The offset in the select statement
 *	@return object 		The dataset
 */

	public static function get_filtered($limit="", $order="", $offset=""){
		$id_fieldname = static::get_id_fieldname(get_called_class()); 
		(!empty($limit)) ? $limit_string = " LIMIT ".$limit : $limit_string = "";
		(!empty($order)) ? $order_string = " ORDER BY ".$order : $order_string = " ORDER BY ".$id_fieldname." DESC";
		(!empty($offset)) ? $offset_string = " OFFSET ".$offset : $offset_string = "";
		return static::find_by_sql("SELECT * FROM ".static::$table_name.$order_string.$limit_string.$offset_string.";");
	}

/*
	END
*/

/*------------------------------------------*/


/*	
*****
*****
		Begin CREATE/UPDATE methods	
*****
*****
*/

//	CALL save(), whenever possible, 
//	instead of create() or update().  It will test for the existence of id, and update or create, accordingly...:)

/**
 * Creates OR Updates a record in the database
 *	@param 	string 	$post 	The $_POST variable from the form submission
 * 	@return boolian
 */


	public function save($post, $files = []) {

		//	Get the name of the id field from the classname
		$id_fieldname = static::get_id_fieldname(get_called_class());
		//	Set $this's properties


		foreach($post as $obj_atributte => $obj_value){ 
			$this->$obj_atributte = $obj_value; 
		}

		// A new record won't have an id yet.
		return isset($this->$id_fieldname) ? $this->update($post, $files) : $this->create($post, $files);
	}


/**
 * Creates a record in the database
 *	@param 	string 	$post 	The $_POST variable from the form submission
 * 	@return boolian
 */

	public function create($post, $files=[]) {
		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();
		
		//	Get the name of the id field from the classname
		$id_fieldname = static::get_id_fieldname(get_called_class());

		foreach($post as $obj_atributte => $obj_value){ $this->$obj_atributte = $obj_value; }

		// Get all of the object attributes
		$attributes = $this->attributes();
		// Shift out the ID, since it auto-increments and we don't want to insert it into the table
		array_shift($attributes);
		// Create array of attributes with a ':' in front of each value.	
		$colon_attibutes_array = array_map(array($this, 'apply_colon'), (array_keys($attributes)) );
		// In order to use the attributes in SQL, turn it into a string with commas seperating each attribute.
		// :username, :password, etc...
		$colon_attibutes_string = join(', ', array_values($colon_attibutes_array));
		// Create a string of all the attributes without the colon for the other part of the sql	
		$attributes_string = join(', ', array_keys($attributes));
		//Create a string for all of the VALUES, seperated by a ','
		// johnny45, 8732heh, John, Smith
		$values_string = join(', ', array_values($attributes));
		// prepare the SQL	
		$q = $pdo->prepare("INSERT INTO ".static::$table_name." (".$attributes_string.") VALUES ( ".$colon_attibutes_string." )");
		
		 //bind the appropriate param in a foreach, using the original (array_shift'ed, though - no id) attributes array	
		foreach ($attributes as $attribute => &$value) {
				if (is_int($value)) {	
					$q->bindParam((":".$attribute), $value, PDO::PARAM_INT);  // bind the variable to the statement
				} else {
					$value = strip_tags($value, '<p><a><br><img><h2><b>');
					$q->bindParam((":".$attribute), $value, PDO::PARAM_STR);  // bind the variable to the statement
				}
		}
		//Execute the query	
		if ($q->execute()) {
		 //Since the id was created in the DB auto-increment, set the current object's id with lastInsertId();
		// lastInsertId is a PDO method, but has to be performed on the connection, not the pdo OBJECT
			$this->$id_fieldname = $pdo->lastInsertId();
			
			//	Upload any files
			foreach($files as $file){
				if(!empty($file['name'])){
					return $this->upload_file($file);
				}

			}
			return array('hasError' => false, 'message' => 'Saved!', 'id' => $this->$id_fieldname);
		} else {
			return array('hasError' => true, 'message' => 'Oops!  Something went wrong.', 'id' => $this->$id_fieldname);
		}
	}


/**
 * Updates a record in the database
 *	@param 	string 	$post 	The $_POST variable from the form submission
 *	@param 	array 	$files 	The $_FILES variable from the form submission
 * 	@return boolian
 */

	public function update($post, $files=[]) {
		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();

		//	Get the name of the id field from the classname
		$id_fieldname = static::get_id_fieldname(get_called_class());
		//	If the array of files only has one index, shift it out
		//(count($files) == 1) ? $files = array_shift($files): $files = $files;
		//	Set the current Obj Vars
		foreach($post as $obj_atributte => $obj_value){ $this->$obj_atributte = $obj_value; }

		// Get all of the object attributes
		$attributes = $this->attributes();
		// Shift out the ID, since it auto-increments	
		array_shift($attributes);
		// Create array of attributes with a ':' in front of each value.	
		$colon_attibutes_array = array_map(array($this, 'apply_colon'), (array_keys($attributes)) );
		// In order to use the attributes in SQL, turn it into a string with commas seperating each attribute.
		// :username, :password, etc...
		$colon_attibutes_string = join(', ', array_values($colon_attibutes_array));
		// Create a string of all the attributes without the colon for the other part of the sql	
		$attributes_string = join(', ', array_keys($attributes));
		//Create a string for all of the VALUES, seperated by a ','
		// johnny45, 8732heh, John, Smith
		$values_string = join(', ', array_values($attributes));
		// prepare the SQL	
		// bind the appropriate param in a foreach, using the original (array_shift'ed, though - no id) attributes array	
		$attribute_pairs = array();
		foreach ($attributes as $attribute => &$value) {
			$attribute_pairs[] = "{$attribute}=".":"."{$attribute}";
		}
		$q = $pdo->prepare("UPDATE ".static::$table_name." SET ".join(", ", $attribute_pairs)." WHERE {$id_fieldname}=".$this->$id_fieldname);
		foreach ($attributes as $attribute => &$value) {
				if (is_int($value)) {	
					$q->bindParam((":".$attribute), $value, PDO::PARAM_INT);  // bind the variable to the statement
				} else {
					$q->bindParam((":".$attribute), $value, PDO::PARAM_STR);  // bind the variable to the statement
				}
		}

		//	Execute the query	
		if ($q->execute()) {
			foreach($files as $file){
					return $this->upload_file($file);
			}
		}
		return ($q->rowCount()==1) ? array('hasError' => false, 'message' => 'The update was successful.') : array('hasError' => true, 'message' => 'The update was not successful, or no changes were made.');

	}



	protected function upload_file($file, $declared_options=[]){
		$options = array_merge(array(
			'uploadDirectory' => IMAGE_UPLOAD_DIR.static::$upload_dir_name.'/',
			'allowedExtensions' => array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF')
		), $declared_options);		

		if($file['size'] > 512000) return array_merge($this->returnStatus(500), array('message' => 'This image appears to be too large in file size for mobile devices.  Please try again with a smaller file.'));
		
		//	We are not running the update on the database, so we do not need the table or column info
		if(!is_uploaded_file($file['tmp_name'])) {
			return array_merge($this->returnStatus(500), array('message' => '3-Sorry, no valid files were found.  Please try again.'));
		}

		$fileName = explode('.', $file['name']);
		$extension = $fileName[count($fileName) - 1];
		unset($fileName[count($fileName) - 1]);

		$fileName = $fileName[0].'.'.$extension;
		$fullPathToFile = $options['uploadDirectory'].basename($fileName);

		if(move_uploaded_file($file['tmp_name'], $fullPathToFile)) {
			unset($file);
			unset($fileName);
			unset($fullPathToFile);
			return array('hasError' => false, 'message' => 'Saved!');
		}
		return array('hasError' => true, 'message' => 'Oops!  Something went wrong with the upload.');

	}


/*
	END
*/

/*------------------------------------------*/


/*	
*****
*****
		Begin DELETE methods	
*****
*****
*/

	public static function delete($post) {
		$id_fieldname = static::get_id_fieldname(get_called_class()); 
		$classname = strtolower(get_called_class());
		$db = SDConnector::getInstance();
		$pdo = $db->getConnection();		
		$q = $pdo->prepare("DELETE FROM ".static::$table_name." 
								   WHERE {$id_fieldname} = ".$post[$id_fieldname]."
								   LIMIT 1");
		$q->execute();
		return ($q->rowCount()==1) ? array($classname.'_data' => $post[$id_fieldname], 'hasError' => false, 'message' => 'The update was successful!') : array('hasError' => false, 'message' => 'The update was successful!');
	}

/*
	END
*/

/*------------------------------------------*/

/*	Helpers	*/


/**
 * Gets the name of the id field of the database object.
 *	@param 	string 	$called_class 	The class object name that is calling this.  Ex. PageList
 * 	@return string  Ex. page_list_id
 */

	public static function get_id_fieldname($called_class){
		$id_fieldname = preg_split('/(?=[A-Z])/', $called_class, -1, PREG_SPLIT_NO_EMPTY);
		$id_fieldname = strtolower(implode('_', $id_fieldname)).'_id';

		return $id_fieldname;
	}

	public function returnStatus($code){
		$r = array('statusCode' => $code);
		switch($code){
			case 200:
				$r['message'] = '{formname} updated successfully!';
				$r['hasError'] = false;
				break;
			case 400:
				$r['message'] = "Sorry, one or more required fields were missing.  Please fill in all required fields and try again.";
				$r['hasError'] = true;
				break;
			case 500:
				$r['message'] = 'Sorry, looks like something went wrong.  Please try again.';
				$r['hasError'] = true;
				break;
			default: 
				$r['message'] = '';
				$r['hasError'] = false;
				break;
		}
		return $r;
	}

	public static function generate_name($input='', $regexType='seoname', $regex=''){
		if(!isset($input) || empty($input)) return '';
		
		switch($regexType){
			case 'seoname':
				$regex = '/[^A-Za-z0-9- ]/';
				break;
			case 'username':
				$regex = '/[^A-Za-z0-9-. ]/';
				break;
		}
		return join('-', explode(' ', trim( strtolower( preg_replace($regex, '', $input) ), '-' ) ) );
	}
	


}

?>