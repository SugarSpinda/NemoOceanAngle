<?php
  session_start();
  if($_SESSION['num'] == null) {
    echo "403 Forbid";
    exit();
  }

  include("mysql_connect.inc.php");

  if (isset($_POST['add']))
  {
    if (!get_magic_quotes_gpc())
    {
      $id = addslashes ($_POST['id']);
	  $type = addslashes ($_POST['type']);
	  $text = addslashes ($_POST['text']);
	  // $latitude = addslashes ($_POST['latitude']);
	  // $longitude = addslashes ($_POST['longitude']);
	  $private = addslashes ($_POST['private']);
    }
    else
    {
      $id = $_POST['id'];
      $type = $_POST['type'];
      $text = $_POST['text'];
      // $latitude = $_POST['latitude'];
      // $longitude = $_POST['longitude'];
      $private = $_POST['private'];
    }
      $latitude = 0;
      $longitude = 0;

      $sql = "INSERT INTO MAP ".
        "(id, latitude, longitude, uid, private) ".
        "VALUES ".
        "('$id', '$latitude', '$longitude', '".$_SESSION['num']."', '$private')";

      $retval = mysql_query($sql, $conn);
      if (!$retval) { die('Could not enter data: ' . mysql_error() . ', ' . $sql); }

      $sql = "INSERT INTO INFO ".
        "(id, type, text) ".
        "VALUES ".
        "('$id', '$type', '$text')";

      $retval = mysql_query($sql, $conn);
      if (!$retval) { die('Could not enter data: ' . mysql_error() . ', ' . $sql); }


  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <title>Add</title>

  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
  <meta http-equiv="description" content="This is my page">
  <link rel="stylesheet" type="text/css" href="/css/main.css">

  </head>

  <body>
    <div id="top_bar">
      <div id="left"><a href="manage.php"><div class="left_title">GPS Management System</div></a></div>
      <div id="right"><a href="index.php"><img src="home_btn.png"/></a></div>
    </div>
    <div id="main">
        <div id="viewtab">
        <form method="post" action="<?php $_PHP_SELF ?>" enctype="multipart/form-data">
        <div id="editlabal"><table width="100%" border="0">

        <tr>
        <td>New</td>
        <td></td>
        </tr>
        <tr>
          <td>ID</td>
          <td width="450"><input name="id" type="text" id="id" required/></td>
        </tr>
        <tr>
          <td>Type</td>
          <td>
          <select name="type">
            <option value="0">Lobster pot</option>
            <option value="1">Fishing net</option>
            <option value="2">Drift net</option>
            <option value="99">Boat</option>
          </select>
          </td>
          <!-- <td><input name="type" type="text" id="type" required/></td> -->
        </tr>
        <tr>
          <td>Description</td>
          <td><input name="text" type="text" id="text" required/></td>
        </tr>
        <!-- <tr> -->
          <!-- <td>Latitude</td> -->
          <!-- <td><input name="latitude" type="text" id="latitude" required/></td> -->
        <!-- </tr> -->
        <!-- <tr> -->
          <!-- <td>Longitude</td> -->
          <!-- <td><input name="longitude" type="text" id="longitude" required/></td> -->
        <!-- </tr> -->
        <tr>
          <td>Private</td>
          <td>
          <?php
            if ($row['private'] == 1) {
            	echo '<input type="radio" name="private" value="1" checked>Yes </input>';
            	echo '<input type="radio" name="private" value="0">No</input>';
            } else {
            	echo '<input type="radio" name="private" value="1">Yes </input>';
            	echo '<input type="radio" name="private" value="0" checked>No</input>';
            }
          ?>
          </td>
        </tr>
        </table></div>
          <div id="fab">
            <input name="add" type="submit" id="add" value="+">
          </div>
        </form>
      </div>
      </div>
    </div>
  </body>
</html>

<?php
  mysql_close($conn);
?>
