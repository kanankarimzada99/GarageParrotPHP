<?php
require_once __DIR__."/../templates/header-admin.php";
?>

<div class="wrapper">

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h2 class="header-titles">Modifier Horaire</h2>
    <div class="connection-wrapper w-max">

      <form action="">
        <div class="schedule-form">
          <div class="form-day center">
            <label for="day">Jour de la semaine</label>
            <input type="text" name="day" id="day" placeholder="lundi" class="large">
          </div>
          <fieldset>
            <legend>Matin</legend>
            <div class="form-group">
              <label for="morning-open">Ouverture</label>
              <input type="text" name="morning-open" id="morning-open" placeholder="00:00">
            </div>
            <div class="form-group">
              <label for="morning-close">Fermeture</label>
              <input type="text" name="morning-close" id="morning-close" placeholder="00:00">
            </div>
          </fieldset>
          <fieldset>
            <legend>Après-midi</legend>
            <div class="form-group">
              <label for="afternoon-open">Ouverture</label>
              <input type="text" name="afternoon-open" id="afternoon-open" placeholder="00:00">
            </div>
            <div class="form-group">
              <label for="afternoon-close">Fermeture</label>
              <input type="text" name="afternoon-close" id="afternoon-close" placeholder="00:00">
            </div>
          </fieldset>
        </div>
        <div class="form-btn">
          <button type="submit" value="modify-schedule" class="btn-fill">Modifier</button>
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>
<?php
require_once __DIR__."/../templates/footer-admin.php";
?>