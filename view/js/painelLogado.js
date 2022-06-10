$(document).ready(function () {

      var $rows1 = $('#list-all-library tr');
      $('#find-library').on("keyup", function () {
            console.log('keyup funciona');
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            $rows1.show().filter(function () {
                  var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                  return !~text.indexOf(val);
            }).hide();
      });

      var $rows2 = $('#list-all-crypt tr');
      $('#find-crypt').on("keyup", function () {
            console.log('keyup funciona');
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            $rows2.show().filter(function () {
                  var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                  return !~text.indexOf(val);
            }).hide();
      });
      $("#decktxt").on('click', function () {
            _this = $(this);
            $.ajax({
                  url: _this.attr('data-action'),
                  type: _this.attr('data-method'),
                  dataType: _this.attr('data-type'),
                  data: deckForTxt(),
                  beforeSend: function () {
                        _this.find('.load').removeClass('d-none').addClass('d-flex');
                  },
                  success: (data) => {
                        console.log(data)
                        validateFields(data, $(this));
                  },
                  error: (error) => {
                        console.log(error.responseText);
                  }
            }).always(function () {
                  _this.find('.load').removeClass('d-flex').addClass('d-none');
            });
      });
      $('#change-deck').on('change', function () {
            _this = $(this);
            $.ajax({
                  url: _this.attr('data-action'),
                  type: _this.attr('data-method'),
                  dataType: _this.attr('data-type'),
                  data: "deck_id=" + _this.val(),
                  beforeSend: function () {
                        _this.find('.load').removeClass('d-none').addClass('d-flex');
                  },
                  success: (data) => {
                        console.log(data);
                        deck(data);
                  },
                  error: (error) => {
                        console.log(error.responseText);
                  }
            }).always(function () {
                  _this.find('.load').removeClass('d-flex').addClass('d-none');
            });
      });
      function deck(datas) {
            $('#library-deck').html('');
            $('#crypt-deck').html('');
            $("#total-library").html('');
            $("#total-crypt").html('');

            if (datas == "deck nao registrado") {
                  return;
            }
            $('#library-deck').html('');
            $('#crypt-deck').html('');

            let totalLibrary = 0;
            let totalCrypt = 0;

            for (data in datas[0]) {
                  if (datas[0][data]) {
                        totalLibrary += parseInt(datas[0][data].amount);
                        $('#library-deck').append(`
                              <tr data-id="${datas[0][data].library_card_id}" class="tr" draggable="true" data-src="${datas[0][data].cardName}">  
                                    <th class="list-library">${datas[0][data].amount}</th>
                                    <td>${datas[0][data].name}</td>
                                    <td>${datas[0][data].type}</td>
                              </tr>
                        `);

                        $(`#library-deck tr[data-id="${datas[0][data].library_card_id}"]`).on('dragstart', dragstart);
                        $(`#library-deck tr[data-id="${datas[0][data].library_card_id}"]`).on('drag', drag);
                        $(`#library-deck tr[data-id="${datas[0][data].library_card_id}"]`).on('dragend', dragend);
                  }
            }
            for (data in datas[1]) {
               totalCrypt += parseInt(datas[1][data].amount);
                  if (datas[1][data]) {
                        $('#crypt-deck').append(`
                              <tr data-id="${datas[1][data].crypt_card_id}" class="tr" draggable="true"  data-src="${datas[1][data].cardName}">
                                    <th class="list-crypt">${datas[1][data].amount}</th>
                                    <td>${datas[1][data].name}</td>
                                    <td>${datas[1][data].clan}</td>
                                    <td class="ps-4">${datas[1][data].capacity}</td>
                              </tr>
                        `);

                        $(`#crypt-deck tr[data-id="${datas[1][data].crypt_card_id}"]`).on('dragstart', dragstart);
                        $(`#crypt-deck tr[data-id="${datas[1][data].crypt_card_id}"]`).on('drag', drag);
                        $(`#crypt-deck tr[data-id="${datas[1][data].crypt_card_id}"]`).on('dragend', dragend);
                  }
            }
            $("#total-library").html('');
            if (totalLibrary) {
                  $("#total-library").html(`(${totalLibrary})`);
            }

            $("#total-crypt").html('');
            if (totalCrypt) {
                  $("#total-crypt").html(`(${totalCrypt})`);
            }
      }

      $(document).on('mouseover', '.tr', function () {
            _this = $(this);
            $.ajax({
                  url: $('#image').attr('data-action') + `?id=${_this.data('id')}`,
                  type: $('#image').attr('data-method'),
                  dataType: $('#image').attr('data-type'),
                  beforeSend: function () {
                        _this.find('.load').removeClass('d-none').addClass('d-flex');
                  },
                  success: (data) => {
                        var img = document.querySelector("#img-card");
                        img.setAttribute('src', data);
                  },
                  error: (error) => {
                        console.log(error.responseText);
                  }
            }).always(function () {
                  _this.find('.load').removeClass('d-flex').addClass('d-none');
            });
            $('#img-card').attr('src', $(this).attr('data-src'));
      });

      const libraryDeck = document.querySelector('#myTabContent');

      libraryDeck.addEventListener('dragenter', dragenter);
      libraryDeck.addEventListener('dragover', dragover);
      libraryDeck.addEventListener('dragleave', dragleave);
      libraryDeck.addEventListener('drop', drop);

      const dropArea = document.querySelector('#drop-area');

      dropArea.addEventListener('dragenter', dragenter);
      dropArea.addEventListener('dragover', dragover);
      dropArea.addEventListener('dragleave', dragleave);
      dropArea.addEventListener('drop', dropTrash);

      let currentElement;

      const elementosMoveis = document.querySelectorAll('.tr');

      for (indice in elementosMoveis) {
            elementosMoveis[indice].addEventListener('dragstart', dragstart);
            elementosMoveis[indice].addEventListener('drag', drag);
            elementosMoveis[indice].addEventListener('dragend', dragend);
            elementosMoveis[indice].addEventListener('dragend', dragend);
            elementosMoveis[indice].addEventListener('dblclick', dblclick);
      }

      function dragstart() {
            currentElement = false
            if ($(this).closest("tbody").prop("id") == "list-all-library" || $(this).closest("tbody").prop("id") == "list-all-crypt") {
                  currentElement = $(this).clone();
            }
            if ($(this).closest("tbody").prop("id") == "library-deck" || $(this).closest("tbody").prop("id") == "crypt-deck") {
                  currentElement = $(this);
            }
      }

      function drag() {
            this.classList.add('movendo-elemento');
      }

      function dragend() {
            this.classList.remove('movendo-elemento');
      }

      function dragenter() {}

      function dragover(event) {
            event.preventDefault();
            $(this).addClass('border border-success');
      }

      function dragleave() {
            $(this).removeClass('border border-success');
      }

      function drop() {
            $(this).removeClass('border border-success');
            let exist = true;
            if (currentElement) {
                  if (currentElement.data('id') < 200000) {
                        $('#library-deck').find('tr').each(function () {

                              if ($(this).data('id') == currentElement.data('id')) {
                                    $(this).find('.list-library').html(parseInt($(this).find('.list-library').html()) + 1);
                                    exist = false;
                              }
                        });
                        if (exist) {
                              $('#library-deck').append(` 
                                          <tr data-id="${currentElement.data('id')}"  draggable="true" class="tr">
                                                <th class="list-library">1</th>      
                                                <td>${currentElement.find('td')[0].innerHTML}</td>      
                                                <td>${currentElement.find('td')[1].innerHTML}</td>       
                                          </tr>
                                    `);
                              $(`#library-deck tr[data-id="${currentElement.data('id')}"]`).on('dragstart', dragstart);
                              $(`#library-deck tr[data-id="${currentElement.data('id')}"]`).on('drag', drag);
                              $(`#library-deck tr[data-id="${currentElement.data('id')}"]`).on('dragend', dragend);
                        }
                        let valorCalculado = 0;
                        $(".list-library").each(function () {
                              valorCalculado += parseInt($(this).html());
                        });

                        $("#total-library").html('');
                        if (valorCalculado) {
                              $("#total-library").html(`(${valorCalculado})`);
                        }

                  } else {
                        $('#crypt-deck').find('tr').each(function () {
                              if ($(this).data('id') == currentElement.data('id')) {
                                    $(this).find('.list-crypt').html(parseInt($(this).find('.list-crypt').html()) + 1);
                                    exist = false;
                              }
                        });

                        if (exist) {
                              $('#crypt-deck').append(` 
                                    <tr data-id="${currentElement.data('id')}" class="tr" draggable="true">
                                          <th class="list-crypt">1</th>      
                                          <td>${currentElement.find('td')[0].innerHTML}</td>      
                                          <td>${currentElement.find('td')[2].innerHTML}</td>      
                                          <td class="ps-4">${currentElement.find('td')[5].innerHTML}</td>
                                    </tr>
                              `);
                              $(`#crypt-deck tr[data-id="${currentElement.data('id')}"]`).on('dragstart', dragstart);
                              $(`#crypt-deck tr[data-id="${currentElement.data('id')}"]`).on('drag', drag);
                              $(`#crypt-deck tr[data-id="${currentElement.data('id')}"]`).on('dragend', dragend);
                        }
                        valorCalculado = 0;
                        $(".list-crypt").each(function () {
                              valorCalculado += parseInt($(this).html());
                        });

                        $("#total-crypt").html('');
                        if (valorCalculado) {
                              $("#total-crypt").html(`(${valorCalculado})`);
                        }
                  }
            }
      }

      function dropTrash() {
            $(this).removeClass('border border-success');
            if (currentElement.data('id') < 200000) {
                  let elementoTrash = currentElement.find('.list-library');
                  if (elementoTrash.html() <= 1) {
                        currentElement.remove();
                  } else {
                        elementoTrash.html(elementoTrash.html() - 1)
                  }

                  let valorCalculado = 0;
                  $(".list-library").each(function () {
                        valorCalculado += parseInt($(this).html());
                  });

                  $("#total-library").html('');
                  if (valorCalculado) {
                        $("#total-library").html(`(${valorCalculado})`);
                  }
            } else {
                  let elementoTrash = currentElement.find('.list-crypt');
                  if (elementoTrash.html() <= 1) {
                        currentElement.remove();
                  } else {
                        elementoTrash.html(elementoTrash.html() - 1)
                  }

                  let valorCalculado = 0;
                  $(".list-crypt").each(function () {
                        valorCalculado += parseInt($(this).html());
                  });

                  $("#total-crypt").html('');
                  if (valorCalculado) {
                        $("#total-crypt").html(`(${valorCalculado})`);
                  }
            }
      }

      function dblclick() {
            let newElement = $(this).clone();

            let exist = true;

            if (newElement) {
                  if (newElement.data('id') < 200000) {

                        $('#library-deck').find('tr').each(function () {

                              if ($(this).data('id') == newElement.data('id')) {
                                    $(this).find('.list-library').html(parseInt($(this).find('.list-library').html()) + 1);
                                    exist = false;
                              }
                        });

                        if (exist) {
                              $('#library-deck').append(` 
                                          <tr data-id="${newElement.data('id')}"  draggable="true" class="tr">
                                                <th class="list-library">1</th>      
                                                <td>${newElement.find('td')[0].innerHTML}</td>      
                                                <td>${newElement.find('td')[1].innerHTML}</td>       
                                          </tr>
                                    `);
                              $(`#library-deck tr[data-id="${newElement.data('id')}"]`).on('dragstart', dragstart);
                              $(`#library-deck tr[data-id="${newElement.data('id')}"]`).on('drag', drag);
                              $(`#library-deck tr[data-id="${newElement.data('id')}"]`).on('dragend', dragend);
                        }

                        let valorCalculado = 0;
                        $(".list-library").each(function () {
                              valorCalculado += parseInt($(this).html());

                        });

                        $("#total-library").html('');
                        if (valorCalculado) {
                              $("#total-library").html(`(${valorCalculado})`);
                        }

                  } else {

                        $('#crypt-deck').find('tr').each(function () {

                              if ($(this).data('id') == newElement.data('id')) {
                                    $(this).find('.list-crypt').html(parseInt($(this).find('.list-crypt').html()) + 1);
                                    exist = false;
                              }
                        });

                        if (exist) {
                              $('#crypt-deck').append(` 
                                    <tr data-id="${newElement.data('id')}" class="tr" draggable="true">
                                          <th class="list-crypt">1</th>      
                                          <td>${newElement.find('td')[0].innerHTML}</td>      
                                          <td>${newElement.find('td')[2].innerHTML}</td>      
                                          <td class="ps-4">${newElement.find('td')[5].innerHTML}</td>
                                    </tr>
                              `);
                              $(`#crypt-deck tr[data-id="${newElement.data('id')}"]`).on('dragstart', dragstart);
                              $(`#crypt-deck tr[data-id="${newElement.data('id')}"]`).on('drag', drag);
                              $(`#crypt-deck tr[data-id="${newElement.data('id')}"]`).on('dragend', dragend);
                        }
                        valorCalculado = 0;
                        $(".list-crypt").each(function () {
                              valorCalculado += parseInt($(this).html());
                        });

                        $("#total-crypt").html('');
                        if (valorCalculado) {
                              $("#total-crypt").html(`(${valorCalculado})`);
                        }
                  }
            }
      }

      function deckForTxt() {
            let deck = {
                  "deckName": $('#change-deck option:selected').html(),
                  "cryptList": {},
                  "libraryList": {}
            };

            $('#library-deck tr').each(function (index, data) {
                  deck.libraryList[index] = {
                        "amount": data.getElementsByTagName('th')[0].innerHTML,
                        "library_card_id": data.getAttribute('data-id')
                  };
            });

            $('#crypt-deck tr').each(function (index, data) {
                  deck.cryptList[index] = {
                        "amount": data.getElementsByTagName('th')[0].innerHTML,
                        "crypt_card_id": data.getAttribute('data-id')
                  };
            });

            return deck;
      }
});