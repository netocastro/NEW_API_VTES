<?php

namespace Source\Controllers\Api;

use Source\Interfaces\Controller;
use Source\Models\CryptList;
use Source\Models\Deck;
use Source\Models\LibraryList;

class DeckController implements Controller
{
    public function createDeck(array $data): void
    {
        $emptyFields = array_keys($data, '');

        if ($emptyFields) {
            echo json_encode(["emptyFields" => $emptyFields]);
            return;
        }

        $data['deckName'] = str_replace(" ", "_", trim($data['deckName']));

        $validateFields = [];

        if ((new Deck())->find("name = :name and user_id = :ui", "name={$data['deckName']}&ui={$_SESSION['user_id']}")->fetch()) {
            $validateFields['deckName'] = 'nome já registrado';
        }

        if ($validateFields) {
            echo json_encode(['validateFields' => $validateFields]);
            return;
        }

        $deckName = filter_var($data['deckName'], FILTER_SANITIZE_STRIPPED);

        $deck = new Deck();
        $deck->name = $deckName;
        $deck->user_id = $_SESSION['user_id'];

        $deck->save();

        if ($deck->fail()) {
            echo json_encode("Error:" . $deck->fail()->getMessage());
        }

        if (isset($data['libraryList'])) {

            foreach ($data['libraryList'] as $libraryCard) {

                $newLibraryList = new LibraryList;

                $newLibraryList->deck_id = $deck->id;
                $newLibraryList->amount = filter_var($libraryCard['amount'], FILTER_SANITIZE_STRIPPED);
                $newLibraryList->library_card_id = filter_var($libraryCard['library_card_id'], FILTER_SANITIZE_STRIPPED);

                $newLibraryList->save();

                if ($newLibraryList->fail()) {
                    echo json_encode("Error:" . $newLibraryList->fail()->getMessage());
                    $deck->destroy();
                    return;
                }
            }
        }

        if (isset($data['cryptList'])) {
            foreach ($data['cryptList'] as $cryptCard) {

                $newCryptList = new CryptList();
                $newCryptList->deck_id =  $deck->id;
                $newCryptList->amount = filter_var($cryptCard['amount'], FILTER_SANITIZE_NUMBER_INT);
                $newCryptList->crypt_card_id = filter_var($cryptCard['crypt_card_id'], FILTER_SANITIZE_NUMBER_INT);

                $newCryptList->save();

                if ($newCryptList->fail()) {
                    $deck->destroy();
                    echo json_encode("Error:" . $newCryptList->fail()->getMessage());
                    return;
                }
            }
        }
        echo json_encode([
            "successCreate" => "deck salvo com sucesso",
            "deckId" => $deck->id,
            "deckName" =>  $deckName
        ]);
    }

    public function showByDeckId($data): void
    {
        //echo json_encode("entrou for:");
        //return;
        $data['deck_id'] = filter_var($data['deck_id'], FILTER_SANITIZE_NUMBER_INT);
        $deck = [];

        $libraryList = (new LibraryList())->find('deck_id = :di', "di={$data['deck_id']}")->fetch(true);
        $crypList = (new CryptList())->find('deck_id = :di', "di={$data['deck_id']}")->fetch(true);

        if ($libraryList) {
            foreach ($libraryList as $libraryCard) {
                $libraryCard->name = $libraryCard->card()->name;
                $libraryCard->type = $libraryCard->card()->type;
            }
        }

        if ($crypList) {
            foreach ($crypList as $crypCard) {
                $crypCard->name = $crypCard->card()->name;
                $crypCard->type = $crypCard->card()->type;
                $crypCard->clan = $crypCard->card()->clan;
                $crypCard->capacity = $crypCard->card()->capacity;
            }
        }

        $deck[] = objectToArray($libraryList);
        $deck[] = objectToArray($crypList);

        if ($libraryList && $crypList) {
            echo json_encode($deck);
        } else {
            echo json_encode("deck nao registrado");
        }
    }

    public function updateDeck(array $data): void
    {
        $validateFields = [];

        if ($data['deckId'] == "--" || empty($data['deckId'])) {
            $validateFields['deckNameUpdate'] = 'deck inválido';
        }

        if ($validateFields) {
            echo json_encode(['validateFields' => $validateFields]);
            return;
        }

        $livrariaDecks = (new LibraryList())->find("deck_id = :di", "di={$data['deckId']}")->fetch(true);
        $cryptDecks = (new CryptList())->find("deck_id = :di", "di={$data['deckId']}")->fetch(true);

        if ($livrariaDecks) {
            foreach ($livrariaDecks as $livrariaDeck) {
                $livrariaDeck->destroy();
            }
        }

        if ($cryptDecks) {
            foreach ($cryptDecks as $cryptDeck) {
                $cryptDeck->destroy();
            }
        }

        if (isset($data['libraryList'])) {
            foreach ($data['libraryList'] as $libraryCard) {

                $newLibraryList = new LibraryList();
                $newLibraryList->deck_id = $data['deckId'];
                $newLibraryList->amount = filter_var($libraryCard['amount'], FILTER_SANITIZE_STRIPPED);
                $newLibraryList->library_card_id = filter_var($libraryCard['library_card_id'], FILTER_SANITIZE_STRIPPED);

                $newLibraryList->save();

                if ($newLibraryList->fail()) {
                    echo json_encode("Error:" . $newLibraryList->fail()->getMessage());

                    return;
                }
            }
        }

        if (isset($data['cryptList'])) {
            foreach ($data['cryptList'] as $cryptCard) {

                $newCryptList = new CryptList();
                $newCryptList->deck_id = $data['deckId'];
                $newCryptList->amount = filter_var($cryptCard['amount'], FILTER_SANITIZE_NUMBER_INT);
                $newCryptList->crypt_card_id = filter_var($cryptCard['crypt_card_id'], FILTER_SANITIZE_NUMBER_INT);

                $newCryptList->save();

                if ($newCryptList->fail()) {
                    echo json_encode("Error:" . $newCryptList->fail()->getMessage());
                    return;
                }
            }
        }
        echo json_encode(["successUpdate" => "deck atualizado com sucesso"]);
    }

    /**
     * Retorna a lista de todos os decks
     */
    public function index(): void
    {
    }

    public function store(array $data): void
    {
    }

    public function show(array $data): void
    {
    }

    public function update(array $data): void
    {
    }

    public function destroy(array $data): void
    {
    }
}
