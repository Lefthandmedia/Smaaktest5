<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

require_once('../db.class.php');

$db = new db_class;
// Open up the database connection.
if (!$db->connect()) {
    $db->print_last_error(false);
}
//==========================

$json = json_decode(file_get_contents("php://input"));
$taak = $json->taak;

if ($taak == "new") {
    $data = array(
        'locatie' => $json->locatie
    , 'thumb' => 'leeg'
    );
    $id_loc = $db->insert_array('app_locaties', $data);
    $al = $db->alter_table_add('app_stemmentotaal', "_" . $id_loc);
    echo json_encode(array("id" => $id_loc));
}

if ($taak = 'edit') {

    $data = array('locatie' => $json->locatie);
    $rows = $db->update_array('app_locaties', $data, "id=" . $json->locid . "");
    if($rows){
        echo json_encode(array('locaties'=>$db->getLocations()));
    }else{
        echo false;
    }
}

//=======================================

