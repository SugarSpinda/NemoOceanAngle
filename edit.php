<?php
  session_start();
  header("Content-Type:text/html; charset=utf-8");
  if($_SESSION['num'] == null) {
    echo "403 Forbid";
    exit();
  }

  include("mysql_connect.inc.php");

  if (isset($_POST['update']))
  {
    if (!get_magic_quotes_gpc())
    {
      $id = addslashes ($_POST['id']);
	  $type = addslashes ($_POST['type']);
	  $text = addslashes ($_POST['text']);
	  $latitude = addslashes ($_POST['latitude']);
	  $longitude = addslashes ($_POST['longitude']);
	  $private = addslashes ($_POST['private']);
    }
    else
    {
      $id = $_POST['id'];
      $type = $_POST['type'];
      $text = $_POST['text'];
      $latitude = $_POST['latitude'];
      $longitude = $_POST['longitude'];
      $private = $_POST['private'];
    }

    $sql = 'UPDATE INFO SET type='.$type.
    ', text="'.$text.
    '" WHERE id='.$id;

    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error() . ', ' . $sql); }

    $sql = 'UPDATE MAP SET latitude='.$latitude.
    ', longitude='.$longitude.
    ', uid='.$_SESSION['num'].
    ', private='.$private.
    ' WHERE id='.$id;

    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error() . ', ' . $sql); }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">

    <title>Update</title>

  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
  <meta http-equiv="description" content="This is my page">
  <link rel="stylesheet" type="text/css" href="/css/main.css">

  <script type="text/javascript">
  function delayer(){ window.location = "/manage.php" }
  </script>
  </head>

  </head>

      <body onLoad="setTimeout('delayer()', 0)">
      <div id="main">
        <div id="dialog">
          <div id="content">
          <p>Update successfully</p>
          <p><a href="/manageStores.php">Prepare to be redirected in 1 seconds!</a></p>
        </div>
      </div>
    </div>
      </body>
</html>
<?php
  } else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <title>Edit</title>

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
        <form method="post" action="<?php $_PHP_SELF ?>">
        <div id="editlabal"><table width="100%" border="0">
<?php
	$id = $_GET['id'];
    $sql = "SELECT * FROM INFO WHERE id=".$id;
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error()); }
    $row = mysql_fetch_assoc($retval);
?>

        <tr>
        <td width="100">Update</td>
        <td></td>
        </tr>
        <tr>
          <td>ID</td>
          <td ><input name="id" type="text" id="id" value="<?php echo $id; ?>" required/></td>
        </tr>
        <tr>
          <td>Type</td>
          <td>
          <select name="type">
          <?php
            if ($row['type'] == 0) {
              echo '<option value="0" selected="selected">Lobster pot</option>';
            } else {
              echo '<option value="0">Lobster pot</option>';
            }

            if ($row['type'] == 1) {
              echo '<option value="1" selected="selected">Fishing net</option>';
            } else {
              echo '<option value="1">Fishing net</option>';
            }

            if ($row['type'] == 2) {
              echo '<option value="2" selected="selected">Drift net</option>';
            } else {
              echo '<option value="2">Drift net</option>';
            }

            if ($row['type'] == 99) {
              echo '<option value="99" selected="selected">Boat</option>';
            } else {
              echo '<option value="99">Boat</option>';
            }
          ?>
          </select>
          </td>
        </tr>
        <tr>
          <td>Description</td>
          <td><input name="text" type="text" id="text" value="<?php echo $row['text']; ?>" required/></td>
        </tr>

<?php
    $sql = "SELECT * FROM MAP WHERE id=".$id;
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error()); }
    $row = mysql_fetch_assoc($retval);
?>
        <tr>
          <td>Latitude</td>
          <td><input name="latitude" type="text" id="latitude" value="<?php echo $row['latitude']; ?>" required/></td>
        </tr>
        <tr>
          <td>Longitude</td>
          <td><input name="longitude" type="text" id="longitude" value="<?php echo $row['longitude']; ?>" required/></td>
        </tr>
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
        </tr>
        </table></div>
          <div id="fab">
            <input name="update" type="submit" id="update" value="√ ">
          </div>
        </form>

      </div>
      </div>
    </div>
  </body>
</html>

<?php
  }

  mysql_close($conn);
?>
