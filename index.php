<html>
  <head>
    <title>Lavatory Logger</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
    <meta charset="utf-8" />
    <!--Icons-->
    <script defer src="js/fontawesome-all.min.js"></script>
  </head>
  <body>
    <?php
      require('settings.php');
      require('api/api.php');
      
      checkPassword();
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
          <a class="navbar-brand" href="#">Lavatory Logger</a>
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
        <h1>Lavatory Logger</h1>
      </div>
    </div>
    <div class="main container">
      <label>Student Lookup</label>
      <form action="id.php" class="form-inline">
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><span class="fa fa-search" aria-hidden="true"></span></div>
            <input class="form-control" placeholder="Student ID" name="id" required="true">
          </div>
        </div>
        <button type="submit" class="btn btn-default" id="id-btn">Submit</button>
      </form>
      <p>See when a student was in the bathroom</p>
      <label>Date and Time Lookup</label>
      <form action="datetime.php" class="form-inline">
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><span class="fa fa-calendar" aria-hidden="true"></span></div>
            <input class="form-control" placeholder="Date" name="date" type="date" required="true">
          </div>
          <div class="input-group">
            <div class="input-group-addon"><span class="fa fa-clock" aria-hidden="true"></span></div>
            <input class="form-control" placeholder="Time" name="time" type="time" >
          </div>
        </div>
        <button type="submit" class="btn btn-default" id="datetime-btn">Submit</button>
      </form>
      <p>See who was in the bathroom on a certain day (and time)</p>
      <p>Leave time empty to search through the whole day</p>
    </div>
    <footer>
      <div class="container">
        <div class="col-sm-10 text">
          <p>Made with <span class="fa fa-heart fa-lg" aria-hidden="true"></span><span class="sr-only">love</span> by Jacob, Avi, Nick, and Jack</p>
        </div>
        <div class="col-sm-2 icons">
          <a href="https://github.com/JANProject">
            <span class="fa-stack fa-lg">
              <span class="fa fa-circle fa-stack-2x"></span>
              <span class="fab fa-github fa-stack-1x"></span>
            </span>
            <span class="sr-only">GitHub</span>
          </a>
        </div>
      </div>
    </footer>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>