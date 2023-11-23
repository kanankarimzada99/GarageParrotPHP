<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/templates/header-admin.php";
$id = null;
if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}

//get cars
$cars = getCars($pdo, _ADMIN_ITEM_PER_PAGE_, $page);


//get total number of cars
$totalCars = getTotalCars($pdo);

//total pages according to total cars
$totalPages = ceil($totalCars / _ADMIN_ITEM_PER_PAGE_);
?>

<!-- if cars and page exist otherwise message error  -->

<div class="wrapper">

  <!-- connection  -->
  <section class="connection">
    <div class="connection-header">
      <h1 class="header-titles">Liste Voitures</h1>
      <a href="/admin/ajouter-voiture.php" class="btn btn-fill">Ajouter</a>
    </div>
    <?php if ($cars && $page) : ?>

      <div class="connection-wrapper wrapper p-2">
        <div class="connection-table">
          <table>
            <tr>
              <th>Code</th>
              <th>Marque</th>
              <th>Modèle</th>
              <th>Année</th>
              <th>Prix</th>
              <th>Km</th>
              <th>Couleur</th>
              <th class="size50">Boite vitesse</th>
              <th>Porte</th>
              <th>Carburant</th>
              <th>CO2</th>
              <th style="width: 10px;">Image</th>
              <th class="size20">action</th>
            </tr>
            <tbody>
              <?php foreach ($cars as $car) { ?>
                <tr>
                  <td><?= $car["code"]; ?></td>
                  <td><?= $car["brand"]; ?></td>
                  <td><?= $car["model"]; ?></td>
                  <td><?= $car["year"]; ?></td>
                  <td><?= number_format($car["price"], 2, ',', '.'); ?></td>
                  <td><?= number_format($car["kilometers"], 0, ',', '.'); ?> </td>
                  <td><?= $car["color"]; ?></td>
                  <td><?= $car["gearbox"]; ?></td>
                  <td><?= $car["number_doors"]; ?></td>
                  <td><?= $car["fuel"]; ?></td>
                  <td><?= $car["co"]; ?></td>
                  <td>
                    <?php if ($car['image_path'] == null) : ?>
                      <p>pas d'image</p>
                    <?php else : ?>
                      <img src="<?= _GARAGE_IMAGES_FOLDER_ . htmlspecialchars_decode($car['image_path']) ?>" alt="<?= $car['brand'] ?>" class="w-100 h-100" loading="lazy">
                    <?php endif ?>
                  </td>

                  <td><a href="modifier-voiture.php?id=<?= $car['carId'] ?>"><i class="fa-solid fa-pencil"></i></a>
                    | <a href="delete-voiture.php?id=<?= $car['carId']  ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette voiture ?')"><i class="fa-solid fa-trash-can"></i></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <nav aria-label="Page navigation voitures">
          <ul class="pagination">
            <?php if ($totalPages > 1) { ?>
              <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item">
                  <a class="page-link <?php if ($i == $page) {
                                        echo " active";
                                      } ?>" href="?page=<?php echo $i; ?>">
                    <?php echo $i; ?>
                  </a>
                </li>
              <?php } ?>
            <?php } ?>
          </ul>
        </nav>
      </div>
    <?php else : ?>
      <article class="cards">
        <h3 class="message my-5">Aucune voiture disponsible pour le moment.</h3>
      </article>
    <?php endif ?>
  </section>
  <!-- END connection  -->
</div>




<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>