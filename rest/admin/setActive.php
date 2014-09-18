<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

require_once('../db.class.php');
$db = new db_class;
if(!$db->connect()){
    $db->print_last_error(false);
}
//==========================

$json = json_decode(file_get_contents("php://input"));
$data = array('actief' => $json->actief);
$rows = $db->update_array('app_locaties', $data, "id=" . $json->locid . "");

//echo json_encode($db->getLocation($json->locid));
echo json_encode(array('locaties'=>$db->getLocations()));

