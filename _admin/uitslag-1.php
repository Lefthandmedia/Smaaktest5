<?php
require_once('../classes/db.class.php');
$db = new db_class;

// Open up the database connection. 

if (!$db->connect()) 
  $db->print_last_error(false);



if(isset($_POST['submit'])) {
foreach($_POST as $value){
print "<pre>";
print $value;
print "</pre>";
}
$locaties=array();

$rn = 1;

if($_POST['tag'] <> 0) {

	$sql = "SELECT
app_tags.tag,
app_locaties.id AS id,
app_locaties.locatie AS locatie
FROM
app_locaties
Inner Join app_locaties_tags ON app_locaties.id = app_locaties_tags.locatie_id
Inner Join app_tags ON app_locaties_tags.tag = app_tags.id


	WHERE app_locaties_tags.tag = '".$_POST['tag']."' AND actief = 1";
	} else {
	
			$sql = "SELECT
			
app_locaties.id AS id,
app_locaties.locatie AS locatie
FROM
app_locaties
Inner Join app_locaties_tags ON app_locaties.id = app_locaties_tags.locatie_id
Inner Join app_tags ON app_locaties_tags.tag = app_tags.id


	WHERE  actief = 1";
	
	}
		$r = mysql_query($sql);
			$aantal = mysql_num_rows($r);
				echo "aantal is: ". $aantal; 
					//echo $sql."<br /><br />";
		if($aantal == 0 ) { echo "Geen resultaten gevonden";} else{ 
			while ($row = mysql_fetch_assoc($r)) {
	        	$loc = "_".$row['id'];
			    	echo "id is: ". $row['id']. "- ". $row['tag'];
			
         	$sql2 = "SELECT AVG($loc) AS gemiddeld, app_stemmentotaal.user_id, 
	users.user_geb_datum, 
	users.id, 
	user_ervaring.ervaring, 
	user_postcode.postcodegebied, 
	user_samenstellingen.samenstelling, 
	user_auto.autobezit, 
	user_geslacht.geslacht, 
	users.user_opleiding, 
	user_opleidingen.opleiding
	
	FROM app_stemmentotaal
	
			INNER JOIN users ON app_stemmentotaal.user_id = users.id
	 		INNER JOIN user_ervaring ON users.user_ervaring = user_ervaring.id
	 		INNER JOIN user_postcode ON users.user_postcodegebied = user_postcode.id
	 		INNER JOIN user_samenstellingen ON users.user_samenstelling = user_samenstellingen.id
	 		INNER JOIN user_auto ON users.user_auto = user_auto.id
	 		INNER JOIN user_geslacht ON users.user_geslacht = user_geslacht.id
	 		INNER JOIN user_opleidingen ON users.user_opleiding = user_opleidingen.id
			
			
			
	 WHERE users.user_ervaring = '".$_POST['ervaring']."'
	 AND users.user_geb_datum > '".$_POST['minGebJaar']."'
	 AND users.user_geb_datum < '".$_POST['maxGebJaar']."'
	 AND users.user_postcodegebied = '".$_POST['postcode']."'
	 AND users.user_samenstelling = '".$_POST['samenstelling']."'
	 AND users.user_auto = '".$_POST['autobezit']."'
	 AND users.user_geslacht = '".$_POST['geslacht']."'
	 AND users.user_opleiding = '".$_POST['opleiding']."'
	 
	 
			" or die ("NO RESULTS");
					$r2 = mysql_query($sql2);
		 				//echo $sql2. "<br /><br />";
		  
      						while ($row2 = mysql_fetch_assoc($r2)) {
								
								array_push($locaties,array('locatie_id'=> $row['id'],
												'locatie_naam'=> $row['locatie'],
												'gemiddelde' => $row2['gemiddeld'],
												'tag' => $row['tag']
												));
												
								
								}
										}
							$locaties = subval_sort($locaties,'gemiddelde');
		
		
		
		print '<pre>';
		print_r($locaties);
		print '</pre>';
		
		echo "<table width=\"500\">";
		echo "<tr><td>Locatie</td><td>Cijfer</td></tr>";
		
		//for($i=0;$i<3;$i++)
		foreach($locaties as $value)
		{ 
		if($value['gemiddelde'] =="") { echo "<tr><td>".$value['locatie_naam']."</td><td>Geen cijfer gevonden</td></tr>"; } else {
		echo "<tr><td>".$value['locatie_naam']."</td><td>". str_replace(".",",",round($value['gemiddelde'],1))."</td></tr>"; }
		}
		
		echo "</table>";
		
		}
} else {		

?>
<br /><br />
<br />

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1">

<table width="100%" border="0">
  <tr>
    <td>Geslacht:</td>
    <td>&nbsp;<?php $db->radio_query("SELECT id, geslacht FROM user_geslacht",'geslacht'); ?></td>
  </tr>
  <tr>
    <td>Ervaring:</td>
    <td>&nbsp;<?php $db->pulldown_query("SELECT id, ervaring FROM user_ervaring",'ervaring'); ?></td>
  </tr>
  <tr>
    <td>Samenstelling:</td>
    <td>&nbsp;<?php $db->pulldown_query("SELECT id, samenstelling FROM user_samenstellingen",'samenstelling'); ?></td>
  </tr>
  <tr>
    <td>Postcode:</td>
    <td>&nbsp;<?php $db->pulldown_query("SELECT id, postcodegebied FROM user_postcode",'postcode'); ?></td>
  </tr>
  <tr>
    <td>Auto:</td>
    <td>&nbsp;<?php $db->checkbox_query("SELECT id,autobezit FROM user_auto",'auto'); ?></td>
  </tr>
  <tr>
    <td>Opleiding</td>
    <td>&nbsp;<?php $db->pulldown_query("SELECT id, opleiding FROM user_opleidingen",'opleiding'); ?></td>
  </tr>
  <tr>
    <td>tags</td>
    <td>&nbsp;<?php $db->pulldown_query("SELECT id, tag FROM app_tags",'tag'); ?></td>
  </tr>
  <tr>
    <td>Geboortejaar</td>
    <td>&nbsp; van <select name="minGebJaar">
        <?php
		for ($minyear = 1900; $minyear < date("Y"); $minyear++) {
		?>
        <option value="<?php echo $minyear; ?>"><?php echo $minyear; ?></option>
        <?php } ?>
        </select>
        tot <select name="maxGebJaar">
        <?php
		for ($maxyear = date("Y"); $maxyear > 1900; $maxyear--) {
		?>
        <option value="<?php echo $maxyear; ?>"><?php echo $maxyear; ?></option>
        <?php } ?>
        </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<input name="submit" type="submit" value="haal gegevens op" /></td>
  </tr>
</table>

        

</form>
<?php } ?>