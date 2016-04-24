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
      $vendor_name = addslashes ($_POST['vendor_name']);
      $address = addslashes ($_POST['address']);
      $phone = addslashes ($_POST['phone']);
    }
    else
    {
      $vendor_name = $_POST['vendor_name'];
      $address = $_POST['address'];
      $phone = $_POST['phone'];
    }

    $vendor_name = urldecode($vendor_name);
    $sql = 'UPDATE VENDORS SET address="'.$address.'", phone="'.$phone.'" WHERE VENDOR_NAME="'.$vendor_name.'"';

    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error().' : '.$sql); }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">

    <title>Update Vendor</title>

  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
  <meta http-equiv="description" content="This is my page">
  <link rel="stylesheet" type="text/css" href="/css/main.css">

  <script type="text/javascript">
  function delayer(){ window.location = "/manageVendors.php" }
  </script>
  </head>

  </head>

      <body onLoad="setTimeout('delayer()', 3000)">
      <div id="main">
        <div id="dialog">
          <div id="content">
          <p>Update successfully</p>
          <p><a href="/manageVendors.php">Prepare to be redirected in 3 seconds!</a></p>
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
  <title>Edit Vendor</title>

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
    $vendor_name = $_GET["vendor_name"];
    $decode_vendor_name = urldecode($vendor_name);
    $sql = "SELECT * FROM VENDORS WHERE VENDOR_NAME='".$decode_vendor_name."'";
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error()); }
    $row = mysql_fetch_assoc($retval);
?>
        <input name="vendor_name" type="hidden" id="vendor_name" value="<?php echo $vendor_name; ?>" /></td>
        <tr>
          <td>Vendor name</td>
          <td><?php echo $decode_vendor_name; ?></td>
        </tr>
        <tr>
          <td width="140">Address</td>
          <td><input name="address" type="text" id="address" style="width:100%" value="<?php echo $row['address']; ?>" required/></td>
        </tr>
        <tr>
          <td>Phone</td>
          <td><input name="phone" type="text" id="phone" value="<?php echo $row['phone']; ?>" required/></td>
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
