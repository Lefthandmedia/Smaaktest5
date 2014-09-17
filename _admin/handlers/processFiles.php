<?php
require_once('../../classes/db.class.php');
$db = new db_class;

// Open up the database connection. 

if(!$db->connect()){
    $db->print_last_error(false);
}

include('../header.php');

$dir = "../../uploads/";

// thumbnail uploaden

$thumb = $_FILES['thumb']['name'];
// strip file_name of slashes
$thumb = stripslashes($thumb);
$thumb = str_replace("'", "", $thumb);
$copy = copy($_FILES['thumb']['tmp_name'], $dir . $thumb);

$locatie = $_POST['locatie'];


$data = array(
        'locatie' => $locatie,
        'thumb' => $thumb
);
$id_loc = $db->insert_array('app_locaties', $data);


// Upload images
$uploadNeed = $_POST['uploadNeed'];
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
if($_POST['tag']){
    foreach ($_POST['tag'] AS $value) {
        $data2 = array(
                'tag' => $value,
                'locatie_id' => $id_loc
        );

        $id = $db->insert_array('app_locaties_tags', $data2);
    }
}
// UPDATE TABLE APP_LOCATIES TO ACTIVATE LOCATIE
if($_POST['actief'] == 1){
    $data = array('actief' => $_POST['actief']);
    $rows = $db->update_array('app_locaties', $data, "id=" . $id_loc . "");
    if(!$rows){
        $db->print_last_error(false);
    }
//function to add column to table
    $al = $db->alter_table_add('app_stemmentotaal', "_" . $id_loc);
}
include('../footer.php');
?>