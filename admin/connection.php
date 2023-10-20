<?php

require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/employees.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $error = false;

  //for security inputs
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $email = $password = '';

  $email = test_input($_POST['email']);
  $password = test_input($_POST['password']);


  //verify if user exist into database
  $user = verifyUserLogin($pdo, $email, $password);


  if ($user) {
    //replace the current session ID with a new one to stop session hijacking and session fixation.
    session_regenerate_id(true);
    $_SESSION['user'] = $user;

    //crypt POST password
    $password_hash = sha1($_POST['password']);

    //verify if email and password correspond to the user
    if ($email !== $user['email'] && $password_hash !== $user['password']) {
      echo '<div class="alert alert-danger m-0" role="alert">Email ou mot de passe incorrect nbadfasdfas</div>';
      $error = true;
      return;
    } else if ($email !== $user['email'] || $password_hash !== $user['password']) {
      echo '<div class="alert alert-danger m-0" role="alert">Email ou mot de passe incorrect.</div>';
      $error = true;
      return;
    }
    if (!$error) {
      if ($user['role'] === 'admin') {
        echo "<script> window.location = '/admin/liste-voitures.php';</script>";
      } else if ($user['role'] === 'employee') {
        echo "<script> window.location = '/admin/liste-voitures.php';</script>";
      } else {
        echo "<script> window.location = '/admin/';</script>";
        exit();
      }
    }
  } else {
    echo '<div class="alert alert-danger m-0" role="alert">Email ou mot de passe incorrect.</div>';
  }
}
