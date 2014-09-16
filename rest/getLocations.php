<?php
/**
 * Created by PhpStorm.
 * User: ralph
 * Date: 9/14/14
 * Time: 7:41 PM
 */

require_once('db.class.php');
$db = new db_class;
// Open up the database connection.
if (!$db->connect()) {
    $db->print_last_error(false);
}

echo json_encode(array('locaties'=>$db->getLocations()));