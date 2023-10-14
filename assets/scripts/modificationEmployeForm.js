$(document).ready(function () {
  $('#lastname').on('input', function () {
    checkLastname()
  })
  $('#name').on('input', function () {
    checkName()
  })
  $('#email').on('input', function () {
    checkEmail()
  })
  $('#password').on('input', function () {
    checkPass()
  })

  $('#submitbtn').click(function () {
    if (!checkLastname() && !checkName() && !checkEmail() && !checkPass()) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else if (!checkLastname() || !checkName() || !checkEmail()) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else {
      $('#form-message').html('')
      var form = $('#modifyEmploye')[0]
      var data = new FormData(form)
      $.ajax({
        type: 'POST',
        url: 'modifierEmployeForm.php',
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

function checkLastname() {
  var patternLastname = /[a-zA-ZÀ-ÿ]{5,25}/
  var lastname = $('#lastname').val()
  var validLastname = patternLastname.test(lastname)
  if (lastname.trim() === '') {
    $('#lastname_err').html('Le nom ne peut pas être vide')
    return false
  } else if ($('#lastname').val().length < 2) {
    $('#lastname_err').html('Le nom est trop court.')
    return false
  } else if (!validLastname) {
    $('#lastname_err').html(
      'Seulement lettres sont permit. Minimum 5, maximum 25.'
    )
    return false
  } else {
    $('#lastname_err').html('')
    return true
  }
}

function checkName() {
  var patternName = /[a-zA-ZÀ-ÿ\s\-\_]{3,25}/
  var name = $('#name').val()
  var validname = patternName.test(name)
  if (name.trim() === '') {
    $('#name_err').html('Le nom ne peut pas être vide')
    return false
  } else if ($('#name').val().length < 2) {
    $('#name_err').html('Le nom est trop court.')
    return false
  } else if (!validname) {
    $('#name_err').html('Seulement lettres sont permit. Minimum 3, maximum 25.')
    return false
  } else {
    $('#name_err').html('')
    return true
  }
}

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

  if (pass.trim() !== '') {
    if (!validPass) {
      $('#password_err').html(
        'Mininum 8 à 16 caractères, une majuscule, une minuscule, un chiffre et un caractère especial.'
      )
      return false
    } else {
      $('#password_err').html('')
      return true
    }
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
