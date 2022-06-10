<?php

namespace Source\Controllers\Api;

use Source\Interfaces\Controller;
use Source\Models\Deck;
use Source\Models\CryptCard;
use Source\Models\CryptList;

class CryptListController implements Controller
{
      /**
       * Retorna todas as cartas da cripta que estão em todos os decks
       */
      public function index(): void
      {
            echo json_encode(objectToArray((new CryptList())->find()->fetch(true)));
      }

      /**
       * insere uma carta de cripta na lista de um deck
       */
      public function store(array $data): void
      {
            $emptyFilds = array_keys($data, '');

            if ($emptyFilds) {
                  echo json_encode(["emptyFields" => $emptyFilds]);
                  return;
            }

            $data = filter_var_array($data, [
                  "deck_id" => FILTER_SANITIZE_NUMBER_INT,
                  "amount" => FILTER_SANITIZE_NUMBER_INT,
                  "crypt_card_id" => FILTER_SANITIZE_NUMBER_INT
            ]);

            $invalidInputTypes = array_keys($data, '');

            if ($invalidInputTypes) {
                  echo json_encode(["invalidInputTypes" => $invalidInputTypes]);
                  return;
            }

            $validateFields = [];
            $libraryList = (new CryptList())->find('deck_id = :di and crypt_card_id = :lci', "di={$data['deck_id']}&lci={$data['crypt_card_id']}")->fetch();

            if ($libraryList) {

                  $data['id'] = $libraryList->id;
                  $data['amount'] += $libraryList->amount;
                  $this->update($data);
                  return;
            }

            if ($validateFields) {
                  echo json_encode(['validateFields' => $validateFields]);
                  return;
            }

            $cryptList = new CryptList();

            $cryptList->deck_id = $data['deck_id'];
            $cryptList->amount = $data['amount'];
            $cryptList->crypt_card_id = $data['crypt_card_id'];

            $cryptList->save();

            if ($cryptList->fail()) {
                  echo json_encode($cryptList->fail()->getMessage());
                  return;
            } else {
                  echo json_encode("carta adicionada a cripta!");
            }
      }

      /**
       * Exibe uma carta especifica da cripta da lista de decks
       */
      public function show(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $card = (new CryptList())->findById($data['id']);
            if ($card) {
                  echo json_encode(objectToArray($card));
            } else {
                  echo json_encode("id nao registrado");
            }
      }

      /**
       * Atualiza uma carta especifica da cripta da lista de decks
       */
      public function update(array $data): void
      { 
            $emptyFilds = array_keys($data, '');

            if ($emptyFilds) {
                  echo json_encode(["emptyFields" => $emptyFilds]);
                  return;
            }

            $data = filter_var_array($data, [
                  "id" =>  FILTER_SANITIZE_NUMBER_INT,
                  "deck_id" => FILTER_SANITIZE_NUMBER_INT,
                  "amount" => FILTER_SANITIZE_NUMBER_INT,
                  "crypt_card_id" => FILTER_SANITIZE_NUMBER_INT
            ]);

            $invalidInputTypes = array_keys($data, '');

            if ($invalidInputTypes) {
                  echo json_encode(["invalidInputTypes" => $invalidInputTypes]);
                  return;
            }

            $validateFields = [];
            $cryptList = (new CryptList())->findById($data['id']);

            if (!$cryptList) {
                  echo json_encode("Id nao registrado");
                  return;
            }

            if (!(new Deck())->findById($data['deck_id'])) {
                  $validateFields['deck_id'] = 'Deck nao registrado';
            }

            if (!(new CryptCard())->findById($data['crypt_card_id'])) {
                  $validateFields['crypt_card_id'] = "Essa carta nao existe na livraria";
            }

            if ($validateFields) {
                  echo json_encode(['validateFields' => $validateFields]);
                  return;
            }

            $cryptList->deck_id = $data['deck_id'];
            $cryptList->amount = $data['amount'];
            $cryptList->crypt_card_id = $data['crypt_card_id'];

            $cryptList->change()->save();

            if ($cryptList->fail()) {
                  echo json_encode($cryptList->fail()->getMessage());
                  return;
            } else {
                  echo json_encode("carta atualizada na sua lista!");
            }   
      }

       /**
       * Deleta uma carta especifica da cripta da lista de decks
       */
      public function destroy(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $card = (new CryptList())->findById($data['id']);

            if ($card) {
                  $card->destroy();

                  if ($card->fail()) {
                        echo json_encode($card->fail()->getMessage());
                  } else {
                        echo json_encode("Deletado com sucesso");
                  }
            } else {
                  echo json_encode("id nao registrado");
            }
      } 
}
