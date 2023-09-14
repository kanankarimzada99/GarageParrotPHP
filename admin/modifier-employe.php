<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/employees.php";
require_once __DIR__ . "/templates/header-admin.php";

//we cant change admin
if (isset($_GET['id'])) {
  if ($_GET['id'] === "1") {
    header("location:/admin/liste-employes.php");
  }
}


$errors = '';
$formEmployee = [
  'lastname' => '',
  'name' => '',
  'email' => '',
  'password' => ''
];
$id = null;

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $_SESSION['employee']['id'] = $id;


  $employee = getEmployeesById($pdo, $id);

  if ($employee === false) {
    $errors =  "<div class='alert alert-danger m-0' role='alert'>Cet employé n'existe pas</div>";
  }
}

?>
<!-- send message by form  -->
<script>
  $(document).ready(function() {
    $("form").submit(function(event) {
      event.preventDefault();
      var lastname = $("#lastname").val();
      var name = $("#name").val();
      var email = $("#email").val();
      var password = $("#password").val();
      var submit = $("#submit").val();
      $(".form-message").load('modifierEmployeForm.php', {
        lastname: lastname,
        name: name,
        email: email,
        password: password,
        submit: submit
      });
    })
  })
</script>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-employes.php">Revenir liste employées</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h1 class="header-titles">Modifier employé</h1>

    <!-- messages  -->

    <div class="form-message">
      <?= $errors; ?>
    </div>

    <?php if ($formEmployee !== false) { ?>
      <div class="connection-wrapper">

        <form action="modifierEmployeForm.php" method="POST">
          <div class="connection-form">

            <div class="form-group">
              <label for="lastname">Nom</label>
              <input type="text" name="lastname" id="lastname" minlength="3" maxlength="25" placeholder="Dupont" autocomplete="off" value="<?= htmlspecialchars($employee['lastname'] ?? ""); ?>">
            </div>
            <div class="form-group">
              <label for="name">Prénom</label>
              <input type="text" name="name" id="name" minlength="3" maxlength="25" placeholder="Guillaume" autocomplete="off" value=<?= htmlspecialchars($employee['name'] ?? ""); ?>>
            </div>
            <div class="form-group">
              <label for="email">Adresse email</label>
              <input type="text" name="email" id="email" minlength="15" maxlength="40" placeholder="email@example.fr" autocomplete="off" value=<?= htmlspecialchars($employee['email'] ?? ""); ?>>
            </div>
            <div class="form-group">
              <label for="password">Mot de passe <span class="red-message">*</span> </label>
              <input type="password" name="password" id="password" minlength="8" maxlength="16" autocomplete="off">
              <p class="red-message">* Optionnel. Si vous remplissez le mot de passe, il remplacera l'ancien!</p>
            </div>
          </div>
          <div class="form-btn">
            <input type="submit" value="Modifier" id="submit" name="submit" class="btn-fill">
          </div>
        </form>
      </div>
  </section>
</div>
<?php } else { ?>
  <div class="not-found">
    <!-- <h2 class="not-found-text">Employé non trouvé</h2> -->
    <div class="go-back-page">
      <a href="javascript:history.back(1)" class="btn-wire">Retour page précédante</a>
    </div>
  </div>
<?php } ?>
<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>