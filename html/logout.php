<?php
  session_start();
  unset($_SESSION['num']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <base href="<%=basePath%>">

  <title>Log Out</title>

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
<body onLoad="setTimeout('delayer()', 3000)">
  <div id="main">
    <div id="dialog">
      <div id="content">
        <p>Logout Successfully</p>
        <p><a href="/index.php">Prepare to be redirected in 3 seconds!</a></p>
      </div>
    </div>
  </div>
</body>
</html>
