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

$geboortejaar = array('geboortejaar' => $db->getPulldown("SELECT * FROM user_voorkeur"));
$sex = array('geslacht' => $db->getPulldown("SELECT * FROM user_geslacht"));
$voorkeur = array('voorkeur' => $db->getPulldown("SELECT * FROM user_voorkeur"));
$ikben = array('ikben' => $db->getPulldown("SELECT * FROM user_ikben"));
$texel = array('texel' => $db->getPulldown("SELECT * FROM user_texel"));
$duurzaamheid = array('duurzaamheid' => $db->getPulldown("SELECT * FROM user_duurzaamheid"));
$mijnband = array('mijnband' => $db->getPulldown("SELECT * FROM user_mijnband"));


$form = array($voorkeur,$geboortejaar,$sex,$ikben,$texel,$duurzaamheid,$mijnband);


// echo json_encode($form);
echo json_encode($form, JSON_FORCE_OBJECT);
