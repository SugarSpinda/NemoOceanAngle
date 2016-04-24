<?php
  include("mysql_connect.inc.php");
	$id = $_GET['id'];
    $sql = "SELECT * FROM MAP WHERE id=".$id;
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error()); }
    $row = mysql_fetch_assoc($retval);

    echo $row['latitude'].",".$row['longitude'];
  mysql_close($conn);
?>
