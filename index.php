<?php

// require_once __DIR__ . "/lib/pdo.php";
// require_once __DIR__ . "/lib/services.php";
// require_once __DIR__ . "/lib/cars.php";
require_once __DIR__ . "/templates/header.php";



?>



<!-- HERO  -->
<section class="hero">
  <div class="hero-text">
    <h1 class="hero-text-title">La confiance avant tout!</h1>
    <p class="hero-text-description">
      Avec 15 d'experience, nous avont une large gamme de services et
      voitures d'occasion à vous offrir.
    </p>
  </div>
</section>
<!-- END HERO  -->

<div class="wrapper">
  <!-- SERVICES  -->
  <section id="services" class="services sections">
    <h2 class="header-titles">Services</h2>
    <article class="cards">
      <?php foreach ($services as $key => $service) { ?>
      <?php require __DIR__ . "/templates/service-part.php" ?>
      <?php }
      ?>
    </article>
  </section>
  <!-- END SERVICES  -->

  <!-- CARS  -->
  <section id="cars" class="used-cars sections">
    <h2 class="header-titles">Nos voitures d'occasion</h2>
    <article class="cards">

      <?php foreach ($cars as $key => $car) { ?>
      <?php require __DIR__ . "/templates/car-part.php" ?>
      <?php }
      ?>

    </article>
  </section>
  <!-- END CARS  -->
</div>

<!-- testimonial  -->
<section class="testimonial sections" id="testimonial">
  <h2 class="header-titles">Les avis</h2>
  <div id="demo" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">

      <div class="carousel-item active">

        <div class="carousel-caption">
          <div class="stars">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-regular fa-star"></i>
          </div>
          <i class="fa-sharp fa-solid fa-quote-left quote-left"></i>
          <p>
            hubsopot offers a powerr full suite of tools that every marketing team must have. And if you get stuck,
            their suppor tteam will help out. Im using hubsotpo to mage the entire inboud process. In one houre i
            can have a complet leag generation campaing set up.
            tteam will help out. Im using because.
          </p>
          <i class="fa-sharp fa-solid fa-quote-right quote-right"></i>
          <div class="name-caption">Daysi</div>
        </div>
      </div>
      <div class="carousel-item ">
        <div class="carousel-caption">
          <div class="stars">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-regular fa-star"></i>
          </div>
          <i class="fa-sharp fa-solid fa-quote-left quote-left"></i>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut quas perferendis impedit iusto ipsa.
          </p>
          <i class="fa-sharp fa-solid fa-quote-right quote-right"></i>
          <div class="name-caption">Sophia</div>
        </div>
      </div>
      <div class="carousel-item ">
        <div class="carousel-caption">
          <div class="stars">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-regular fa-star"></i>
          </div>
          <i class="fa-sharp fa-solid fa-quote-left quote-left"></i>
          <p>
            Lorem Ipsum is simply dummy text of the printing and
            typesetting industry.
          </p>
          <i class="fa-sharp fa-solid fa-quote-right quote-right"></i>
          <div class="name-caption">Jorge</div>
        </div>
      </div>

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
  <div class="contact-wrapper">
    <h3>Comment pouvons-nous vous aider?</h3>
    <p>Service? Rendez-vous? Voiture d'occasion?</p>
    <p>N'hésitez pas à nous rejoindre.</p>
    <form action="">
      <div class="contact-form">
        <div class="contact-form-left">
          <div>
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname">
          </div>
          <div>
            <label for="name">Prenom</label>
            <input type="text" name="name" id="name">
          </div>
          <div>
            <label for="email">Adresse email</label>
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
            <textarea name="message" id="message" cols="30" rows="10"></textarea>
          </div>
        </div>
      </div>
      <div class="form-btn">

        <input type="submit" value="Envoyer" class="btn-fill">
      </div>
    </form>
  </div>
</section>
<!-- END CONTACT  -->

<?php
require_once __DIR__ . "/templates/footer.php";
?>