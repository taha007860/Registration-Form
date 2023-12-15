<?php
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
      body {
        background-color: #f8f9fa;
        color: #343a40;
      }
      
      .container {
        max-width: 400px;
        margin-top: 50px;
      }
      
      h1 {
        text-align: center;
        margin-bottom: 30px;
      }
      
      .btn {
        display: block;
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
    <div class="container mt-5">
      <h1 class="text-center">Welcome <?php echo $_SESSION["username"]; ?></h1>
      <a href="logout.php" class="btn btn-primary">Logout</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>