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

$geboortejaar = array('label' => 'geboortejaar', 'value' => $db->getPulldown("SELECT * FROM user_voorkeur"));
$sex = array('label' => 'geslacht', 'value' => $db->getPulldown("SELECT * FROM user_geslacht"));
$voorkeur = array('label' => 'voorkeur', 'value' => $db->getPulldown("SELECT * FROM user_voorkeur"));
$ikben = array('label' => 'ikben', 'value' => $db->getPulldown("SELECT * FROM user_ikben"));
$texel = array('label' => 'texel', 'value' => $db->getPulldown("SELECT * FROM user_texel"));
$duurzaamheid = array('label' => 'duurzaamheid', 'value' => $db->getPulldown("SELECT * FROM user_duurzaamheid"));
$mijnband = array('label' => 'mijnband', 'value' => $db->getPulldown("SELECT * FROM user_mijnband"));


$form = array($geboortejaar, $sex, $voorkeur, $ikben, $texel, $duurzaamheid, $mijnband);

echo json_encode(array('form' => $form));
