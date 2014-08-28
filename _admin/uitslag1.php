<?php
require_once('../classes/db.class.php');
require_once('../classes/ralph.php');
$db = new db_class;

// Open up the database connection. 

if (!$db->connect()) 
  $db->print_last_error(false);



if(isset($_POST['submit'])) {

/*
foreach($_POST as $value){
    print "<pre>";
    print $value;
    print "</pre>";
}
 *
 */


$filterString = "";
$locaties=array();

//----------------------------------
$postcodeGebieden = array();
$pcSQL = "SELECT * FROM user_postcode";

$pcResult = mysql_query($pcSQL);

while($pcRows = mysql_fetch_array($pcResult))
{
    $postcodeGebieden[$pcRows['id']] = $pcRows['postcodegebied'];
}
//----------------------------------
//----------------------------------
$ervaringen = array();
$ervaringSQL = "SELECT * FROM user_ervaring";

$ervaringResult = mysql_query($ervaringSQL);

while($ervaringRows = mysql_fetch_array($ervaringResult))
{
    $ervaringen[$ervaringRows['id']] = $ervaringRows['ervaring'];
}
//----------------------------------
//----------------------------------
$samenstellingen = array();
$samenstellingSQL = "SELECT * FROM user_samenstellingen";

$samenstellingResult = mysql_query($samenstellingSQL);

while($samenstellingRows = mysql_fetch_array($samenstellingResult))
{
    $samenstellingen[$samenstellingRows['id']] = $samenstellingRows['samenstelling'];
}
//----------------------------------
//----------------------------------
$gesl = array();
$geslSQL = "SELECT * FROM user_geslacht";

$geslResult = mysql_query($geslSQL);

while($geslRows = mysql_fetch_array($geslResult))
{
    $gesl[$geslRows['id']] = $geslRows['geslacht'];
}
//----------------------------------
//----------------------------------
$autobezit = array();
$autobezitSQL = "SELECT * FROM user_auto";

$autobezitResult = mysql_query($autobezitSQL);

while($autobezitRows = mysql_fetch_array($autobezitResult))
{
    $autobezit[$autobezitRows['id']] = $autobezitRows['autobezit'];
}
//----------------------------------
//----------------------------------
$opleidingen = array();
$opleidingenSQL = "SELECT * FROM user_opleidingen";

$opleidingenResult = mysql_query($opleidingenSQL);

while($opleidingenRows = mysql_fetch_array($opleidingenResult))
{
    $opleidingen[$opleidingenRows['id']] = $opleidingenRows['opleiding'];
}
//----------------------------------

$rn = 1;
if($_POST['tag'] <> 0) {

$locatieSQL = "SELECT
                app_tags.tag,
                app_locaties.id AS id,
                app_locaties.locatie AS locatie,
                app_locaties.thumb AS thumb
               FROM
                app_locaties
                Inner Join app_locaties_tags ON app_locaties.id = app_locaties_tags.locatie_id
                Inner Join app_tags ON app_locaties_tags.tag = app_tags.id
               WHERE
                app_locaties_tags.tag = '".$_POST['tag']."' AND actief = 1";

}
/*
else{
    $locatieSQL = "SELECT
                    app_locaties.id as id,
                    app_locaties.locatie AS locatie,
                    app_locaties.thumb AS thumb 
                   FROM app_locaties";
}
*/
$locatieResult = mysql_query($locatieSQL);

while($row = mysql_fetch_array($locatieResult))
{
    $cijferArray = array();

    for($i=0; $i <=10; $i++)
    {
        array_push($cijferArray, 0);
    }

    $locaties[$row['id']] = array('locatie' => $row['locatie'],
                                   'thumb'  => $row['thumb'],
                                  'cijferlijst' => $cijferArray);
}
		
		$joinSQL = " INNER JOIN users ON app_stemmentotaal.user_id = users.id ";
		$filterSQL = "";
        
        if($_POST['ervaring'] && $_POST['ervaring'] != "")
        {
            $joinSQL .= " INNER JOIN user_ervaring        ON users.user_ervaring = user_ervaring.id ";
			$filterSQL .= " AND users.user_ervaring = '".$_POST['ervaring']."' ";
            $filterString .= "ervaring is ". $ervaringen[$_POST['ervaring']] .", <br> ";
        }

        if($_POST['minGebJaar'] && $_POST['minGebJaar'] != "")
        {
            
			$filterSQL .= " AND users.user_geb_datum > '".$_POST['minGebJaar']."' ";
            $filterString .= "geboortejaar van  " . $_POST['minGebJaar'] .", ";
        }

        if($_POST['maxGebJaar'] && $_POST['maxGebJaar'] != "")
        {
            $filterSQL .= " AND users.user_geb_datum < '".$_POST['maxGebJaar']."' ";
            $filterString .= "geboortejaar tot is " . $_POST['maxGebJaar'] .", <br>";
        }

        if($_POST['postcode'] && $_POST['postcode'] != "")
        {
            $joinSQL .= " INNER JOIN user_postcode        ON users.user_postcodegebied = user_postcode.id ";
			$filterSQL .= " AND users.user_postcodegebied = '".$_POST['postcode']."' ";
            $filterString .= "postcodegebied is " . $postcodeGebieden[$_POST['postcode']] .", <br>";
        }

        if($_POST['samenstelling'] && $_POST['samenstelling'] != "")
        {
              
			$joinSQL .= " INNER JOIN user_samenstellingen ON users.user_samenstelling = user_samenstellingen.id ";
			$filterSQL .= " AND users.user_samenstelling = '".$_POST['samenstelling']."' ";
            $filterString .= "samenstelling is " . $samenstellingen[$_POST['samenstelling']] .", <br>";
        }

        if($_POST['autobezit'] && $_POST['autobezit'] != "")
        {
            $joinSQL .= " INNER JOIN user_auto ON users.user_auto = user_auto.id ";
			$filterSQL .= " AND users.user_auto = '".$_POST['autobezit']."' ";
            $filterString .= "autobezit is " . $autobezit[$_POST['autobezit']] .", <br>";
        }

        if($_POST['geslacht'] && $_POST['geslacht'] != "")
        {
            $joinSQL .= " INNER JOIN user_geslacht        ON users.user_geslacht = user_geslacht.id ";
			$filterSQL .= " AND users.user_geslacht = '".$_POST['geslacht']."' ";
            $filterString .= "geslacht is " . $gesl[$_POST['geslacht']] .", <br>";
        }

        if($_POST['opleiding'] && $_POST['opleiding'] != "")
        {
             $joinSQL .= " INNER JOIN user_opleidingen     ON users.user_opleiding = user_opleidingen.id ";
			 $filterSQL .= " AND users.user_opleiding = '".$_POST['opleiding']."' ";
            $filterString .= "opleiding is " . $opleidingen[$_POST['opleiding']] .", <br>";
        }


        $filterString = substr($filterString, 0, strlen($filterString)-2);
		
//-----------------------------------

$totalSQL = "SELECT * FROM app_stemmentotaal ". $joinSQL . " WHERE 1 ". $filterSQL ;

//----------------------------------
		
		
		


$filterResult = mysql_query($totalSQL) or die(mysql_error());


$filterResultArray = array();

while ($row2 = mysql_fetch_assoc($filterResult))
{
    foreach ($row2 as $col => $value)
    {
        
        if(substr($col, 0, 1) == "_")
        {
            $locatieId = substr($col,1);
            $locaties[$locatieId]['cijferlijst'][$value]++;
        }
    }
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Haarlem Smaaktest</title>
    <link href="_css/uitslag.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF">

<div id='wrapper'>

<br />
    <table width="400" align="center" cellpadding="5" cellspacing="2" bordercolor="#FFFFFF"> 
        <tr>
          <td colspan="15" style='padding-top:15px;padding-botttom:0px;'><input type="hidden" name="id" value="1" />
              Gefilterd op basis van: <?=$filterString?></td>
        </tr>
        <tr> 
          <td >&nbsp;</td> 
          <td colspan="14" bgcolor="#D6605C">Aantal stemmen per foto</td> 
        </tr> 
        <tr> 
          <td align="center">&nbsp;</td> 
          <td align="center">Foto</td> 
          <td align="center" style='background-color:#9C0606'>0</td> 
          <td align="center" bgcolor="#0000FF">1</td> 
          <td align="center" style='background-color:#E3412C'>2</td> 
          <td align="center">3</td> 
          <td align="center" style='background-color:#E3412C'>4</td> 
          <td align="center">5</td> 
          <td align="center" style='background-color:#E3412C'>6</td> 
          <td align="center">7</td> 
          <td align="center" style='background-color:#E3412C'>8</td> 
          <td align="center">9</td> 
          <td align="center" style='background-color:#E3412C'>10</td> 
          <td align="center">Totaal</td> 
          <td align="center">Gemiddeld</td> 
        </tr> 
        

<?
$rowIndex = 0;
foreach($locaties as $locatie)
{

    $totaal         = 0;
    $totaalStemmen  = 0;
    $gemiddeld      = 0;


    for($i=0; $i<=10;$i++)
    {
        $totaalStemmen += $locatie['cijferlijst'][$i];

        $totaal += $i * $locatie['cijferlijst'][$i];
    }

    if($totaalStemmen == 0){
        $gemiddeld = 0;
 			}else{
  		$gemiddeld = $totaal / $totaalStemmen; 
 }

    if($rowIndex % 2)
    {
        $rowStyle = "class='alternate'";
    }
    $rowIndex++;
?>
        <tr <?=$rowStyle?>>
          <td class="overzicht_table"><div align="left"><?=$locatie['locatie']?></div></td>
          <td class="overzicht_table"><img src="../uploads/<?=$locatie['thumb']?>" width="100"  border="0" /></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][0]?></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][1]?></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][2]?></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][3]?></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][4]?></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][5]?></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][6]?></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][7]?></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][8]?></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][9]?></td>
          <td class="overzicht_table"><?=$locatie['cijferlijst'][10]?></td>
          <td class="overzicht_table"><?=$totaalStemmen?></td>
          <td class="overzicht_table"><?=round($gemiddeld, 1)?></td>
        </tr>
<?

}

?>

    </table>
</div>
<?
/*
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
 *
 *
 */
} else {		

?>
<br />
<?php echo "Deze test is <strong>" .count_test(). "</strong> gedaan"; ?><br />
Huidige Top 3: 
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
    <td>&nbsp;<?php $db->checkbox_query("SELECT id,autobezit FROM user_auto",'autobezit'); ?></td>
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
<?php makevotelist();?>

</body>
</html>