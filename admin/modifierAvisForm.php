<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/reviews.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $id = null;

  $id = ($_SESSION['review']['id']);

  //for security inputs
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $client = test_input($_POST['client']);
  $comment = test_input($_POST['comment']);
  $note = test_input($_POST['note']);

  $errorEmpty = false;
  $errorClient = false;
  $errorComment = false;
  $errorNote = false;




  //to validate reviews
  if (empty($client) && empty($comment) && empty($note)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Vous devez remplir tous les champs.</div>";
    $errorEmpty = true;
  } elseif (!preg_match(_REGEX_CLIENT_, $client)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le nom du client est requis. Maximum 50 caractères</div>";
    $errorClient = true;
  } elseif (!preg_match(_REGEX_COMMENT_, $comment)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le nom du client doit contenir uniquement des lettres et espaces et avoir une longueur maximale de 50 caractères.</div>";
    $errorComment = true;
  }

  //to validate note
  elseif (empty($note) || $note === '') {
    echo "<div class='alert alert-danger  m-0' role='alert'>La note est requis.</div>";
    $errorNote = true;
  }

  //if no errors we save all information
  if ($errorEmpty !== true && $errorClient !== true && $errorComment !== true && $errorNote !== true) {

    //all data will be saved at saveReview function
    $res = saveReview($pdo, $client, $comment, $note, $id);

    if ($res) {
      echo "<div class='alert alert-success  m-0' role='alert'>L'avis du client a bien été sauvegardé.</div>";

      $errorEmpty = false;
      $errorClient = false;
      $errorComment = false;
      $errorNote = false;

      unset($_SESSION['review']);
    } else {
      echo "<div class='alert alert-danger m-0' role='alert'>L'avis du client n'a pas été sauvegardé.</div>";
      $errorEmpty = true;
    }
  }
} else {
  echo "<div class='alert alert-danger m-0' role='alert'>Une erreur s'est produite durant l'envoi.</div>";
  $errorEmpty = true;
}
?>

<script>
  $("#client, #comment, #note").removeClass("input-error");

  //get variable php inside js
  var errorEmpty = "<?php echo $errorEmpty; ?>";
  var errorClient = "<?php echo $errorClient; ?>";
  var errorComment = "<?php echo $errorComment; ?>";
  var errorNote = "<?php echo $errorNote; ?>";


  if (errorEmpty == true) {
    $("#client, #comment, #note").addClass("input-error");
  }
  if (errorClient == true) {
    $("#client").addClass("input-error");
  }
  if (errorComment == true) {
    $("#comment").addClass("input-error");
  }
  if (errorNote == true) {
    $("#note").addClass("input-error");
  }


  if (errorEmpty == false && errorClient == false && errorComment == false && errorNote == false) {
    $("#client, #comment, #note").val("");

    $(".connection-wrapper").hide();
    //hide message after 4 seconds
    setTimeout(function() {
      // $('.form-message').hide();
      window.location = '/admin/liste-avis.php';

    }, 4000); // <-- time in milliseconds
  }
</script>