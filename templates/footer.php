<?php
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/schedules.php";

// get schedules information 
$schedules = getSchedules($pdo);
?>

</main>
<!-- FOOTER   -->
<footer id="schedules" class="footer">
  <div class="footer-logo">
    <img src="/assets/images/logo_white.png" alt="logo garage parrot">
  </div>
  <div class="footer-schedule">
    <div class="footer-local">
      <p class="footer-local-owner">Vicent Parrot</p>
      <div class="footer-phone">
        <i class="fa-solid fa-phone icon"></i>
        <p>555-555-5455</p>
      </div>
      <div class="footer-email">
        <i class="fa-solid fa-envelope icon"></i>
        <p>vparrot@garageparrot.net</p>
      </div>
      <div class="footer-address">
        <p>45 Av. Gen. Foch 31000 Toulouse</p>
      </div>
    </div>
    <div class="footer-days">
      <h5 class="footer-days-title">Horaires d'ouverture</h5>

      <?php foreach ($schedules as  $schedule) { ?>
        <?php require __DIR__ . "/footer-part.php" ?>
      <?php }
      ?>
    </div>
  </div>
  <div class="footer-navigation">
    <nav class="footer-nav">

      <ul class="footer-nav-list">
        <li>
          <a class="footer-nav-link" aria-current="page" href="#">Accueil</a>
        </li>
        <li>
          <a class="footer-nav-link" aria-current="page" href="#services">Services</a>
        </li>
        <li>
          <a class="footer-nav-link" aria-current="page" href="#cars">Voitures</a>
        </li>
        <li>
          <a class="footer-nav-link" aria-current="page" href="#testimonial">Avis</a>
        </li>
        <li>
          <a class="footer-nav-link" aria-current="page" href="#contact">Contact</a>
        </li>
        <li>
          <a class="footer-nav-link" aria-current="page" href="#schedules">Horaires</a>
        </li>
      </ul>
    </nav>
    <div class="footer-social-network">
      <a href="#"><i class="fa-brands fa-square-facebook"></i></a>
      <a href="#"><i class="fa-brands fa-square-instagram"></i></a>
      <a href="#"><i class="fa-brands fa-square-twitter"></i></a>
    </div>
  </div>
</footer>


<!-- END FOOTER   -->

<script src="/assets/scripts/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script src="/assets/scripts/scripts.js"></script>
<script src="/assets/scripts/topbutton.js"></script>
</body>

</html>