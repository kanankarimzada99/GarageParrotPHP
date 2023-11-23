<?php
require_once __DIR__ . "/admin/templates/header-admin.php";

$error = $_SERVER["REDIRECT_STATUS"] ?? null;

$error_title = '';
$error_message = '';

if ($error === '404') {
  $error_title = "La page que vous recherchez semble introuvable.";
}
?>

<!-- hero-404  -->
<section class="hero-404">
  <div class="hero-404-text">
    <h1 class="hero-404-text-title"> <span>OOOups!</span></h1>
    <p class="hero-404-text-description">
      <span>
        <?php echo $error_title ?>
      </span>
    </p>
    <a href="javascript:history.back(1)" class="btn-fill center">Page precedante</a>
  </div>
</section>
<!-- END hero-404  -->

<?php
require_once __DIR__ . "/templates/footer.php";
?>