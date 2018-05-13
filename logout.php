<html>
  <head>
    <title>Lavatory Logger</title>
  </head>
  <body>
    <?php
      require("api/api.php");
      
      setcookie("auth", false);
      setcookie("session", false);
      redirect('login.php');
    ?>
  </body>
</html>