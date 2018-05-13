<html>
  <head>
    <title>Lavatory Logger</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/datepicker.min.css" />
    <meta charset="utf-8" />
    <!--Icons-->
    <script defer src="js/fontawesome-all.min.js"></script>
  </head>
  <body>
    <?php
      require("settings.php");
      require("api/api.php");
    
      global $websitePassword;
      $enteredPass = $_POST['password'];
      $classes = "";
      $label = "";
      
      if(isset($enteredPass)) {
        if($enteredPass == $websitePassword) {
          setcookie("auth", true);
          $classes = "has-success has-feedback";
          redirect('index.php');
          return;
        } else {
          $classes = " has-error has-feedback";
          $label = '<label class="control-label" for="incorrect-password">Incorrect password</label>';
        }
      }
      
      if(isset($_COOKIE['auth']) && $_COOKIE['auth'] == true) {
        redirect('index.php');
        return;
      }
      
      setcookie("auth", false);
    ?>
    <div class="jumbotron">
      <div class="container">
        <h1>Lavatory Logger</h1>
      </div>
    </div>
    <div class="container">
      <form action method="post" class="form">
        <div class="form-group<?php echo $classes; ?>">
          <?php
            echo $label;
          ?>
          <div class="input-group">
            <div class="input-group-addon"><span class="fa fa-search" aria-hidden="true"></span></div>
            <input class="form-control" placeholder="Password" name="password" type="password">
          </div>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>