<?php
$failure = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connect.php';

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the user already exists using a prepared statement
    $checkUserQuery = "SELECT * FROM `registration` WHERE username = ?";
    $checkUserStmt = mysqli_prepare($conn, $checkUserQuery);
    mysqli_stmt_bind_param($checkUserStmt, "s", $username);
    mysqli_stmt_execute($checkUserStmt);
    $checkUserResult = mysqli_stmt_get_result($checkUserStmt);

    if (!$checkUserResult) {
        die("Error checking user: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($checkUserResult) > 0) {
        $failure = 1;
    } else {
        // Insert the new user using a prepared statement
        $insertUserQuery = "INSERT INTO `registration` (username, password) VALUES (?, ?)";
        $insertUserStmt = mysqli_prepare($conn, $insertUserQuery);
        mysqli_stmt_bind_param($insertUserStmt, "ss", $username, $hashedPassword);
        $insertUserResult = mysqli_stmt_execute($insertUserStmt);

        if (!$insertUserResult) {
            die("Error inserting user: " . mysqli_error($conn));
        }
        header("location: login.php");
    }

}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup page</title>
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
      
      .alert {
        margin-bottom: 20px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <?php
        if ($failure) {
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Failure!</strong> Sorry, the username already exists.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
      ?>
      <h1>Sign up with our website</h1>
      <form action="sign-up.php" method="post">  
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" placeholder="Enter a username" name="username">
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Enter a password" name="password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign up</button>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>