<?php

// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once (LIB_PATH . DS . 'database.php');

class Notification extends DatabaseObject {

	protected static $table_name = "notifications";
	protected static $db_fields = array('id', 'request_id', 'body', 'created', 'visible');

	public $id;
	public $request_id;
	public $body;
	public $created;
	public $visible;

}
?>