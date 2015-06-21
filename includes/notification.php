<?php

// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once (LIB_PATH . DS . 'database.php');

class Notification extends DatabaseObject {

	protected static $table_name = "notifications";
	protected static $db_fields = array('id', 'request_id', 'body', 'created', 'department');

	public $id;
	public $request_id;
	public $body;
	public $created;
	public $department;

	
	public static function notification_department_count_all($department ="") {
		global $database;
		$sql = "SELECT COUNT(*) FROM " . static::$table_name. " WHERE department = '{$department}'";
		$result_set = $database -> query($sql);
		$row = $database -> fetch_array($result_set);
		return array_shift($row);
	}
	
	public static function find_by_request_id($request_id = 0) {
		return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE request_id={$request_id}");
	}
	
	
}
?>