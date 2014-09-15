<?php
	require_once('classes/db.class.php');

  $db = new db_class;
  
  // Open up the database connection. 
  
  if (!$db->connect()) 
	$db->print_last_error(false);
  
  
  
  // inserten van de cijfers
  $data = array('_'.$_POST['locatie'].'' => $_POST['cijfer']);
  
  $rows = $db->update_array('app_stemmentotaal', $data, "user_id=".$_POST['sessie']."");
  if (!$rows) $db->print_last_error(false);
  
  
  // test afronden en xml aanmaken voor uitslag
  if(isset($_POST['afgerond']) == "true") {
	  
	echo "succes=einde&xml=";
 	echo "<scores>";
   	echo eindscore_totaal();
    echo eindscore_user_totaal(); 
	echo "</scores>";
	session_destroy();
  } else { 
  echo "succes=ok&xml=no";
  }
  
  ?>

