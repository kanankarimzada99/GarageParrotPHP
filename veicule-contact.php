<?php
require_once __DIR__."/templates/header.php";
?>



<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs">
    <ul class="breadcrumb">
      <li><a href="#">Accueil</a></li>
      <li><a href="#">Veicules d'occasion</a></li>
      <li><a href="#">Renault Clio - 5</a></li>
      <li><a href="#" class="isDisabled">Contact Achat</a></li>
    </ul>
    <div class="go-back-list">
      <a href="#">Revenir liste</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->


  <!-- CONTACT  BUY CAR-->
  <section class="contact contact-buy-car sections" id="contact">
    <h2 class="header-titles">Contact achat</h2>
    <p class="contact-buy-car-txt">Service? Rendez-vous? Voiture d'occasion? N'hésitez pas à nous rejoindre.</p>

    <div class="contact-wrapper">


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
              <input type="text" name="subject" id="subject" value="Annonce numero 34 Renault Clio 5">
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
  <!-- END CONTACT BUY CAR -->
</div>



<?php
 require_once __DIR__."/templates/footer.php";
?>