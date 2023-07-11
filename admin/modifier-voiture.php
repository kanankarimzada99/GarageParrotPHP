<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/templates/header-admin.php";

//employees don't have permission to visit this page
if ($_SESSION['user']['role'] === 'employee') {
  header("location: /admin/liste-voitures.php");
}

$id = null;
$car = null;
$errors = [];
$messages = [];
$formCar = [
  'code'=>'',
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

//regex
$regexCode = '/^[a-zA-Z0-9\s]{1,20}$/';
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

  //verify errors inside the form

   //to validate code
   if (empty($_POST['code'])) {
    $errors[] = "Le code est requis.";
  } elseif (!preg_match($regexCode, $_POST['code'])) {
    $errors[] = "Le code doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 5 caractères.";
  }

  //to validate brand
  if (empty($_POST['brand'])) {
    $errors[] = "La marque est requis.";
  } elseif (!preg_match($regexBrand, $_POST['brand'])) {
    $errors[] = "La marque doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 25 caractères.";
  }
  //to validate model
  if (empty($_POST['model'])) {
    $errors[] = "Le modèle est requis.";
  } elseif (!preg_match($regexModel, $_POST['model'])) {
    $errors[] = "Le modèle doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 25 caractères.";
  }
  //to validate year
  if (empty($_POST['year'])) {
    $errors[] = "L'anneé est requis.";
  } elseif (!preg_match($regexYear, $_POST['year'])) {
    $errors[] = "L'anneé doit contenir uniquement des chiffres et avoir une longueur maximale de 4 caractères.";
  }
  //to validate kilometer
  if (empty($_POST['kilometer'])) {
    $errors[] = "La Kilométrage est requis.";
  } elseif (!preg_match($regexKilometers, $_POST['kilometer'])) {
    $errors[] = "La Kilométrage doit contenir uniquement des chiffres et avoir une longueur maximale de 6 caractères.";
  }
  //to validate gearbox
  if (empty($_POST['gearbox'])) {
    $errors[] = "La boîte de vitesses est requis.";
  } elseif (!preg_match($regexGearbox, $_POST['gearbox'])) {
    $errors[] = "La boîte de vitesses doit contenir uniquement des lettres et avoir une longueur maximale de 15 caractères.";
  }
  //to validate doors
  if (empty($_POST['doors'])) {
    $errors[] = "Le numéro de portes est requis.";
  } elseif (!preg_match($regexDoors, $_POST['doors'])) {
    $errors[] = "Le numéro de portes doit contenir uniquement des chiffres et avoir une longueur maximale de 2 caractères.";
  }
  //to validate price
  if (empty($_POST['price'])) {
    $errors[] = "Le prix est requis.";
  } elseif (!preg_match($regexPrice, $_POST['price'])) {
    $errors[] = "Le prix doit contenir uniquement des chiffres et avoir une longueur maximale de 10 caractères.";
  }
  //to validate color
  if (empty($_POST['color'])) {
    $errors[] = "La couleur est requis.";
  } elseif (!preg_match($regexColor, $_POST['color'])) {
    $errors[] = "La couleur doit contenir uniquement des lettres et espaceset avoir une longueur maximale de 15 caractères.";
  }
  //to validate fuel
  if (empty($_POST['fuel'])) {
    $errors[] = "Le carburant est requis.";
  } elseif (!preg_match($regexFuel, $_POST['fuel'])) {
    $errors[] = "Le carburant doit contenir uniquement des lettres et avoir une longueur maximale de 15 caractères.";
  }
  //to validate c02
  if (empty($_POST['co2'])) {
    $errors[] = "Le CO2 est requis.";
  } elseif (!preg_match($regexCo2, $_POST['co2'])) {
    $errors[] = "Le CO2 doit contenir uniquement des chiffres et avoir une longueur maximale de 3 caractères.";
  }


  // //to verify image format
  // if (!preg_match('/\.(jpg|jpeg|png|gif)$/', $_POST['car-image'])) {
  //   $errors[] = "Le format d'image n'est pas valide.";
  // }




  $imagePath = null;
  //verify if a file is sent
  // if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {
  //   $sizeImage = getimagesize($_FILES['file']['tmp_name']);
  //   if ($sizeImage !== false) {

  //     //delete spaces into the name and make name file with lowercase letters
  //     $fileName = slugify(basename($_FILES['file']['name']));

  //     //generate unique ID for a file
  //     $fileName = uniqid() . '-' . $fileName;


  //     //move file image into new location (uploads images folder)  

  //     if (move_uploaded_file($_FILES['file']['tmp_name'], dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $fileName)) {

  //       if (isset($_POST['car-image'])) {
  //         //delete old image if new one is uploaded
  //         unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_POST['car-image']);
  //       }
  //     } else {
  //       $errors[] = "Le fichier n'a pas été uploadé";
  //     }
  //   } else {
  //     $errors[] = "Le fichier doit être une image";
  //   }
  // } else {
  //   //if any image was sent
  //   if (isset($_GET['id'])) {
  //     // if (isset($_POST['delete_image'])) {
  //     //   // delete image if checkbox is checked
  //     //   unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_POST['image']);
  //     // } 
  //     // else {
  //     $fileName = $_POST['car-image'];
  //     // }
  //   }
  // }

  // Verifica se um arquivo foi enviado
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image'];

    // Obtém informações sobre a imagem
    $imageName = $image['name'];
    $imageTmpPath = $image['tmp_name'];

     //delete spaces into the name and make name file with lowercase letters
     $imageId = slugify(basename($_FILES['image']['name']));

     

    // Gera um ID único para a imagem
    $imageId = uniqid(). '-'.$imageId;
    // Move a imagem para uma pasta permanente
    $imagePath = dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $imageId; 
    move_uploaded_file($imageTmpPath, $imagePath);

  
   
   $messages[]= 'Imagem enviada com sucesso! ID: ' . $imageId;
  } else {
    $errors[]= 'Erro ao enviar a imagem.';
  }

  //put information from form to formEmployee
  $formCar = [
    'code'=> $_POST['code'],
    'brand' => $_POST['brand'],
    'model' => $_POST['model'],
    'year' => $_POST['year'],
    'kilometer' => $_POST['kilometer'],
    'gearbox' => $_POST['gearbox'],
    'doors' => $_POST['doors'],
    'price' => $_POST['price'],
    'color' => $_POST['color'],
    'fuel' => $_POST['fuel'],
    'co2' => $_POST['co2'],
    'image' => $imageId
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

    $res = saveCar($pdo, $_POST['code'], $_POST['brand'], $_POST['model'], $_POST['year'], $_POST['kilometer'], $_POST['gearbox'], $_POST['doors'], $_POST['price'], $_POST['color'], $_POST['fuel'], $_POST['co2'],  $imageId, $id);


    if ($res) {
      $messages[] = "Le service a bien été sauvegardé";

      //all information at formService will be deleted
      if (!isset($_GET["id"])) {
        $formCar = [
          'code'=>'',
          'brand' => '',
          'model' => '',
          'year' => '',
          'kilometer' => '',
          'gearbox' => '',
          'doors' => '',
          'price' => '',
          'color' => '',
          'fuel' => '',
          'co2' => '',
          'car-image' => ''

        ];
      } else {
        $errors[] = "Le service n'a pas été sauvegardé";
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
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="connection-form add-car">

          <div class="model">
            <div class="model-bottom">
              <div class="form-group" style="width: 100px;">
                <label for="code">Code</label>
                <input type="text" name="code" id="code"
                  value=<?= htmlspecialchars($car['code'] ?? $formCar['code']); ?>>
              </div>
              <div class="form-group">
                <label for="brand">Marque</label>
                <input type="text" name="brand" id="brand"
                  value=<?= htmlspecialchars($car['brand'] ?? $formCar['brand']); ?>>
              </div>
              <div class="form-group">
                <label for="model">Modèle</label>
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
                <label for="kilometer">Kilométrage</label>
                <input type="text" name="kilometer" id="kilometer"
                  value=<?= htmlspecialchars($car['kilometers'] ?? $formCar['kilometer']); ?>>
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
                <input type="file" name="image" required>

              </div>
            </div>
          </div>
        </div>
        <div class="form-btn">
          <input type="submit" class="btn-fill" value="Modifier">
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