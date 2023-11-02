$(document).ready(function () {
  $('#email').on('input', function () {
    checkEmail()
  })
  $('#password').on('input', function () {
    checkPass()
  })

  $('#submitbtn').click(function () {
    if (!checkEmail() && !checkPass()) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else if (!checkEmail() || !checkPass()) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else {
      $('#form-message').html('')
      var form = $('#connectionForm')[0]
      var data = new FormData(form)
      $.ajax({
        type: 'POST',
        url: '../admin/connection.php',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        async: true,

        success: function (data) {
          $('#form-message').html(data)
        },
      })
    }
  })
})

function checkEmail() {
  var patterEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/
  var email = $('#email').val()
  var validEmail = patterEmail.test(email)
  if (email.trim() === '') {
    $('#email_err').html('Le mail ne peut pas être vide')
    return false
  } else if ($('#email').val().length < 2) {
    $('#email_err').html('Le mail est trop court.')
    return false
  } else if (!validEmail) {
    $('#email_err').html("Le format du mail n'est pas valide.")
    return false
  } else {
    $('#email_err').html('')
    return true
  }
}

function checkPass() {
  var patternPassword =
    /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,16}$/
  var pass = $('#password').val()
  var validPass = patternPassword.test(pass)

  if (pass == '') {
    $('#password_err').html('Le mot de passe ne peut pas être vide.')
    return false
  } else if (!validPass) {
    $('#password_err').html(
      'Mininum 8 à 16 caractères, une majuscule, une minuscule, un chiffre et un caractère especial.'
    )
    return false
  } else {
    $('#password_err').html('')
    return true
  }
}

function password_show_hide() {
  var password = document.getElementById('password')
  var show_eye = document.getElementById('show_eye')
  var hide_eye = document.getElementById('hide_eye')
  hide_eye.classList.remove('d-none')
  if (password.type === 'password') {
    password.type = 'text'
    show_eye.style.display = 'none'
    hide_eye.style.display = 'block'
  } else {
    password.type = 'password'
    show_eye.style.display = 'block'
    hide_eye.style.display = 'none'
  }
}
