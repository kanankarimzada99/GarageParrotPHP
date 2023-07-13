<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/session.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/cars.php";
require_once __DIR__ . "/templates/header-navigation.php";

//verify if id is on the URL
$error = false;
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $car = getCarsById($pdo, $id);

  $_SESSION['car'] = $car;

  //verify if car is on db
  if (!$car) {
    $error = true;
  }
} else {
  $error = true;
}

$id = null;
$errors = [];
$messages = [];
$formCar = [
  'name'=>'',
  'lastname' => '',
  'email' => '',
  'phone' => '',
  'subject'=>'',
  'message' => ''
];



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (!isset($_POST['lastname']) || $_POST['lastname'] == '') {
    $errors[] = "Le nom ne doit pas être vide";
  }elseif (!preg_match(_REGEX_LAST_NAME_, $_POST['lastname'])) {
    $errors[] = "Le nom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.";
  }
  if (!isset($_POST['name']) || $_POST['name'] == '') {
    $errors[] = "Le prénom ne doit pas être vide";
  }elseif (!preg_match(_REGEX_FIRST_NAME_, $_POST['name'])) {
    $errors[] = "Le prénom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.";
  }

  if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'adresse e-mail n'est pas valide";
  }

  if (!isset($_POST['phone']) || $_POST['phone'] == '') {
    $errors[] = "Le téléphone ne doit pas être vide  ";
  }elseif (!preg_match(_REGEX_PHONE_, $_POST['phone'])) {
    $errors[] = "Le téléphone doit contenir uniquement des chiffres et avoir une longueur maximale de 16 caractères. Pour appel internationale, le signal \"+\" et le \"()\".";
  }

  if (!isset($_POST['subject']) || $_POST['subject'] == '') {
    $errors[] = "Le sujet ne doit pas être vide  ";
  }elseif (!preg_match(_REGEX_SUBJECT_, $_POST['subject'])) {
    $errors[] = "Le sujet doit contenir uniquement des lettres et avoir une longueur maximale de 60 caractères.";
  }


 
  if (!isset($_POST['message']) || $_POST['message'] == '') {
    $errors[] = "Le message ne doit pas être vide  ";
  }elseif (!preg_match(_REGEX_MESSAGE_, $_POST['message'])) {
    $errors[] = "Le message doit contenir uniquement des chiffres, () ou + et avoir une longueur maximale de 16 caractères.";
  }

  $formCar = [
    'name'=>$_POST['name'],
    'lastname' => $_POST['lastname'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'subject'=>$_POST['subject'],
    'message' => $_POST['message']
  ];



  if(!$errors){
    $to= _APP_EMAIL_;
    $email = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);
    $subject = '[Garage Parrot] Formulaire de contact';
    $emailContent = "Email : $email<br>"
    ."Prénom: <br>"
    .nl2br(htmlentities($_POST['name']))
    ."Nom: <br>"
    .nl2br(htmlentities($_POST['lastname']))
    ."téléphone: <br>"
    .nl2br(htmlentities($_POST['phone']))
    ."Adresse e-mail: <br>"
    .nl2br(htmlentities($_POST['email']))
    ."Message : <br>"
    .nl2br(htmlentities($_POST['message']));
    $headers = "From: "._APP_EMAIL_ . 
    "\r\n"."MIME-Version: 1.0" . "\r\n".
    "Content-type: text/html; charset=utf-8";
    
    if(mail($to, $subject, $emailContent, $headers)) {
      $messages[]="Votre email a bien été envoyé";
      unset($_SESSION['car']);
    }else {
      $errors[]="Une erreur s'est produite durant l'envoi";
    }

//all information at formReview will be deleted
if (!isset($_GET["id"])) {
  $formCar = [
    'name'=>'',
    'lastname' => '',
    'email' => '',
    'phone' => '',
    'subject'=>'',
    'message' => ''
  ];
} else {
  $errors[] = "Votre messag n'a pas été sauvegardé";
}
  }
}
?>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <?php require __DIR__ . "/templates/breadcrumb-part.php" ?>
  <!-- END BREADCRUMB  -->

  <!-- CONTACT  BUY CAR-->
  <section class="contact contact-buy-car sections" id="contact">
    <h1 class="header-titles">Contact achat</h1>
    <p class="contact-buy-car-txt">Service? Rendez-vous? Voiture d'occasion? N'hésitez pas à nous rejoindre.</p>

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

    <?php if ($formCar !== false) { ?>

    <div class="contact-wrapper">

      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="contact-form">
          <div class="contact-form-left">
            <div>
              <label for="lastname">Nom</label>
              <input type="text" name="lastname" id="lastname" minlength="3" maxlength="25" placeholder="Dupont"
                autocomplete="off" value=<?= htmlspecialchars($formCar['lastname']); ?>>
            </div>
            <div>
              <label for="name">Prénom</label>
              <input type="text" name="name" id="name" minlength="3" maxlength="25" placeholder="Guillaume"
                autocomplete="off" value=<?= htmlspecialchars($formCar['name']); ?>>
            </div>
            <div>
              <label for="email">Adresse email</label>
              <input type="text" name="email" id="email" maxlength="40" placeholder="email@example.fr"
                autocomplete="off" value=<?= htmlspecialchars($formCar['email']); ?>>
            </div>
            <div>
              <label for="phone">Téléphone</label>
              <input type="text" name="phone" id="phone" minlength="9" maxlength="15" placeholder="0105456789"
                autocomplete="off" value=<?= htmlspecialchars($formCar['phone']); ?>>
            </div>
          </div>
          <div class="contact-form-right">
            <div>
              <label for="subject">Sujet</label>
              <input type="text" name="subject" id="subject" autocomplete="off"
                value="<?= $_SESSION['car']['code']  . " " . $_SESSION['car']['brand'] . " " . $_SESSION['car']['model']; ?>">

            </div>
            <div>
              <label for="message">Message</label>
              <textarea name="message" id="message" cols="30" rows="5"
                autocomplete="off"><?= htmlspecialchars($formCar['message']); ?></textarea>
            </div>
          </div>
        </div>
        <img src="<?= _GARAGE_IMAGES_FOLDER_ . htmlspecialchars($_SESSION['car']['image'])?>"
          alt="<?= $_SESSION['car']['brand']." ". $_SESSION['car']['model']?>" class="w-25">
        <div class="form-btn">
          <input type="submit" value="Envoyer" class="btn-fill">
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT BUY CAR -->
</div>

<?php } else { ?>
<div class="not-found">
  <!-- <h1 class="not-found-text">Employé non trouvé</h1> -->
  <div class="go-back-page">
    <a href="javascript:history.back(1)" class="btn-wire">Retour page précédante</a>
  </div>
</div>
<?php } ?>

<?php
require_once __DIR__ . "/templates/footer.php";

?>