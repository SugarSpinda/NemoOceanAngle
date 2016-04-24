<?php
  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = 'your_passeord';
  $conn = mysql_connect($dbhost, $dbuser, $dbpass);
  $this_page = $_SERVER["SCRIPT_NAME"];

  if (!$conn) { die('Could not connect: ' . mysql_error()); }

  mysql_select_db('FISHING');
?>
