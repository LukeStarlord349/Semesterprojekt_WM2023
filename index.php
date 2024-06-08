<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
  $isAdmin = isset($_COOKIE['adminCookie']) && $_COOKIE['adminCookie'] == true;

  // Überprüfe, ob der Benutzer eingeloggt ist
  if (isset($_SESSION['login'])) {
      $isLoggedIn = true;
      $username = $_COOKIE['username'];
  } else {
      $isLoggedIn = false;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Semesterprojet_Help_Style.css">
    <link rel="stylesheet" href="home/home.css">
  </head>
<body class="bg-light">
<?php include "includes/navbar.php";?>
<div class="min-vh-100">
  <?php include "content.php"?>
</div>
<?php include "includes/footer.php";?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>