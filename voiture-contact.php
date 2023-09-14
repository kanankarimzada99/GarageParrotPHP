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

  if ($car['image'] === "" || $car['image'] === null) {
    $imagePath = "/assets/images/no-image.svg";
  } else {
    $imagePath =  '/uploads/images/' . $car["image"];
  }

  $_SESSION['car'] = $car;

  //verify if car is on db
  if (!$car) {
    $error = true;
  }
} else {
  $error = true;
}

$id = null;
?>
<!-- send message by form  -->
<script>
  $(document).ready(function() {
    $("form").submit(function(event) {
      event.preventDefault();
      var lastname = $("#lastname").val();
      var name = $("#name").val();
      var email = $("#email").val();
      var phone = $("#phone").val();
      var subject = $("#subject").val();
      var message = $("#message").val();
      var submit = $("#submit").val();
      $(".form-message").load('mailVoiture.php', {
        lastname: lastname,
        name: name,
        email: email,
        phone: phone,
        subject: subject,
        message: message,
        submit: submit
      });
    })
  })
</script>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <?php require __DIR__ . "/templates/breadcrumb-part.php" ?>
  <!-- END BREADCRUMB  -->

  <!-- CONTACT  BUY CAR-->
  <section class="contact contact-buy-car sections" id="contact">
    <h1 class="header-titles">Contact achat</h1>
    <p class="contact-buy-car-txt">Service? Rendez-vous? Voiture d'occasion? N'hésitez pas à nous rejoindre.</p>


    <!-- messages  -->
    <div class="form-message"></div>

    <div class="contact-wrapper">

      <form action="mailVoiture.php" method="POST">
        <div class="contact-form">
          <div class="contact-form-left">
            <div>
              <label for="lastname">Nom</label>
              <input type="text" name="lastname" id="lastname" minlength="3" maxlength="25" placeholder="Dupont" autocomplete="off">
            </div>
            <div>
              <label for="name">Prénom</label>
              <input type="text" name="name" id="name" minlength="3" maxlength="25" placeholder="Guillaume" autocomplete="off">
            </div>
            <div>
              <label for="email">Adresse email</label>
              <input type="text" name="email" id="email" maxlength="40" placeholder="email@example.fr" autocomplete="off">
            </div>
            <div>
              <label for="phone">Téléphone</label>
              <input type="text" name="phone" id="phone" minlength="9" maxlength="15" placeholder="0105456789" autocomplete="off">
            </div>
          </div>
          <div class="contact-form-right">
            <div>
              <label for="subject">Sujet</label>
              <input type="text" name="subject" id="subject" autocomplete="off" disabled value="<?= htmlspecialchars($_SESSION['car']['code']  . " " . $_SESSION['car']['brand'] . " " . $_SESSION['car']['model']); ?>">

            </div>
            <div>
              <label for="message">Message</label>
              <textarea name="message" id="message" cols="30" rows="5" autocomplete="off"></textarea>
            </div>
          </div>
        </div>

        <img src="<?= $imagePath; ?>" alt="<?= $_SESSION['car']['brand'] . " " . $_SESSION['car']['model'] ?>" class="w-25 image-car">
        <div class="form-btn">
          <input type="submit" value="Envoyer" id="submit" name="submit" class="btn-fill">
        </div>

      </form>
    </div>
  </section>
</div>

<?php
require_once __DIR__ . "/templates/footer.php";
?>