<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class CryptCard extends DataLayer
{
      function __construct()
      {
            parent::__construct('vtescrypt', ['name', 'type', 'clan', 'group', 'capacity', 'card_text'], 'id');
      }

      public function grupo(): ?string
      {
            return $this->data()->group;
      }

      public function cardName(): string
      {
            $formatedCardName = str_replace(["!", "@", "#", "$", "&", ">", "<", "*", "/", "\\", " ", ",", "\'", "/'", "'", ":", "`", "´", "%", ")", "(", "-", "_", ".", "\""], '', $this->name);
            $formatedCardName = preg_replace('/(\')/', '', $formatedCardName);
            $formatedCardName = str_replace(
                  ['á', 'Á', 'ç', 'ñ', 'é', 'ó', 'É', 'è', 'ë', 'í', 'ú',     'ã', 'ö', 'ê', 'ü', 'í'],
                  ['a', 'a', 'c', 'n', 'e', 'o', 'e', 'e', 'e', 'i', 'u', 'a', 'o', 'e', 'u', 'i'],
                  $formatedCardName
            );
            if ($this->adv) {
                  return json_encode(IMAGE_PATH .  strtolower($formatedCardName) . "adv.jpg");
                  
            }
            return json_encode(IMAGE_PATH . strtolower($formatedCardName) . ".jpg");
      }
}
