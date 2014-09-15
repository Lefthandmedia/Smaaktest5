<?php
/**
 * Created by PhpStorm.
 * User: ralph
 * Date: 9/12/14
 * Time: 3:33 PM
 */

require_once('db.class.php');
$db = new db_class;
// Open up the database connection.
if (!$db->connect()) {
    $db->print_last_error(false);
}

$json = json_decode(file_get_contents("php://input"));

// echo json_encode(array('top3' => $db->eindscore_totaal()));

//=======================
 echo json_encode(array('top3' => $db->eindscore_totaal(), 'uwtop3' => $db->eindscore_user_totaal($json->id)));

