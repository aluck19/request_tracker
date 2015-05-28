<?php

// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once (LIB_PATH . DS . 'database.php');

class Comment extends DatabaseObject {

	protected static $table_name = "comments";
	protected static $db_fields = array('id', 'request_id', 'user_id', 'created', 'body');
	public $id;
	public $request_id;
	public $created;
	public $user_id;
	public $body;

	// "new" is a reserved word so we use "make" (or "build")
	public static function make($request_id, $user_id = "", $body = "") {
		if (!empty($request_id) && !empty($user_id) && !empty($body)) {
			$comment = new Comment();
			$comment -> request_id = (int)$request_id;
			$comment -> created = strftime("%Y-%m-%d %H:%M:%S", time());
			$comment -> user_id = (int)$user_id;
			$comment -> body = $body;
			return $comment;
		} else {
			return false;
		}
	}

	//finds just the comment on the request
	public static function find_comments_on($request_id = 0) {
		global $database;
		$sql = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE request_id=" . $database -> escape_value($request_id);
		$sql .= " ORDER BY created ASC";
		return self::find_by_sql($sql);
	}

	
}
?>