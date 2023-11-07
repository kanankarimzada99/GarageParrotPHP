$(document).ready(function () {
  $('#service').on('input', function () {
    checkService()
  })
  $('#description').on('input', function () {
    checkDescription()
  })

  $('#file').on('change', function () {
    checkImage()
  })

  $('#submitbtn').click(function () {
    if (!checkService() && !checkDescription() && !checkImage()) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else if (!checkService() || !checkDescription() || !checkImage()) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else {
      $('#form-message').html('')
      var form = $('#modifyService')[0]
      var data = new FormData(form)
      $.ajax({
        type: 'POST',
        url: 'modifierServiceForm.php',
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

function checkService() {
  var patternService = /^[a-zA-ZÀ-ÿ\sp{P}0-9_.-]{15,30}$/
  var service = $('#service').val()
  var validUser = patternService.test(service)
  if (service.trim() === '') {
    $('#service_err').html('Le service ne peut pas être vide')
    return false
  } else if ($('#service').val().length < 4) {
    $('#service_err').html('Le service est trop court.')
    return false
  } else if (!validUser) {
    $('#service_err').html(
      'Le service doit avoir minimum 15 caractères et maximum 30'
    )
    return false
  } else {
    $('#service_err').html('')
    return true
  }
}
function checkDescription() {
  var patternDescription = /^[a-zA-ZÀ-ÿ0-9\s\'\.\?\!\,\-]{50,150}$/
  var description = $('#description').val()
  var validateDescription = patternDescription.test(description)
  if (description.trim() == '') {
    $('#description_err').html('La description ne peut pas être vide')
    return false
  } else if (!validateDescription) {
    $('#description_err').html(
      'Seulement lettres, chiffres et espaces sont permit.'
    )
    return false
  } else {
    $('#description_err').html('')
    return true
  }
}

function checkImage() {
  if ($('#imgCar').is(':checked')) {
    var fileInput = $('#file')[0].files[0]
    //image validation
    if (!fileInput) {
      $('#file').addClass('input-error')
      $('#message-error').removeClass('d-none')
      $('#image_err').html("L'image est requis.")
      return false
    }

    if (fileInput.size > 1000000) {
      $('#file').addClass('input-error')
      $('#message-error').removeClass('d-none')
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">La taille d\'image est trop grand</div>'
      )
      $('#image_err').html("L'image ne peut pas depasser 1 Mega.")
      $(fileInput).val('')
      return false
    }

    if (!fileInput.type.match('image/jpeg|image/jpg|image/png|image/webp')) {
      $('#file').addClass('input-error')
      $('#message-error').removeClass('d-none')
      $('#message-error').html("Format d'image invalide.")
      $('#image_err').html('Seulement jpg, jpeg, png ou webp sont accepté')
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Format d\'image invalide.</div>'
      )
      return false
    } else {
      $('#image_err').html('')
      return true
    }
  } else {
    return true
  }
}
