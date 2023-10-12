<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/employees.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $id = null;
  $error = false;

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
    if ($employee['name'] == $name && $employee['lastname'] == $lastName) {
      echo "<div class='alert alert-danger  m-0' role='alert'>Cet(te) employé(e) existe déjà.</div>";
      $error = true;
    } else if ($employee['email'] == $email) {
      echo "<div class='alert alert-danger  m-0' role='alert'>Cet mail existe déjà.</div>";
      $error = true;
    }
  }


  if (empty($lastName) && empty($name) && empty($email) && empty($password)  && empty($confPassword)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Vous devez remplir tous les champs.</div>";
    $error = true;
  }

  //if no errors we save all information
  if ($error == false) {


    //all data will be saved at saveEmployee function
    $res = saveEmployee($pdo, $lastName, $name, $email, $password, $id);

    if ($res) {
      echo "<div class='alert alert-success  m-0' role='alert'>L'employé a bien été sauvegardé.</div>";
      $error = false;
    } else {
      echo "<div class='alert alert-danger m-0' role='alert'>L'employé n'a pas été sauvegardé.</div>";
      exit();
    }
  }
}
?>
<script>
  //get variable php inside js
  var errorEmpty = "<?php echo $error; ?>";
  if (errorEmpty == false) {
    $("#lastname, #name, #email, #password, #conf-password").val("");
    $(".connection-wrapper").hide();

    // hide message after 3 seconds
    setTimeout(function() {
      // $('.form-message').hide();
      window.location = '/admin/liste-employes.php';

    }, 3000); // <-- time in milliseconds
  }
</script>