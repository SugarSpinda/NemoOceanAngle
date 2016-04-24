<?php
  session_start();
  if($_SESSION['num'] == null) {
    echo "403 Forbid";
    exit();
  }

  include("mysql_connect.inc.php");

  if (isset($_GET['del']))
  {
    if (!get_magic_quotes_gpc())
    {
      $id = addslashes ($_GET['id']);
    }
    else
    {
      $id = $_GET['id'];
    }

    $sql = "DELETE FROM MAP WHERE id=".$id;
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error()); }

    $sql = "DELETE FROM INFO WHERE id=".$id;
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error()); }
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <title>Manage</title>

  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
  <meta http-equiv="description" content="This is my page">
  <link rel="stylesheet" type="text/css" href="/css/main.css">
  </head>
  <body>
    <div id="top_bar">
      <div id="left"><a href="index.php"><div class="left_title">GPS Management System</div></a></div>
      <div id="right"><a href="index.php"><img src="home_btn.png"/></a></div>
    </div>
    <div id="main">
        <div id="viewtab">
<?php
  $sql = "select * FROM MAP M, INFO I where M.uid=".$_SESSION['num']." AND M.id=I.id GROUP BY M.id";
  include("page_number.inc.php");
?>
    <table width="100%" border="0">
        <tr>
          <td width="50">ID</td>
          <td>Type</td>
          <!-- <td>Last update</td> -->
          <td>DEL.</td>
          <td>Edit</td>
        </tr>
<?php
  $sql = $sql." ORDER BY I.update_date LIMIT ".$offset.",".$items_per_page;
  $retval = mysql_query($sql, $conn);
  if (!$retval) { die('Could not enter data: ' . mysql_error()); }

  while ($row = mysql_fetch_assoc($retval))
  {
    $id = $row["id"];

    if ($row['type'] == 0) {
      $type = "Lobster pot";
    } else if ($row['type'] == 1) {
      $type = "Fishing net";
    } else if ($row['type'] == 2) {
      $type = "Drift net";
    } else {
      $type = "Boat";
    }

    echo "<tr><td>".$id."</td>";
    echo "<td>".$type."</td>";
    // echo "<td><img src=\"/movieThumbnail.php?show=&vid=".$vid."&stock_num=".$stock_num."\"/></td>";
    // echo "<td>".$row["update_date"]."</td>";
    echo "<td><a href=\"".$this_page."?del=&id=".$id."\">";
    echo "<img width=\"16\" height=\"16\" src=\"/delete.png\" />";
    echo "</a></td><td><a href=\"edit.php?id=".$id."\">";
    echo "<img width=\"16\" height=\"16\" src=\"/edit.png\" /></a></td></tr>";
    echo "</tr>";
  }
?>

        </table></div>
        </form>
      </div>
          <div id="fab">
            <div id="fab_text"><a href="add.php">+</a></div>
          </div>
    </div>

  </body>
</html>

<?php
  mysql_close($conn);
?>
