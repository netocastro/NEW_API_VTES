<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class LibraryCard extends DataLayer
{
      function __construct()
      {
            parent::__construct('vteslib', ['name', 'type', 'card_text'], 'id');
      }

      public function cardName()
      {
            $formatedCardName = str_replace(["!", "@", "#", "$", "&", ">", "<", "*", "/", "\\", " ", ",", "\'", "/'", "'", ":", "`", "´", "%", ")", "(", "-", "_", ".", "\""], '', $this->name);
            $formatedCardName = preg_replace('/(\')/', '', $formatedCardName);
            $formatedCardName = str_replace(
                  ['á', 'Á', 'ç', 'ñ', 'é', 'ó', 'É', 'è', 'ë', 'í', 'ú', 'ã', 'ö', 'ê', 'ü', 'í'],
                  ['a', 'a', 'c', 'n', 'e', 'o', 'e', 'e', 'e', 'i', 'u', 'a', 'o', 'e', 'u', 'i'],
                  $formatedCardName
            );
            return json_encode(IMAGE_PATH . strtolower($formatedCardName) . ".jpg");
      }
}
