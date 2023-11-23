<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/employees.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] == $_POST['token']) {

  $id = null;
  $error = false;
  $errorEmpty = false;
  $errorLastName = false;
  $errorName = false;
  $errorEmail = false;
  $errorPassword = false;

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
  $lastName = test_input($_POST['lastname']);
  $email = test_input($_POST['email']);
  $password = test_input($_POST['password']);
  $confPassword = test_input($_POST['cpassword']);

  //get employees
  $employees = getEmployees($pdo);


  //verify if employee or email exist on the database
  foreach ($employees as $employee) {
    if ($employee['email'] == $email) {
      echo "<div class='alert alert-danger  m-0' role='alert'>Cet mail existe déjà.</div>";
      $errorEmail = true;
    }
  }

  //to validate employee
  if (empty($lastname) && empty($name) && empty($email) && empty($password)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Vous devez remplir tous les champs.</div>";
    $errorEmpty = true;
  } elseif (!preg_match(_REGEX_LAST_NAME_, $lastName)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le nom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.</div>";
    $errorLastName = true;
  } elseif (!preg_match(_REGEX_FIRST_NAME_, $name)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le prénom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.</div>";
    $errorName = true;
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le format du e-mail address n'est pas valide</div>";
    $errorEmail = true;
  } elseif (!preg_match(_REGEX_PASSWORD_, $password)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Au moins une minuscule, une majuscule, un symbol et un chiffre. De 8 à 16 caractères maximum.</div>";
    $errorPassword = true;
  }

  //if no errors we save all information
  if ($errorEmpty !== true && $error !== true && $errorLastName !== true && $errorName !== true && $errorEmail !== true && $errorPassword !== true) {

    //all data will be saved at saveEmployee function
    $res = saveEmployee($pdo, $lastName, $name, $email, sha1($password), $id);

    if ($res) {
      echo "<div class='alert alert-success  m-0 mt-3' role='alert'>L'employé a bien été sauvegardé.</div>";

      $error = false;
      $errorEmpty = false;
      $errorLastName = false;
      $errorName = false;
      $errorEmail = false;
      $errorPassword = false;
    } else {
      echo "<div class='alert alert-danger m-0 mt-3' role='alert'>L'employé n'a pas été sauvegardé.</div>";
      exit();
    }
  }
}
?>

<script>
$("#name, #lastname, #email, #password").removeClass("input-error");

//get variable php inside js
var errorEmpty = "<?php echo $errorEmpty; ?>";
var errorName = "<?php echo $errorName; ?>";
var errorLastName = "<?php echo $errorLastName; ?>";
var errorEmail = "<?php echo $errorEmail; ?>";
var errorPassword = "<?php echo $errorPassword; ?>";

if (errorEmpty == true) {
  $("#name, #lastname, #email, #password").addClass("input-error");

}
if (errorName == true) {
  $("#name").addClass("input-error");
}
if (errorLastName == true) {
  $("#lastname").addClass("input-error");
}
if (errorEmail == true) {
  $("#email").addClass("input-error");
}
if (errorPassword == true) {
  $("#password").addClass("input-error");
}

if (errorEmpty == false && errorName == false && errorLastName == false && errorEmail == false && errorPassword ==
  false) {
  $("#name, #lastname, #email, #password").val("");
  //hide form
  $(".connection-wrapper").hide();
  $('#backPage').removeClass('d-none')
}
</script>