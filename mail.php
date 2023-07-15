<?php

if (isset($_POST['submit'])) {
  $lastname = $_POST['lastname'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  // $subject = "Contact Form";
  // $mailTo = "marcosgarage.parrot@gmail.com";
  // $headers = "From: " . $email;
  // $txt = "You have received a message from " . $name .
  //   ".\n\n" . $message;

  $errorEmpty = false;
  $errorEmail = false;

  if (empty($lastname) || empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
    echo "<span class='form-error'>Vous devez remplir tout les champs</span>";
    $errorEmpty = true;
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<span class='form-error'>Le format du e-mail address n'est pas valide</span>";
    $errorEmail = true;
  } else {
    
    echo "<span class='form-success'>Merci pour votre message. On vous recontacte dès que possible! Bonne journée!</span>";
    $to= "marcosgarage.parrot@gmail.com";
    $email = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);
    $subject = '[Garage Parrot] Formulaire de contact';
    $emailContent = "Email : $email<br>"
    ."Prénom: <br>"
    .nl2br(htmlentities($_POST['name']))
    ."Nom: <br>"
    .nl2br(htmlentities($_POST['lastname']))
    ."téléphone: <br>"
    .nl2br(htmlentities($_POST['phone']))
    ."Adresse e-mail: <br>"
    .nl2br(htmlentities($_POST['email']))
    ."Message : <br>"
    .nl2br(htmlentities($_POST['message']));
    $headers = "From: ".$email. 
    "\r\n"."MIME-Version: 1.0" . "\r\n".
    "Content-type: text/html; charset=utf-8";
    
    if(mail("meneghettimarcos@outlook.com","My subject","teste")) {
      $messages[]="Votre email a bien été envoyé";
    }else {
      $errors[]="Une erreur s'est produite durant l'envoi";
    }
  }
} else {
  echo "Une erreur s'est produite durant l'envoi";
}
?>



<script>
$("#lastname, #name, #email, #phone, #subject, #message").removeClass("input-error");


//get variable php inside js
var errorEmpty = "<?php echo $errorEmpty; ?>";
var errorEmail = "<?php echo $errorEmail; ?>";

if (errorEmpty == true) {
  $("#lastname, #name, #email, #phone, #subject, #message").addClass("input-error");
}
if (errorEmail == true) {
  $("#email").addClass("input-error");
}
if (errorEmpty == false && errorEmail == false) {
  $("#lastname,#name,#email,#phone,#subject,#message").val("");
  $(".image-car").addClass("hide");

  //hide message after 9 seconds
  setTimeout(function() {
    $('.form-message').fadeOut('fast');
  }, 5000); // <-- time in milliseconds
}
</script>