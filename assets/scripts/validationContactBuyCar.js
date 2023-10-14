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
  $('#phone').on('input', function () {
    checkPhone()
  })

  $('#message').on('input', function () {
    checkMessage()
  })

  $('#submitbtn').click(function () {
    if (
      !checkLastname() &&
      !checkName() &&
      !checkEmail() &&
      !checkPhone() &&
      !checkMessage()
    ) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else if (
      !checkLastname() ||
      !checkName() ||
      !checkEmail() ||
      !checkPhone() ||
      !checkMessage()
    ) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else {
      $('#form-message').html('')
      var form = $('#buyContact')[0]
      var data = new FormData(form)
      var message = $('#message').val()
      $.ajax({
        type: 'POST',
        url: '../../mailVoiture.php',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        async: true,
        message: message,

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
  } else if ($('#lastname').val().length < 4) {
    $('#lastname_err').html('Le nom est trop court.')
    return false
  } else if (!validLastname) {
    $('#lastname_err').html(
      'Le nom doit avoir minimum 5 caractères et maximum 25'
    )
    return false
  } else {
    $('#lastname_err').html('')
    return true
  }
}

function checkName() {
  var patternName = /[a-zA-ZÀ-ÿ\s\-]{3,25}/
  var name = $('#name').val()
  var validName = patternName.test(name)
  if (name.trim() === '') {
    $('#name_err').html('Le prénom ne peut pas être vide')
    return false
  } else if ($('#name').val().length < 4) {
    $('#name_err').html('Le prénom est trop court.')
    return false
  } else if (!validName) {
    $('#name_err').html(
      'Le prénom doit avoir minimum 5 caractères et maximum 25'
    )
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

function checkPhone() {
  var patternPhone = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/
  var phone = $('#phone').val()
  var validPhone = patternPhone.test(phone)
  if (phone.trim() === '') {
    $('#phone_err').html('Le téléphone ne peut pas être vide')
    return false
  } else if ($('#phone').val().length < 4) {
    $('#phone_err').html('Le téléphone est trop court.')
    return false
  } else if (!validPhone) {
    $('#phone_err').html(
      'Le téléphone doit avoir minimum 5 caractères et maximum 25'
    )
    return false
  } else {
    $('#phone_err').html('')
    return true
  }
}

function checkMessage() {
  var patternMessage = /^[0-9a-zA-ZÀ-ÿ\s?\.\,\;\"\'\d]{15,250}/
  var message = $('#message').val()
  var validMessage = patternMessage.test(message)
  if (message.trim() === '') {
    $('#message_err').html('Le message ne peut pas être vide')
    return false
  } else if ($('#message').val().length < 4) {
    $('#message_err').html('Le message est trop court.')
    return false
  } else if (!validMessage) {
    $('#message_err').html(
      'Le message doit avoir minimum 10 caractères et maximum 60'
    )
    return false
  } else {
    $('#message_err').html('')
    return true
  }
}
