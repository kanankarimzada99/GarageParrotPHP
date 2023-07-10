<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/templates/header-admin.php";



$errors = [];
$messages = [];
$formCar = [
  'brand' => '',
  'model' => '',
  'year' => '',
  'kilometers' => '',
  'gearbox' => '',
  'doors' => '',
  'price' => '',
  'color' => '',
  'fuel' => '',
  'co2' => '',
  'image'=>''

];
$id = null;


//regex
$regexBrand = '/^[a-zA-Z0-9\s]{1,20}$/';
$regexModel = '/^[a-zA-Z0-9-\s]{1,20}$/';
$regexYear = '/^[0-9\s]{4,20}$/';
$regexKilometers = '/^[0-9]{3,20}$/';
$regexGearbox = '/^[a-zA-Z\s]{3,20}$/';
$regexDoors = '/^[0-9]{1,20}$/';
$regexPrice = '/^[0-9]{4,20}$/';
$regexColor = '/^[a-zA-Z\s]{3,20}$/';
$regexFuel = '/^[a-zA-Z\s]{3,20}$/';
$regexCo2 = '/^[0-9\s]{3,20}$/';





if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $_SESSION['user']['id'] = $id;


  $car = getCarsById($pdo, $id);


  if ($car === false) {
    $errors[] = "Cette voiture n'existe pas";
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {




  //to validate brand
  if (empty($_POST["brand"])) {
    $errors[] = "La marque est requis.";
  } elseif (!preg_match($regexBrand, $_POST["brand"])) {
    $errors[] = "La marque doit contenir uniquement des lettres et avoir une longueur maximale de 20 caractères.";
  }

  //to validate model
  if (empty($_POST["model"])) {
    $errors[] = "Le modèle du service est requis.";
  } elseif (!preg_match($regexModel, $_POST["model"])) {
    $errors[] = "Le modèle doit contenir uniquement des lettres et/ou chiffres et avoir une longueur maximale de 20 caractères.";
  }
  //to validate year
  if (empty($_POST["year"])) {
    $errors[] = "L'année' est requis.";
  } elseif (!preg_match($regexYear, $_POST["year"])) {
    $errors[] = "L'année' doit contenir uniquement des chiffres et avoir une longueur maximale de 4 caractères.";
  }
  //to validate kilometers
  if (empty($_POST["kilometers"])) {
    $errors[] = "Le kilométrage est requis.";
  } elseif (!preg_match($regexKilometers, $_POST["kilometers"])) {
    $errors[] = "Le kilométrage doit contenir uniquement des chiffres et avoir une longueur maximale de 6 caractères.";
  }
  //to validate gearbox
  if (empty($_POST["gearbox"])) {
    $errors[] = "La boîte de vitesses est requis.";
  } elseif (!preg_match($regexGearbox, $_POST["gearbox"])) {
    $errors[] = "La boîte de vitesses doit contenir uniquement des lettres et avoir une longueur maximale de 20 caractères.";
  }
  //to validate doors
  if (empty($_POST["doors"])) {
    $errors[] = "Le numéro de portes est requis.";
  } elseif (!preg_match($regexDoors, $_POST["doors"])) {
    $errors[] = "Le numéro de portes doit contenir uniquement des chiffres et avoir une longueur maximale de 1 caractère.";
  }
  //to validate price
  if (empty($_POST["price"])) {
    $errors[] = "Le prix du service est requis.";
  } elseif (!preg_match($regexPrice, $_POST["price"])) {
    $errors[] = "Le prix doit contenir uniquement des chiffres et avoir une longueur maximale de 10 chiffres.";
  }
  //to validate color
  if (empty($_POST["color"])) {
    $errors[] = "La couleur du service est requis.";
  } elseif (!preg_match($regexColor, $_POST["color"])) {
    $errors[] = "La couleur doit contenir uniquement des lettres et avoir une longueur maximale de 20 caractères.";
  }
  //to validate fuel
  if (empty($_POST["fuel"])) {
    $errors[] = "Le carburant du service est requis.";
  } elseif (!preg_match($regexFuel, $_POST["fuel"])) {
    $errors[] = "Le carburant doit contenir uniquement des lettres et avoir une longueur maximale de 250 caractères.";
  }
  //to validate co2
  if (empty($_POST["co2"])) {
    $errors[] = "Le co2 du service est requis.";
  } elseif (!preg_match($regexCo2, $_POST["co2"])) {
    $errors[] = "Le co2 doit contenir uniquement des chiffres et avoir une longueur maximale de 3 chiffres.";
  }
  //to validate image
  if (empty($_POST["image"])) {
    $errors[] = "L'image de la voiture est requis.";
  }

  // if (!preg_match('/[^\s]+(.*?).(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/', $_POST['image'])) {
  //   $errors[] = "Le format d'image n'est pas valide.";
  // }


$fileName = null;
  //verify if a file is sent
  if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {
    $sizeImage = getimagesize($_FILES['file']['tmp_name']);
    if ($sizeImage !== false) {

      //delete spaces into the name and make name file with lowercase letters
      $fileName = slugify(basename($_FILES['file']['name']));

      //generate unique ID for a file
      $fileName = uniqid() . '-' . $fileName;


      //move file image into new location (uploads images folder)  

      if (move_uploaded_file($_FILES['file']['tmp_name'], dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $fileName)) {

        if (isset($_FILES['file']['name'])) {

          // $service = getServicesById($pdo, $_SESSION['service']['id']);


          if (file_exists(dirname(__DIR__) . _GARAGE_UPLOADS_ . $_FILES['file']['name'])) {
            //delete old image if new one is uploaded
            unlink(dirname(__DIR__) . _GARAGE_UPLOADS_ . $_FILES['file']['name']);
          } else {
            $messages[] = "image remplace avec success";
          }
        }
      } else {
        $errors[] = "Le fichier n'a pas été uploadé";
      }
    } else {
      $errors[] = "Le fichier doit être une image";
    }
  } else {
    //if any image was sent
    if (isset($_GET['id'])) {
      // if (isset($_POST['delete_image'])) {
      //   // delete image if checkbox is checked
      //   unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_POST['image']);
      // } 
      // else {
      $fileName = $_POST['image'];
      // }
    }
  }

  //to validate service
  // if (empty($_POST['service'])){
  //   $errors[] = "Le services est requis.";
  // }elseif(!preg_match($regexService, $_POST['service'])){
  //   $errors[] = "Le service doit contenir uniquement des lettres et chiffres avoir une longueur maximale de 20 caractères.";
  // }

  //to validate description
  // if(empty($_POST['service-description'])){
  //   $errors[] = "La description est requis.";
  // }elseif(!preg_match($regexDescription, $_POST['service-description'])){
  //   $errors[]="La description doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 200 caractères.";
  // }


  // to validate image
  // if(empty($_FILES['file']['name'])){
  //   $errors[] = "L'image pour la voiture est requis.";
  // }







  $formCar = [
    'brand' => $_POST['brand'],
    'model' => $_POST['model'],
    'year' => $_POST['year'],
    'kilometers' => $_POST['kilometers'],
    'gearbox' => $_POST['gearbox'],
    'doors' => $_POST['doors'],
    'price' => $_POST['price'],
    'color' => $_POST['color'],
    'fuel' => $_POST['fuel'],
    'co2' => $_POST['co2'],
    'image' => $_POST['image']
  ];


  //if no errors we save all information
  if (!$errors) {
    if (isset($_SESSION['user']['id'])) {
      //the id will be int
      $id = (int)$_SESSION['user']['id'];
    } else {
      $id = null;
    }


    //all data will be saved at saveEmployee function
    // $id = $_SESSION['user']['id'];

    $res = saveCar($pdo, $_POST["brand"], $_POST["model"], $_POST["year"], $_POST["kilometers"], $_POST["gearbox"], $_POST["doors"], $_POST["price"], $_POST["color"], $_POST["fuel"], $_POST["co2"], $fileName, $id);



    if ($res) {
      $messages[] = "La voiture a bien été sauvegardé";

      //all information at formEmployee will be deleted
      if (!isset($_GET["id"])) {
        $formCar = [
          'brand' => '',
          'model' => '',
          'year' => '',
          'kilometers' => '',
          'gearbox' => '',
          'doors' => '',
          'price' => '',
          'color' => '',
          'fuel' => '',
          'co2' => '',
          'image'=>''
        ];
      } else {
        $errors[] = "La voiture n'a pas été sauvegardé";
      }
    }
  }
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

    <!-- messages  -->
    <?php foreach ($messages as $message) { ?>
    <div class="alert alert-success mt-4" role="alert">
      <?= $message; ?>
    </div>
    <?php } ?>

    <?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger mt-4" role="alert">
      <?= $error; ?>
    </div>
    <?php } ?>

    <?php if ($formCar !== false) { ?>

    <div class="connection-wrapper">


      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="connection-form add-car">

          <div class="car-model">
            <div class="car-model-bottom">
              <div class="form-group">
                <label for="car-brand">Marque</label>
                <input type="text" name="brand" id="brand"
                  value=<?= htmlspecialchars($car['brand'] ?? $formCar['brand']); ?>>
              </div>
              <div class="form-group">
                <label for="car-model">Modèle</label>
                <input type="text" name="model" id="model"
                  value=<?= htmlspecialchars($car['model'] ?? $formCar['model']); ?>>
              </div>
            </div>
          </div>

          <div class="car-description">

            <!-- LEFT SIDE  -->
            <div class="car-description-left">
              <div class="form-group">
                <label for="year">Année</label>
                <input type="text" name="year" id="year"
                  value=<?= htmlspecialchars($car['year'] ?? $formCar['year']); ?>>
              </div>
              <div class="form-group">
                <label for="kilometers">Kilométrage</label>
                <input type="text" name="kilometers" id="kilometers"
                  value=<?= htmlspecialchars($car['kilometers'] ?? $formCar['kilometers']); ?>>
              </div>
              <div class="form-group">
                <label for="gearbox">Boîte de vitesses</label>
                <input type="text" name="gearbox" id="gearbox"
                  value=<?= htmlspecialchars($car['gearbox'] ?? $formCar['gearbox']); ?>>
              </div>
              <div class="form-group">
                <label for="doors">Numéro de portes</label>
                <input type="text" name="doors" id="doors"
                  value=<?= htmlspecialchars($car['number_doors'] ?? $formCar['doors']); ?>>
              </div>
            </div>

            <!-- RIGHT SIDE  -->
            <div class="car-description-right">
              <div class="form-group">
                <label for="price">Prix</label>
                <input type="text" name="price" id="price"
                  value=<?= htmlspecialchars($car['price'] ?? $formCar['price']); ?>>
              </div>
              <div class="form-group">
                <label for="color">Couleur</label>
                <input type="text" name="color" id="color"
                  value=<?= htmlspecialchars($car['color'] ?? $formCar['color']); ?>>
              </div>
              <div class="form-group">
                <label for="fuel">Carburant</label>
                <input type="text" name="fuel" id="fuel"
                  value=<?= htmlspecialchars($car['fuel'] ?? $formCar['fuel']); ?>>
              </div>
              <div class="form-group">
                <label for="co2">CO2</label>
                <input type="text" name="co2" id="co2" value=<?= htmlspecialchars($car['co'] ?? $formCar['co2']); ?>>
              </div>

              <div class="form-group">
                <img src="<?= _GARAGE_IMAGES_FOLDER_ . htmlspecialchars($car['image'] ?? $formCar['image'])?>"
                  alt="<?= $formCar['brand']." ".$formCar['model'] ?>" class="w-25">
                <!-- <label for="delete_image">Supprimer l'image</label>
          <input type="checkbox" name="delete_image" id="delete_image"> -->
                <input type="hidden" name="image" value="<?= htmlspecialchars($car['image'] ?? $fileName) ; ?>">
              </div>



              <p>
                <input type="file" name="file" id="file">
              </p>
            </div>
          </div>
        </div>
        <div class="form-btn">
          <button type="submit" class="btn-fill">Modifier</button>
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>
<?php } else { ?>
<div class="not-found">
  <!-- <h1 class="not-found-text">Employé non trouvé</h1> -->
  <div class="go-back-page">
    <a href="javascript:history.back(1)" class="btn-wire">Retour page précédante</a>
  </div>
</div>
<?php } ?>

<?php
require_once __DIR__ . "/templates/footer-admin.php";

?>