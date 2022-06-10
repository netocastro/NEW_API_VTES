<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class Deck extends DataLayer
{
      function __construct()
      {
            parent::__construct('decks', ['name', 'user_id'], 'id');
      }

      public function libraryList(): LibraryList
      {
            return (new LibraryList())->find("deck_id = :di", "di={$this->id}")->fetch();
      }
}
