<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/../templates/header-navigation.php";

//verify if id is on the URL
$error = false;
if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];

  $car = getCarsById($pdo, $id);

  if ($car) {
    if ($car['image_path'] === "" || $car['image_path'] === null) {
      $imagePath = "/assets/images/no-image.svg";
    } else {
      $imagePath =  '/uploads/images/' . $car["image_path"];
    }

    $_SESSION['car'] = $car;
  }
}
?>

<div class="wrapper">

  <?php if ($car) : ?>

  <!-- BREADCRUMB  -->
  <?php require __DIR__ . "/../templates/breadcrumb-part.php" ?>
  <!-- END BREADCRUMB  -->

  <!-- CONTACT  BUY CAR-->
  <section class="contact contact-buy-car sections" id="contact">
    <h1 class="header-titles">Contact achat</h1>


    <p class="contact-buy-car-txt">Service? Rendez-vous? Voiture d'occasion? N'hésitez pas à nous rejoindre.</p>

    <!-- messages  -->
    <div id="form-message" class="my-3 d-flex justify-content-center"></div>

    <div class="contact-wrapper">

      <form method="POST" id="buyContact">
        <div class="contact-form">
          <div class="contact-form-left">
            <div class="form-group">
              <label for="lastname">Nom</label>
              <input type="text" name="lastname" id="lastname" minlength="3" maxlength="25" placeholder="Dupont"
                autocomplete="off">
              <span class="error" id="lastname_err"> </span>
            </div>
            <div class="form-group">
              <label for="name">Prénom</label>
              <input type="text" name="name" id="name" minlength="3" maxlength="25" placeholder="Guillaume"
                autocomplete="off">
              <span class="error" id="name_err"> </span>
            </div>
            <div class="form-group">
              <label for="email">Adresse email</label>
              <input type="text" name="email" id="email" maxlength="40" placeholder="email@example.fr"
                autocomplete="off">
              <span class="error" id="email_err"> </span>
            </div>
            <div class="form-group">
              <label for="phone">Téléphone</label>
              <input type="text" name="phone" id="phone" minlength="9" maxlength="15" placeholder="0105456789"
                autocomplete="off">
              <span class="error" id="phone_err"> </span>
            </div>
          </div>
          <div class="contact-form-right">
            <div class="form-group">
              <label for="subject">Sujet</label>
              <input type="text" name="subject" id="subject" autocomplete="off" readonly
                value="<?= htmlspecialchars($_SESSION['car']['code']  . " " . $_SESSION['car']['brand'] . " " . $_SESSION['car']['model']); ?>">

            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea name="message" id="message" cols="30" rows="5" autocomplete="off"></textarea>
              <span class="error" id="message_err"> </span>
            </div>
          </div>
        </div>

        <img src="<?= $imagePath; ?>" alt="<?= $_SESSION['car']['brand'] . " " . $_SESSION['car']['model'] ?>"
          class="w-25 image-car">
        <div class="form-btn">
          <button type="button" id="submitbtn" class="btn-fill">Envoyer</button>
        </div>

      </form>
    </div>
    <?php else : ?>
    <div id="form-message" class="d-flex justify-content-center">
      <div class='d-flex justify-content-center  alert alert-danger mt-5 mb-3 mx-auto' role='alert'>Cette voiture
        n'existe
        pas</div>
    </div>

    <div class="go-back-page my-3 d-flex justify-content-center">
      <a href="javascript:history.back(1)" class="btn-wire mb-5">Retour page précédante</a>
    </div>
    <?php endif ?>

  </section>
</div>
<script src="../assets/scripts/validationContactBuyCar.js"></script>
<?php
require_once __DIR__ . "/../templates/footer.php";
?>