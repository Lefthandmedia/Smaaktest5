<?php
require_once('../classes/db.class.php');
$db = new db_class;

// Open up the database connection. 

if (!$db->connect()) 
  $db->print_last_error(false);
include('header.php');?>


<form action="handlers/processFiles.php" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="10">
  <tr>
    <td width="139">Locatie:</td>
    <td width="151"><input name="locatie" type="text" size="60" /></td>
  </tr>
  <tr>
    <td>Thumbnail:</td>
    <td><input name="thumb" type="file" style="width:500px" size="60"/></td>
  </tr>
      <?
  // start of dynamic form
 
  for($x=0;$x<1;$x++){
  ?>
  <tr>
  <td>Foto<?php echo $x+1; ?></td><td>
    <input name="photo<? echo $x;?>" type="file" id="photo<? echo $x; ?>" style="width:500px" size="60">
  
  </td>
  </tr>
  <?php } // end of for loop  ?>
 
  <tr>
  <td>Tags:</td><td><?php $db->pulldown_query_tags("SELECT * FROM app_tags"); ?></td></tr>
  <input name="uploadNeed" type="hidden" value="1" />



    <tr><td>Activeer locatie</td><td><input name="actief" type="checkbox" value="1" checked /></td>
  <tr><td>&nbsp;</td><td><input name="Submit" type="submit" value="Locatie aanmaken" /></td></tr>
</table>

</form>

<?php  
include('footer.php');
?>

