<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */
require_once('db.class.php');
$db = new db_class;
// Open up the database connection.
if (!$db->connect()) {
    $db->print_last_error(false);
}
//=======================

$json = json_decode(file_get_contents("php://input"));


$data = array(
    'user_geb_datum' => $json->geboortejaar,
    'user_voorkeur' => $json->voorkeur,
    'user_ikben' => $json->ikben,
    'user_texel' => $json->texel,
    'user_geslacht' => $json->geslacht,
    'user_duurzaamheid' => $json->duurzaamheid,
    'user_mijnband' => $json->mijnband
);
//--- create user ------
$id = $db->insert_array('users', $data);

$_SESSION['user_id'] = $id;

// ---- create new session -------
$data2 = array('user_id' => $id);
$id2 = $db->insert_array('app_stemmentotaal', $data2);
$active_session = "_" . $id;

$locatiesJSON = $db->getPictures($id);

//
//$dat = [['url' => '/locations/Biogewas.jpg', 'name' => 'plaatje1'],
//    ['url' => '/locations/Biologischrestaurant.jpg', 'name' => 'plaatje2'],
//    ['url' => '/locations/Biologischrestaurant1.jpg', 'name' => 'plaatje3'],
//    ['url' => '/locations/Biologischrestaurant2.jpg', 'name' => 'plaatje4']];

echo json_encode($locatiesJSON);

