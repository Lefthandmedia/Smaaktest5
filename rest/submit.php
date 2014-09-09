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

$data = array(
    'user_geb_datum' => $_POST['geboortejaar'],
    'user_voorkeur' => $_POST['voorkeur'],
    'user_ikben' => $_POST['ikben'],
    'user_texel' => $_POST['texel'],
    'user_geslacht' => $_POST['geslacht'],
    'user_duurzaamheid' => $_POST['duurzaamheid'],
    'user_mijnband' => $_POST['mijnband']
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
//$dat = [['url' => '/pictures/Biogewas.jpg', 'name' => 'plaatje1'],
//    ['url' => '/pictures/Biologischrestaurant.jpg', 'name' => 'plaatje2'],
//    ['url' => '/pictures/Biologischrestaurant1.jpg', 'name' => 'plaatje3'],
//    ['url' => '/pictures/Biologischrestaurant2.jpg', 'name' => 'plaatje4']];

echo json_encode($locatiesJSON);

