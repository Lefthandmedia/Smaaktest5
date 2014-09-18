<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */
require_once('../db.class.php');
$db = new db_class;
if(!$db->connect()){
    $db->print_last_error(false);
}
//==========================


// print_r($_FILES);
// print_r($POST);

if(isset($_FILES['myFile'])){

    $dir = "../../uploads/";
    $extensions = array("jpeg", "jpg", "png");
    $photoData = json_decode($_POST['photoData']);

    $errors = array();
    $file_name = $_FILES['myFile']['name'];
    $file_size = $_FILES['myFile']['size'];
    $file_tmp = $_FILES['myFile']['tmp_name'];
    $file_type = $_FILES['myFile']['type'];

//
//    echo $photoData->taak;
//    echo $photoData->locid;
//    echo $photoData->phototag;

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if(in_array($file_ext, $extensions) === false){
        $errors[] = "image extension not allowed, please choose a JPEG or PNG file.";
    }
    if($file_size > 2097152){
        $errors[] = 'File size cannot exceed 2 MB';
    }


    if(empty($errors) == true){

        switch ($photoData->phototag) {
            case 'thumb':
                // save the thumb to a location
                move_uploaded_file($file_tmp, $dir . $file_name);
                $data = array(
                        'thumb' => $file_name
                );
                $rows = $db->update_array('app_locaties', $data, "id=" . $photoData->locid . "");
                break;

            case "photo":
                // add photos and set their locationid
                move_uploaded_file($file_tmp, $dir . $file_name);
                $data = array(
                        'photo_src' => $file_name,
                        'photo_locatie' => $photoData->locid
                );
                $id = $db->insert_array('app_photos', $data);
                break;

        }


    } else {
        print_r($errors);
    }
} else {
    $errors = array();
    $errors[] = "No image found";
    print_r($errors);
}




