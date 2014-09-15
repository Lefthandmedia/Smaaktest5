<?php 
require_once('classes/db.class.php');
$db = new db_class;

// Open up the database connection. 

if (!$db->connect()) 
  $db->print_last_error(false);
  
 $data = array(
   'email' => $_REQUEST['bak34']
   );
  		$id = $db->insert_array('email_adressen', $data);
		if($id) {
echo 'succes=ok';
		}
?>