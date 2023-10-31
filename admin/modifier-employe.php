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
  $id = (int)$_GET['id'];
  $_SESSION['employee']['id'] = $id;

  //get employe id
  $employee = getEmployeesById($pdo, $id);
  // if ($employee === false) {
  //   $errors =  "<div class='alert alert-danger m-0' role='alert'>Cet employé n'existe pas</div>";
  // }
}

?>
<!-- send message by form  -->
<!-- <script>
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
</script> -->

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
    <?php if ($employee) : ?>
    <!-- messages  -->
    <div id="form-message" class="my-3 d-flex justify-content-center"></div>


    <div class="connection-wrapper">

      <form method="POST" id="modifyEmploye">
        <div class="connection-form">

          <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" minlength="3" maxlength="25" placeholder="Dupont"
              autocomplete="off" value="<?= htmlspecialchars($employee['lastname'] ?? ""); ?>">
            <span class="error" id="lastname_err"> </span>
          </div>
          <div class="form-group">
            <label for="name">Prénom</label>
            <input type="text" name="name" id="name" minlength="3" maxlength="25" placeholder="Guillaume"
              autocomplete="off" value=<?= htmlspecialchars($employee['name'] ?? ""); ?>>
            <span class="error" id="name_err"> </span>
          </div>
          <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="text" name="email" id="email" minlength="15" maxlength="40" placeholder="email@example.fr"
              autocomplete="off" value=<?= htmlspecialchars($employee['email'] ?? ""); ?>>
            <span class="error" id="email_err"> </span>
          </div>
          <div class="form-group">
            <label for="password">
              Mot de passe<span class="red-message mx-3">* Optionnel. Si vous remplissez le mot de passe, il remplacera
                l'ancien!</span>
            </label>
            <div class="input-group">
              <input type="password" name="password" id="password" class="form-control" minlength="8" maxlength="16"
                autocomplete="off">
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
          <button type="button" id="submitbtn" class="btn-fill">Modifier</button>
        </div>
      </form>
    </div>
  </section>

  <?php else : ?>
  <div id="form-message" class="d-flex justify-content-center">
    <div class='d-flex justify-content-center  alert alert-danger mt-5 mb-3 mx-auto' role='alert'>Cet(te) employé(é)
      n'existe
      pas</div>
  </div>


  <div class="go-back-page my-3 d-flex justify-content-center">
    <a href="javascript:history.back(1)" class="btn-wire mb-5">Retour page précédante</a>
  </div>

  <?php endif ?>

</div>
<script src="../assets/scripts/modificationEmployeForm.js"></script>
<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>