<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/services.php";
require_once __DIR__ . "/templates/header-admin.php";


if ($_SESSION['user']['role'] === 'employee') {
  header("location: /admin/liste-voitures.php");
}

if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}

//get employees
$services = getServices($pdo, 600, $page);




//get total number of employees
$totalServices = getTotalServices($pdo);



//total pages according to total employees
$totalPages = ceil($totalServices / _ADMIN_ITEM_PER_PAGE_);





?>



<div class="wrapper">
  <!-- connection  -->
  <section class="connection">
    <div class="connection-header">
      <h2 class="header-titles">Liste Services</h2>
      <a href="ajouter-service.php" class="btn  btn-fill">Ajouter</a>
    </div>

    <div class="connection-wrapper wrapper">
      <div class="connection-table">
        <table>
          <tr>
            <!-- <th>#</th> -->
            <th>Service</th>
            <th class="w-50">Description</th>
            <th>image</th>
            <th style="min-width:100px">action</th>
          </tr>
          <!-- <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr> -->
          <tbody>
            <?php foreach ($services as $service) { ?>
            <tr>
              <!-- <th scope="row"><?= $service["id"]; ?></th> -->
              <td><?= $service["service"]; ?></td>
              <td><?= $service["description"]; ?></td>
              <td><?= $service["image"]; ?></td>

              <td><a href="modifier-service.php?id=<?= $service['id'] ?>"><i class="fa-solid fa-pencil"></i></a>
                | <a href="delete-service.php?id=<?= $service['id'] ?>"
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