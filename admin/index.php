<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/employees.php";
require_once __DIR__ . "/../templates/header-connexion.php";
?>

<div class="wrapper">

  <!-- connection  -->
  <section class="connection w-min sections" id="connection">
    <h1 class="header-titles">Connexion</h1>
    <!-- messages  -->
    <div id="form-message" class="my-3 mt-3 d-flex justify-content-center"></div>

    <div class="connection-wrapper w-min">

      <form method="POST" id="connectionForm">
        <div class="connection-form">

          <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="text" name="email" id="email" minlength="15" maxlength="40" placeholder="email@example.fr" autocomplete="off">
            <span class="error" id="email_err"> </span>
          </div>
          <div class="form-group">
            <label for="password">
              Mot de passe
            </label>
            <div class="input-group">
              <input type="password" name="password" id="password" class="form-control" minlength="8" maxlength="16" autocomplete="off">
              <div class="input-group-append">
                <span class="input-group-text" onclick="password_show_hide();">
                  <i class="fas fa-eye" id="show_eye"></i>
                  <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                </span>
              </div>
            </div>
            <span class="error" id="password_err"> </span>
          </div>
        </div>
        <div class="form-btn">
          <button type="button" id="submitbtn" class="btn-fill">Connecter</button>
        </div>

      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>
<script src="/assets/scripts/validationConnection.js"></script>