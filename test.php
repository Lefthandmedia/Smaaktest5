<?php
	require_once('classes/db.class.php');
  $db = new db_class;
  
  // Open up the database connection. 
  
  if (!$db->connect()) 
	$db->print_last_error(false);
  
  // functie om de array te sorteren
/*  function subval_sort($a,$subkey) {
	  foreach($a as $k=>$v) {
		  $b[$k] = $v[$subkey];
	  }
	  asort($b);
	  foreach($b as $key=>$val) {
		  $c[$key] = $a[$key];
	  }
	  return $c;
  }	
*/ 
function subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	arsort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}
  
  // test afronden en xml aanmaken voor uitslag
 
  
  
  $locaties=array();
  echo "succes=einde&xml=<eindscore>";
  $rn = 1;
	  $sql = "SELECT * FROM app_locaties WHERE actief = 1";
		  $r = mysql_query($sql);
	  
	  while ($row = mysql_fetch_assoc($r)) {
			   $loc = "_".$row['id'];
				  
			  
			  $sql2 = "SELECT AVG($loc) AS gemiddeld FROM app_stemmentotaal"; 
					  $r2 = mysql_query($sql2);
						  echo $sql2;
			   
							  while ($row2 = mysql_fetch_assoc($r2)) {
								  
			  array_push($locaties,array('locatie_id'=>$row['id'],
												  'locatie_naam'=> $row['locatie'],
												  'gemiddelde' => $row2['gemiddeld'],1,
												  'thumb' => $row['thumb']
												  ));
															  
			  
	  }
		  }
		  $SORTlocaties = subval_sort($locaties,'gemiddelde');
		  print '<pre>';
		  print($SORTlocaties[0]['gemiddelde'].' ., ');
		  print($SORTlocaties[1]['gemiddelde'].' ., ');
		  print($SORTlocaties[2]['gemiddelde']);
		  print '</pre>';
		  
		  for($i=0;$i<3;$i++)
		  {
		  print $i;
		  
		  echo "<item id='".$rn++."'><naam><![CDATA[".$locaties[$i]['locatie_naam']."]]></naam><cijfer><![CDATA[".str_replace(".",",",round($locaties[$i]['gemiddelde'],1))."]]></cijfer><image src='".$locaties[$i]['thumb']."' /></item>";
		  
		  }
  echo"</eindscore>";
  
	  
  

  
  ?>

