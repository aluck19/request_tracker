<?php

// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once (LIB_PATH . DS . 'database.php');

class Request extends DatabaseObject {

	protected static $table_name = "requests";
	protected static $db_fields = array('id', 'user_id', 'created', 'department', 'subject', 'description', 'expected_solution', 
										'priority', 'status','deadline');

	public $id;
	public $user_id;
	public $created;
	public $department;
	public $subject;
	public $description;
	public $expected_solution;
	public $priority;
	public $status;
	public $deadline;
	
	public function comments() {
		return Comment::find_comments_on($this -> id);
	}
	
	public  function submitted_requested_count_all($user_id = 0) {
		global $database;
		$sql = "SELECT COUNT(*) FROM " . static::$table_name ." WHERE user_id={$user_id}";
		$result_set = $database -> query($sql);
		$row = $database -> fetch_array($result_set);
		return array_shift($row);
	}
	
	public  function department_requests_count_all($department = "") {
		global $database;
		$sql = "SELECT COUNT(*) FROM " . static::$table_name ." WHERE department='{$department}'";
		$result_set = $database -> query($sql);
		$row = $database -> fetch_array($result_set);
		return array_shift($row);
	}
	
	
	public static function find_by_user_id($user_id = 0) {
		return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE user_id={$user_id}");
	}
	

}
?>