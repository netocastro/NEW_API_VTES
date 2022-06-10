<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class LibraryList extends DataLayer
{
      function __construct()
      {
            parent::__construct('library_list', ['deck_id', 'amount', 'library_card_id'], 'id');
      }

      public function card(): LibraryCard
      {
            return (new LibraryCard())->findById($this->library_card_id);
      }
}
