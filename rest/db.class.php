<?php session_start();

/*
 *
 *  1 = auto
  * 2 = duurzaamheid
  * 3 = geslacht
  * 4 = ikben
  * 5 = mijnband
  * 6 = texel
  * 7 = voorkeur
 */

// constants used by class
define('MYSQL_TYPES_NUMERIC', 'int real ');
define('MYSQL_TYPES_DATE', 'datetime timestamp year date time ');
define('MYSQL_TYPES_STRING', 'string blob ');

//$ebits = ini_get('error_reporting');
//error_reporting($ebits ^ E_NOTICE);
class db_class{

    var $last_error; // holds the last error. Usually mysql_error()
    var $last_query; // holds the last query executed.
    var $row_count; // holds the last number of rows from a select

    var $host; // mySQL host to connect to
    var $user; // mySQL user name
    var $pw; // mySQL password
    var $db; // mySQL database to select

    var $db_link; // current/last database link identifier
    var $auto_slashes; // the class will add/strip slashes when it can

    function db_class(){

        // class constructor.  Initializations here.

        // Setup your own default values for connecting to the database here. You
        // can also set these values in the connect() function and using
        // the select_database() function.


        //testserver

        $this->host = 'localhost';
        $this->user = 'root';
        $this->pw = 'root';
        $this->db = 'smaaktest';

        //live server
        // $this->host = '85.17.140.102';
        // $this->user = 'staging';
        // $this->pw = 'Vqrb9_42';
        // $this->db = 'architectuur_STAGING';

        $this->auto_slashes = true;
    }

    function connect($host = '', $user = '', $pw = '', $db = '', $persistant = true){

        // Opens a connection to MySQL and selects the database.  If any of the
        // function's parameter's are set, we want to update the class variables.
        // If they are NOT set, then we're giong to use the currently existing
        // class variables.
        // Returns true if successful, false if there is failure.

        if(!empty($host)){
            $this->host = $host;
        }
        if(!empty($user)){
            $this->user = $user;
        }
        if(!empty($pw)){
            $this->pw = $pw;
        }


        // Establish the connection.
        if($persistant){
            $this->db_link = mysql_pconnect($this->host, $this->user, $this->pw);
        } else {
            $this->db_link = mysql_connect($this->host, $this->user, $this->pw);
        }

        // Check for an error establishing a connection
        if(!$this->db_link){
            $this->last_error = mysql_error();
            return false;
        }

        // Select the database
        if(!$this->select_db($db)){
            return false;
        }

        return $this->db_link; // success
    }


    /* =====================================================
     *
     *
     * -------------- LHM  port naar HTML JSON -------------
     *
     *
     =======================================================*/
    function getPulldown($sql){
        $r = $this->select($sql);
        $res = array();
        while ($row = mysql_fetch_assoc($r)) {
            $res[] = array('label' => $row['label'], 'value' => $row['id']);
        }
        // $object = json_decode(json_encode($res), FALSE);
        return $res;
    }

    function getPulldownJaren(){
        $res = array();
        for ($i = 1914; $i < 2014; $i++) {
            $res[] = array('label' => $i, 'value' => $i);
        }
        return $res;
    }

    function getPictures($userID){
        $sql = "SELECT * FROM app_locaties WHERE actief = 1 ORDER BY RAND()";
        $result = mysql_query($sql) or die("Data not found.");
        $entries = array();
        while ($row = mysql_fetch_assoc($result)) {

            $sql2 = "SELECT * FROM app_photos WHERE photo_locatie = " . $row['id'] . " ORDER BY id ASC";
            $result2 = mysql_query($sql2) or die("Data not found.");
            $rn = 0;
            $photos = array();
            while ($row2 = mysql_fetch_assoc($result2)) {
                $photos[$rn] = $row2['photo_src'];
            }

            $entrie = array("id" => $row['id'], "locatie" => $row['locatie'], "photos" => $photos);
            array_push($entries, $entrie);
        }
        return array('entries' => $entries, "sessie" => $userID);
    }

    function eindscore_totaal(){
        $locaties = array();
        // $totaalxml = "<eindscore>";
        $rn = 1;
        $sql = "SELECT * FROM app_locaties WHERE actief = 1";
        $r = mysql_query($sql);

        while ($row = mysql_fetch_assoc($r)) {
            $loc = "_" . $row['id'];


            $sql2 = "SELECT AVG($loc) AS gemiddeld FROM app_stemmentotaal";
            $r2 = mysql_query($sql2);


            while ($row2 = mysql_fetch_assoc($r2)) {

                array_push($locaties, array(
                        'locatie_id' => $row['id'],
                        'locatie_naam' => $row['locatie'],
                        'gemiddelde' => $row2['gemiddeld'], 1,
                        'thumb' => $row['thumb']
                ));


            }
        }
        $locaties = subval_sort($locaties, 'gemiddelde');
        $top3 = array();

        for ($i = 0; $i < 3; $i++) {
            array_push($top3, $locaties[$i]);
        }
        return $top3;
    }

    function eindscore_user_totaal($uid){
        $locaties = array();
        //  $xmltotaal = "<uweindscore>";

        $rn = 1;
        $sql = "SELECT * FROM app_locaties WHERE actief = 1";
        $r = mysql_query($sql);

        while ($row = mysql_fetch_assoc($r)) {
            $loc = "_" . $row['id'];


            $sql2 = "SELECT AVG($loc) AS gemiddeld FROM app_stemmentotaal WHERE user_id = '" . $uid . "'";
            $r2 = mysql_query($sql2);
            //echo $sql2;

            while ($row2 = mysql_fetch_assoc($r2)) {

                array_push($locaties, array(
                        'locatie_id' => $row['id'],
                        'locatie_naam' => $row['locatie'],
                        'gemiddelde' => $row2['gemiddeld'], 1,
                        'thumb' => $row['thumb']
                ));


            }
        }
        $locaties = subval_sort($locaties, 'gemiddelde');
        $uwtop = array();

        for ($i = 0; $i < 3; $i++) {
            array_push($uwtop, $locaties[$i]);
            //$xmltotaal .= "<item id='" . $rn++ . "'><naam><![CDATA[" . $locaties[$i]['locatie_naam'] . "]]></naam><cijfer><![CDATA[" . str_replace(".", ",", round($locaties[$i]['gemiddelde'], 1)) . "]]></cijfer><image src='" . $locaties[$i]['thumb'] . "' /></item>";

        }
        // $xmltotaal .= "</uweindscore>";
        return $uwtop;
    }

    //================= ADMIN ================================
    function getPhotosToLocation($locationId){
        $sql2 = "SELECT * FROM app_photos WHERE photo_locatie = '" . $locationId . "' ";
        $r2 = mysql_query($sql2);
        $ret = array();
        $i = 0;
        while ($row2 = mysql_fetch_assoc($r2)) {
            $ret[$i] = array('photo_src' => $row2['photo_src'], 'id' => $row2['id']);
            $i++;
        }
        return $ret;
    }

    function getLocations(){
        $sql = "SELECT * FROM app_locaties";
        $r = $this->select($sql);
        if(!$r){
            return false;
        }
        $ret = array();

        while ($row = mysql_fetch_assoc($r)) {
            $locatie = array();
            foreach ($row as $key => $value) {
                // array_push($locatie, array($key => $value));
                $locatie[$key] = $value;
            }
            $locatie['photos'] = $this->getPhotosToLocation($locatie['id']);

            array_push($ret, $locatie);
        }
        return $ret;
    }

    function getLocation($id){
        $sql = "SELECT * FROM app_locaties WHERE id = '" . $id . "'";
        $r = $this->select($sql);
        if(!$r){
            return false;
        }
        $ret = array();

        while ($row = mysql_fetch_assoc($r)) {
            $locatie = array();
            foreach ($row as $key => $value) {
                // array_push($locatie, array($key => $value));
                $locatie[$key] = $value;
            }
         $locatie['photos'] = $this->getPhotosToLocation($locatie['id']);

            array_push($ret, $locatie);
        }
        return $ret;
    }


    /*
     * ================== END PORT ==========================
     */


    function select_db($db = ''){

        // Selects the database for use.  If the function's $db parameter is
        // passed to the function then the class variable will be updated.

        if(!empty($db)){
            $this->db = $db;
        }

        if(!mysql_select_db($this->db)){
            $this->last_error = mysql_error();
            return false;
        }

        return true;
    }

    function select($sql){

        // Performs an SQL query and returns the result pointer or false
        // if there is an error.

        $this->last_query = $sql;

        $r = mysql_query($sql);
        if(!$r){
            $this->last_error = mysql_error();
            return false;
        }
        $this->row_count = mysql_num_rows($r);
        return $r;
    }

    function select_one($sql){

        // Performs an SQL query with the assumption that only ONE column and
        // one result are to be returned.
        // Returns the one result.

        $this->last_query = $sql;

        $r = mysql_query($sql);
        if(!$r){
            $this->last_error = mysql_error();
            return false;
        }
        if(mysql_num_rows($r) > 1){
            $this->last_error = "Your query in function select_one() returned more that one result.";
            return false;
        }
        if(mysql_num_rows($r) < 1){
            $this->last_error = "Your query in function select_one() returned no results.";
            return false;
        }
        $ret = mysql_result($r, 0);
        mysql_free_result($r);
        if($this->auto_slashes){
            return stripslashes($ret);
        } else {
            return $ret;
        }
    }

    function get_row($result, $type = 'MYSQL_BOTH'){

        // Returns a row of data from the query result.  You would use this
        // function in place of something like while($row=mysql_fetch_array($r)).
        // Instead you would have while($row = $db->get_row($r)) The
        // main reason you would want to use this instead is to utilize the
        // auto_slashes feature.

        if(!$result){
            $this->last_error = "Invalid resource identifier passed to get_row() function.";
            return false;
        }

        if($type == 'MYSQL_ASSOC'){
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
        }
        if($type == 'MYSQL_NUM'){
            $row = mysql_fetch_array($result, MYSQL_NUM);
        }
        if($type == 'MYSQL_BOTH'){
            $row = mysql_fetch_array($result, MYSQL_BOTH);
        }

        if(!$row){
            return false;
        }
        if($this->auto_slashes){
            // strip all slashes out of row...
            foreach ($row as $key => $value) {
                $row[$key] = stripslashes($value);
            }
        }
        return $row;
    }

    function dump_query($sql){

        // Useful during development for debugging  purposes.  Simple dumps a
        // query to the screen in a table.

        $r = $this->select($sql);
        if(!$r){
            return false;
        }
        echo "<div style=\"border: 1px solid blue; font-family: sans-serif; margin: 8px;\">\n";
        echo "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" width=\"100%\">\n";

        $i = 0;
        while ($row = mysql_fetch_assoc($r)) {
            if($i == 0){
                echo "<tr><td colspan=\"" . sizeof($row) . "\"><span style=\"font-face: monospace; font-size: 9pt;\">Overzicht</span></td></tr>\n";
                echo "<tr>\n";
                foreach ($row as $col => $value) {

                    echo "<td bgcolor=\"#E6E5FF\"><span style=\"font-face: sans-serif; font-size: 9pt; font-weight: bold;\">$col</span></td>\n";
                }
                echo "<td bgcolor=\"#E6E5FF\"><span style=\"font-face: sans-serif; font-size: 9pt; font-weight: bold;\">&nbsp;</span></td>\n";
                echo "<td bgcolor=\"#E6E5FF\"><span style=\"font-face: sans-serif; font-size: 9pt; font-weight: bold;\">&nbsp;</span></td>\n";
                echo "</tr>\n";
            }
            $i++;
            if($i % 2 == 0){
                $bg = '#E3E3E3';
            } else {
                $bg = '#F3F3F3';
            }
            echo "<tr>\n";
            foreach ($row as $value) {

                echo "<td bgcolor=\"$bg\"><span style=\"font-face: sans-serif; font-size: 9pt;\">$value</span></td>\n";
            }
            echo "<td bgcolor=\"$bg\"><span style=\"font-face: sans-serif; font-size: 9pt;\"><a href=\"" . $_SERVER['PHP_SELF'] . "?action=delete&id=" . $row['id'] . "\">Verwijder</a></span></td>\n";
            echo "<td bgcolor=\"$bg\"><span style=\"font-face: sans-serif; font-size: 9pt;\"><a href=\"" . $_SERVER['PHP_SELF'] . "?action=edit&id=" . $row['id'] . "\">Bewerk</a></span></td>";
            echo "</tr>\n";
        }
        echo "</table></div>\n";
    }

    function dump_query_photos($sql){

        // Useful during development for debugging  purposes.  Simple dumps a
        // query to the screen in a table.

        $r = $this->select($sql);
        if(!$r){
            return false;
        }
        echo "<div style=\"border: 1px solid blue; font-family: sans-serif; margin: 8px;\">\n";
        echo "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" width=\"100%\">\n";

        $i = 0;
        while ($row = mysql_fetch_assoc($r)) {
            if($i == 0){
                echo "<tr><td colspan=\"" . sizeof($row) . "\"><span style=\"font-face: monospace; font-size: 9pt;\">Photo database</span></td></tr>\n";
                echo "<tr>\n";
                foreach ($row as $col => $value) {

                    echo "<td bgcolor=\"#E6E5FF\"><span style=\"font-face: sans-serif; font-size: 9pt; font-weight: bold;\">$col</span></td>\n";
                }

                echo "</tr>\n";
            }
            $i++;
            if($i % 2 == 0){
                $bg = '#E3E3E3';
            } else {
                $bg = '#F3F3F3';
            }
            echo "<tr>\n";
            foreach ($row as $value) {

                echo "<td bgcolor=\"$bg\"><span style=\"font-face: sans-serif; font-size: 9pt;\">$value</span></td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table></div>\n";
    }

    //======================== pulldown ===========================
    function pulldown_query($sql, $name){
        $r = $this->select($sql);
        echo "<select name='" . $name . "'>\n";
        echo "<option value=''>allen</option>\n";
        while ($row = mysql_fetch_array($r)) {

            echo "<option value='" . $row[0] . "'>" . $row[1] . " </option>\n";

        }
        echo "</select>\n";
    }

    //======================== radio btn ===========================
    function radio_query($sql, $name){
        $r = $this->select($sql);
        while ($row = mysql_fetch_array($r)) {
            echo "<input type='radio' name='" . $name . "' value='" . $row[0] . "'> " . $row[1] . "<br/>";
        }
    }

    //======================== checkbox ===========================
    function checkbox_query($sql, $name){
        $r = $this->select($sql);
        while ($row = mysql_fetch_array($r)) {
            echo "<input type='checkbox' name='" . $name . "' value='" . $row[0] . "'> " . $row[1] . "";
        }
    }

    //======================== ervaring ===========================
    function pulldown_query_ervaring($sql){
        $r = $this->select($sql);


        //  echo "<div>\n";
        echo "<select name='ervaring' id='ervaring'>\n";
        echo "<option value=''>Selecteer</option>";
        while ($row = mysql_fetch_assoc($r)) {
            echo "<option value=\"" . $row['id'] . "\">" . $row['ervaring'] . "</option>\n";
        }
        // echo "</div>\n";
        echo "</select>\n";
    }


    //=====================pull down tags =============================
    function pulldown_query_tags($sql){
        $r = $this->select($sql);

        echo "<select name=\"tag[]\" multiple=\"multiple\">\n";
        echo "<option value=\"Null\"></option>";
        while ($row = mysql_fetch_assoc($r)) {
            echo "<option value=\"" . $row['id'] . "\">" . $row['tag'] . "</option>\n";
        }
        echo "</select>\n";
    }

    //===================== tag ==============================
    function pulldown_query_tag($sql){
        $r = $this->select($sql);

        echo "<select name=\"tag\" style='select'>\n";
        echo "<option value=\"0\"></option>";
        while ($row = mysql_fetch_assoc($r)) {
            echo "<option value=\"" . $row['id'] . "\">" . $row['tag'] . "</option>\n";
        }
        echo "</select>\n";
    }

    //======================== geslacht ===========================
    function pulldown_query_geslacht($sql){
        $r = $this->select($sql);
        echo "<div>\n";
        while ($row = mysql_fetch_assoc($r)) {
            echo "<input type=\"radio\" name=\"geslacht\"  id=\"geslacht\" value=\"" . $row['id'] . "\"> " . $row['geslacht'] . "  &nbsp;&nbsp;";
        }
        echo "</div>\n";
    }

    //===================== postcode ==============================
    function pulldown_query_postcode($sql){
        $r = $this->select($sql);

        echo "<select name=\"postcode\" id=\"postcode\">\n";
        echo "<option value=''>Selecteer</option>";
        while ($row = mysql_fetch_assoc($r)) {
            echo "<option value=\"" . $row['id'] . "\">" . $row['postcodegebied'] . "</option>\n";
        }
        echo "</select>\n";
    }

    //====================== samnestelling =============================

    function pulldown_query_voorkeur($sql){
        $r = $this->select($sql);
        $res = array();
        while ($row = mysql_fetch_assoc($r)) {
            //['label' => $row['samenstelling'], 'value'=>$row['id']]
            array_push($res, array('label' => $row['label'], 'value' => $row['id']));
        }

        return array('voorkeur' => $res);
    }

    //======================== opleiding ===========================

    function pulldown_query_opleiding($sql){
        $r = $this->select($sql);

        echo "<select name=\"opleiding\" id=\"opleiding\" >\n";
        echo "<option value=''>Selecteer</option>";
        while ($row = mysql_fetch_assoc($r)) {
            echo "<option value=\"" . $row['id'] . "\">" . $row['opleiding'] . "</option>\n";
        }
        echo "</select>\n";
    }

    //======================== woningtype ===========================

    function pulldown_query_woningtype($sql){
        $r = $this->select($sql);

        echo "<select name=\"woningtype\" name=\"woningtype\">\n";
        echo "<option value=''>Selecteer</option>";
        while ($row = mysql_fetch_assoc($r)) {
            echo "<option value=\"" . $row['id'] . "\">" . $row['woningtype'] . "</option>\n";
        }
        echo "</select>\n";
    }

    //======================= auto ============================

    function pulldown_query_auto($sql){
        $r = $this->select($sql);

        //echo "<select name=\"autobezit\">\n";

        //while ($row = mysql_fetch_assoc($r)) {

        echo "<input type=\"checkbox\" name=\"autobezit\" value=\"1\">";
        //echo "<option value=\"".$row['id']."\">".$row['autobezit']."</option>\n";
        //}
        //echo "</select>\n";
    }

    //====================== locatie =============================

    function pulldown_query_locatie($sql){
        $r = $this->select($sql);

        echo "<select name=\"locatie\">\n";
        echo "<option>Selecteer Locatie</option>";
        while ($row = mysql_fetch_assoc($r)) {
            echo "<option value=\"" . $row['id'] . "\">" . $row['locatie'] . "</option>\n";
        }
        echo "</select>\n";
    }

    //===================================================

    function pulldown_query_photo($sql){
        echo "<table width=\"600\" border=\"0\">";

        for ($x = 1; $x < 10; $x++) {

            $r = $this->select($sql);
            echo "<tr>";
            echo "<td>";
            echo "Photo :" . $x . "\n";
            echo "</td><td>";
            echo "<select name=\"photo$x\">\n";

            while ($row = mysql_fetch_assoc($r)) {
                echo "<option value=\"" . $row['id'] . "\">" . $row['photo_src'] . "</option>\n";
            }
            echo "</select>\r\n";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function insert_sql($sql){

        // Inserts data in the database via SQL query.
        // Returns the id of the insert or true if there is not auto_increment
        // column in the table.  Returns false if there is an error.

        $this->last_query = $sql;

        $r = mysql_query($sql);
        if(!$r){
            $this->last_error = mysql_error();
            return false;
        }

        $id = mysql_insert_id();
        if($id == 0){
            return true;
        } else {
            return $id;
        }
    }

    function update_sql($sql){

        // Updates data in the database via SQL query.
        // Returns the number or row affected or true if no rows needed the update.
        // Returns false if there is an error.

        $this->last_query = $sql;

        $r = mysql_query($sql);
        if(!$r){
            $this->last_error = mysql_error();
            return false;
        }

        $rows = mysql_affected_rows();
        if($rows == 0){
            return true;
        } // no rows were updated
        else {
            return $rows;
        }

    }

    function insert_array($table, $data){
        // Inserts a row into the database from key->value pairs in an array. The
        // array passed in $data must have keys for the table's columns. You can
        // not use any MySQL functions with string and date types with this
        // function.  You must use insert_sql for that purpose.
        // Returns the id of the insert or true if there is not auto_increment
        // column in the table.  Returns false if there is an error.

        if(empty($data)){
            $this->last_error = "You must pass an array to the insert_array() function.";
            return false;
        }

        $cols = '(';
        $values = '(';

        foreach ($data as $key => $value) { // iterate values to input

            $cols .= "$key,";

            $col_type = $this->get_column_type($table, $key); // get column type
            if(!$col_type){
                return false;
            } // error!

            // determine if we need to encase the value in single quotes
            if(is_null($value)){
                $values .= "NULL,";
            } elseif(substr_count(MYSQL_TYPES_NUMERIC, "$col_type ")) {
                $values .= "$value,";
            } elseif(substr_count(MYSQL_TYPES_DATE, "$col_type ")) {
                $value = $this->sql_date_format($value, $col_type); // format date
                $values .= "'$value',";
            } elseif(substr_count(MYSQL_TYPES_STRING, "$col_type ")) {
                if($this->auto_slashes){
                    $value = addslashes($value);
                }
                $values .= "'$value',";
            }
        }
        $cols = rtrim($cols, ',') . ')';
        $values = rtrim($values, ',') . ')';

        // insert values
        $values = str_replace(' ', '_', $values);
        $sql = "INSERT INTO $table $cols VALUES $values";
        return $this->insert_sql($sql);

    }

    // add colomn to table
    function alter_table_add($table, $locatie){
        //$locatie = str_replace(' ', '_', $locatie);
        $sql = ("ALTER TABLE $table " .
                "ADD COLUMN $locatie INT(11) " .
                "AFTER user_id;");
        return $this->insert_sql($sql);

    }

    // remove colomn from table
    function alter_table_drop($table, $locatie){
        //$locatie = str_replace(' ', '_', $locatie);
        $sql = ("ALTER TABLE $table " .
                "DROP COLUMN $locatie");
        return $this->insert_sql($sql);

    }

    function update_array($table, $data, $condition){

        // Updates a row into the database from key->value pairs in an array. The
        // array passed in $data must have keys for the table's columns. You can
        // not use any MySQL functions with string and date types with this
        // function.  You must use insert_sql for that purpose.
        // $condition is basically a WHERE claus (without the WHERE). For example,
        // "column=value AND column2='another value'" would be a condition.
        // Returns the number or row affected or true if no rows needed the update.
        // Returns false if there is an error.

        if(empty($data)){
            $this->last_error = "You must pass an array to the update_array() function.";
            return false;
        }

        $sql = "UPDATE $table SET";
        foreach ($data as $key => $value) { // iterate values to input

            $sql .= " $key=";

            $col_type = $this->get_column_type($table, $key); // get column type
            if(!$col_type){
                return false;
            } // error!

            // determine if we need to encase the value in single quotes
            if(is_null($value)){
                $sql .= "NULL,";
            } elseif(substr_count(MYSQL_TYPES_NUMERIC, "$col_type ")) {
                $sql .= "$value,";
            } elseif(substr_count(MYSQL_TYPES_DATE, "$col_type ")) {
                $value = $this->sql_date_format($value, $col_type); // format date
                $sql .= "'$value',";
            } elseif(substr_count(MYSQL_TYPES_STRING, "$col_type ")) {
                if($this->auto_slashes){
                    $value = addslashes($value);
                }
                $sql .= "'$value',";
            }

        }
        $sql = rtrim($sql, ','); // strip off last "extra" comma
        if(!empty($condition)){
            $sql .= " WHERE $condition";
        }

        // insert values
        return $this->update_sql($sql);
    }

    function execute_file($file){

        // executes the SQL commands from an external file.

        if(!file_exists($file)){
            $this->last_error = "The file $file does not exist.";
            return false;
        }
        $str = file_get_contents($file);
        if(!$str){
            $this->last_error = "Unable to read the contents of $file.";
            return false;
        }

        $this->last_query = $str;

        // split all the query's into an array
        $sql = explode(';', $str);
        foreach ($sql as $query) {
            if(!empty($query)){
                $r = mysql_query($query);

                if(!$r){
                    $this->last_error = mysql_error();
                    return false;
                }
            }
        }
        return true;

    }

    function get_column_type($table, $column){

        // Gets information about a particular column using the mysql_fetch_field
        // function.  Returns an array with the field info or false if there is
        // an error.

        $r = mysql_query("SELECT $column FROM $table");
        if(!$r){
            $this->last_error = mysql_error();
            return false;
        }
        $ret = mysql_field_type($r, 0);
        if(!$ret){
            $this->last_error = "Unable to get column information on $table.$column.";
            mysql_free_result($r);
            return false;
        }
        mysql_free_result($r);
        return $ret;

    }

    function sql_date_format($value){

        // Returns the date in a format for input into the database.  You can pass
        // this function a timestamp value such as time() or a string value
        // such as '04/14/2003 5:13 AM'.

        if(gettype($value) == 'string'){
            $value = strtotime($value);
        }
        return date('Y-m-d H:i:s', $value);

    }

    function print_last_error($show_query = true){

        // Prints the last error to the screen in a nicely formatted error message.
        // If $show_query is true, then the last query that was executed will
        // be displayed aswell.

        ?>

        <div
                style="border: 1px solid red; font-size: 9pt; font-family: monospace; color: red; padding: .5em; margin: 8px; background-color: #FFE2E2">
            <span style="font-weight: bold">db.class.php Error:</span><br>
            <?= $this->last_error ?>
        </div>
        <?
        if($show_query && (!empty($this->last_query))){
            $this->print_last_query();
        }

    }

    function print_last_query(){

        // Prints the last query that was executed to the screen in a nicely formatted
        // box.

        ?>
        <div
                style="border: 1px solid blue; font-size: 9pt; font-family: monospace; color: blue; padding: .5em; margin: 8px; background-color: #E6E5FF">
            <span style="font-weight: bold">Last SQL Query:</span><br>
            <?= str_replace("\n", '<br>', $this->last_query) ?>
        </div>
    <?
    }
}

//XML
function xml($userID){
    $sql = "SELECT * FROM app_locaties WHERE actief = 1 ORDER BY RAND()";
    $result = mysql_query($sql) or die("Data not found.");


    $xml_output = "<?xml version=\"1.0\"?>";
    $xml_output .= "<entries sessie = \"" . $userID . "\">\n";

    while ($row = mysql_fetch_assoc($result)) {


        $xml_output .= "<entry>\n";
        $xml_output .= "<id>" . $row['id'] . "</id>\n";
        $xml_output .= "<locatie>" . $row['locatie'] . "</locatie>\n";
        $xml_output .= "<photos>\n";

        $sql2 = "SELECT * FROM app_photos WHERE photo_locatie = " . $row['id'] . " ORDER BY id ASC";
        $result2 = mysql_query($sql2) or die("Data not found.");
        $rn = 0;
        while ($row2 = mysql_fetch_assoc($result2)) {

            $xml_output .= "<photo id = \"" . $rn++ . "\"><![CDATA[" . $row2['photo_src'] . "]]></photo>\n";
        }
        $xml_output .= "</photos>";
        $xml_output .= "</entry>";
    }
    $xml_output .= "</entries>";

    echo $xml_output;
}

function maketable($active_session){
    $makeTable = 'CREATE TABLE ' . $active_session . ' ( ' .
            'id INT NOT NULL AUTO_INCREMENT , ' .
            'user_id int(5) default NULL , ' .
            'locatie int(5) default NULL , ' .
            'cijfer int(2) default NULL , ' .
            'PRIMARY KEY(id))';

    $result = mysql_query($makeTable);
}

// functie om de array te sorteren

function subval_sort($a, $subkey){
    foreach ($a as $k => $v) {
        $b[$k] = strtolower($v[$subkey]);
    }
    arsort($b);
    foreach ($b as $key => $val) {
        $c[] = $a[$key];
    }
    return $c;
}


function count_test(){
    $sql = "SELECT * FROM app_stemmentotaal";
    $r = mysql_query($sql);
    $aantal = mysql_num_rows($r);
    return $aantal;
}

