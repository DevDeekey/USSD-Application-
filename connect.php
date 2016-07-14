/*
	Holla: DeetechApps [at] Gmail dot Com
	Twitter  @Devdeekey
*/

<?php
$con = mysql_connect("localhost","odwako","odwako");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("dbBooking", $con);
?>
