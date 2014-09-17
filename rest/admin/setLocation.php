<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

require_once('../db.class.php');

$db = new db_class;
// Open up the database connection.
if(!$db->connect()){
    $db->print_last_error(false);
}
//==========================

$json = json_decode(file_get_contents("php://input"));
$taak = $json->taak;

if($taak == "new"){


    $locatie = $json->locatienaam;
    $data = array(
            'locatie' => $locatie
    , 'thumb' => 'leeg'
    );
    $id_loc = $db->insert_array('app_locaties', $data);
    $al = $db->alter_table_add('app_stemmentotaal', "_" . $id_loc);
    echo json_encode(array("id" => $id_loc));
}

if($taak = 'update'){

    $locid = $json->id;

    $dir = "../../uploads/";

// thumbnail uploaden
//    $thumb = $_FILES['thumb']['name'];
//    $thumb = stripslashes($thumb);
//    $thumb = str_replace("'", "", $thumb);
//    $copy = copy($_FILES['thumb']['tmp_name'], $dir . $thumb);


    // Upload images
    $uploadNeed = $json->uploadNeed;
    // start for loop
    for ($x = 0; $x < $uploadNeed; $x++) {
        $file_name = $_FILES['photo' . $x]['name'];
        // strip file_name of slashes
        $file_name = stripslashes($file_name);
        $file_name = str_replace("'", "", $file_name);
        $copy = copy($_FILES['photo' . $x]['tmp_name'], $dir . $file_name);


        // check if successfully copied
        if($copy){
            echo "$file_name | uploaded sucessfully!<br>";

        } else {
            echo "$file_name | could not be uploaded!<br>";
        }
        $data = array(
                'photo_src' => $file_name,
                'photo_locatie' => $id_loc
        );
        $id = $db->insert_array('app_photos', $data);
    }


    // Tags opslaan
    if($json->tag){
        foreach ($_POST['tag'] AS $value) {
            $data2 = array(
                    'tag' => $value,
                    'locatie_id' => $id_loc
            );

            $id = $db->insert_array('app_locaties_tags', $data2);
        }
    }
}

// UPDATE TABLE APP_LOCATIES TO ACTIVATE LOCATIE
if($json->actief){
    $data = array('actief' => $_POST['actief']);
    $rows = $db->update_array('app_locaties', $data, "id=" . $id_loc . "");
    if(!$rows){
        $db->print_last_error(false);
    }


}
if($taak == "photo"){


}


if($taak == "delete"){
    /*
     * delete row in app_locaties
     * EN
     * delete veld uit app_stemmentotaal
    */
    return 'ok';
}


//=======================================

if($taak == "update_actief"){
    $data = array('actief' => $json['actief']);
    $rows = $db->update_array('app_locaties', $data, "id=" . $json['id'] . "");
    return 'ok';
}