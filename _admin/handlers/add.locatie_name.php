<?php
require_once('../../classes/db.class.php');
$db = new db_class;

// Open up the database connection.  You can either setup your database login
// information in the db.class.php file or you can overide the defaults here. 
// If you setup the default values, you just have to call $db->connect() without
// any parameters-- which is much easier.

if (!$db->connect()) 
  $db->print_last_error(false);

$dir = "../../uploads/";
$uploadNeed = 1;
// start for loop
for($x=0;$x<$uploadNeed;$x++){
$file_name = $_FILES['file']['name'];
// strip file_name of slashes
$file_name = stripslashes($file_name);
$file_name = str_replace("'","",$file_name);
$copy = copy($_FILES['file']['tmp_name'], $dir . $file_name);

	
// check if successfully copied
 if($copy){
 echo "$file_name | uploaded sucessfully!<br>";
 
 }else{
 echo "$file_name | could not be uploaded!<br>";
 }
 
$locatie = $_POST['locatie'];
$thumb = $file_name;

$data = array(
   'locatie' => $locatie,
   'thumb' => $thumb
	);
$id = $db->insert_array('app_locaties', $data);
}

?>