<?php
require_once __DIR__."/../templates/header-connexion.php";
?>

<div class="wrapper">

  <!-- connection  -->
  <section class="connection w-min sections" id="connection">
    <h2 class="header-titles">connexion</h2>
    <div class="connection-wrapper w-min">

      <form action="">
        <div class="connection-form">
          <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="text" name="email" id="email">
          </div>
          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="text" name="password" id="password">
          </div>
        </div>
        <div class="form-btn">
          <input type="submit" value="connection" class="btn-fill">
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>

<?php
require_once __DIR__."/../templates/footer-connexion.php";
?>