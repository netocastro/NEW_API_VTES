<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class WantListCrypt extends DataLayer
{
    function __construct()
    {
        parent::__construct('want_list_crypt', ['amount', 'user_id', 'crypt_card_id'], 'id');
    }

    public function cryptCard() : CryptCard
    {
        return (new CryptCard())->findById($this->crypt_card_id);
    }
}
    