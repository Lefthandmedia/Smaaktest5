<?php 



function makevotelist(){
	$amt_of_locs = 70 ;
	$stemverdeling = array();
	
	
	for($i=0; $i<=35; $i++){
		$stemverdeling[$i] = 0 ;
	}
	
	// haal  *  op uit stemmen totaal
	$locatieSQL = "SELECT * FROM app_stemmentotaal";
	
	$totaalstemmen = mysql_query($locatieSQL) or die(mysql_error());
	
	while ($row = mysql_fetch_assoc($totaalstemmen)){
		$c = checkVotes($row);
		$amt++;
		//echo $c ."<br>";
		$stemverdeling[$c] ++;
		}
		
		
	// RESULTAAT
	$t_header = "<table width='100%' border='1' cellspacing='1' cellpadding='1'> <tr>";
	$t_top = "<td>aantal foto's</td>";
	$t_bottom = "</tr><tr><td>aantal stemmers</td>";
	$t_footer = " </tr></table>";
	
	
	for($i=0; $i<= $amt_of_locs; $i++){
		$n = ($stemverdeling[$i] == '') ? 0 : $stemverdeling[$i];
		$t_top .= "<td>". $i ."</td>";
		$t_bottom .= "<td>".$n."</td>";

	}
	echo $t_header.$t_top.$t_bottom.$t_footer;
}


function checkVotes($r){
	
	$row = $r;
	$votes = 0;
	
	//loop door de velden van de row
	 foreach ($row as $col => $value){
        if(substr($col, 0, 1) == "_"){
			if($value != null){
				$votes ++;
			}
        }
   	}
	// return op hoeveel foto's deze stemmer heeft gestemd
	return $votes;
}
  

?>