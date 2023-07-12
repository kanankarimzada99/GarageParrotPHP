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

//we cant change admin
if (isset($_GET['id'])){
  if ($_GET['id'] === "1"){
    header("location:/admin/liste-employes.php");
   }
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

//regex
$regexName = '/^[a-zA-Z]{1,25}$/';
$regexEmail = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
$regexPassword = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{10,}$/';



if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $_SESSION['user']['id'] = $id;

  $employee = getEmployeesById($pdo, $_GET['id']);

  if ($employee === false) {
    $errors[] = "Cet employé n'existe pas";
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //to validate lastname
  if (empty($_POST["lastname"])) {
    $errors[] = "Le nom est requis.";
  } elseif (!preg_match($regexName, $_POST["lastname"])) {
    $errors[] = "Le nom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.";
  }
  //to validate name
  if (empty($_POST["name"])) {
    $errors[] = "Le prénom est requis.";
  } elseif (!preg_match($regexName, $_POST["name"])) {
    $errors[] = "Le prénom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.";
  }

   // to validate email
   if (empty($_POST["email"])) {
    $errors[] = "L'e-mail est requis.";
} elseif (!preg_match($regexEmail, $_POST["email"])) {
  $errors[] = "L'e-mail n'est pas valide.";
}

// Valider le mot de passe
if (empty($_POST["password"])) {
  
  $_POST['password'] = $_SESSION['user']['password'];
} elseif (!preg_match($regexPassword, $_POST["password"])) {
  $errors[] = "Le mot de passe doit contenir au moins 10 caractères, incluant au moins une lettre minuscule, une lettre majuscule, un chiffre et un symbole.";
}

  $formEmployee = [
    'lastname' => $_POST['lastname'],
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'password' => $_POST['password']
  ];

  //if no errors we save all information
  if (!$errors) {
    if (isset($_SESSION['user']['id'])) {
      //the id will be int
      $id = (int)$_SESSION['user']['id'];
    } else {
      $id = null;
    }

    //all data will be saved at saveEmployee function
    $id = $_SESSION['user']['id'];

    $res = saveEmployee($pdo, $_POST["lastname"], $_POST["name"], $_POST["email"], $_POST["password"], $id);

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
    <h1 class="header-titles">Modifier employé</h1>

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
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" minlength="3" maxlength="25" placeholder="Dupont"
              value=<?= htmlspecialchars($employee['lastname'] ?? $formEmployee['lastname']) ; ?>>
          </div>
          <div class="form-group">
            <label for="name">Prénom</label>
            <input type="text" name="name" id="name" minlength="3" maxlength="25" placeholder="Guillaume"
              value=<?= htmlspecialchars($employee['name'] ?? $formEmployee['name']) ; ?>>
          </div>
          <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="text" name="email" id="email" minlength="15" maxlength="40" placeholder="email@example.fr"
              value=<?= htmlspecialchars($employee['email'] ?? $formEmployee['email']) ; ?>>
          </div>
          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" minlength="8" maxlength="20">
          </div>
        </div>
        <div class="form-btn">
          <button type="submit" name="saveEmployee" class="btn-fill">Modifier</button>
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
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