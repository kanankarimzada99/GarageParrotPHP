<?php
require_once __DIR__ . "/lib/config.php";

if (isset($_POST['submit'])) {
  $lastname = $_POST['lastname'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  $errorEmpty = false;
  $errorLastname = false;
  $errorName = false;
  $errorEmail = false;
  $errorPhone = false;
  $errorSubject = false;
  $errorMessage = false;

  if (empty($lastname) && empty($name) && empty($email) && empty($phone)   && empty($message)) {
    echo "<div class='alert alert-danger m-0' role='alert'>Vous devez remplir tous les champs</div>";
    $errorEmpty = true;
  } elseif (!preg_match(_REGEX_LAST_NAME_, $lastname)) {
    echo "<div class='alert alert-danger m-0' role='alert'>Le nom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.</div>";
    $errorLastname = true;
  } elseif (!preg_match(_REGEX_FIRST_NAME_, $name)) {
    echo "<div class='alert alert-danger m-0' role='alert'>Le prénom doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.</div>";
    $errorName = true;
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<div class='alert alert-danger m-0' role='alert'>Le format du e-mail address n'est pas valide</div>";
    $errorEmail = true;
  } elseif (!preg_match(_REGEX_PHONE_, $phone)) {
    echo "<div class='alert alert-danger m-0' role='alert'>Le téléphone doit contenir uniquement des chiffres et avoir une longueur maximale de 16 caractères. Pour appel internationale, le signal \"+\" et le \"()</div>";
    $errorPhone = true;
  } elseif (!preg_match(_REGEX_SUBJECT_, $subject)) {
    echo "<div class='alert alert-danger m-0' role='alert'>Le sujet doit contenir uniquement des lettres et avoir une longueur maximale de 60 caractères.</div>";
    $errorSubject = true;
  } elseif (!preg_match(_REGEX_MESSAGE_, $message)) {
    echo "<div class='alert alert-danger m-0' role='alert'>Le message doit contenir une longueur maximale de 250 caractères.</div>";
    $errorMessage = true;
  }

  if ($errorEmpty !== true && $errorLastname !== true && $errorName !== true && $errorEmail !== true && $errorPhone !== true && $errorSubject !== true && $errorMessage !== true) {

    $to = _APP_EMAIL_;
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = '[Garage Parrot] Formulaire de contact:' . ' ' . nl2br(htmlentities($_POST['subject']));
    $emailContent = "Email : $email"
      . "<br>"
      . "Prénom:"
      . nl2br(htmlentities($_POST['name']))
      . "<br>"
      . "Nom:"
      . nl2br(htmlentities($_POST['lastname']))
      . "<br>"
      . "téléphone:"
      . nl2br(htmlentities($_POST['phone']))
      . "<br>"
      . "Message :"
      . nl2br(htmlentities($_POST['message']));
    $headers = "From: " . $email .
      "\r\n" . "MIME-Version: 1.0" . "\r\n" .
      "Content-type: text/html; charset=utf-8";

    if (mail($to, $subject, $emailContent, $headers)) {

      echo "<div class='alert alert-success m-0' role='alert'>Merci pour votre message. On vous recontacte dès que possible! Bonne journée!</div>";
      $errorEmpty = false;
      $errorLastname = false;
      $errorName = false;
      $errorEmail = false;
      $errorPhone = false;
      $errorMessage = false;
    } else {
      echo "<div class='alert alert-danger m-0' role='alert'>Une erreur s'est produite durant l'envoi</div>";
      $errorEmpty = true;
    }
  }
} else {
  echo "<div class='alert alert-danger m-0' role='alert'>Une erreur s'est produite durant l'envoi.</div>";
  $errorEmpty = true;
}
?>

<script>
  $("#lastname, #name, #email, #phone, #subject, #message").removeClass("input-error");


  //get variable php inside js
  var errorEmpty = "<?php echo $errorEmpty; ?>";
  var errorLastName = "<?php echo $errorLastname; ?>";
  var errorName = "<?php echo $errorName; ?>";
  var errorEmail = "<?php echo $errorEmail; ?>";
  var errorPhone = "<?php echo $errorPhone; ?>";
  var errorSubject = "<?php echo $errorSubject; ?>";
  var errorMessage = "<?php echo $errorMessage; ?>";

  if (errorEmpty == true) {
    $("#lastname, #name, #email, #phone, #subject, #message").addClass("input-error");
  }
  if (errorLastName == true) {
    $("#lastname").addClass("input-error");
  }
  if (errorName == true) {
    $("#name").addClass("input-error");
  }
  if (errorEmail == true) {
    $("#email").addClass("input-error");
  }
  if (errorPhone == true) {
    $("#phone").addClass("input-error");
  }
  if (errorSubject == true) {
    $("#subject").addClass("input-error");
  }
  if (errorMessage == true) {
    $("#message").addClass("input-error");
  }

  if (errorEmpty == false && errorLastName == false && errorName == false && errorEmail == false && errorPhone == false &&
    errorSubject == false && errorMessage == false) {
    $("#lastname,#name,#email,#phone,#subject,#message").val("");
    $(".image-car").addClass("hide");

    //hide message after 5 seconds
    setTimeout(function() {
      $('.form-message').fadeOut('fast');
    }, 5000); // <-- time in milliseconds
  }
</script>