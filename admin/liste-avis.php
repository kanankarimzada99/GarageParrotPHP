<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/reviews.php";
require_once __DIR__ . "/templates/header-admin.php";

if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}
//get reviews
$reviews = getReviews($pdo, _ADMIN_ITEM_PER_PAGE_, $page);

//get total number of reviews
$totalreviews = getTotalReviews($pdo);

//total pages according to total reviews
$totalPages = ceil($totalreviews / _ADMIN_ITEM_PER_PAGE_);
?>

<div class="wrapper">
  <!-- connection  -->
  <section class="connection">
    <div class="connection-header">
      <h1 class="header-titles">Liste Avis Clients</h1>
      <a href="ajouter-avis.php" class="btn  btn-fill">Ajouter</a>
    </div>

    <div class="connection-wrapper wrapper">
      <div class="connection-table">
        <table>
          <tr>
            <th>Nom du client</th>
            <th class="w-75">Commentaire</th>
            <th>Note</th>
            <th class="size100">action</th>
          </tr>
          <tbody>
            <?php foreach ($reviews as $review) { ?>
              <tr>
                <td><?= $review["client"]; ?></td>
                <td><?= $review["comment"]; ?></td>
                <td><?= $review["note"]; ?></td>
                <td><a href="modifier-avis.php?id=<?= $review['id'] ?>"><i class="fa-solid fa-pencil"></i></a>
                  | <a href="delete-review.php?id=<?= $review['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?')"><i class="fa-solid fa-trash-can"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <nav aria-label="Page navigation reviews">
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