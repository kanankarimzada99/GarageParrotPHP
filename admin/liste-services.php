<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/services.php";
require_once __DIR__ . "/templates/header-admin.php";


if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}

//get employees
$services = getServices($pdo, _ADMIN_ITEM_PER_PAGE_, $page);

//get total number of employees
$totalServices = getTotalServices($pdo);

//total pages according to total employees
$totalPages = ceil($totalServices / _ADMIN_ITEM_PER_PAGE_);
?>

<div class="wrapper">
  <!-- connection  -->
  <section class="connection">
    <div class="connection-header">
      <h1 class="header-titles">Liste Services</h1>
      <a href="ajouter-service.php" class="btn btn-fill">Ajouter</a>
    </div>

    <div class="connection-wrapper wrapper">
      <div class="connection-table">
        <table>
          <tr>
            <!-- <th>#</th> -->
            <th>Service</th>
            <th class="w-50">Description</th>
            <th>image</th>
            <th class="size100">action</th>
          </tr>
          <tbody>
            <?php foreach ($services as $service) { ?>
              <tr>
                <!-- <th scope="row"><?= $service["id"]; ?></th> -->
                <td><?= $service["service"]; ?></td>
                <td><?= $service["description"]; ?></td>
                <td><?= $service["image"]; ?></td>

                <td><a href="modifier-service.php?id=<?= $service['id'] ?>"><i class="fa-solid fa-pencil"></i></a>
                  | <a href="delete-service.php?id=<?= $service['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')"><i class="fa-solid fa-trash-can"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <nav aria-label="Page navigation employes">
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
  </section>
  <!-- END connection  -->
</div>
<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>