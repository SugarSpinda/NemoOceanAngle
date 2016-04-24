<?php
  include("mysql_connect.inc.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <title>Public</title>

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

        <form method="get" action="<?php $_PHP_SELF ?>">
        <div id="viewtab"><table width="100%" border="0">
<?php
  $sql = "select M.*, I.type, I.text FROM MAP M, INFO I where M.private=0 GROUP BY M.id";
  include("page_number.inc.php");
?>
        <tr>
          <td width="50">ID</td>
          <td>Type</td>
          <td>Description</td>
          <td>Last update</td>
        </tr>
<?php
  $sql = $sql." ORDER BY update_date LIMIT ".$offset.",".$items_per_page;
  $retval = mysql_query($sql, $conn);
  if (!$retval) { die('Could not enter data: ' . mysql_error()); }

  while ($row = mysql_fetch_assoc($retval))
  {
    $id = $row["id"];
    echo "<tr><td>".$id."</td>";
    echo "<td>".$row["type"]."</td>";
    // echo "<td><img src=\"/movieThumbnail.php?show=&vid=".$vid."&stock_num=".$stock_num."\"/></td>";
    echo "<td>".$row["text"]."</td>";
    echo "<td>".$row["update_date"]."</td>";
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
    </div>
    </div>
  </body>
</html>

<?php
  mysql_close($conn);
?>
