<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/employees.php";
require_once __DIR__ . "/templates/header-admin.php";

//employees don't have permission to visit this page
if ($_SESSION['user']['role'] === 'employee') {
  header("location: /admin/liste-veicules.php");
}


$errors = [];
$messages = [];
$formEmployee = [
  'lastname' => '',
  'name' => '',
  'email' => '',
  'password' => ''
];
$id = null;
$employee ='employee';




if (isset($_POST['add-employee'])) {

  //put information from form to formEmployee
  $formEmployee = [
    'lastname' => $_POST['lastname'],
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'password' => $_POST['password']
  ];


  //if no errors we save all information
  if (!$errors) {
  

    //all data will be saved at saveEmployee function
  
    $res = changeEmployee($pdo, $_POST["lastname"], $_POST["name"], $_POST["email"], $_POST["password"], $id);


    if ($res) {
      $messages[] = "L'employé a bien été sauvegardé";

      //all information at formEmployee will be deleted
      if (!isset($_GET["id"])) {
        $formEmployee = [
          'lastname' => '',
          'name' => '',
          'email' => '',
          'password' => ''
        ];
      } else {
        $errors[] = "L'employé n'a pas été sauvegardé";
      }
    }
  }
}




?>



<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-employes.php">Revenir liste</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h2 class="header-titles">Ajouter employé</h2>


    <!-- messages  -->
    <?php foreach ($messages as $message) { ?>
    <div class="alert alert-success mt-4" role="alert">
      <?= $message; ?>
    </div>
    <?php } ?>

    <?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger mt-4" role="alert">
      <?= $error; ?>
    </div>


    <?php } ?>
    <?php if ($formEmployee !== false) { ?>
    <div class="connection-wrapper">

      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="connection-form">
          <div class="form-group">
            <label for="name">Prénom</label>
            <input type="text" name="name" id="name">
          </div>
          <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname">
          </div>
          <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="text" name="email" id="email">
          </div>
          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
          </div>
          <div class="form-group">
            <label for="conf-password">Confirm mot de passe</label>
            <input type="password" name="conf-password" id="conf-password">
          </div>
        </div>
        <div class="form-btn">
          <button type="submit" name="add-employee" class="btn-fill">Ajouter</button>
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>



<?php } else { ?>
<div class="not-found">
  <!-- <h1 class="not-found-text">Employé non trouvé</h1> -->
  <div class="go-back-page">
    <a href="javascript:history.back(1)" class="btn-wire">Retour page précédante</a>
  </div>
</div>
<?php } ?>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>