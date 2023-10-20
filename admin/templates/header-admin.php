<?php
//ob_start() function will turn output buffering on. While output buffering is active no output is sent from the script (other than headers)
// ob_start();
require_once __DIR__ . "../../../lib/config.php";
require_once __DIR__ . "../../../lib/session.php";
require_once __DIR__ . "../../../lib/pdo.php";
require_once __DIR__ . "../../../lib/not-connected.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Garage V. Parrot</title>

  <!-- favicon  -->
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon/favicon-16x16.png">
  <link rel="manifest" href="/assets/images/favicon/site.webmanifest">

  <!-- jquery  -->

  <link rel="stylesheet" href="../assets/scripts/jquery-ui.min.css">
  <script src="../assets/scripts/jquery-3.7.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


  <!-- BOOTSTRAP  -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- FONT AWESOME  -->
  <script src="https://kit.fontawesome.com/1a0b88a9d7.js" crossorigin="anonymous"></script>

  <!-- CSS  -->
  <!-- <link rel="stylesheet" href="./assets/css/override-bootstrap.css"> -->
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <div class="wrapper">
    <header class="connection-header header">
      <div class="user-connection">
        <span>Bonjour</span>
        <span><?= $_SESSION['user']['name'] ?></span>
        <i class="fa-solid fa-user"></i>
      </div>
      <nav class="nav">
        <a class="logo" href="/">
          <img src="../assets/images/logo_car_title.png" alt="logo garage parrot">
        </a>

        <ul class="nav-list">
          <?php if ($_SESSION['user']['role'] === 'admin') : ?>
            <li>
              <a class="nav-link" aria-current="page" href="/admin/liste-employes.php">Employés</a>
            </li>
            <li>
              <a class="nav-link" href="/admin/liste-services.php">Services</a>
            </li>
            <li>
              <a class="nav-link" href="/admin/liste-horaires.php">Horaires</a>
            </li>
            <li>
              <a class="nav-link" href="/admin/liste-voitures.php">Voitures</a>
            </li>
            <li>
              <a class="nav-link" href="/admin/liste-avis.php">Avis</a>
            </li>

          <?php else : ?>
            <li>
              <a class="nav-link" href="/admin/liste-voitures.php">Voitures</a>
            </li>
            <li>
              <a class="nav-link" href="/admin/liste-avis.php">Avis</a>
            </li>
          <?php endif ?>
          <li>
            <a href="/admin/logout.php" class="btn-wire">Déconnecter</a>
          </li>
        </ul>

        <!-- HAMBURGER MENU  -->
        <div class="mobile-menu">
          <div class="line1"></div>
          <div class="line2"></div>
          <div class="line3"></div>
        </div>
      </nav>
    </header>
  </div>
  <main class="main">