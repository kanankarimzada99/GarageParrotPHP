<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";

//prevent user to back to login page if is already connected
if(!empty($_SESSION)){

  if($_SESSION['user']['role'] === 'admin'){
    header('location:/admin/liste-employes.php');
  }else if($_SESSION['user']['role'] === 'employee'){
    header('location:/admin/liste-voitures.php');
  } else {
    header('location:/admin/index.php');
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Garage V. Parrot</title>

  <!-- favicon  -->
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/images/favicon/site.webmanifest">

  <!-- jquery  -->
  <!-- <link rel="stylesheet" href="../assets/scripts/jquery-ui.min.css">
  <script src="../assets/scripts/jquery-3.7.0.min.js"></script> -->

  <!-- BOOTSTRAP  -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- FONT AWESOME  -->
  <script src="https://kit.fontawesome.com/1a0b88a9d7.js" crossorigin="anonymous"></script>

  <!-- CSS  -->
  <!-- <link rel="stylesheet" href="./assets/css/override-bootstrap.css"> -->
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <div class="wrapper">
    <header class="header">
      <nav class="nav">
        <a class="logo" href="/">
          <img src="../assets/images/logo_car_title.png" alt="logo garage parrot">
        </a>
        <!-- HAMBURGER MENU  -->
        <div class="mobile-menu">
          <div class="line1"></div>
          <div class="line2"></div>
          <div class="line3"></div>
        </div>
        <ul class="nav-list">
          <li>
            <a href="/index.php" class="btn-wire">Accueil</a>
          </li>
        </ul>
      </nav>
    </header>
  </div>
  <main class="main">