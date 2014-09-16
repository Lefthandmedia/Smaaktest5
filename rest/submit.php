<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 *
 * 1 = auto
 * 2 = duurzaamheid
 * 3 = geslacht
 * 4 = ikben
 * 5 = mijnband
 * 6 = texel
 * 7 = voorkeur
 *
 *
 *
 *
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
    'user_veld1' => $json->veld1,
    'user_veld7' => $json->veld7,
    'user_veld4' => $json->veld4,
    'user_veld6' => $json->veld6,
    'user_veld3' => $json->veld3,
    'user_veld2' => $json->veld2,
    'user_veld5' => $json->veld5
);

//--- create user ------

$id = $db->insert_array('users', $data);
if($id==false){
    echo $db->last_error;
}

$_SESSION['user_id'] = $id;

// ---- create new session -------
$data2 = array('user_id' => $id);

$sessionid = $db->insert_array('app_stemmentotaal', $data2);
$active_session = "_" . $id;

$locatiesJSON = $db->getPictures($id);



echo json_encode(array('locaties'=>$locatiesJSON, 'user_id'=>$id));

