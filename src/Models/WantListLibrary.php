<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class WantListLibrary extends DataLayer
{
    function __construct()
    {
        parent::__construct('want_list_library', ['amount', 'user_id', 'library_card_id'], 'id');
    }

    public function libraryCard() : LibraryCard
    {
        return (new LibraryCard())->findById($this->library_card_id);
    }
}
    