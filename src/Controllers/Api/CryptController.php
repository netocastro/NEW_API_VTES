<?php

namespace Source\Controllers\Api;

use Source\Interfaces\Controller;
use Source\Models\CryptCard;
use Stonks\DataLayer\Connect;

class CryptController implements Controller
{
      /**
       * Retorna todas as cartas da cripta
       */
      public function index(): void
      {
            echo json_encode(objectToArray((new CryptCard())->find()->fetch(true)));
      }

      /**
       * Insere uma nova carta de cripta
       */
      public function store(array $data): void
      {
      }

      /**
       * Exibe uma carta de cripta atravez do id
       */
      public function show(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $card = (new CryptCard())->findById($data['id']);
            /**
             * depois de consultar a carta, verificar se exite, se existir adicionar a url da imagem
             * ainda como objeto e na hora do retorno transformar em array e json 
             */
            // $card = objectToArray($card);  IMAGE_PATH . $formatedCardName . ".jpg"
            // $card[0]['image'] = "sdfsdff"; // falta colocar o uri das imagens, precisa de um foreach pra isso e um frinto pra o nome da carta
            if ($card) {
                  echo json_encode(objectToArray($card));
            } else {
                  echo json_encode("id nao registrado");
            }
      }

      /**
       * Atualiza uma carta de cripta
       */
      public function update(array $data): void
      {
      }

      /**
       * Exibe uma carta especifica atraves do nome
       */
      public function showByName(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);
            $card = (new CryptCard())->find('name = :name', "name={$data['name']}")->fetch();
            if ($card) {
                  echo json_encode(objectToArray($card));
            } else {
                  echo json_encode("Nome errado ou carta nao cadastrada");
            }
      }

      /**
       * Atravez das parte de um nome retorna as cartas que possuem
       * uma parte desse nome;
       */
      public function partName(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $connect = Connect::getInstance();
            $cards = $connect->query("SELECT * from vtescrypt WHERE name like '%{$data['name']}%'");
            $result =  $cards->fetchAll();

            if ($result) {
                  echo json_encode($result);
            } else {
                  echo json_encode("Nome errado ou carta nao cadastrada");
            }
      }

      /**
       * Retorna o url formatada de uma carta
       */
      public function cardImage(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            if (isset((new CryptCard())->find('name = :name', "name={$data['name']}")->fetch()->name)) {
                  $formatedCardName = str_replace(["!", "@", "#", "$", "&", ">", "<", "*", "/", "\\", " ", "%", ")", "(", "]", "[", "-", "_", ".", ",", "'", "`", "´"], '', $data['name']);

                  echo IMAGE_PATH . $formatedCardName . ".jpg";
            } else {
                  echo json_encode("Nome errado ou carta nao cadastrada");
            }
      }

      /**
       * destroi uma carta da cripta
       */
      public function destroy(array $data): void
      {
      }

      /**
       * Busca url de todas as cartas de cripta
       */
      public function selectCryptForList()
      {
            $cryptCards = (new CryptCard())->find()->fetch(true);

            foreach ($cryptCards as $key => $cryptCard) {
                  $cryptCard->cardUrl = $cryptCard->cardName();
            }

            echo json_encode(objectToArray($cryptCards));
      }
}
