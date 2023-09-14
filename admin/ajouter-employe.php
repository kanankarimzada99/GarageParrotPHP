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

$employee = 'employee';

?>

<!-- send message by form  -->
<script>
  $(document).ready(function() {
    $("form").submit(function(event) {
      event.preventDefault();
      var lastName = $("#lastname").val();
      var name = $("#name").val();
      var email = $("#email").val();
      var password = $("#password").val();
      var confPassword = $("#conf-password").val();
      var submit = $("#submit").val();

      $(".form-message").load('ajouterEmployeeForm.php', {
        lastName: lastName,
        name: name,
        email: email,
        password: password,
        confPassword: confPassword,
        submit: submit
      });
    })
  })
</script>

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
    <div class="form-message">
    </div>

    <div class="connection-wrapper">

      <form action="ajouterEmployeeForm.php" method="POST">
        <div class="connection-form">

          <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" minlength="3" maxlength="25" placeholder="Dupont" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="name">Prénom</label>
            <input type="text" name="name" id="name" minlength="3" maxlength="25" placeholder="Guillaume" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="text" name="email" id="email" minlength="15" maxlength="40" placeholder="email@example.fr" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" minlength="8" maxlength="16" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="conf-password">Confirm mot de passe</label>
            <input type="password" name="conf-password" id="conf-password" minlength="8" maxlength="16" autocomplete="off">
          </div>
        </div>
        <div class="form-btn">
          <button type="submit" name="add-employee" class="btn-fill">Ajouter</button>
        </div>

      </form>
    </div>
  </section>
</div>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>