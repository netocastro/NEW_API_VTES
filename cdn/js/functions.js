/**
 * Valida os campos do formulário
 */
function validateFields(data, dadosForm) {
      $(`#error-deckName`).fadeOut().remove();
      $(dadosForm.find('input, select, textarea')).each(function (index) {
            $(`${$(this).prop('tagName')}[name=${$(this).attr('name')}]`).removeClass('is-invalid');
            $(`#error-${$(this).attr('name')}`).fadeOut().remove();
      });
      $('#success').fadeOut().remove();

      if (data.emptyFields) {
            data.emptyFields.forEach(element => {
                  $(`[name=${element}]`).addClass('is-invalid');
                  $(`[name=${element}]`).after(`<div id='error-${element}' class='text-danger'>Campo vazio</div>`);
                  $(`#error-${element}`).hide().fadeIn();
            });
      }

      if (data.validateFields) {
            let fields = data.validateFields;
            for (const field in fields) {
                  $(`[name=${field}]`).addClass('is-invalid');
                  $(`[name=${field}]`).after(`<div id='error-${field}' class='text-danger'>${fields[field]}</div>`);
            }
      }

      if (data.validateFieldsTxt) {
            $(`#error-deckName`).fadeOut().remove();
            let fields = data.validateFieldsTxt;
            $(`#decktxt`).after(`<div id='error-deckName' class='text-danger'>${fields.deckName}</div>`);
      }

      if (data.success) {
            $('button[type=submit]').after(`<h6 id="success" class="bg-primary text-light p-2 mt-3 rounded text-center">${data.success}</h6>`).hide().fadeIn();
            $('.form-control').val('');
      }

      // exclusivo pra parte de vtes
      if (data.successUpdate) {
            $('#update-deck').after(`<h6 id="success" class="bg-primary text-light p-2 mt-3 rounded text-center">${data.successUpdate}</h6>`).hide().fadeIn();
      }

      if (data.successCreate) {
            $('#save-deck').after(`<h6 id="success" class="bg-primary text-light p-2 mt-3 rounded text-center">${data.successCreate}</h6>`).hide().fadeIn();
            $('.form-control').val('');
      }

      if (data.successCreateTxt) {

            $('#decktxt').after(`<h6 id="success" class="bg-primary text-light p-2 mt-3 rounded text-center">${data.successCreateTxt}</h6>`).hide().fadeIn();
      }

}

/**
 * Carrega as imagens das cartas
 */
function show_image(input) {
      if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                  $('#preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
      }
}