<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>

 * 1 = geboortejaar
 * 2 = duurzaamheid
 * 3 = geslacht
 * 4 = ikben
 * 5 = mijnband
 * 6 = texel
 * 7 = voorkeur

 */

require_once('db.class.php');
$db = new db_class;
// Open up the database connection.
if (!$db->connect()) {
    $db->print_last_error(false);
}
//=======================

$geboortejaar   = array('veld' => 'veld1', 'label' => 'Geboortejaar', 'value' => $db->getPulldownJaren(),"type"=>"list");
$duurzaamheid   = array('veld' => 'veld2', 'label' => 'Duurzaamheid versterkt toerisme op Texel..', 'value' => $db->getPulldown("SELECT * FROM user_veld2"),"type"=>"list");
$sex            = array('veld' => 'veld3', 'label' => 'Geslacht', 'value' => $db->getPulldown("SELECT * FROM user_veld3"),"type"=>"list");
$ikben          = array('veld' => 'veld4', 'label' => 'Ik zou mezelf omschrijven als een…', 'value' => $db->getPulldown("SELECT * FROM user_veld4"),"type"=>"list");
$mijnband       = array('veld' => 'veld5', 'label' => 'Mijn belangrijkste binding met Texel is..', 'value' => $db->getPulldown("SELECT * FROM user_veld5"),"type"=>"list");
$texel          = array('veld' => 'veld6', 'label' => 'Texel heeft een sterke identiteit..', 'value' => $db->getPulldown("SELECT * FROM user_veld6"),"type"=>"list");
$voorkeur       = array('veld' => 'veld7', 'label' => 'Mijn voorkeur gaat uit naar', 'value' => $db->getPulldown("SELECT * FROM user_veld7"),"type"=>"list");

$form = array($geboortejaar, $sex, $voorkeur, $ikben, $texel, $duurzaamheid, $mijnband);

echo json_encode(array('form' => $form));
