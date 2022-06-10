<?php

namespace Source\Controllers\Api;

use Source\Interfaces\Controller;
use Source\Models\LibraryCard;
use Stonks\DataLayer\Connect;

class LibraryController implements Controller
{
      /**
       * Retorna todas as cartas da livraria
       */
      public function index(): void
      {
            echo json_encode(objectToArray((new LibraryCard())->find()->fetch(true)));
      }

      /**
       * Insere uma carta de livraria
       */
      public function store(array $data): void
      {
      }

      /**
       * Exibe uma carta de livraria
       */
      public function show(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $card = (new LibraryCard())->findById($data['id']);
            $card = objectToArray($card);
            $card[0]['image'] = "ss";
            if ($card) {
                  echo json_encode($card);
            } else {
                  echo json_encode("id nao registrado");
            }
      }

      /**
       * Atualiza uma carta de livraria
       */
      public function update(array $data): void
      {
      }

      /**
       * Exibeo resultado de uma consulta de uma carta de
       * livraria por uma parte do nome
       */
      public function partName(array $data): void
      {
            //$data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $connect = Connect::getInstance();
            $cards = $connect->query("SELECT * from vteslib WHERE name like '%{$data['name']}%'");
            $result = $cards->fetchAll();

            if ($result) {
                  echo json_encode($result);
            } else {
                  echo json_encode("Nome errado ou carta nao cadastrada");
            }
      }

      /**
       * Exibe uma carta de livraria pelo nome
       */
      public function showByName(array $data): void
      {
            //$data = filter_var_array($data, FILTER_SANITIZE_STRING); // verificar os filtros do datalayer pra saber se ele bloqueia sql injection
            $card = (new LibraryCard())->find('name = :name', "name={$data['name']}")->fetch();
            if ($card) {
                  echo json_encode(objectToArray($card));
            } else {
                  echo json_encode("Nome errado ou carta nao cadastrada");
            }
      }

      /**
       * Destroi uma carta da livraria
       */
      public function destroy(array $data): void
      {
      }

      /**
       * retorna url da imagem de uma carta da livraria
       */
      public function cardImage(array $data): void
      {
            if (isset((new LibraryCard())->find('name = :name', "name={$data['name']}")->fetch()->name)) {
                  $formatedCardName = str_replace(["!", "@", "#", "$", "&", ">", "<", "*", "/", "\\", " ", ",", "\'", "/'", "'", "`", "´", "%", ")", "(", "-", "_", "."], '', $data['name']);
                  $formatedCardName = preg_replace('/(\')/', '', $formatedCardName);
                  //echo "<img src=' ". IMAGE_PATH . $formatedCardName . ".jpg'>";
                  echo json_encode(IMAGE_PATH . $formatedCardName . ".jpg");
            } else {
                  echo json_encode("Nome errado ou carta nao cadastrada");
            }
      }

      /**
       * Busca url de todas as cartas da livraria
       */
      public function selectLibraryForList()
      {
            $libraryCards = (new LibraryCard())->find()->fetch(true);

            foreach ($libraryCards as $key => $libraryCard) {
                  $libraryCard->cardUrl = $libraryCard->cardName();
            }
            
            echo json_encode(objectToArray($libraryCards));
      }
}
