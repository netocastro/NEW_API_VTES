<?php

namespace Source\Controllers\Site;

use Source\Models\CryptCard;
use Source\Models\CryptList;
use Source\Models\Decks;
use Source\Models\DeckTxt;
use Source\Models\HaveListCrypt;
use Source\Models\HaveListLibrary;
use Source\Models\LibraryCard;
use Source\Models\LibraryList;
use Source\Models\WantListCrypt;
use Source\Models\WantListLibrary;

class Request
{
      public function cardImage(): void
      {
            if ($_GET['id'] > 100000 && $_GET['id'] < 200000) {
                  $card = (new LibraryCard())->findById($_GET['id']);
                  if ($card) {
                        $formatedCardName = str_replace(["!", "@", "#", "$", "&", ">", "<", "*", "/", "\\", " ", ",", "\'", "/'", "'", ":", "`", "´", "%", ")", "(", "-", "_", ".", "\""], '', $card->name);
                        $formatedCardName = preg_replace('/(\')/', '', $formatedCardName);
                        $formatedCardName = str_replace(
                              ['á', 'Á', 'ç', 'ñ', 'é', 'ó', 'É', 'è', 'ë', 'í', 'ú', 'ã', 'ö', 'ê', 'ü', 'í'],
                              ['a', 'a', 'c', 'n', 'e', 'o', 'e', 'e', 'e', 'i', 'u', 'a', 'o', 'e', 'u', 'i'],
                              $formatedCardName
                        );
                        echo json_encode(IMAGE_PATH . strtolower($formatedCardName)  . ".jpg");
                  } else {
                        echo json_encode("Nome errado ou carta nao cadastrada");
                  }
            }

            if ($_GET['id'] > 200000 && $_GET['id'] < 300000) {
                  $card = (new CryptCard())->findById($_GET['id']);
                  if ($card) {
                        $formatedCardName = str_replace(["!", "@", "#", "$", "&", ">", "<", "*", "/", "\\", " ", ",", "\'", "/'", "'", ":", "`", "´", "%", ")", "(", "-", "_", ".", "\""], '', $card->name);
                        $formatedCardName = preg_replace('/(\')/', '', $formatedCardName);
                        $formatedCardName = str_replace(
                              ['á', 'Á', 'ç', 'ñ', 'é', 'ó', 'É', 'è', 'ë', 'í', 'ú', 'ã', 'ö', 'ê', 'ü', 'í'],
                              ['a', 'a', 'c', 'n', 'e', 'o', 'e', 'e', 'e', 'i', 'u', 'a', 'o', 'e', 'u', 'i'],
                              $formatedCardName
                        );
                        if ($card->adv) {
                              echo json_encode(IMAGE_PATH .  strtolower($formatedCardName) . "adv.jpg");
                              return;
                        }
                        echo json_encode(IMAGE_PATH . strtolower($formatedCardName) . ".jpg");
                  } else {
                        echo json_encode("Nome errado ou carta nao cadastrada");
                  }
            }
      }

      public function saveDeck(array $data): void
      {
            echo json_encode($data);
      }

      public function debug(array $data): void
      {
            echo gettype(json_encode($data));
      }

      public function deckTxt(array $data): void
      {
            $validateFieldsTxt = [];

            if (!isset($data['deckName']) || $data['deckName'] == " -- ") {
                  $validateFieldsTxt['deckName'] = 'selecione um deck válido';
            }

            if ($validateFieldsTxt) {
                  echo json_encode(['validateFieldsTxt' => $validateFieldsTxt]);
                  return;
            }

            if (!is_dir("cdn/media/files/decks/{$_SESSION['user_id']}")) {
                  mkdir("cdn/media/files/decks/{$_SESSION['user_id']}");
            }

            $directory = "cdn/media/files/decks/{$_SESSION['user_id']}/{$data['deckName']}.txt";
            $arquivo = fopen($directory, 'w');
            if ($arquivo == false) {
                  echo json_encode('Não foi possível criar o arquivo.');
                  return;
            }
            if (isset($data['libraryList'])) {
                  foreach ($data['libraryList'] as $card) {
                        fwrite($arquivo, "{$card['amount']}\t" . (new LibraryCard())->findById($card['library_card_id'])->name);
                        fwrite($arquivo, "\n");
                  }
            }

            fwrite($arquivo, "Crypt:");
            fwrite($arquivo, "\n");

            if (isset($data['cryptList'])) {
                  foreach ($data['cryptList'] as $card) {
                        fwrite($arquivo, "{$card['amount']}\t" . (new CryptCard())->findById($card['crypt_card_id'])->name);
                        fwrite($arquivo, "\n");
                  }
            }

            $deckTxt = new DeckTxt();
            $deckTxt->user_id = $_SESSION['user_id'];
            $deckTxt->directory = $directory;
            $deckTxt->save();

            if ($deckTxt->fail()) {
                  echo json_encode("Error:" . $deckTxt->fail()->getMessage());
                  return;
            }

            $result = fclose($arquivo);

            if ($result) {
                  echo json_encode(["successCreateTxt" => "txt criado com sucesso"]);
            }
      }

      public function saveWantList(array $data)
      {


            $wantLibraryCards = (new WantListLibrary())->find("user_id = :ui", "ui={$_SESSION['user_id']}")->fetch(true);
            $wantCryptCards = (new WantListCrypt())->find("user_id = :ui", "ui={$_SESSION['user_id']}")->fetch(true);

            if ($wantLibraryCards) {
                  foreach ($wantLibraryCards as $wantLibraryCard) {
                        $wantLibraryCard->destroy();
                  }
            }

            if ($wantCryptCards) {
                  foreach ($wantCryptCards as $wantCryptCard) {
                        $wantCryptCard->destroy();
                  }
            }

            if (isset($data['libraryList'])) {

                  foreach ($data['libraryList'] as $libraryCard) {

                        $newWantListLibrary = new WantListLibrary();

                        $newWantListLibrary->user_id = $_SESSION['user_id'];
                        $newWantListLibrary->amount = filter_var($libraryCard['amount'], FILTER_SANITIZE_NUMBER_INT);
                        $newWantListLibrary->library_card_id = filter_var($libraryCard['library_card_id'], FILTER_SANITIZE_NUMBER_INT);

                        $newWantListLibrary->save();

                        if ($newWantListLibrary->fail()) {
                              echo json_encode("Error:" . $newWantListLibrary->fail()->getMessage());
                              return;
                        }
                  }
            }
            if (isset($data['cryptList'])) {

                  foreach ($data['cryptList'] as $cryptCard) {

                        $newWantListcrypt = new WantListCrypt();

                        $newWantListcrypt->user_id = $_SESSION['user_id'];
                        $newWantListcrypt->amount = filter_var($cryptCard['amount'], FILTER_SANITIZE_NUMBER_INT);
                        $newWantListcrypt->crypt_card_id = filter_var($cryptCard['crypt_card_id'], FILTER_SANITIZE_NUMBER_INT);

                        $newWantListcrypt->save();

                        if ($newWantListcrypt->fail()) {
                              echo json_encode("Error:" . $newWantListcrypt->fail()->getMessage());
                              return;
                        }
                  }
            }
            echo json_encode(["success" => "Want list has been updated!"]);
      }

      public function saveHaveList(array $data)
      {
            $haveLibraryCards = (new HaveListLibrary())->find("user_id = :ui", "ui={$_SESSION['user_id']}")->fetch(true);
            $haveCryptCards = (new HaveListCrypt())->find("user_id = :ui", "ui={$_SESSION['user_id']}")->fetch(true);

            if ($haveLibraryCards) {
                  foreach ($haveLibraryCards as $haveLibraryCard) {
                        $haveLibraryCard->destroy();
                  }
            }

            if ($haveCryptCards) {
                  foreach ($haveCryptCards as $haveCryptCard) {
                        $haveCryptCard->destroy();
                  }
            }

            if (isset($data['libraryList'])) {

                  foreach ($data['libraryList'] as $libraryCard) {

                        $newhaveListLibrary = new HaveListLibrary();

                        $newhaveListLibrary->user_id = $_SESSION['user_id'];
                        $newhaveListLibrary->amount = filter_var($libraryCard['amount'], FILTER_SANITIZE_NUMBER_INT);
                        $newhaveListLibrary->library_card_id = filter_var($libraryCard['library_card_id'], FILTER_SANITIZE_NUMBER_INT);

                        $newhaveListLibrary->save();

                        if ($newhaveListLibrary->fail()) {
                              echo json_encode("Error:" . $newhaveListLibrary->fail()->getMessage());
                              return;
                        }
                  }
            }
            if (isset($data['cryptList'])) {

                  foreach ($data['cryptList'] as $cryptCard) {

                        $newhaveListcrypt = new HaveListCrypt();

                        $newhaveListcrypt->user_id = $_SESSION['user_id'];
                        $newhaveListcrypt->amount = filter_var($cryptCard['amount'], FILTER_SANITIZE_NUMBER_INT);
                        $newhaveListcrypt->crypt_card_id = filter_var($cryptCard['crypt_card_id'], FILTER_SANITIZE_NUMBER_INT);

                        $newhaveListcrypt->save();

                        if ($newhaveListcrypt->fail()) {
                              echo json_encode("Error:" . $newhaveListcrypt->fail()->getMessage());
                              return;
                        }
                  }
            }
            echo json_encode(["success" => "Have list has been updated!"]);
      }
}
