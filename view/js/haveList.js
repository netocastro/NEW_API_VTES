$(document).ready(function () {

    /**
     * Evento acionado para carragar a imagem da carta no modal referente
     * ao proprio elemento de botao qual foi clicado
     */
    $(document).on('click', '.btn-link', function () {
        let _this = $(this);
        $('#image').attr('src', _this.data('src'));

        setTimeout(function () {
            $('#load-card-image').addClass('d-none');
            $('#load-card').removeClass('bg-white');
            $('#image').hide().removeClass('d-none').fadeIn();

        }, '500');
    });

    /**
     * Evento acionado toda vez que o modal e escondido.
     * serve para voltar os atributos originais do modal
     */
    $('#exampleModal').on('hidden.bs.modal', function () {
        $('#load-card').addClass('bg-white');
        $('#load-card-image').removeClass('d-none');
        $('#image').hide().addClass('d-none');
    });

    /**
     * Pega o valor total de todas as quantidade de cartas de cripta
     * da lista.
     */
    let valorCalculado = 0;
    $(".amount-crypt").each(function () {
        valorCalculado += parseInt($(this).html());
    });

    /**
     * Imprime na aba "crypt" a quantidade todal de cartas
     * da cripta.
     */
    $("#total-have-crypt").html('');
    if (valorCalculado) {
        $("#total-have-crypt").html(`(${valorCalculado})`);
    }

    /**
     * Pega o valor total de todas as quantidade de cartas de livraria
     * da lista.
     */
    valorCalculado = 0;
    $(".amount-library").each(function () {
        valorCalculado += parseInt($(this).html());
    });

    /**
     * Imprime na aba "library" a quantidade todal de cartas
     * da livraria.
     */
    $("#total-have-library").html('');
    if (valorCalculado) {
        $("#total-have-library").html(`(${valorCalculado})`);
    }

    /**
     * escolhe no select se as cartas quer serão carregadas no 
     * datalist serão crypt ou library cards
     */
    $(document).on('change', '#type-card', function () {
        _this = $(this);
        let url = (_this.val() == 'library' ? _this.data('url').replace('crypt/selectCryptForList', 'library/selectLibraryForList') : _this.data('url'));
        $.ajax({
            url: url,
            type: _this.attr('data-method'),
            dataType: _this.attr('data-type'),
            beforeSend: function () {
                $('.load').removeClass('d-none').addClass('d-flex');
            },
            success: (data) => {
                dataList(data);
            },
            error: (error) => {
                console.log(error.responseText);
            }
        }).always(function () {
            $('.load').removeClass('d-flex').addClass('d-none');
        });
    });

    /**
     *  Função utilizada como o resultado de detorno do change acima,
     *  os options do datalist serão preenchidos com a lista de crypt
     *  ou library cards.
     */
    function dataList(data) {
        $('#list').html('');
        if ($('#type-card').val() == 'crypt') {
            for (index in data) {
                $('#list').append(`
                    <option data-id="${data[index].id}" data-src=${data[index].cardUrl} value="${data[index].name} ${data[index].adv == 'Advanced' ? 'adv' : ''}"> ${data[index].clan}</option>
                `);
            }
        }

        if ($('#type-card').val() == 'library') {
            for (index in data) {
                $('#list').append(`
                    <option data-id="${data[index].id}" data-src=${data[index].cardUrl} value="${data[index].name}">${data[index].type}</option>
                `);
            }
        }
    }

    /**
     * Evento usado para  fazer a persistencia da lista have
     * no banco de dados
     */
    $('#save-have-list').on('click', function (e) {
        e.preventDefault();
        _this = $(this);
        $.ajax({
            url: _this.data('url'),
            type: 'post',
            dataType: 'json',
            data: saveHaveList(),
            beforeSend: function () {
                $('.load').removeClass('d-none').addClass('d-flex');
            },
            success: (data) => {
                $('.success').remove()
                $('.navbar').after(`
                    <div class="bg-success pt-2 pb-1 success" style="display: none;"> <p class="text-center text-light">${data.success}</p></div>
                `);
                $('.success').fadeIn(500, function () {
                    setTimeout(function () {
                        $(".success").remove().empty();
                    }, 5000);
                });
            },
            error: (error) => {
                console.log(error.responseText);
            }
        }).always(function () {
            $('.load').removeClass('d-flex').addClass('d-none');
        });
    });

    /**
     * Função auxiliar do evento de save-have-list, serve para formatar as
     * informações do front end e enviar para o back end
     */
    function saveHaveList() {
        let haveList = {
            "cryptList": {},
            "libraryList": {}
        };
        $('#libraryList tr').each(function (index, data) {
            haveList.libraryList[index] = {
                "amount": data.getElementsByTagName('td')[0].innerHTML,
                "library_card_id": data.getAttribute('data-id')
            };
        });
        $('#cryptList tr').each(function (index, data) {
            haveList.cryptList[index] = {
                "amount": data.getElementsByTagName('td')[0].innerHTML,
                "crypt_card_id": data.getAttribute('data-id')
            };
        });
        return haveList;
    }

    /**
     * Evento usado para adicionar uma carta a lista de cripta
     */
    $(document).on('click', '#addCrypt', function () {
        let newAmount = parseInt($(this).closest('tr').find('.amount-crypt').html()) + 1;
        $(this).closest('tr').find('.amount-crypt').html(newAmount);

        let valorCalculado = 0;
        $(".amount-crypt").each(function () {
            valorCalculado += parseInt($(this).html());
        });

        $("#total-have-crypt").html('');
        if (valorCalculado) {
            $("#total-have-crypt").html(`(${valorCalculado})`);
        }
        $('#input').focus();
    });

    /**
     * Evento usado para remover uma carta a lista de cripta
     */
    $(document).on('click', '#removeCrypt', function () {
        if ($(this).closest('tr').find('.amount-crypt').html() <= 1) {
            $(this).closest('tr').remove();

            let valorCalculado = 0;
            $(".amount-crypt").each(function () {
                valorCalculado += parseInt($(this).html());
            });

            $("#total-have-crypt").html('');
            if (valorCalculado) {
                $("#total-have-crypt").html(`(${valorCalculado})`);
            }

            $('#input').focus();
            return false;
        }

        let newAmount = parseInt($(this).closest('tr').find('.amount-crypt').html()) - 1;
        $(this).closest('tr').find('.amount-crypt').html(newAmount);

        let valorCalculado = 0;
        $(".amount-crypt").each(function () {
            valorCalculado += parseInt($(this).html());
        });

        $("#total-have-crypt").html('');
        if (valorCalculado) {
            $("#total-have-crypt").html(`(${valorCalculado})`);
        }

        $('#input').focus();
    });

    /**
     * Evento usado para adicionar uma carta a lista de livraria
     */
    $(document).on('click', '#addLibrary', function () {
        let newAmount = parseInt($(this).closest('tr').find('.amount-library').html()) + 1;
        $(this).closest('tr').find('.amount-library').html(newAmount);

        valorCalculado = 0;
        $(".amount-library").each(function () {
            valorCalculado += parseInt($(this).html());
        });

        $("#total-have-library").html('');
        if (valorCalculado) {
            $("#total-have-library").html(`(${valorCalculado})`);
        }

        $('#input').focus();
    });

    /**
     * Evento usado para remover uma carta a lista de livraria
     */
    $(document).on('click', '#removeLibrary', function () {
        if ($(this).closest('tr').find('.amount-library').html() <= 1) {
            $(this).closest('tr').remove();

            valorCalculado = 0;
            $(".amount-library").each(function () {
                valorCalculado += parseInt($(this).html());
            });

            $("#total-have-library").html('');
            if (valorCalculado) {
                $("#total-have-library").html(`(${valorCalculado})`);
            }

            $('#input').focus();
            return false;
        }

        let newAmount = parseInt($(this).closest('tr').find('.amount-library').html()) - 1;
        $(this).closest('tr').find('.amount-library').html(newAmount);

        valorCalculado = 0;
        $(".amount-library").each(function () {
            valorCalculado += parseInt($(this).html());
        });

        $("#total-have-library").html('');
        if (valorCalculado) {
            $("#total-have-library").html(`(${valorCalculado})`);
        }

        $('#input').focus();
    });

    /**
     *?
     */
    function qs(query, context) {
        return (context || document).querySelector(query);
    }

    /**
     *?
     */
    function qsa(query, context) {
        return (context || document).querySelectorAll(query);
    }

    /**
     * De forma geral não sei como esse evento funciona,
     * achei na internet junto com essas 2 funcções auxiliares acima
     * onde sua função é que apos eu selecionar uma informação em um 
     * datalist, eu consiga referenciar o elemento pega suas informações.
     */
    qs("#input").addEventListener('change', function (e) {
        e.preventDefault();

        var options = qsa('#' + e.target.getAttribute('list') + ' > option'),
            values = [];

        [].forEach.call(options, function (option) {
            values.push(option.value)
        });

        var currentValue = e.target.value;
        var targetTeste = e.target;

        if (values.indexOf(currentValue) !== -1) {
            if ($('#type-card').val() == 'crypt') {
                let selector = document.querySelector('option[value="' + currentValue + '"]');
                let exists = true;

                $('#cryptList').find('tr').each(function (indice, element) {
                    if ($(this).data('id') == selector.getAttribute('data-id')) {
                        $(this).find('.amount-crypt').text(parseInt($(this).find('.amount-crypt').html()) + 1);
                        $('#input').val('');
                        exists = false;
                        return;
                    }
                });
                if (exists) {
                    $('#cryptList').prepend(`
                        <tr data-id="${selector.getAttribute('data-id')}">
                            <td class="amount-crypt">1</td>
                            <td class="card-name">
                                <div class="d-grid">
                                <button class="btn btn-link text-start" data-bs-toggle="modal" data-bs-target="#exampleModal" data-src="${selector.getAttribute('data-src')}">
                                    ${currentValue}
                                </button>
                            </div
                            </td>
                            <td>${selector.textContent}</td>
                            <td class="text-center">
                                <button class="btn py-1 btn-sm" id="removeCrypt"><i class="fas fa-minus"></i></button>
                                <button class="btn me-1 py-1 btn-sm" id="addCrypt"><i class="fas fa-plus"></i></button>
                            </td>
                        </tr>
                    `);
                    $('#input').val('');
                }

                let valorCalculado = 0;
                $(".amount-crypt").each(function () {
                    valorCalculado += parseInt($(this).html());
                });

                $("#total-have-crypt").html('');
                if (valorCalculado) {
                    $("#total-have-crypt").html(`(${valorCalculado})`);
                }
            }

            if ($('#type-card').val() == 'library') {
                let selector = document.querySelector('option[value="' + currentValue + '"]');
                let exists = true;

                $('#libraryList').find('tr').each(function (indice, element) {
                    if ($(this).data('id') == selector.getAttribute('data-id')) {
                        $(this).find('.amount-library').text(parseInt($(this).find('.amount-library').html()) + 1);
                        $('#input').val('');
                        exists = false;
                        return;
                    }
                });

                if (exists) {
                    $('#libraryList').prepend(`
                    <tr data-id="${selector.getAttribute('data-id')}">
                        <td class="amount-library">1</td>
                        <td class="card-name">
                            <div class="d-grid">
                                <button class="btn btn-link text-start" data-bs-toggle="modal" data-bs-target="#exampleModal" data-src="${selector.getAttribute('data-src')}">
                                    ${currentValue}
                                </button>
                            </div>
                        </td>
                        <td>${selector.textContent}</td>
                        <td class="text-center">
                            <button class="btn py-1 btn-sm" id="removeLibrary"><i class="fas fa-minus"></i></button>
                            <button class="btn me-1 py-1 btn-sm" id="addLibrary"><i class="fas fa-plus"></i></button>
                        </td>
                    </tr>
                `);
                    $('#input').val('');
                }

                let valorCalculado = 0;
                $(".amount-library").each(function () {
                    valorCalculado += parseInt($(this).html());
                });

                $("#total-have-library").html('');
                if (valorCalculado) {
                    $("#total-have-library").html(`(${valorCalculado})`);
                }
            }
        }
    });
});

/**
 * OBS:
 * depois colocar pra o usuario salvar varias listas have
 */