<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/schedules.php";
require_once __DIR__ . "/templates/header-admin.php";

if ($_SESSION['user']['role'] === 'employee') {
  header("location: /admin/liste-voitures.php");
}

if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}

//get schedules
$schedules = getSchedules($pdo);

//get total number of employees
$totalSchedules = getTotalSchedules($pdo);

?>
<div class="wrapper">
  <!-- connection  -->
  <section class="connection">
    <div class="connection-header">
      <h2 class="header-titles">Liste Horaires d'ouverture</h2>
    </div>

    <div class="connection-wrapper wrapper">
      <div class="connection-table">
        <table>
          <tr>
            <th>Jour</th>
            <th>Matin début</th>
            <th>Matin fin</th>
            <th>Midi début</th>
            <th>Midi fin</th>
            <th class="size100">action</th>
          </tr>
          <tbody>
            <?php foreach ($schedules as $schedule) { ?>
            <tr>
              <!-- <th scope="row"><?= $schedule["id"]; ?></th> -->
              <td><?= $schedule["day"]; ?></td>

              <?php if($schedule["morningOpen"] !== "00:00"){?>
              <td><?= $schedule["morningOpen"]; ?></td>
              <?php } else { ?>
              <td><?= "fermé" ?></td>
              <?php } ?>

              <?php if($schedule["morningClose"] !== "00:00"){?>
              <td><?= $schedule["morningClose"]; ?></td>
              <?php } else { ?>
              <td><?= "fermé" ?></td>
              <?php } ?>

              <?php if($schedule["afternoonOpen"] !== "00:00"){?>
              <td><?= $schedule["afternoonOpen"]; ?></td>
              <?php } else { ?>
              <td><?= "fermé" ?></td>
              <?php } ?>

              <?php if($schedule["afternoonClose"] !== "00:00"){?>
              <td><?= $schedule["afternoonClose"]; ?></td>
              <?php } else { ?>
              <td><?= "fermé" ?></td>
              <?php } ?>

              <td><a href="modifier-horaire.php?id=<?= $schedule['id'] ?>"><i class="fa-solid fa-pencil"></i></a>
              </td>

            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <!-- END connection  -->
</div>
<?php
require_once __DIR__."/templates/footer-admin.php";
// require_once __DIR__."/../lib/session.php";
// adminOnly();
?>