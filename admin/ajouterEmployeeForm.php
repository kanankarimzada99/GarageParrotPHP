<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/employees.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $id = null;

  //for security inputs
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $name = $lastName = $email = $password = $confPassword = '';

  $name = test_input($_POST['name']);
  $lastName = test_input($_POST['lastName']);
  $email = test_input($_POST['email']);
  $password = test_input($_POST['password']);
  $confPassword = test_input($_POST['confPassword']);

  $errorEmpty = false;
  $errorLastName = false;
  $errorName = false;
  $errorEmail = false;
  $errorPassword = false;
  $errorConfPassword = false;

  if (empty($lastName) && empty($name) && empty($email) && empty($password)  && empty($confPassword)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Vous devez remplir tous les champs.</div>";
    $errorEmpty = true;
  } elseif (!preg_match(_REGEX_LAST_NAME_, $lastName)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le nom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.</div>";
    $errorLastName = true;
  } elseif (!preg_match(_REGEX_FIRST_NAME_, $name)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le prénom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.</div>";
    $errorName = true;
  } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le format du e-mail address n'est pas valide</div>";
    $errorEmail = true;
  } elseif ($password !== $confPassword) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Les mots de passe ne correspondent pas. Ils doivent avoir au moins un symbole, un chiffre et un majuscule. Minimum 8, maximum 16 caractères.</div>";
    $errorConfPassword = true;
    $errorPassword = true;
  } elseif (!preg_match(_REGEX_PASSWORD_, $password)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le mot de passe doit avoir minimum 10 caractères et maximum 16 caractères. Il doit avoir au moins un symbole, un chiffre et un majuscule.</div>";
    $errorPassword = true;
  } elseif (!preg_match(_REGEX_PASSWORD_, $confPassword)) {

    $errorConfPassword = true;
  }

  //if no errors we save all information
  if ($errorEmpty !== true && $errorLastName !== true && $errorName !== true && $errorEmail !== true && $errorPassword !== true && $errorConfPassword !== true) {


    //all data will be saved at saveEmployee function
    $res = saveEmployee($pdo, $lastName, $name, $email, $password, $id);

    if ($res) {
      echo "<div class='alert alert-success  m-0' role='alert'>L'employé a bien été sauvegardé.</div>";
      $errorEmpty = false;
      $errorLastName = false;
      $errorName = false;
      $errorEmail = false;
      $errorPassword = false;
      $errorConfPassword = false;
    } else {
      echo "<div class='alert alert-danger m-0' role='alert'>L'employé n'a pas été sauvegardé.</div>";
      $errorEmpty = true;
    }
  }
}
?>

<script>
  $("#lastname, #name, #email, #password, #conf-password").removeClass("input-error");

  //get variable php inside js
  var errorEmpty = "<?php echo $errorEmpty; ?>";
  var errorLastName = "<?php echo $errorLastName; ?>";
  var errorName = "<?php echo $errorName; ?>";
  var errorEmail = "<?php echo $errorEmail; ?>";
  var errorPassword = "<?php echo $errorPassword; ?>";
  var errorConfPassword = "<?php echo $errorConfPassword; ?>";

  if (errorEmpty == true) {
    $("#lastname, #name, #email, #password, #conf-password").addClass("input-error");
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
  if (errorConfPassword == true) {
    $("#conf-password").addClass("input-error");
  }

  if (errorEmpty == false && errorName == false && errorLastName == false && errorEmail == false && errorPassword ==
    false && errorConfPassword == false) {
    $("#lastname, #name, #email, #password, #conf-password").val("");
    $(".connection-wrapper").hide();

    // hide message after 3 seconds
    setTimeout(function() {
      // $('.form-message').hide();
      window.location = '/admin/liste-employes.php';

    }, 3000); // <-- time in milliseconds
  }
</script>