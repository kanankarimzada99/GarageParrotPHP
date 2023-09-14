<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/employees.php";

$id = null;

//get id from session
$id = ($_SESSION['employee']['id']);
//for security inputs
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_POST['submit'])) {
  $lastname = test_input($_POST['lastname']);
  $name = test_input($_POST['name']);
  $email = test_input($_POST['email']);
  $password = test_input($_POST['password']);

  $errorEmpty = false;
  $errorLastName = false;
  $errorName = false;
  $errorEmail = false;
  $errorPassword = false;


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

  // Valider le mot de passe
  if (!empty($password)) {

    if (!preg_match(_REGEX_PASSWORD_, $password)) {
      echo "<div class='alert alert-danger  m-0' role='alert'>Le mot de passe doit avoir minimum 10 caractères et maximum 16 caractères. Il doit avoir au moins un symbole, un chiffre et un majuscule.</div>";
      $errorPassword = true;
    } else {
      $password = $_SESSION['user']['password'];
      $errorPassword = false;
    }
  }


  //if no errors we save all information
  if ($errorEmpty !== true && $errorLastName !== true && $errorName !== true && $errorEmail !== true && $errorPassword !== true) {


    $res = saveEmployee($pdo, $lastname, $name, $email, $password, $id);

    if ($res) {
      echo "<div class='alert alert-success  m-0' role='alert'>L'employé a bien été sauvegardé</div>";
      $errorEmpty = false;
      $errorLastName = false;
      $errorName = false;
      $errorEmail = false;
      $errorPassword = false;

      unset($_SESSION['employee']);
    }
  }
} else {
  echo "<div class='alert alert-danger m-0' role='alert'>Une erreur s'est produite durant l'envoi.</div>";
  $errorEmpty = true;
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

  if (errorEmpty == false && errorLastName == false && errorName == false && errorEmail == false && errorPassword ==
    false) {
    $("#lastname, #name, #email, #password").val("");

    $(".connection-wrapper").hide();
    //hide message after 4 seconds
    setTimeout(function() {
      // $('.form-message').hide();
      window.location = '/admin/liste-employes.php';

    }, 4000); // <-- time in milliseconds
  }
</script>