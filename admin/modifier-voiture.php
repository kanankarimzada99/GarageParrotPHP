<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/templates/header-admin.php";

$_SESSION['token'] = bin2hex(random_bytes(30));

$id = null;
$car = null;
$fileName = null;
$errors = [];
$messages = [];


if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];

  $car = getCarsById($pdo, $id);

  $_SESSION['car'] = $car;
  $carImages = getCarImagesById($pdo, $id);
}
?>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-voitures.php">Revenir liste voitures</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h1 class="header-titles">Modifier voiture</h1>

    <?php if ($car) : ?>
      <!-- messages  -->
      <div id="form-message" class="my-3 mt-3 d-flex justify-content-center"></div>

      <div class="w-100 text-center mt-5 d-none" id="backPage">
        <a href="javascript:history.back(1)" class="btn-fill ">Retourner liste voiture</a>
      </div>


      <div class="connection-wrapper">
        <form id="modifyCar" method="POST" enctype="multipart/form-data">
          <div class="connection-form add-car">

            <div class="model">
              <div class="model-bottom">
                <div class="form-group">
                  <label for="code">Code</label>
                  <input type="text" name="code" id="code" minlength="6" maxlength="6" placeholder="BMW033" autocomplete="off" value="<?= htmlspecialchars_decode($car['code'], ENT_NOQUOTES); ?>">
                  <span class="error" id="code_err"></span>
                </div>
                <div class="form-group">
                  <label for="brand">Marque</label>
                  <input type="text" name="brand" id="brand" minlength="3" maxlength="15" placeholder="Tesla" autocomplete="off" value="<?= htmlspecialchars_decode($car['brand'], ENT_NOQUOTES); ?>">
                  <span class="error" id="brand_err"></span>
                </div>
                <div class="form-group">
                  <label for="model">Modèle</label>
                  <input type="text" name="model" id="model" minlength="3" maxlength="15" placeholder="Max 5" autocomplete="off" value="<?= htmlspecialchars_decode($car['model'], ENT_NOQUOTES); ?>">
                  <span class="error" id="model_err"></span>
                </div>
              </div>
            </div>

            <div class="car-description">

              <!-- LEFT SIDE  -->
              <div class="car-description-left">
                <div class="form-group">
                  <label for="year">Année</label>
                  <input type="text" name="year" id="year" minlength="4" maxlength="4" placeholder="2002" autocomplete="off" value="<?= htmlspecialchars_decode($car['year'], ENT_NOQUOTES); ?>">
                  <span class="error" id="year_err"></span>
                </div>
                <div class="form-group">
                  <label for="kilometer">Kilométrage</label>
                  <input type="text" name="kilometer" id="kilometer" minlength="3" maxlength="6" placeholder="92233" autocomplete="off" value="<?= htmlspecialchars_decode($car['kilometers'], ENT_NOQUOTES); ?>">
                  <span class="error" id="kilometer_err"></span>
                </div>
                <div class="form-group">
                  <label for="gearbox">Boîte de vitesses</label>
                  <input type="text" name="gearbox" id="gearbox" minlength="6" maxlength="12" placeholder="manuelle" autocomplete="off" value="<?= htmlspecialchars_decode($car['gearbox'], ENT_NOQUOTES); ?>">
                  <span class="error" id="gearbox_err"></span>
                </div>
                <div class="form-group">
                  <label for="doors">Numéro de portes</label>
                  <input type="text" name="doors" id="doors" minlength="1" maxlength="1" placeholder="2" autocomplete="off" value="<?= htmlspecialchars_decode($car['number_doors'], ENT_NOQUOTES); ?>">
                  <span class="error" id="doors_err"></span>
                </div>
              </div>

              <!-- RIGHT SIDE  -->
              <div class="car-description-right">
                <div class="form-group">
                  <label for="price">Prix</label>
                  <input type="text" name="price" id="price" minlength="4" maxlength="6" placeholder="12768" autocomplete="off" value="<?= htmlspecialchars_decode($car['price'], ENT_NOQUOTES); ?>">
                  <span class="error" id="price_err"></span>
                </div>
                <div class="form-group">
                  <label for="color">Couleur</label>
                  <input type="text" name="color" id="color" minlength="3" maxlength="15" placeholder="rouge" autocomplete="off" value="<?= htmlspecialchars_decode($car['color'], ENT_NOQUOTES); ?>">
                  <span class="error" id="color_err"></span>
                </div>
                <div class="form-group">
                  <label for="fuel">Carburant</label>
                  <input type="text" name="fuel" id="fuel" minlength="6" maxlength="12" placeholder="életrique" autocomplete="off" value="<?= htmlspecialchars_decode($car['fuel'], ENT_NOQUOTES); ?>">
                  <span class="error" id="fuel_err"></span>
                </div>
                <div class="form-group">
                  <label for="co2">CO2</label>
                  <input type="text" name="co2" id="co2" minlength="1" maxlength="4" placeholder="123" autocomplete="off" value="<?= htmlspecialchars_decode($car['co'], ENT_NOQUOTES); ?>">
                  <span class="error" id="co2_err"></span>
                </div>
                <div class="form-group d-flex justify-content-start">

                  <div class="d-flex align-items-center w-100">
                    <input type="checkbox" id="imgCar" name="imgCar" value="0" class="col-2">
                    <label for="imgCar">Ajouter image?</label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="inputFile">
                    <label for="file">Ajouter image(s)</label>
                    <input type="file" name="file[]" id="file" multiple accept=".jpeg, .jpg, .png, .webp">
                    <span class="error" id="image_err"> </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php if (count($carImages)) { ?>

            <!-- car thumbnails  -->
            <div class="table-cars">
              <div class="table-car-delete">
                <div class="checkbox-delete">
                  <p class="text-center">Selectionnez tout</p>
                  <input type="checkbox" id="checkAll">
                </div>

                <div class="button-delete">
                  <button type="button" class="btn btn-wire" id="delete">Supprimer selection</button>
                </div>

              </div>
              <?php foreach ($carImages as $car) { ?>
                <div class="table-car">
                  <input type="checkbox" class="checkboxCars" id="<?php echo $car['id'] ?>" name="id[]">
                  <div class="table-car-img">
                    <img src="<?= _GARAGE_IMAGES_FOLDER_ . htmlspecialchars_decode($car['image_path']) ?>" alt="<?= $car['brand'] ?>" loading="lazy">
                  </div>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
          <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
          <div class="form-btn mt-2">
            <button type="button" id="submitbtn" class="btn-fill">Modifier</button>
          </div>
        </form>
      </div>
  </section>
</div>

<?php
      require_once __DIR__ . "/templates/footer-admin.php";
?>

<script>
  $(document).ready(function() {
    $('#checkAll').click(function() {
      if (this.checked) {
        $('.checkboxCars').each(function() {
          this.checked = true
        })
      } else {
        $('.checkboxCars').each(function() {
          this.checked = false
        })
      }
    })

    $('#delete').click(function() {
      var dataArr = new Array()
      if ($('.checkboxCars:checked').length > 0) {
        $('.checkboxCars:checked').each(function() {
          dataArr.push($(this).attr('id'))
          $(this).closest('div').remove()
        })
        sendResponse(dataArr)

      } else {
        alert('Aucune image selectionné')
      }
    })

    function sendResponse(dataArr) {
      $.ajax({
        type: 'post',
        url: 'deleteCars.php',
        data: {
          'data': dataArr
        },
        success: function(response) {
          alert(response)
          if ($('.table-car').length == 0) {
            $('.table-cars').hide()
          } else {
            $('.table-cars').show()
          }

        },
        error: function(errResponse) {
          alert(errResponse)
        }
      })

    }
  })
</script>


<script src="../assets/scripts/modifyCarForm.js"></script>

<!-- show / hide upload button  -->
<script>
  let changeImg = document.getElementById("imgCar");
  let inputFile = document.querySelector(".inputFile");

  const checkClick = () => {
    if (inputFile.style.display === "block") {
      inputFile.style.display = "none";
    } else {
      inputFile.style.display = "block";
    }
  }

  changeImg.addEventListener('change', checkClick)
</script>

<?php else : ?>
  <div id="form-message" class="d-flex justify-content-center">
    <div class='d-flex justify-content-center  alert alert-danger mt-5 mb-3 mx-auto' role='alert'>Cette voiture n'existe
      pas</div>
  </div>

  <div class="go-back-page my-3 d-flex justify-content-center">
    <a href="javascript:history.back(1)" class="btn-wire mb-5">Retourner liste voitures</a>
  </div>
<?php endif ?>