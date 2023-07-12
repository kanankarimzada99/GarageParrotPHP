<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/schedules.php";
require_once __DIR__ . "/templates/header-admin.php";

//employees don't have permission to visit this page
if ($_SESSION['user']['role'] === 'employee') {
  header("location: /admin/liste-veicules.php");
}

//VARIABLES
$errors = [];
$messages = [];
$formSchedule = [
  'day' => '',
  'morning-open' => '',
  'morning-close' => '',
  'afternoon-open' => '',
  'afternoon-close' => ''
];
$id = null;

//REGEX
$regexDay = '/^[a-zA-Z]{1,25}$/';
$regexTime = '/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'; //00:00


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $_SESSION['user']['id'] = $id;

  $schedule = getSchedulesById($pdo, $_GET['id']);

  if ($schedule === false) {
    $errors[] = "Cette horaire n'existe pas";
  }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {


//transform post['day'] into lowercase
$day = strtolower($_POST["day"]);

  //to validate day
  if (empty($_POST["day"])) {
    $errors[] = "Le jour de la semaine est requis.";
  } elseif (!preg_match($regexDay, $_POST["day"])) {
    $errors[] = "Le nom doit contenir uniquement des lettres et avoir une longueur maximale de 8 caractères.";
  } 

  if ($day != 'lundi' && $day != 'mardi' && $day != 'mercredi' && $day != 'jeudi' && $day != 'vendredi' && $day != 'samedi' && $day != 'dimanche') {
    $errors[] = "Le jour de la semaine n'est pas valide.";
  }
  //to validate morning start
  if (empty($_POST["morning-open"])) {
    $errors[] = "L'horaire d'ouverture du matin est requis.";
  } elseif (!preg_match($regexTime, $_POST["morning-open"])) {
    $errors[] = "Le format d'horaire doit être 00:00. Les lettres ne sont pas accepté.";
  }

  //to validate morning end
  if (empty($_POST["morning-close"])) {
    $errors[] = "L'horaire fermeture du matin est requis.";
  } elseif (!preg_match($regexTime, $_POST["morning-close"])) {
    $errors[] = "Le format d'horaire doit être 00:00. Les lettres ne sont pas accepté.";
  }

  //to validate afternoon start
  if (empty($_POST["afternoon-open"])) {
    $errors[] = "L'horaire d'ouverture de l'après-midi est requis.";
  } elseif (!preg_match($regexTime, $_POST["afternoon-open"])) {
    $errors[] = "Le format d'horaire doit être 00:00. Les lettres ne sont pas accepté.";
  }

  //to validate afternoon end
  if (empty($_POST["afternoon-close"])) {
    $errors[] = "L'horaire de fermeture de l'après-midi est requis.";
  } elseif (!preg_match($regexTime, $_POST["afternoon-close"])) {
    $errors[] = "Le format d'horaire doit être 00:00. Les lettres ne sont pas accepté.";
  }

  $formSchedule = [
    'day' => $_POST['day'],
    'morning-open' => $_POST['morning-open'],
    'morning-close' => $_POST['morning-close'],
    'afternoon-open' => $_POST['afternoon-open'],
    'afternoon-close' => $_POST['afternoon-close']
  ];

  //if no errors we save all information
  if (!$errors) {
    if (isset($_SESSION['schedule']['id'])) {
      //the id will be int
      $id = (int)$_SESSION['schedule']['id'];
    } else {
      $id = null;
    }

    //all data will be saved at saveSchedule function
    $id = $_SESSION['schedule']['id'];

    //strtolower transform any input day into lowercase and save into the table
    $res = saveSchedule($pdo, strtolower($_POST["day"]), $_POST["morning-open"], $_POST["morning-close"], $_POST["afternoon-open"], $_POST["afternoon-close"], $id);

    if ($res) {
      $messages[] = "L'horaire a bien été sauvegardé";

      //all information at formEmployee will be deleted
      if (!isset($_GET["id"])) {
        $formSchedule = [
          'day' => '',
          'morning-open' => '',
          'morning-close' => '',
          'afternoon-open' => '',
          'afternoon-close' => ''
        ];
      } else {
        $errors[] = "L'horaire n'a pas été sauvegardé";
      }
    }
  }
}
?>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-horaires.php">Revenir liste horaires</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h1 class="header-titles">Modifier Horaire</h1>

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

    <?php if ($formSchedule !== false) { ?>

    <div class="connection-wrapper w-max">

      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="schedule-form">
          <div class="form-day center">
            <label for="day">Jour de la semaine</label>
            <input type="text" name="day" id="day" placeholder="lundi" minlength="5" maxlength="8" class="large"
              value=<?= htmlspecialchars($schedule['day'] ?? $formSchedule['day']); ?>>

          </div>
          <div class="class-group text-center">
            <p class="time-message">&gt;&gt; L'horaire 00:00 = fermé &lt;&lt;</p>
          </div>
          <fieldset>
            <legend>Matin</legend>
            <div class="form-group">
              <label for="morning-open">Ouverture</label>
              <input type="text" name="morning-open" id="morning-open" placeholder="00:00" minlength="5" maxlength="5"
                value=<?= htmlspecialchars($schedule['morningOpen'] ?? $formSchedule['morning-open']); ?>>

            </div>
            <div class="form-group">
              <label for="morning-close">Fermeture</label>
              <input type="text" name="morning-close" id="morning-close" placeholder="00:00" minlength="5" maxlength="5"
                value=<?= htmlspecialchars($schedule['morningClose'] ?? $formSchedule['morning-close']); ?>>

            </div>
          </fieldset>
          <fieldset>
            <legend>Après-midi</legend>
            <div class="form-group">
              <label for="afternoon-open">Ouverture</label>
              <input type="text" name="afternoon-open" id="afternoon-open" placeholder="00:00" minlength="5"
                maxlength="5"
                value=<?= htmlspecialchars($schedule['afternoonOpen'] ?? $formSchedule['afternoon-open']); ?>>

            </div>
            <div class="form-group">
              <label for="afternoon-close">Fermeture</label>
              <input type="text" name="afternoon-close" id="afternoon-close" placeholder="00:00" minlength="5"
                maxlength="5"
                value=<?= htmlspecialchars($schedule['afternoonClose'] ?? $formSchedule['afternoon-close']); ?>>

            </div>
          </fieldset>

        </div>
        <div class="form-btn">
          <button type="submit" value="modify-schedule" class="btn-fill">Modifier</button>
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