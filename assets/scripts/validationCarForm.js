$(document).ready(function () {
  $('#code').on('input', function () {
    checkCode()
  })
  $('#brand').on('input', function () {
    checkBrand()
  })
  $('#model').on('input', function () {
    checkModel()
  })
  $('#year').on('input', function () {
    checkYear()
  })
  $('#kilometer').on('input', function () {
    checkKilometer()
  })
  $('#gearbox').on('input', function () {
    checkGearbox()
  })
  $('#doors').on('input', function () {
    checkDoors()
  })
  $('#price').on('input', function () {
    checkPrice()
  })
  $('#color').on('input', function () {
    checkColor()
  })

  $('#fuel').on('input', function () {
    checkFuel()
  })

  $('#co2').on('input', function () {
    checkCo2()
  })

  $('#image').on('change', function () {
    checkImage()
  })

  $('#submitbtn').click(function () {
    if (
      !checkCode() &&
      !checkBrand() &&
      !checkModel() &&
      !checkYear() &&
      !checkKilometer() &&
      !checkGearbox() &&
      !checkDoors() &&
      !checkPrice() &&
      !checkColor() &&
      !checkFuel() &&
      !checkCo2() &&
      !checkImage()
    ) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else if (
      !checkCode() ||
      !checkBrand() ||
      !checkModel() ||
      !checkYear() ||
      !checkKilometer() ||
      !checkGearbox() ||
      !checkDoors() ||
      !checkPrice() ||
      !checkColor() ||
      !checkFuel() ||
      !checkCo2() ||
      !checkImage()
    ) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else {
      $('#form-message').html('')
      var form = $('#addCar')[0]
      var data = new FormData(form)
      $.ajax({
        type: 'POST',
        url: 'ajouterVoitureForm.php',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        beforeSend: function () {
          $('#submitbtn').attr('disabled', true)
        },

        success: function (data) {
          $('#form-message').html(data)
        },
        complete: function () {
          $('#addCar').trigger('reset')
          // hide form
          $('.connection-wrapper').hide()
          // hide message after 3 seconds
          setTimeout(function () {
            // $('.form-message').hide();
            window.location = '/admin/liste-voitures.php'
          }, 3000)
        },
      })
    }
  })
})

function checkCode() {
  var patternCode = /^[A-Z]{3}\d{3}$/
  var code = $('#code').val()
  var validCode = patternCode.test(code)
  if (code.trim() === '') {
    $('#code_err').html('Le code ne peut pas être vide')
    return false
  } else if ($('#code').val().length < 2) {
    $('#code_err').html('Le code est trop court. Format XXX000')
    return false
  } else if (!validCode) {
    $('#code_err').html(
      'Le code doit avoit 3 majuscules et 3 chiffres seulement'
    )
    return false
  } else {
    $('#code_err').html('')
    return true
  }
}

function checkBrand() {
  var patternBrand = /^[a-zA-Z0-9\s\-\_]{3,15}$/
  var brand = $('#brand').val()
  var validBrand = patternBrand.test(brand)
  if (brand.trim() === '') {
    $('#brand_err').html('La marque ne peut pas être vide')
    return false
  } else if ($('#brand').val().length < 4) {
    $('#brand_err').html('La marque est trop court.')
    return false
  } else if (!validBrand) {
    $('#brand_err').html(
      'La marque doit avoit 3 caractères minimum et 15 maximum.'
    )
    return false
  } else {
    $('#brand_err').html('')
    return true
  }
}
function checkModel() {
  var patternModel = /^[a-zA-Z0-9\s\-\_]{3,15}$/
  var model = $('#model').val()
  var validModel = patternModel.test(model)
  if (model.trim() === '') {
    $('#model_err').html('Le kilométrage ne peut pas être vide')
    return false
  } else if ($('#model').val().length < 4) {
    $('#model_err').html('Le kilométrage est trop court.')
    return false
  } else if (!validModel) {
    $('#model_err').html(
      'Le kilométrage doit avoit 3 caractères minimum et 15 maximum.'
    )
    return false
  } else {
    $('#model_err').html('')
    return true
  }
}
function checkYear() {
  var patternYear = /^(20)\d{2}$/
  var year = $('#year').val()
  var validYear = patternYear.test(year)
  if (year.trim() === '') {
    $('#year_err').html('Le modèle ne peut pas être vide')
    return false
  } else if ($('#year').val().length < 4) {
    $('#year_err').html('Le modèle est trop court.')
    return false
  } else if (!validYear) {
    $('#year_err').html(
      'Le format année est 4 chiffre à partir de 2000 (20XX).'
    )
    return false
  } else {
    $('#year_err').html('')
    return true
  }
}
function checkKilometer() {
  var patternKilometer = /[1-9]\d{3,6}/
  var kilometer = $('#kilometer').val()
  var validKilometer = patternKilometer.test(kilometer)
  if (kilometer.trim() === '') {
    $('#kilometer_err').html('Le kilométrage ne peut pas être vide')
    return false
  } else if ($('#kilometer').val().length < 4) {
    $('#kilometer_err').html('Le kilométrage est trop court.')
    return false
  } else if ($('#kilometer').val() < 1000) {
    $('#kilometer_err').html(
      'Le kilométrage ne peut pas être plus petit que 1000.'
    )
    return false
  } else if (!validKilometer) {
    $('#kilometer_err').html(
      'Seulement les chiffres sont permit, format XXXXXX.'
    )
    return false
  } else {
    $('#kilometer_err').html('')
    return true
  }
}

function checkGearbox() {
  var patternGearbox = /^[a-zA-ZÀ-ÿ-]{6,12}$/
  var gearbox = $('#gearbox').val()
  var validGearbox = patternGearbox.test(gearbox)
  if (gearbox.trim() === '') {
    $('#gearbox_err').html('Boîte de vitesses ne peut pas être vide')
    return false
  } else if ($('#gearbox').val().length < 4) {
    $('#gearbox_err').html('Boîte de vitesses est trop court.')
    return false
  } else if (!validGearbox) {
    $('#gearbox_err').html(
      'Seulement les caractères sont permit. De 6 à 12 caractères maximum.'
    )
    return false
  } else {
    $('#gearbox_err').html('')
    return true
  }
}

function checkDoors() {
  var patternDoors = /^[0-9]{0,1}$/
  var doors = $('#doors').val()
  var validDoors = patternDoors.test(doors)
  if (doors.trim() === '') {
    $('#doors_err').html('Le prix ne peut pas être vide')
    return false
  } else if ($('#doors').val() < 2) {
    $('#doors_err').html(
      'Le numéro de portes ne peut pas être plus petit que 2.'
    )
    return false
  } else if (!validDoors) {
    $('#doors_err').html('Seulement les chiffres sont permit, format XXXXXX.')
    return false
  } else {
    $('#doors_err').html('')
    return true
  }
}

function checkPrice() {
  var patternPrice = /^[0-9]{4,10}$/
  var price = $('#price').val()
  var validPrice = patternPrice.test(price)
  if (price.trim() === '') {
    $('#price_err').html('Le prix ne peut pas être vide')
    return false
  } else if ($('#price').val() < 3000) {
    $('#price_err').html('Le prix ne peut pas être plus petit que 3000.')
    return false
  } else if (!validPrice) {
    $('#price_err').html('Seulement les chiffres sont permit, format XXXXXX.')
    return false
  } else {
    $('#price_err').html('')
    return true
  }
}

function checkColor() {
  var patternColor = /^[a-zA-ZÀ-ÿ\s]{3,15}$/
  var color = $('#color').val()
  var validColor = patternColor.test(color)
  if (color.trim() === '') {
    $('#color_err').html('La couleur ne peut pas être vide')
    return false
  } else if ($('#color').val().length < 4) {
    $('#color_err').html('La couleur est trop court.')
    return false
  } else if (!validColor) {
    $('#color_err').html(
      'Seulement les caractères sont permit. De 6 à 15 caratères, maximum.'
    )
    return false
  } else {
    $('#color_err').html('')
    return true
  }
}
function checkFuel() {
  var patternFuel = /^[a-zA-ZÀ-ÿ]{6,12}$/
  var fuel = $('#fuel').val()
  var validFuel = patternFuel.test(fuel)
  if (fuel.trim() === '') {
    $('#fuel_err').html('Le carburant ne peut pas être vide')
    return false
  } else if ($('#fuel').val().length < 4) {
    $('#fuel_err').html('Le carburant est trop court.')
    return false
  } else if (!validFuel) {
    $('#fuel_err').html(
      'Seulement les caractères sont permit. De 6 à 12 caratères, maximum.'
    )
    return false
  } else {
    $('#fuel_err').html('')
    return true
  }
}

function checkCo2() {
  var patternCo2 = /^[0-9]{0,4}$/
  var co2 = $('#co2').val()
  var validCo2 = patternCo2.test(co2)
  if (co2.trim() === '') {
    $('#co2_err').html('Le CO2 ne peut pas être vide')
    return false
  } else if ($('#co2').val() < 0) {
    $('#co2_err').html('Le CO2 ne peut pas être plus petit que 3000.')
    return false
  } else if (!validCo2) {
    $('#co2_err').html('Seulement les chiffres sont permit, format XXX.')
    return false
  } else {
    $('#co2_err').html('')
    return true
  }
}

function checkImage() {
  var fileInput = $('#image')[0].files[0]
  //image validation
  if (!fileInput) {
    $('#image').addClass('input-error')
    $('#message-error').removeClass('d-none')
    $('#image_err').html("L'image est requis.")
    return false
  }

  if (fileInput.size > 1000000) {
    $('#image').addClass('input-error')
    $('#message-error').removeClass('d-none')
    $('#form-message').html(
      '<div class="alert alert-danger d-inline" role="alert">La taille d\'image est trop grand</div>'
    )
    $('#image_err').html("L'image ne peut pas depasser 1 Mega.")
    $(fileInput).val('')
    return false
  }

  if (!fileInput.type.match('image/jpeg|image/jpg|image/png|image/webp')) {
    $('#image').addClass('input-error')
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
}
