<?php
  session_start();
  include("mysql_connect.inc.php");

  $is_login_fail = 0;
  $login_result = 0;

  if (isset($_POST['name'])) {
    if (!get_magic_quotes_gpc())
    {
      $name = addslashes ($_POST['name']);
    }
    else
    {
      $name = $_POST['name'];
    }

    $sql = 'SELECT num FROM USER WHERE name="'.$name.'" LIMIT 1';
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error() . ', ' . $sql); }

    $login_result = mysql_num_rows($retval);

    if ($login_result == 1) {
      $row = mysql_fetch_assoc($retval);
      $_SESSION['num'] = $row['num'];
    } else {
      $is_login_fail = 1;
    }
  }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <base href="<%=basePath%>">

  <title>Employee Log In</title>

  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
  <meta http-equiv="description" content="This is my page">
  <link rel="stylesheet" type="text/css" href="/css/main.css">

  <script type="text/javascript">
  function delayer(){ window.location = "/index.php" }
  </script>

</head>
<?php
if($_SESSION['num'] != null) {
  echo '<body onLoad="setTimeout(\'delayer()\', 3000)">';
} else {
  echo '<body>';
}
?>
  <div id="main">
    <div id="dialog">
      <div id="content">
<?php
      if($_SESSION['num'] != null) {
        if ($login_result == 0) {
          echo "<p>Already login</p>";
        } else {
          echo "<p>Login successfully</p>";
        }
        echo '<p><a href="/index.php">Prepare to be redirected in 3 seconds!</a></p>';
      } else {
?>
      <div class="editlabal">
      <form method="post" action="elogin.php">
      <table>
        <tr>
          <td width="110">name</td>
          <td><input type="text" name="name"></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" name="password"></td>
        </tr>
        <tr>
          <td><input type="submit" value="Log In"></td>
        </tr>
<?php
      if ($is_login_fail == 1) {
        echo '<tr><td>Try Again</td></tr>';
      }
?>
      </table>
      </form>
      </div>
<?php
      }
?>
    </div>
   </div>
  </div>
</body>
</html>

<?php
  mysql_close($conn);
?>
