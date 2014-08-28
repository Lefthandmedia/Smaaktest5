<?php session_start();
require_once('../classes/db.class.php');
	$db = new db_class;

// Open up the database connection. 

		if (!$db->connect()) 
 			$db->print_last_error(false);
 
		xml($_SESSION['user_id']);
?>
