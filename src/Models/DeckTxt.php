<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class DeckTxt extends DataLayer
{
    function __construct()
    {
        parent::__construct('decktxt', ['user_id', 'directory'], 'id');
    }
}
