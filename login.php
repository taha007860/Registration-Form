<?php
$passFailure = 0;
$notFound = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connect.php';

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the user already exists using a prepared statement
    $checkUserQuery = "SELECT * FROM `registration` WHERE username = ?";
    $checkUserStmt = mysqli_prepare($conn, $checkUserQuery);
    mysqli_stmt_bind_param($checkUserStmt, "s", $username);
    mysqli_stmt_execute($checkUserStmt);
    $checkUserResult = mysqli_stmt_get_result($checkUserStmt);

    if (!$checkUserResult) {
        die("Error checking user: " . mysqli_stmt_error($checkUserStmt));
    }

    if (mysqli_num_rows($checkUserResult) > 0) {
        $user = mysqli_fetch_assoc($checkUserResult);
        $hashedPassword = $user['password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION["username"] = $username;
            header("location: home.php");
        } else {
            $passFailure = 1;
            
        }
    } else {
        $notFound = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login page</title>
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

    .signup-heading {
      text-align: center;
      margin-top: 20px;
      margin-bottom: 10px;
      font-size: 20px;
    }

    .signup-link {
      text-align: center;
      display: block;
      font-size: 16px;
      color: #0069d9;
      text-decoration: none;
      margin-bottom: 20px;
    }

    .signup-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php
      if ($passFailure) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Failure!</strong> Sorry, wrong password.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }

      if ($notFound) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Failure!</strong> Sorry, user not found.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
    ?>
    <h1>Log in to our website</h1>
    <form action="login.php" method="post">  
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" placeholder="Enter your username" name="username">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Enter your password" name="password">
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
      <h3 class="signup-heading">Don't have an account?</h3>
      <a href="sign-up.php" class="signup-link">Go to Signup page</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>