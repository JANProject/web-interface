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
      
      checkPassword();
      
      if($_GET['date'] == '') {
        redirect('time.php?time=' . $_GET['time']);
      } else if($_GET['time'] == '') {
        redirect('date.php?date=' . $_GET['date']);
      }
      
      $result = get_datetime($_GET['date'], $_GET['time']);
    ?>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./">Lavatory Logger</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <form action="logout.php" class="navbar-form navbar-right" method="post">
            <button type="submit" class="btn btn-default">Log Out</button>
          </form>
        </div>
      </div>
    </nav>
    <div class="jumbotron">
      <div class="container">
        <h1><?php
          echo $_GET['date'] . ' ' . convertTo12Hour($_GET['time']);
        ?></h1>
      </div>
    </div>
    <div class="container">
      <form action="id.php" class="form-inline">
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><span class="fa fa-search" aria-hidden="true"></span></div>
            <input class="form-control" placeholder="Student ID" name="id">
          </div>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <form action="date.php" class="form-inline">
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><span class="fa fa-calendar" aria-hidden="true"></span></div>
            <input class="form-control" placeholder="Date" name="date" data-toggle="datepicker">
          </div>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Student ID</th>
            <th>Time Out</th>
            <th>Time In</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(mysqli_num_rows($result) == 0) {
              echo '<tr><td colspan="3">No Data Found</td></tr>';
            }
            
            while($row = $result -> fetch_assoc()) {
              echo '<tr><td>' . $row['id'] . '</td><td>' . parseTime($row['time_out'], true) . '</td><td>' . parseTime($row['time_in'], true) . '</td></tr>';
            }
          ?>
        </tbody>
      </table>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/datepicker.min.js"></script>
    <script>
      $('[data-toggle="datepicker"]').datepicker();
    </script>
  </body>
</html>