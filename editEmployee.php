<?php
  session_start();
  if($_SESSION['eid'] == null) {
    echo "403 Forbid";
    exit();
  }

  include("mysql_connect.inc.php");

  if (isset($_POST['update']))
  {
    if (!get_magic_quotes_gpc())
    {
      $eid = addslashes ($_POST['eid']);
      $name = addslashes ($_POST['name']);
      $store_num = addslashes ($_POST['store_num']);
      $commission_rate = addslashes ($_POST['commission_rate']);
    }
    else
    {
      $eid = $_POST['eid'];
      $name = $_POST['name'];
      $store_num = $_POST['store_num'];
      $commission_rate = $_POST['commission_rate'];
    }

    $sql = 'UPDATE EMPLOYEES SET name="'.$name.'", store_num='.$store_num.', '.
        'commission_rate='.$commission_rate.' WHERE EID='.$eid;

    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error()); }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">

    <title>Update Employee</title>

  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
  <meta http-equiv="description" content="This is my page">
  <link rel="stylesheet" type="text/css" href="/css/main.css">

  <script type="text/javascript">
  function delayer(){ window.location = "/manageEmployees.php?eid=<?php echo $eid; ?>" }
  </script>
  </head>

  </head>

      <body onLoad="setTimeout('delayer()', 3000)">
      <div id="main">
        <div id="dialog">
          <div id="content">
          <p>Update successfully</p>
          <p><a href="/manageEmployees.php?eid=<?php echo $eid; ?>">Prepare to be redirected in 3 seconds!</a></p>
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
  <title>Edit Employee</title>

  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
  <meta http-equiv="description" content="This is my page">
  <link rel="stylesheet" type="text/css" href="/css/main.css">

  </head>

  <body>
    <div id="main">
      <header id="masthead" role="banner">
      <nav id="access">
        <div class="menu">
          <ul>
            <?php include("menubar.inc.php"); ?>
          </ul>
        </div>
      </nav>
      </header>
      <br></br><p></p>
      <div id="content">
        <form method="post" action="<?php $_PHP_SELF ?>">
        <div id="editlabal"><table width="600" border="0">
<?php
    $sql = "SELECT * FROM EMPLOYEES WHERE EID=".$_GET['eid'];
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error()); }
    $row = mysql_fetch_assoc($retval);
?>
        <input name="eid" type="hidden" id="eid" value="<?php echo $_GET["eid"]; ?>" /></td>
        <tr>
          <td align="center">EID</td>
          <td><?php echo $_GET["eid"]; ?></td>
        </tr>
        <tr>
          <td width="200" align="center">Name</td>

          <td width="400"><input name="name" type="text" id="name" value="<?php echo $row['name']; ?>" required/></td>
        </tr>
        <tr>
          <td align="center">Store number</td>
          <td><input name="store_num" type="text" id="store_num" value="<?php echo $row['store_num']; ?>" required/></td>
        </tr>
        <tr>
          <td align="center">Commission rate</td>
          <td><input name="commission_rate" type="text" id="commission_rate" value="<?php echo $row['commission_rate']; ?>" required/></td>
        </tr>
        <tr><td><input name="update" type="submit" id="update" value="Update"></td></tr>
        </table></div>
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
