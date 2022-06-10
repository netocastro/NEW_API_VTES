<?php

namespace Source\Controllers\Site;


use League\Plates\Engine;
use Source\Models\CryptCard;
use Source\Models\CryptList;
use Source\Models\Deck;
use Source\Models\HaveListCrypt;
use Source\Models\HaveListLibrary;
use Source\Models\LibraryCard;
use Source\Models\LibraryList;
use Source\Models\User;
use Source\Models\WantListCrypt;
use Source\Models\WantListLibrary;
use Stonks\Router\Router;

class Web
{
      private Engine $view;

      private Router $route;

      function __construct(Router $route)
      {
            $this->view = Engine::create(dirname(__DIR__, 3) . "/view", 'php');
            $this->route = $route;
            $this->view->addData(['route' => $route]);
            $this->view->addData(['navbarUser' => (isset($_SESSION['user_id']) ? (new User())->findById($_SESSION['user_id']) : '')]);
      }

      public function home(): void
      {
            echo $this->view->render('home', [
                  "title" => "Vtes | Home"
            ]);
      }

      public function error($data): void
      {
            echo $this->view->render('error', [
                  "title" => "Vtes | Error",
                  "error" => $data['error']
            ]);
      }

      public function login(): void
      {
            echo $this->view->render('login', [
                  "title" => "Vtes | Login"
            ]);
      }

      public function register(): void
      {
            echo $this->view->render('register', [
                  "title" => "Vtes | Register"
            ]);
      }

      public function deckEditor(): void
      {
            $cryptCards = (new CryptCard())->find()->fetch(true);
            $libraryCards = (new LibraryCard())->find()->order('name ASC')->fetch(true);

            /*$libraryList = (new LibraryLists)->findById($_SESSION['user_id']);
            $cryptList = (new CryptLists)->findById($_SESSION['user_id']);*/

            $userDecks = (new Deck())->find('user_id = :ui', "ui={$_SESSION['user_id']}")->fetch(true);

            echo $this->view->render('userPanel', [
                  "title" => "Vtes | Panel",
                  "cryptCards" => $cryptCards,
                  "libraryCards" => $libraryCards,
                  "userDecks" => $userDecks
            ]);
      }

      public function userDecksTxt(): void
      {
            echo $this->view->render('meusDecksTxt', [
                  "title" => "Vtes | Meus decks txt"
            ]);
      }

      public function debug(): void
      {
            $testes = (new LibraryList())->find()->fetch(true);
            // $testes = (new CryptList())->find()->fetch(true);
            // $testes = (new Deck())->find()->fetch(true);
            // $testes = (new LibraryCard())->find()->fetch(true);
            // $testes = (new CryptCard())->find()->fetch(true);
            //$testes = (new User())->find()->fetch(true);
            echo $this->view->render('debug', [
                  "title" => "Vtes | Debug",
                  "testes" => $testes
            ]);
      }

      public function logout(): void
      {
            unset($_SESSION['user_id']);
            $this->route->redirect('web.home');
      }

      public function wantLIst($data): void
      {
            $user = (new User())->find('name = :name', "name={$data['name']}")->fetch();

            if (!$user) {
                  $this->route->redirect('web.error', [
                        "error" => "Usuario não cadastrado"
                  ]);
                  return;
            }

            $wantListCrypt = (new WantListCrypt())->find('user_id = :ui', "ui={$user->id}")->order('crypt_card_id asc')->fetch(true);
            $wantListLibrary = (new WantListLibrary())->find('user_id = :ui', "ui={$user->id}")->order('library_card_id asc')->fetch(true);

            $cryptCards = (new CryptCard())->find()->order('name ASC')->fetch(true);

            echo $this->view->render('wantList', [
                  "title" => "Vtes | Want List",
                  "wantListCrypt" => $wantListCrypt,
                  "wantListLibrary" => $wantListLibrary,
                  "name" => $data['name'],
                  "cryptCards" => $cryptCards,
                  "user" => $user
            ]);
      }

      public function haveList($data): void
      {
            $user = (new User())->find('name = :name', "name={$data['name']}")->fetch();

            if (!$user) {
                  $this->route->redirect('web.error', [
                        "error" => "Usuario não cadastrado"
                  ]);
                  return;
            }

            $haveListCrypt = (new HaveListCrypt())->find('user_id = :ui', "ui={$user->id}")->order('crypt_card_id asc')->fetch(true);
            $haveListLibrary = (new HaveListLibrary())->find('user_id = :ui', "ui={$user->id}")->order('library_card_id asc')->fetch(true);
            $cryptCards = (new CryptCard())->find()->order('name ASC')->fetch(true);

            echo $this->view->render('haveList', [
                  "title" => "Vtes | Have List",
                  "haveListCrypt" => $haveListCrypt,
                  "haveListLibrary" => $haveListLibrary,
                  "name" => $data['name'],
                  "cryptCards" => $cryptCards,
                  "user" => $user
            ]);
      }
}
