<?php

namespace Source\Controllers\Api;

use Source\Interfaces\Controller;
use Source\Models\Deck;
use Source\Models\LibraryCard;
use Source\Models\LibraryList;

class LibraryListController implements Controller
{
      /**
       * Retorna todas as cartas da livraria que estão em todos os decks
       */
      public function index(): void
      {
            echo json_encode(objectToArray((new LibraryList())->find()->fetch(true)));
      }

      /**
       * insere uma carta de livraria na lista de um deck
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
                  "library_card_id" => FILTER_SANITIZE_NUMBER_INT
            ]);

            $invalidInputTypes = array_keys($data, '');

            if ($invalidInputTypes) {
                  echo json_encode(["invalidInputTypes" => $invalidInputTypes]);
                  return;
            }

            $validateFields = [];
            $libraryList = (new LibraryList())->find('deck_id = :di and library_card_id = :lci', "di={$data['deck_id']}&lci={$data['library_card_id']}")->fetch();

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

            $libraryList = new LibraryList();

            $libraryList->deck_id = $data['deck_id'];
            $libraryList->amount = $data['amount'];
            $libraryList->library_card_id = $data['library_card_id'];

            $libraryList->save();

            if ($libraryList->fail()) {
                  echo json_encode($libraryList->fail()->getMessage());
                  return;
            } else {
                  echo json_encode("carta adicionada a livraria!");
            }
      }

      /**
       * Exibe uma carta especifica da livraria da lista de decks
       */
      public function show(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $card = (new LibraryList())->findById($data['id']);
            if ($card) {
                  echo json_encode(objectToArray($card));
            } else {
                  echo json_encode("id nao registrado");
            }
      }

      /**
       * Atualiza uma carta especifica da livraria da lista de decks
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
                  "library_card_id" => FILTER_SANITIZE_NUMBER_INT
            ]);

            $invalidInputTypes = array_keys($data, '');

            if ($invalidInputTypes) {
                  echo json_encode(["invalidInputTypes" => $invalidInputTypes]);
                  return;
            }

            $validateFields = [];
            $libraryList = (new LibraryList())->findById($data['id']);

            if (!$libraryList) {
                  echo json_encode("Id nao registrado");
                  return;
            }

            if (!(new Deck())->findById($data['deck_id'])) {
                  $validateFields['deck_id'] = 'Deck nao registrado';
            }

            if (!(new LibraryCard())->findById($data['library_card_id'])) {
                  $validateFields['library_card_id'] = "Essa carta nao existe na livraria";
            }

            if ($validateFields) {
                  echo json_encode(['validateFields' => $validateFields]);
                  return;
            }

            $libraryList->deck_id = $data['deck_id'];
            $libraryList->amount = $data['amount'];
            $libraryList->library_card_id = $data['library_card_id'];

            $libraryList->change()->save();

            if ($libraryList->fail()) {
                  echo json_encode($libraryList->fail()->getMessage());
                  return;
            } else {
                  echo json_encode("carta atualizada na sua lista!");
            }
      }

      /**
       * Deleta uma carta especifica da livraira da lista de decks
       */
      public function destroy(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $card = (new LibraryList())->findById($data['id']);

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

      /**
       * Retorna a lista de cartas de livraria de um deck epecifico.
       */
      public function showByDeckId(): void
      {
            $data = filter_var($_GET['deck_id'], FILTER_SANITIZE_STRING);

            $card = (new LibraryList())->find('deck_id = :di', "di={$data}")->fetch(true);

            $card = objectToArray($card);

            if ($card) {
                  echo json_encode($card);
            } else {
                  echo json_encode("id nao registrado");
            }
      }
}
