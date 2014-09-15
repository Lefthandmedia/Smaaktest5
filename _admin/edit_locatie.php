<?php

require_once('../classes/db.class.php');

$db = new db_class;

// Open up the database connection. 

if (!$db->connect())
    $db->print_last_error(false);


$taak = $_REQUEST['action'];

if ($taak == "EditThumb") {

    echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\" enctype=\"multipart/form-data\"><input type=\"hidden\" name=\"id\" value=\"" . $_REQUEST['id'] . "\">";
    echo "Selecteer thumbnail: <input name=\"thumb\" type=\"file\" />";
    echo "<input name=\"action\" type=\"submit\" value=\"Verander thumb\" />";
    echo "</form>";


}

if ($taak == "EditPhoto") {

    echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\" enctype=\"multipart/form-data\"><input type=\"hidden\" name=\"id\" value=\"" . $_REQUEST['id'] . "\"><input type=\"hidden\" name=\"locID\" value=\"" . $_REQUEST['locID'] . "\">";
    echo "Selecteer foto: <input name=\"photo\" type=\"file\" />";
    echo "<input name=\"action\" type=\"submit\" value=\"Verander foto\" />";
    echo "</form>";


}


if ($taak == "edit") {
// tags	
    echo "<form action=\"" . $_SERVER['PHP_SELF'] . "?action=edittaag\" method=\"POST\"><input type=\"hidden\" name=\"id\" value=\"" . $_REQUEST['id'] . "\">\n";
    $SQLtags = "SELECT * FROM app_tags";
    $REStag = mysql_query($SQLtags);
    while ($ROWtag = mysql_fetch_assoc($REStag)) {

        $a = $ROWtag['id'];
        $tagnaam = $ROWtag['tag'];

        $array = array();

        $activeTAGS = "SELECT * FROM app_locaties_tags WHERE locatie_id = '" . $_REQUEST['id'] . "' AND tag = '" . $a . "' ";

        $RESULT = mysql_query($activeTAGS);

        while ($row = mysql_fetch_assoc($RESULT)) {
            $fieldno = $row['id'];
            $array = $row['tag'];
        }
        if ($a == $array) {
            echo "<input type=\"checkbox\" name=\"tag[]\" value=\"" . $a . "\"  checked > " . $tagnaam . " <br />\n";
        } else {
            echo "<input type=\"checkbox\" name=\"tag[]\" value=\"" . $a . "\" > " . $tagnaam . "<br />\n";
        }
    }
    echo "<input type=\"submit\" name=\"action\" value=\"Tags Bewaren\">";
    echo "</form>";


    echo "<table>\n";
    $i = 1;


    $sql = "SELECT * FROM app_locaties WHERE id = '" . $_REQUEST['id'] . "'";


    $r = mysql_query($sql);

    while ($row = mysql_fetch_assoc($r)) {
        if ($row['actief'] == '1') {
            $actief = 'Actief';
        } else $actief = 'Inactief';

        if (!$row['thumb']) {
            $row['thumb'] = "dummy.jpg";
        }
        echo "<tr>\n";
        if ($row['actief'] == '1') {
            echo "<td><a href=\"edit_locatie.php?action=update_actief&id=" . $row['id'] . "&value=0 \">" . $actief . "</a></td>";
        } else {
            echo "<td><a href=\"edit_locatie.php?action=update_actief&id=" . $row['id'] . "&value=1 \">" . $actief . "</a></td>";
        }
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td valign=\"top\">Locatienaam:</td>\n";
        echo "<td><form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\"><input type=\"hidden\" name=\"id\" value=\"" . $_REQUEST['id'] . "\"><input type=\"text\" name =\"locatie\" value=\"" . $row['locatie'] . "\" ><input type=\"submit\" name=\"action\" value=\"Verander naam\"></form></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td valign=\"top\">Thumbnail:</td>\n";
        echo "<td><a href=\"edit_locatie.php?action=EditThumb&id=" . $row['id'] . "\"><img src=\"../uploads/" . $row['thumb'] . "\" /></a></td>\n";
        echo " </tr>\n";


        $sql2 = "SELECT * FROM app_photos WHERE photo_locatie = '" . $row['id'] . "' ";

        $r2 = mysql_query($sql2);
        while ($row2 = mysql_fetch_assoc($r2)) {

            echo "<tr>\n";
            echo "<td valign=\"top\">foto " . $i++ . ":</td>\n";
            echo "<td> <a href=\"edit_locatie.php?action=EditPhoto&locID=" . $_REQUEST['id'] . "&id=" . $row2['id'] . "\"><img src=\"../uploads/" . $row2['photo_src'] . "\"></a></td>\n";
            echo "</tr>\n";

        }
    }
    echo "</table>";
}


if ($taak == "delete") {

    $sql = "DELETE FROM app_locaties WHERE id='" . $_REQUEST['id'] . "' ";

    $r = mysql_query($sql);
    $al = $db->alter_table_drop('app_stemmentotaal', "_" . $_REQUEST['id']);
} elseif (!$taak) {
    $db->dump_query("SELECT * FROM app_locaties");

}

if ($taak == "Tags Bewaren") {
    // eerst verwijderen

    $sql = "DELETE FROM app_locaties_tags WHERE locatie_id='" . $_REQUEST['id'] . "' ";
    $r = mysql_query($sql);
    // Tags opslaan
    foreach ($_POST['tag'] AS $value) {
        $data2 = array(
            'tag' => $value,
            'locatie_id' => $_POST['id']
        );

        $id = $db->insert_array('app_locaties_tags', $data2);
    }
    $succes = 1;
}

if ($taak == "Verander naam") {
    $data = array('locatie' => $_POST['locatie']);
    $rows = $db->update_array('app_locaties', $data, "id=" . $_POST['id'] . "");
    $succes = 1;
}

if ($taak == "update_actief") {
    $data = array('actief' => $_REQUEST['value']);
    $rows = $db->update_array('app_locaties', $data, "id=" . $_REQUEST['id'] . "");
    $succes = 1;
}

if ($taak == "Verander thumb") {
    $dir = "../uploads/";
    $thumb = $_FILES['thumb']['name'];
    $thumb = stripslashes($thumb);
    $thumb = str_replace("'", "", $thumb);
    $copy = copy($_FILES['thumb']['tmp_name'], $dir . $thumb);
    $data = array('thumb' => $thumb);
    $rows = $db->update_array('app_locaties', $data, "id=" . $_POST['id'] . "");
    $succes = 1;

}

if ($taak == "Verander foto") {
    $dir = "../uploads/";
    $photo = $_FILES['photo']['name'];
    $photo = stripslashes($photo);
    $photo = str_replace("'", "", $photo);
    $copy = copy($_FILES['photo']['tmp_name'], $dir . $photo);
    $data = array('photo_src' => $photo);
    $rows = $db->update_array('app_photos', $data, "id=" . $_POST['id'] . "");
    $succes = 2;

}

if ($succes == 1) {
    header("Location: edit_locatie.php?action=edit&id=" . $_REQUEST['id'] . "");
};
if ($succes == 2) {
    header("Location: edit_locatie.php?action=edit&id=" . $_REQUEST['locID'] . "");
}

?>