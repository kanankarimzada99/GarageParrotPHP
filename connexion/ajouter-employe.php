<?php
require_once __DIR__."/../templates/header-admin.php";
?>

<div class="wrapper">
  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h2 class="header-titles">Ajouter employé</h2>
    <div class="connection-wrapper">
      <form action="">
        <div class="connection-form">
          <div class="form-group">
            <label for="name">Prénom</label>
            <input type="text" name="name" id="name">
          </div>
          <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname">
          </div>
          <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="text" name="email" id="email">
          </div>
          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
          </div>
          <div class="form-group">
            <label for="conf-password">Confirm mot de passe</label>
            <input type="password" name="conf-password" id="conf-password">
          </div>
        </div>
        <div class="form-btn">
          <button type="submit" value="add-employee" class="btn-fill">Ajouter</button>
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>
<?php
require_once __DIR__."/../templates/footer-admin.php";
?>