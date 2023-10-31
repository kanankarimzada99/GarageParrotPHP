<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/../lib/carImages.php";
require_once __DIR__ . "/templates/header-admin.php";



$id = null;
$car = null;
$fileName = null;
$errors = [];
$messages = [];
$formCar = [
  'code' => '',
  'brand' => '',
  'model' => '',
  'year' => '',
  'kilometer' => '',
  'gearbox' => '',
  'doors' => '',
  'price' => '',
  'color' => '',
  'fuel' => '',
  'co2' => ''
];



if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  // $_SESSION['user']['id'] = $id;

  $car = getCarsById($pdo, $id);

  $_SESSION['car'] = $car;
  $carImages = getCarImagesById($pdo, $id);


  if ($car === false) {
    $errors[] = "Cette voiture n'existe pas";
  }
}

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//   //verify errors inside the form

//   //to validate code
//   if (empty($_POST['code'])) {
//     $errors[] = "Le code est requis.";
//   } elseif (!preg_match(_REGEX_CODE_, $_POST['code'])) {
//     $errors[] = "Le code doit contenir uniquement des lettres et chiffres. Trois lettres et trois numeros";
//   }

//   //to validate brand
//   if (empty($_POST['brand'])) {
//     $errors[] = "La marque est requis.";
//   } elseif (!preg_match(_REGEX_BRAND_, $_POST['brand'])) {
//     $errors[] = "La marque doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 25 caractères.";
//   }
//   //to validate model
//   if (empty($_POST['model'])) {
//     $errors[] = "Le modèle est requis.";
//   } elseif (!preg_match(_REGEX_MODEL_, $_POST['model'])) {
//     $errors[] = "Le modèle doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 25 caractères.";
//   }
//   //to validate year
//   if (empty($_POST['year'])) {
//     $errors[] = "L'anneé est requis.";
//   } elseif (!preg_match(_REGEX_YEAR_, $_POST['year'])) {
//     $errors[] = "L'anneé doit contenir uniquement des chiffres et avoir une longueur maximale de 4 caractères.";
//   }
//   //to validate kilometer
//   if (empty($_POST['kilometer'])) {
//     $errors[] = "La Kilométrage est requis.";
//   } elseif (!preg_match(_REGEX_KILOMETERS_, $_POST['kilometer'])) {
//     $errors[] = "La Kilométrage doit contenir uniquement des chiffres et avoir une longueur maximale de 6 caractères.";
//   }
//   //to validate gearbox
//   if (empty($_POST['gearbox'])) {
//     $errors[] = "La boîte de vitesses est requis.";
//   } elseif (!preg_match(_REGEX_GEARBOX_, $_POST['gearbox'])) {
//     $errors[] = "La boîte de vitesses doit contenir uniquement des lettres et avoir une longueur maximale de 15 caractères.";
//   }
//   //to validate doors
//   if (empty($_POST['doors'])) {
//     $errors[] = "Le numéro de portes est requis.";
//   } elseif (!preg_match(_REGEX_DOORS_, $_POST['doors'])) {
//     $errors[] = "Le numéro de portes doit contenir uniquement des chiffres et avoir une longueur maximale de 2 caractères.";
//   }
//   //to validate price
//   if (empty($_POST['price'])) {
//     $errors[] = "Le prix est requis.";
//   } elseif (!preg_match(_REGEX_PRICE_, $_POST['price'])) {
//     $errors[] = "Le prix doit contenir uniquement des chiffres et avoir une longueur maximale de 10 caractères.";
//   }
//   //to validate color
//   if (empty($_POST['color'])) {
//     $errors[] = "La couleur est requis.";
//   } elseif (!preg_match(_REGEX_COLOR_, $_POST['color'])) {
//     $errors[] = "La couleur doit contenir uniquement des lettres et espaceset avoir une longueur maximale de 15 caractères.";
//   }
//   //to validate fuel
//   if (empty($_POST['fuel'])) {
//     $errors[] = "Le carburant est requis.";
//   } elseif (!preg_match(_REGEX_FUEL_, $_POST['fuel'])) {
//     $errors[] = "Le carburant doit contenir uniquement des lettres et avoir une longueur maximale de 15 caractères.";
//   }
//   //to validate c02
//   if (empty($_POST['co2'])) {
//     $errors[] = "Le CO2 est requis.";
//   } elseif (!preg_match(_REGEX_CO2_, $_POST['co2'])) {
//     $errors[] = "Le CO2 doit contenir uniquement des chiffres et avoir une longueur maximale de 3 caractères.";
//   }

//   $imagePath = null;

//   //verify if a file is sent
//   if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {
//     $sizeImage = getimagesize($_FILES['file']['tmp_name']);
//     if ($sizeImage !== false) {

//       //delete spaces into the name and make name file with lowercase letters
//       $fileName = slugify(basename($_FILES['file']['name']));

//       //generate unique ID for a file
//       $fileName = uniqid() . '-' . $fileName;

//       //move file image into new location (uploads images folder)  

//       if (move_uploaded_file($_FILES['file']['tmp_name'], dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $fileName)) {

//         if (isset($_FILES['file']['name'])) {

//           // $service = getServicesById($pdo, $_SESSION['service']['id']);

//           if (file_exists(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['file']['name'])) {
//             //delete old image if new one is uploaded
//             unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['file']['name']);
//           } else {
//             $messages[] = "image remplace avec success";
//           }
//         }
//       } else {
//         $errors[] = "Le fichier n'a pas été uploadé";
//       }
//     } else {
//       $errors[] = "Le format d'image n'est pas valide. Seulement jpg, jpeg, png ou webp sont permit.";
//     }
//   }

//   //to validate image
//   if (isset($_POST['imgCar'])) {
//     if (empty($_FILES['file']['name'])) {
//       $errors[] = "L'image pour le service est requis.";
//     }
//   }


//   //put information from form to formEmployee
//   $formCar = [
//     'code' => $_POST['code'],
//     'brand' => $_POST['brand'],
//     'model' => $_POST['model'],
//     'year' => $_POST['year'],
//     'kilometer' => $_POST['kilometer'],
//     'gearbox' => $_POST['gearbox'],
//     'doors' => $_POST['doors'],
//     'price' => $_POST['price'],
//     'color' => $_POST['color'],
//     'fuel' => $_POST['fuel'],
//     'co2' => $_POST['co2'],
//     'image' => $_POST['image']
//   ];


//   //if no errors we save all information
//   if (!$errors) {
//     if (isset($_SESSION['user']['id'])) {
//       //the id will be int
//       $id = (int)$_SESSION['user']['id'];
//     } else {
//       $id = null;
//     }

//     //all data will be saved at saveEmployee function
//     $id = $_SESSION['user']['id'];

//     if (isset($_POST['imgCar'])) {
//       $res = saveCar($pdo, $_POST['code'], $_POST['brand'], $_POST['model'], $_POST['year'], $_POST['kilometer'], $_POST['gearbox'], $_POST['doors'], $_POST['price'], $_POST['color'], $_POST['fuel'], $_POST['co2'],   $id);
//     } else {
//       $res = saveCar($pdo, $_POST['code'], $_POST['brand'], $_POST['model'], $_POST['year'], $_POST['kilometer'], $_POST['gearbox'], $_POST['doors'], $_POST['price'], $_POST['color'], $_POST['fuel'], $_POST['co2'],   $id);
//     }

//     if ($res) {
//       $messages[] = "Le service a bien été sauvegardé";

//       //all information at formService will be deleted
//       if (!isset($_GET["id"])) {
//         $formCar = [
//           'code' => '',
//           'brand' => '',
//           'model' => '',
//           'year' => '',
//           'kilometer' => '',
//           'gearbox' => '',
//           'doors' => '',
//           'price' => '',
//           'color' => '',
//           'fuel' => '',
//           'co2' => '',
//           'car-image' => ''
//         ];
//         unset($_SESSION['car']);
//       } else {
//         $errors[] = "Le service n'a pas été sauvegardé";
//       }
//     }
//   }
// }
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
      <div id="form-message" class="my-3 d-flex justify-content-center"></div>


      <div class="connection-wrapper">
        <form id="modifyCar" method="POST" enctype="multipart/form-data">
          <div class="connection-form add-car">

            <div class="model">
              <div class="model-bottom">
                <div class="form-group">
                  <label for="code">Code</label>
                  <input type="text" name="code" id="code" minlength="6" maxlength="6" placeholder="BMW033" autocomplete="off" value="<?= htmlspecialchars_decode($car['code'] ?? $formCar['code'], ENT_NOQUOTES); ?>">
                  <span class="error" id="code_err"></span>
                </div>
                <div class="form-group">
                  <label for="brand">Marque</label>
                  <input type="text" name="brand" id="brand" minlength="3" maxlength="15" placeholder="Tesla" autocomplete="off" value="<?= htmlspecialchars_decode($car['brand'] ?? $formCar['brand'], ENT_NOQUOTES); ?>">
                  <span class="error" id="brand_err"></span>
                </div>
                <div class="form-group">
                  <label for="model">Modèle</label>
                  <input type="text" name="model" id="model" minlength="3" maxlength="15" placeholder="Max 5" autocomplete="off" value="<?= htmlspecialchars_decode($car['model'] ?? $formCar['model'], ENT_NOQUOTES); ?>">
                  <span class="error" id="model_err"></span>
                </div>
              </div>
            </div>

            <div class="car-description">

              <!-- LEFT SIDE  -->
              <div class="car-description-left">
                <div class="form-group">
                  <label for="year">Année</label>
                  <input type="text" name="year" id="year" minlength="4" maxlength="4" placeholder="2002" autocomplete="off" value="<?= htmlspecialchars_decode($car['year'] ?? $formCar['year'], ENT_NOQUOTES); ?>">
                  <span class="error" id="year_err"></span>
                </div>
                <div class="form-group">
                  <label for="kilometer">Kilométrage</label>
                  <input type="text" name="kilometer" id="kilometer" minlength="6" maxlength="6" placeholder="92233" autocomplete="off" value="<?= htmlspecialchars_decode($car['kilometers'] ?? $formCar['kilometer'], ENT_NOQUOTES); ?>">
                  <span class="error" id="kilometer_err"></span>
                </div>
                <div class="form-group">
                  <label for="gearbox">Boîte de vitesses</label>
                  <input type="text" name="gearbox" id="gearbox" minlength="6" maxlength="12" placeholder="manuelle" autocomplete="off" value="<?= htmlspecialchars_decode($car['gearbox'] ?? $formCar['gearbox'], ENT_NOQUOTES); ?>">
                  <span class="error" id="gearbox_err"></span>
                </div>
                <div class="form-group">
                  <label for="doors">Numéro de portes</label>
                  <input type="text" name="doors" id="doors" minlength="1" maxlength="1" placeholder="2" autocomplete="off" value="<?= htmlspecialchars_decode($car['number_doors'] ?? $formCar['doors'], ENT_NOQUOTES); ?>">
                  <span class="error" id="doors_err"></span>
                </div>
              </div>

              <!-- RIGHT SIDE  -->
              <div class="car-description-right">
                <div class="form-group">
                  <label for="price">Prix</label>
                  <input type="text" name="price" id="price" minlength="4" maxlength="6" placeholder="12768" autocomplete="off" value="<?= htmlspecialchars_decode($car['price'] ?? $formCar['price'], ENT_NOQUOTES); ?>">
                  <span class="error" id="price_err"></span>
                </div>
                <div class="form-group">
                  <label for="color">Couleur</label>
                  <input type="text" name="color" id="color" minlength="5" maxlength="10" placeholder="rouge" autocomplete="off" value="<?= htmlspecialchars_decode($car['color'] ?? $formCar['color'], ENT_NOQUOTES); ?>">
                  <span class="error" id="color_err"></span>
                </div>
                <div class="form-group">
                  <label for="fuel">Carburant</label>
                  <input type="text" name="fuel" id="fuel" minlength="5" maxlength="12" placeholder="életrique" autocomplete="off" value="<?= htmlspecialchars_decode($car['fuel'] ?? $formCar['fuel'], ENT_NOQUOTES); ?>">
                  <span class="error" id="fuel_err"></span>
                </div>
                <div class="form-group">
                  <label for="co2">CO2</label>
                  <input type="text" name="co2" id="co2" minlength="1" maxlength="4" placeholder="123" autocomplete="off" value="<?= htmlspecialchars_decode($car['co'] ?? $formCar['co2'], ENT_NOQUOTES); ?>">
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
                  <!-- <p>Delete</p> -->
                  <input type="checkbox" class="checkboxCars" id="<?php echo $car['id'] ?>" name="id[]">
                  <div class="table-car-img">
                    <img src="<?= _GARAGE_IMAGES_FOLDER_ . htmlspecialchars_decode($car['image_path']) ?>" alt="<?= $car['brand'] ?>" loading="lazy">
                  </div>

                </div>
              <?php } ?>
            </div>

          <?php } ?>

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
          // $(this).closest('th').remove()
        })
        sendResponse(dataArr)
        // console.log(dataArr)

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
    <a href="javascript:history.back(1)" class="btn-wire mb-5">Retour page précédante</a>
  </div>

<?php endif ?>