<?php

require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/session.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/cars.php";
require_once __DIR__ . "/lib/services.php";
require_once __DIR__ . "/lib/reviews.php";
require_once __DIR__ . "/lib/starRating.php";
require_once __DIR__ . "/templates/header.php";

$errors = [];
$messages = [];




$cars = getCars($pdo, 3);
$services = getServices($pdo, 6);
$reviews = getReviews($pdo, 3);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (!isset($_POST['lastname']) || $_POST['lastname'] == '') {
    $errors[] = "Le prénom ne doit pas être vide  ";
  }
  if (!isset($_POST['name']) || $_POST['name'] == '') {
    $errors[] = "Le nom ne doit pas être vide  ";
  }

  if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'adresse e-mail n'est pas valide";
  }



  if (!isset($_POST['phone']) || $_POST['phone'] == '') {
    $errors[] = "Le téléphone ne doit pas être vide  ";
  }
  if (!isset($_POST['subject']) || $_POST['subject'] == '') {
    $errors[] = "Le subjet ne doit pas être vide  ";
  }

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
    }else {
      $errors[]="Une erreur s'est produite durant l'envoi";
    }
  }

 
}



?>

<!-- HERO  -->
<section class="hero">
  <div class="hero-text">
    <h1 class="hero-text-title">La confiance avant tout!</h1>
    <p class="hero-text-description">
      Avec 15 ans d'experience, nous avont une large gamme de services et
      voitures d'occasion à vous offrir.
    </p>
  </div>
</section>
<!-- END HERO  -->


<!-- SERVICES  -->
<section id="services" class="services sections">
  <h2 class="header-titles">Services</h2>
  <article class="cards">
    <?php foreach ($services as  $service) { ?>
    <?php require __DIR__ . "/templates/service-part.php" ?>
    <?php }
    ?>
  </article>
</section>
<!-- END SERVICES  -->

<!-- CARS  -->
<section id="cars" class="used-cars sections">
  <h2 class="header-titles">Nos derniers voitures d'occasion</h2>
  <article class="cards">
    <?php foreach ($cars as  $car) { ?>
    <?php require __DIR__ . "/templates/car-part.php" ?>
    <?php }
    ?>

    <div class="more-cars">
      <a href="voitures.php" class="btn-fill center">Voir plus</a>
    </div>
  </article>
</section>
<!-- END CARS  -->


<!-- testimonial  -->
<section class="testimonial sections" id="testimonial">
  <h2 class="header-titles">Les avis</h2>
  <div id="demo" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">


      <!-- the last reviews  -->
      <div class="carousel-item active">

        <div class="carousel-caption">
          <div class="stars">
            <?php
            echo starRating($reviews[0]['note']); ?>
          </div>
          <i class="fa-sharp fa-solid fa-quote-left quote-left"></i>
          <p>
            <?php echo $reviews[0]['comment']; ?>
          </p>
          <i class="fa-sharp fa-solid fa-quote-right quote-right"></i>
          <div class="name-caption"><?php echo $reviews[0]['client']; ?></div>
        </div>
      </div>


      <!-- foreach to start from 1  -->
      <?php foreach ($reviews as $key =>  $review) :
        if ($key < 1) continue;
        require __DIR__ . "/templates/review-part.php";
      endforeach;
      ?>

    </div>
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
      <i class="fas fa-arrow-left"> </i>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
      <i class="fas fa-arrow-right"> </i>
    </a>
  </div>
</section>

<!-- END TESTIMONIAL  -->

<!-- CONTACT  -->

<section class="contact sections" id="contact">
  <h2 class="header-titles">Contact</h2>


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






  <div class="contact-wrapper">
    <h3>Comment pouvons-nous vous aider?</h3>
    <p>Service? Rendez-vous? Voiture d'occasion?</p>
    <p>N'hésitez pas à nous rejoindre.</p>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
      <div class="contact-form">
        <div class="contact-form-left">
          <div>
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname">
          </div>
          <div>
            <label for="name">Prénom</label>
            <input type="text" name="name" id="name">
          </div>
          <div>
            <label for="email">Adresse e-mail</label>
            <input type="text" name="email" id="email">
          </div>
          <div>
            <label for="phone">Téléphone</label>
            <input type="text" name="phone" id="phone">
          </div>
        </div>
        <div class="contact-form-right">
          <div>
            <label for="subject">Sujet</label>
            <input type="text" name="subject" id="subject">
          </div>
          <div>
            <label for="message">Message</label>
            <textarea name="message" id="message" cols="30" rows="5"></textarea>
          </div>
        </div>
      </div>
      <div class="form-btn">

        <input type="submit" value="Envoyer" name='sendContact' class="btn-fill">
      </div>
    </form>
  </div>
</section>


<!-- END CONTACT  -->

<?php
require_once __DIR__ . "/templates/footer.php";
?>