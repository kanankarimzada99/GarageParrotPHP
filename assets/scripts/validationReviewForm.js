$(document).ready(function () {
  $('#client').on('input', function () {
    checkClient()
  })
  $('#comment').on('input', function () {
    checkComment()
  })

  $('#note').on('change', function () {
    checkNote()
  })

  $('#submitbtn').click(function () {
    if (!checkClient() && !checkComment() && !checkNote()) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else if (!checkClient() || !checkComment() || !checkNote()) {
      $('#form-message').html(
        '<div class="alert alert-danger d-inline" role="alert">Vous devez remplir tous les champs.</div>'
      )
    } else {
      $('#form-message').html('')
      var form = $('#addReview')[0]
      var data = new FormData(form)
      $.ajax({
        type: 'POST',
        url: 'ajouterAvisForm.php',
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

function checkClient() {
  var patternClient = /^[0-9a-zA-ZÀ-ÿ\s?.;"'\d]{5,50}/
  var client = $('#client').val()
  var validClient = patternClient.test(client)
  if (client.trim() === '') {
    $('#client_err').html('Le client ne peut pas être vide')
    return false
  } else if ($('#client').val().length < 3) {
    $('#client_err').html('Le client est trop court.')
    return false
  } else if (!validClient) {
    $('#client_err').html(
      'Seulement des lettres, chiffres et pontuation sont permit. De 5 à 45 caractères maximum.'
    )
    return false
  } else {
    $('#client_err').html('')
    return true
  }
}
function checkComment() {
  var patternComment = /^[0-9a-zA-ZÀ-ÿ\s?!.:;"'\d]{15,250}$/
  var comment = $('#comment').val()
  var validComment = patternComment.test(comment)
  if (comment.trim() === '') {
    $('#comment_err').html('Le commentaire ne peut pas être vide')
    return false
  } else if ($('#comment').val().length < 3) {
    $('#comment_err').html('Le commentaire est trop court.')
    return false
  } else if (!validComment) {
    $('#comment_err').html(
      'Seulement des lettres, chiffres et pontuation sont permit. De 15 à 250 caractères maximum.'
    )
    return false
  } else {
    $('#comment_err').html('')
    return true
  }
}

function checkNote() {
  var note = $('#note').val()
  if (note == 0) {
    $('#note_err').html('La note ne peut pas être vide')
    return false
  } else {
    $('#note_err').html('')
    return true
  }
}
