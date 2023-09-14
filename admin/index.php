<?php
//ob_start() function will turn output buffering on. While output buffering is active no output is sent from the script (other than headers)
ob_start();

require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/employees.php";
require_once __DIR__ . "/../templates/header-connexion.php";

$errors = [];
$messages = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = verifyUserLogin($pdo, $_POST['email'], $_POST['password']);

  if ($user) {
    //replace the current session ID with a new one to stop session hijacking and session fixation.
    session_regenerate_id(true);
    $_SESSION['user'] = $user;

    //crypt POST password
    $password_hash = sha1($_POST['password']);

    //verify if email and password correspond to the user
    if ($_POST['email'] !== $user['email'] || $password_hash !== $user['password']) {
      $errors[] = 'Email ou mot de passe incorrect';
    } else {
      if ($user['role'] === 'admin') {
        header('location: /admin/liste-employes.php');
      } else if ($user['role'] === 'employee') {
        header('location: /admin/liste-voitures.php');
      } else {
        header('location: index.php');
        exit();
      }
    }
  } else {
    $errors[] = 'Email ou mot de passe incorrect';
  }
}
?>

<div class="wrapper">

  <!-- connection  -->
  <section class="connection w-min sections" id="connection">
    <h1 class="header-titles">Connexion</h1>


    <!-- error messages  -->
    <div class="form-message">
      <?php foreach ($errors as $error) { ?>
      <div class="alert alert-danger m-0" role="alert">
        <?= $error; ?>
      </div>
      <?php } ?>
    </div>


    <div class="connection-wrapper w-min">

      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="connection-form">
          <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="text" name="email" maxlength="40" placeholder="email@example.fr" autocomplete="off"
              value=<?= htmlspecialchars($_POST['email'] ?? '') ?>>
          </div>
          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" minlength="8" maxlength="16" id="password" autocomplete="off"
              value=<?= htmlspecialchars($_POST['password'] ?? '') ?>>
          </div>
        </div>
        <div class="form-btn">
          <input type="submit" name="login" value="connexion" class="btn-fill">
        </div>
      </form>
    </div>
  </section>
</div>

<?php
require_once __DIR__ . "/../templates/footer-connexion.php";
?>