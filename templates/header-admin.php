<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Garage V. Parrot</title>

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
    <header class="connection-header header">
      <div class="user-connection">
        <span>Vicent</span>
        <i class="fa-solid fa-user"></i>
      </div>
      <nav class="nav">
        <a class="logo" href="/">
          <img src="../assets/images/logo_car_title.png" alt="logo garage parrot">
        </a>

        <ul class="nav-list">
          <li>
            <a class="nav-link" aria-current="page" href="/connexion/liste-employes.php">Employés</a>
          </li>
          <li>
            <a class="nav-link" href="/connexion/liste-services.php">Services</a>
          </li>
          <li>
            <a class="nav-link" href="/connexion/liste-horaires.php">Horaires</a>
          </li>
          <li>
            <a class="nav-link" href="/connexion/liste-veicules.php">Veicules</a>
          </li>
          <li>
            <a class="nav-link" href="/connexion/liste-avis.php">Avis</a>
          </li>
          <li>
            <a href="#" class="btn-wire">Deconnecter</a>
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