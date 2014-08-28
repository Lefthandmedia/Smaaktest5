<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

require_once('db.class.php');
$db = new db_class;
// Open up the database connection.
if(!$db->connect()){
    $db->print_last_error(false);
}
//=======================

$geboortejaar = array('voorkeur' => $db->getPulldown("SELECT * FROM user_voorkeur"));
$sex = array('geslacht' => $db->getPulldown("SELECT * FROM user_geslacht"));
$voorkeur = array('voorkeur' => $db->getPulldown("SELECT * FROM user_voorkeur"));
$ikben = array('ikben' => $db->getPulldown("SELECT * FROM user_ikben"));
$texel = array('texel' => $db->getPulldown("SELECT * FROM user_texel"));
$duurzaamheid = array('duurzaamheid' => $db->getPulldown("SELECT * FROM user_duurzaamheid"));
$mijnband = array('mijnband' => $db->getPulldown("SELECT * FROM user_mijnband"));


$form = array($voorkeur,
        'identiteit' => array('identiteit1' => 1, 'identiteit2' => 2, 'identiteit3' => 3)
);

echo json_encode($form);
