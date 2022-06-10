<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class CryptList extends DataLayer
{
      function __construct()
      {
            parent::__construct('crypt_list', ['deck_id', 'amount', 'crypt_card_id'], 'id');
      }

      public function card(): CryptCard
      {
            return (new CryptCard())->findById($this->crypt_card_id);
      }
}
