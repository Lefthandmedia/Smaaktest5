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


$sex = array('veld' => 'geslacht', 'label' => 'Geslacht', 'value' => $db->getPulldown("SELECT * FROM user_geslacht"),"type"=>"list");
$voorkeur = array('veld' => 'voorkeur', 'label' => 'Mijn voorkeur gaat uit naar', 'value' => $db->getPulldown("SELECT * FROM user_voorkeur"),"type"=>"list");
$ikben = array('veld' => 'ikben', 'label' => 'Ik zou mezelf omschrijven als een…', 'value' => $db->getPulldown("SELECT * FROM user_ikben"),"type"=>"list");
$texel = array('veld' => 'texel', 'label' => 'Texel heeft een sterke identiteit..', 'value' => $db->getPulldown("SELECT * FROM user_texel"),"type"=>"list");
$duurzaamheid = array('veld' => 'duurzaamheid', 'label' => 'Duurzaamheid versterkt toerisme op Texel..', 'value' => $db->getPulldown("SELECT * FROM user_duurzaamheid"),"type"=>"list");
$mijnband = array('veld' => 'mijnband', 'label' => 'Mijn belangrijkste binding met Texel is..', 'value' => $db->getPulldown("SELECT * FROM user_mijnband"),"type"=>"list");
$geboortejaar = array('veld' => 'geboortejaar', 'label' => 'Geboortejaar', 'value' => $db->getPulldown("SELECT * FROM user_voorkeur"),"type"=>"list");

$form = array($geboortejaar, $sex, $voorkeur, $ikben, $texel, $duurzaamheid, $mijnband);

echo json_encode(array('form' => $form));
