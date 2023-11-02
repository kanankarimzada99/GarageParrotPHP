<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/employees.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $id = null;

  // get id from session
  $id = (int)($_SESSION['employee']['id']);

  //for security inputs
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $name = $lastName = $email = $password = '';

  $lastname = test_input($_POST['lastname']);
  $name = test_input($_POST['name']);
  $email = test_input($_POST['email']);
  $password = ($_POST['password']);

  $error = false;
  $errorEmpty = false;
  $errorLastName = false;
  $errorName = false;
  $errorEmail = false;
  $errorPassword = false;

  //get employees
  $employees = getEmployees($pdo);

  //verify if employee or email exist on the database
  foreach ($employees as $employee) {

    //verify if employee id different employe id url to check if email exist

    if ($employee['email'] === $email && $employee['id'] !== $id) {
      echo "<div class='alert alert-danger  m-0' role='alert'>Cet e-mail existe déjà.</div>";
      $errorEmail = true;
    }
  }

  //to validate employee
  if (empty($lastname) && empty($name) && empty($email)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Vous devez remplir tous les champs.</div>";
    $errorEmpty = true;
  } elseif (!preg_match(_REGEX_LAST_NAME_, $lastname)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le nom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.</div>";
    $errorLastName = true;
  } elseif (!preg_match(_REGEX_FIRST_NAME_, $name)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le prénom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.</div>";
    $errorName = true;
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le format du e-mail address n'est pas valide</div>";
    $errorEmail = true;
  }

  //if no errors we save all information
  if ($errorEmpty !== true && $error !== true && $errorLastName !== true && $errorName !== true && $errorEmail !== true) {

    if (($_POST['password']) === 'undefined' || ($_POST['password']) === '') {
      $res = saveEmployee($pdo, $lastname, $name, $email, $_SESSION['employee']['password'], $id);
    } else {
      $res = saveEmployee($pdo, $lastname, $name, $email, sha1($password), $id);
    }

    if ($res) {
      echo "<div class='alert alert-success  m-0' role='alert'>L'employé a bien été sauvegardé</div>";
      $errorEmpty = false;
      $errorLastName = false;
      $errorName = false;
      $errorEmail = false;
      $errorPassword = false;
      $error = false;

      unset($_SESSION['employee']);
    }
  }
} else {
  echo "<div class='alert alert-danger m-0' role='alert'>Une erreur s'est produite durant l'envoi.</div>";
  $error = true;
}
?>

<script>
  $("#lastname, #name, #email, #password").removeClass("input-error");

  //get variable php inside js
  var errorEmpty = "<?php echo $errorEmpty; ?>";
  var errorLastName = "<?php echo $errorLastName; ?>";
  var errorName = "<?php echo $errorName; ?>";
  var errorEmail = "<?php echo $errorEmail; ?>";
  var errorPassword = "<?php echo $errorPassword; ?>";
  var error = "<?php echo $error; ?>";

  if (errorEmpty == true) {
    $("#lastname, #name, #email").addClass("input-error");
  }
  if (errorLastName == true) {
    $("#lastname").addClass("input-error");
  }
  if (errorName == true) {
    $("#name").addClass("input-error");
  }
  if (errorEmail == true) {
    $("#email").addClass("input-error");
  }
  if (errorPassword == true) {
    $("#password").addClass("input-error");
  }

  if (errorEmpty == false && error == false && errorLastName == false && errorName == false && errorEmail == false &&
    errorPassword ==
    false) {
    $("#lastname, #name, #email, #password").val("");
    //hide form
    $(".connection-wrapper").hide();
    //hide message after 3 seconds
    setTimeout(function() {
      window.location = '/admin/liste-employes.php';

    }, 3000); // <-- time in milliseconds
  }
</script>