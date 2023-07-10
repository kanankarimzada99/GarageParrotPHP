<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/templates/header-admin.php";


if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}

//get cars
$cars = getCars($pdo);

//get total number of cars
$totalCars = getTotalCars($pdo);

//total pages according to total cars
$totalPages = ceil($totalCars / _ADMIN_ITEM_PER_PAGE_);

?>
<div class="wrapper">

  <!-- connection  -->
  <section class="connection">
    <div class="connection-header">
      <h1 class="header-titles">Liste Voitures</h1>
      <a href="/admin/ajouter-voiture.php" class="btn  btn-fill">Ajouter</a>
    </div>

    <div class="connection-wrapper wrapper p-2">
      <div class="connection-table">
        <table>
          <tr>
            <!-- <th>Code</th> -->
            <!-- <th>Titre</th> -->
            <th>Code</th>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Année</th>
            <th>Prix</th>
            <th>Km</th>
            <th>Couleur</th>
            <th class="size100">Boite vitesse</th>
            <th>Portes</th>
            <th>Carburant</th>
            <th>CO2</th>
            <th>Images</th>
            <th class="size100">action</th>
          </tr>
          <!-- <tr>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>Lorem</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr> -->
          <tbody>
            <?php foreach ($cars as $car) { ?>
            <tr>
              <!-- <th scope="row"><?= $car["id"]; ?></th> -->
              <td><?= $car["code"]; ?></td>
              <td><?= $car["brand"]; ?></td>
              <td><?= $car["model"]; ?></td>
              <td><?= $car["year"]; ?></td>
              <td><?= $car["price"]; ?></td>
              <td><?= $car["kilometers"]; ?></td>
              <td><?= $car["color"]; ?></td>
              <td><?= $car["gearbox"]; ?></td>
              <td><?= $car["number_doors"]; ?></td>
              <td><?= $car["fuel"]; ?></td>
              <td><?= $car["co"]; ?></td>
              <td><?= $car["image"]; ?></td>


              <td><a href="modifier-voiture.php?id=<?= $car['id'] ?>"><i class="fa-solid fa-pencil"></i></a>
                | <a href="delete-voiture.php?id=<?= $car['id'] ?>"
                  onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')"><i
                    class="fa-solid fa-trash-can"></i></a>
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
?>