<?php
  require_once('../classes/db.class.php');
  $db = new db_class;
  
  // Open up the database connection. 
  
  if (!$db->connect())
      $db->print_last_error(false);
  include('header.php');
  
  if($_POST['doit']) {
	  
	$data = array('tag' => $_POST['tag']);
$rows = $db->update_array('app_tags', $data, "id=".$_POST['id']."");
  }
  
  
  
  $taak = $_REQUEST['action'];
  
  if ($taak == "edit") {
	  
      $sql = "SELECT * FROM app_tags WHERE id = '" . $_GET['id'] . "'";
      $r = mysql_query($sql);
      while ($row = mysql_fetch_assoc($r)) {
		  
          echo "<h1>Bewerk</h1><br />";
          echo "<form name=\"edittag\" action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" >";
          echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" >";
          echo "<input type=\"text\" name=\"tag\" value=\"" . $row['tag'] . "\" >";
          echo "<input type=\"submit\" name=\"doit\" Value=\"Verstuur\" >";
          echo "</form>";
      }
  }
  
  if ($taak == "delete") {
      $sql = "DELETE FROM app_tags WHERE id='" . $_GET['id'] . "' ";
      $r = mysql_query($sql);
  }
  
  if (isset($_POST['submit'])) {
      $data = array('tag' => $_POST['tag']);
      $id_loc = $db->insert_array('app_tags', $data);
  }
  
  $db->dump_query("SELECT * FROM app_tags");
?>


  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <input name="tag" type="text" />
  <input name="submit" type="submit" value="Toevoegen" />
  </form>


  <?php
  include('footer.php');
?>
