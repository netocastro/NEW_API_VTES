$(document).ready(function () {
    $('#form-deck-update').on('submit', function (e) {
        e.preventDefault();
        _this = $(this);

        $.ajax({
            url: _this.attr('action'),
            type: _this.attr('method'),
            dataType: _this.attr('data-type'),
            data: updateDeckList(),
            beforeSend: function () {
                _this.find('.load').removeClass('d-none').addClass('d-flex');
            },
            success: (data) => {
                console.log(data);
                validateFields(data,_this);
            },
            error: (error) => {
                console.log(error.responseText);
            }
        }).always(function () {
            _this.find('.load').removeClass('d-flex').addClass('d-none');
        });
    });
});
function updateDeckList() {
    let deck = {
        "deckId": $('#change-deck').val(),
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