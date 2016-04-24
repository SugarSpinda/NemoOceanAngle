<?php
  include("mysql_connect.inc.php");

    if (!get_magic_quotes_gpc())
    {
      $id = addslashes ($_POST['id']);
	  $latitude = addslashes ($_POST['latitude']);
	  $longitude = addslashes ($_POST['longitude']);
    }
    else
    {
      $id = $_POST['id'];
      $latitude = $_POST['latitude'];
      $longitude = $_POST['longitude'];
    }

    $sql = 'UPDATE MAP SET latitude='.$latitude.
    ', longitude='.$longitude.
    ' WHERE id='.$id;

    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error() . ', ' . $sql); }

    $sql = "SELECT * FROM MAP WHERE id=".$id;
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error().", ".$sql); }
    $row = mysql_fetch_assoc($retval);

  echo "OK, update: id=".$id.", latitude=".$latitude.", longitude=".$longitude;

  mysql_close($conn);
?>
