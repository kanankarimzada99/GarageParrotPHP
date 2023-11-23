<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/schedules.php";


//get id from session
$id = $_SESSION['schedule']['id'];
if (!$id) {
  $id = null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //for security inputs
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $morningOpen = test_input($_POST['morningOpen']);
  $morningClose = test_input($_POST['morningClose']);
  $afternoonOpen = test_input($_POST['afternoonOpen']);
  $afternoonClose = test_input($_POST['afternoonClose']);

  $errorEmpty = false;
  $errorMorningOpen = false;
  $errorMorningClose = false;
  $errorAfternoonOpen = false;
  $errorAfternoonClose = false;
  $errorTime = false;

  $twoNumbersMorningOpen = substr($morningOpen, 0, 2);
  $twoNumbersMorningClose = substr($morningClose, 0, 2);
  $lastTwoNumbersMorningOpen = substr($morningOpen, -2, 2);
  $lastTwoNumbersMorningClose = substr($morningClose, -2, 2);
  $twoNumbersAfternoonOpen = substr($afternoonOpen, 0, 2);
  $twoNumbersAfternoonClose = substr($afternoonClose, 0, 2);
  $lastTwoNumbersAfternoonOpen = substr($afternoonOpen, -2, 2);
  $lastTwoNumbersAfternoonClose = substr($afternoonClose, -2, 2);


  //to validate schedule
  if (empty($morningOpen) && empty($morningClose) && empty($afternoonOpen) && empty($afternoonClose)) {
    echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>Vous devez remplir tous les champs.</div>";
    $errorEmpty = true;
  } else {
    //to validate morning
    if ($twoNumbersMorningOpen !== "00" || $twoNumbersMorningClose !== "00") {

      if (empty($morningOpen)) {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>L'horaire d'ouverture du matin est requis.</div>";
        $errorMorningOpen = true;
      } elseif (!preg_match(_REGEX_TIME_, $morningOpen)) {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>Le format d'horaire doit être 00:00. Les lettres ne sont pas accepté.</div>";
        $errorMorningOpen = true;
      }

      //to validate morning end
      elseif (empty($morningClose)) {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>L'horaire fermeture du matin est requis.</div>";
        $errorMorningClose = true;
      } elseif (!preg_match(_REGEX_TIME_, $morningClose)) {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>Le format d'horaire doit être 00:00. Les lettres ne sont pas accepté.</div>";
        $errorMorningClose = true;
      } elseif (($twoNumbersMorningOpen == $twoNumbersMorningClose) && ($lastTwoNumbersMorningOpen == $lastTwoNumbersMorningClose)) {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>L'horaire d'ouverture ne peut pas être le même que l'horaire de fermeture.</div>";
        $errorMorningOpen = true;
      } elseif ($twoNumbersMorningOpen > $twoNumbersMorningClose && $twoNumbersMorningClose !== "00") {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>L'horaire d'ouverture ne peut pas être plus grand que l'horaire de fermeture.</div>";
        $errorMorningOpen = true;
      }
    }

    //to validate afternoon
    if ($twoNumbersAfternoonOpen !== "00" && $twoNumbersAfternoonClose !== "00") {

      if (empty($afternoonOpen)) {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>L'horaire d'ouverture de l'
        après-midi est requis.</div>";
        $errorAfternoonOpen = true;
      } elseif (!preg_match(_REGEX_TIME_, $afternoonOpen)) {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>Le format d'horaire doit être 00:00. Les lettres ne sont pas accepté.</div>";
        $errorAfternoonOpen = true;
      } elseif ($twoNumbersAfternoonOpen != "00" && intval($twoNumbersAfternoonOpen) <= intval($twoNumbersMorningClose)) {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>L'horaire d'ouverture de l'après-midi  doit être plus grand que l'horaire de fermeture du matin.</div>";
        $errorAfternoonOpen = true;
      } elseif (empty($afternoonClose)) {
        echo "<div class='alert alert-danger  m-auto' role='alert'>L'horaire fermeture de l'
        après-midi est requis.</div>";
        $errorAfternoonClose = true;
      } elseif (!preg_match(_REGEX_TIME_, $morningClose)) {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>Le format d'horaire doit être 00:00. Les lettres ne sont pas accepté.</div>";
        $errorMorningClose = true;
      } elseif (($twoNumbersAfternoonOpen == $twoNumbersAfternoonClose) && ($lastTwoNumbersAfternoonOpen == $lastTwoNumbersAfternoonClose)) {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>L'horaire d'ouverture ne peut pas être le même que l'horaire de fermeture.</div>";
        $errorAfternoonOpen = true;
      } elseif ($twoNumbersAfternoonOpen > $twoNumbersAfternoonClose && $twoNumbersAfternoonClose !== "00") {
        echo "<div class='alert alert-danger  m-auto mt-3' role='alert'>L'horaire d'ouverture ne peut pas être plus grand que l'horaire de fermeture.</div>";
        $errorAfternoonOpen = true;
      }
    }
  }

  // if no errors we save all information
  if ($errorEmpty !== true && $errorMorningOpen !== true && $errorMorningClose !== true && $errorAfternoonOpen !== true && $errorAfternoonClose !== true && $errorTime !== true) {

    //strtolower transform any input day into lowercase and save into the table
    $res = saveSchedule($pdo, $morningOpen, $morningClose, $afternoonOpen, $afternoonClose, $id);

    if ($res) {
      echo  "<div class='alert alert-success  mx-auto mt-3' role='alert'>L'horaire a bien été sauvegardé.</div>";

      $errorEmpty = false;
      $errorMorningOpen = false;
      $errorMorningClose = false;
      $errorAfternoonOpen = false;
      $errorAfternoonClose = false;
      $errorTime = false;

      unset($_SESSION['schedule']);
    } else {
      echo "<div class='alert alert-error  mx-auto mt-3' role='alert'>L'horaire n'a pas été sauvegardé.</div>";
    }
  }
}
?>
<script>
  $("#morning-open, #morning-close, #afternoon-open", "afternoon-close").removeClass("input-error");

  //get variable php inside js
  var errorEmpty = "<?php echo $errorEmpty; ?>";
  var errorMorningOpen = "<?php echo $errorMorningOpen; ?>";
  var errorMorningClose = "<?php echo $errorMorningClose; ?>";
  var errorAfternoonOpen = "<?php echo $errorAfternoonOpen; ?>";
  var errorAfternoonClose = "<?php echo $errorAfternoonClose; ?>";
  var errorTime = "<?php echo $errorTime; ?>";

  if (errorEmpty == true) {
    $('input').addClass("input-error");
  }
  if (errorMorningOpen == true) {
    $("#morning-open").addClass("input-error");
  } else {
    $("#morning-open").removeClass("input-error");
  }
  if (errorMorningClose == true) {
    $("#morning-close").addClass("input-error");
  } else {
    $("#morning-close").removeClass("input-error");
  }
  if (errorAfternoonOpen == true) {
    $("#afternoon-open").addClass("input-error");
  } else {
    $("#afternoon-open").removeClass("input-error");
  }
  if (errorAfternoonClose == true) {
    $("#afternoon-close").addClass("input-error");
  } else {
    $("#afternoon-close").removeClass("input-error");
  }


  if (errorEmpty == false && errorMorningOpen == false && errorMorningClose == false && errorAfternoonOpen == false &&
    errorAfternoonClose == false &&
    errorTime == false) {
    $("#moring-open, #morning-close, #afternoon-open", "afternoon-close").val("");
    //hide form
    $(".connection-wrapper").hide();
    $('#backPage').removeClass('d-none')
  }
</script>