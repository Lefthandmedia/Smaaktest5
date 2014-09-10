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

 // inserten van de cijfers
   $data = array('_'.$json->locatie .'' => $json->cijfer);

   $rows = $db->update_array('app_stemmentotaal', $data, "user_id=".$json->user_id."");
   if (!$rows) $db->print_last_error(false);

echo true;