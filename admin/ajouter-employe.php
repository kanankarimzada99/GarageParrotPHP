<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/employees.php";
require_once __DIR__ . "/templates/header-admin.php";

$formEmployee = [
  'lastname' => '',
  'name' => '',
  'email' => '',
  'password' => '',
  'conf-password' => ''
];
?>


<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-employes.php">Revenir liste employé</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h1 class="header-titles">Ajouter employé</h1>

    <!-- messages  -->
    <div id="form-message" class="my-3 d-flex justify-content-center"></div>

    <div class="connection-wrapper">

      <form method="POST" id="addEmploye">
        <div class="connection-form">

          <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" minlength="3" maxlength="25" placeholder="Dupont" autocomplete="off">
            <span class="error" id="lastname_err"> </span>
          </div>
          <div class="form-group">
            <label for="name">Prénom</label>
            <input type="text" name="name" id="name" minlength="3" maxlength="25" placeholder="Guillaume" autocomplete="off">
            <span class="error" id="name_err"> </span>
          </div>

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
          <div class="form-group">
            <label for="cpassword">
              Confirm mot de passe
            </label>
            <div class="input-group">
              <input type="password" name="cpassword" id="cpassword" class="form-control" minlength="8" maxlength="16" autocomplete="off">
              <div class="input-group-append">
                <span class="input-group-text" onclick="cpassword_show_hide();">
                  <i class="fas fa-eye" id="cshow_eye"></i>
                  <i class="fas fa-eye-slash d-none" id="chide_eye"></i>
                </span>
              </div>
            </div>
            <span class="error" id="cpassword_err"> </span>
          </div>

        </div>
        <div class="form-btn">
          <button type="button" id="submitbtn" class="btn-fill">Ajouter</button>
        </div>

      </form>
    </div>
  </section>
</div>
<script src="../assets/scripts/validationEmployeForm.js"></script>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>