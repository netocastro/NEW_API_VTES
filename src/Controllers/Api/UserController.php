<?php

namespace Source\Controllers\Api;

use Source\Interfaces\Controller;
use Source\Models\User;
use Stonks\DataLayer\Connect;

class UserController implements Controller
{
      /**
       * Retorna todos os usuarios
       */
      public function index(): void
      {
            echo json_encode(objectToArray((new User())->find()->fetch(true)));
      }

      public function store(array $data): void
      {
            $emptyFields = array_keys($data, '');

            if ($emptyFields) {
                  echo json_encode(["emptyFields" => $emptyFields]);
                  return;
            }

            $data = filter_var_array($data, [
                  "name" => FILTER_SANITIZE_STRIPPED,
                  "email" => FILTER_VALIDATE_EMAIL,
                  "password" => FILTER_SANITIZE_STRIPPED,
                  "repeat_password" => FILTER_SANITIZE_STRIPPED
            ]);

            $validateFields = [];

            if (!validateEmail($data['email'])) {
                  $validateFields['email'] = 'Formato de email invalido';
            }

            if ((new User())->find('email = :e', "e={$data['email']}")->fetch()) {
                  $validateFields['email'] = 'Email ja foi cadastrado';
            }

            if ((new User())->find('name = :n', "n={$data['name']}")->fetch()) {
                  $validateFields['name'] = 'Nome ja foi cadastrado';
            }

            if (!validateName($data['name'])) {
                  $validateFields['name'] = 'Formato do nome invalido';
            }

            if ($data['password'] != $data['repeat_password']) {
                  $validateFields['repeat_password'] = "Senhas nao conferem";
            }

            if ($validateFields) {
                  echo json_encode(['validateFields' => $validateFields]);
                  return;
            }

            $user = new User();

            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = password_hash($data['password'], PASSWORD_BCRYPT);

            $user->save();

            if ($user->fail()) {
                  echo json_encode($user->fail()->getMessage());
                  return;
            } else {
                  echo json_encode(['success' => 'Registrado com sucesso']);
            }
      }

      public function show(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $card = (new User())->findById($data['id']);
            if ($card) {
                  echo json_encode(objectToArray($card));
            } else {
                  echo json_encode("id nao registrado");
            }
      }

      public function update(array $data): void
      {
            $emptyFilds = array_keys($data, '');

            if ($emptyFilds) {
                  echo json_encode(["emptyFields" => $emptyFilds]);
                  return;
            }

            $data = filter_var_array($data, [
                  "id" => FILTER_SANITIZE_NUMBER_INT,
                  "name" => FILTER_SANITIZE_STRIPPED,
                  "email" => FILTER_VALIDATE_EMAIL,
                  "password" => FILTER_SANITIZE_STRIPPED,
                  "repeat_password" => FILTER_SANITIZE_STRIPPED
            ]);

            $validateFields = [];

            if (!(new User())->findById($data['id'])) {
                  echo json_encode("usuario não cadastrado");
                  return;
            }

            if (!validateEmail($data['email'])) {
                  $validateFields['email'] = 'Formato de email invalido';
            }

            if ((new User())->find('email = :e', "e={$data['email']}")->fetch()) {
                  $validateFields['email'] = 'Email ja foi cadastrado';
            }

            if ((new User())->find('name = :n', "n={$data['name']}")->fetch()) {
                  $validateFields['name'] = 'Nome ja foi cadastrado';
            }

            if (!validateName($data['name'])) {
                  $validateFields['name'] = 'Formato do nome invalido';
            }

            if ($data['password'] != $data['repeat_password']) {
                  $validateFields['repeat_password'] = "Senhas nao conferem";
            }

            if ($validateFields) {
                  echo json_encode(['validateFields' => $validateFields]);
                  return;
            }

            $user = (new User())->findById($data['id']);

            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = $data['password'];

            $user->change()->save();

            if ($user->fail()) {
                  echo json_encode($user->fail()->getMessage());
                  return;
            } else {
                  echo json_encode("atualizado com sucesso");
            }
      }

      public function partName(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $connect = Connect::getInstance();
            $cards = $connect->query("SELECT * from User WHERE name like '%{$data['name']}%'");
            $result =  $cards->fetchAll();

            if ($result) {
                  echo json_encode($result);
            } else {
                  echo json_encode("Nome errado ou carta nao cadastrada");
            }
      }

      public function showByName(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $card = (new User())->find('name = :name', "name={$data['name']}")->fetch();
            if ($card) {
                  echo json_encode(objectToArray($card));
            } else {
                  echo json_encode("Nome errado ou carta nao cadastrada");
            }
      }

      public function showByEmail(array $data): void
      {

            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            $card = (new User())->find('email = :email', "email={$data['email']}")->fetch();
            if ($card) {
                  echo json_encode(objectToArray($card));
            } else {
                  echo json_encode("Nome errado ou carta nao cadastrada");
            }
      }

      public function destroy(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);
            $user = (new User())->findById($data['id']);

            $user->destroy();

            if ($user->fail()) {
                  echo json_encode($user->fail()->getMessage());
            } else {
                  echo json_encode("Usuario deletado com sucesso");
            }
      }

      public function cardImage(array $data): void
      {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            if (isset((new User())->find('name = :name', "name={$data['name']}")->fetch()->name)) {
                  $formatedCardName = str_replace(["!", "@", "#", "$", "&", ">", "<", "*", "/", "\\", " ", "%", ")", "(", "]", "[", "-", "_", ".", ",", "'", "`", "´"], '', $data['name']);

                  //echo "<img src=' ". IMAGE_PATH . $formatedCardName . ".jpg'>";
                  echo IMAGE_PATH . $formatedCardName . ".jpg";
            } else {
                  echo json_encode("Nome errado ou carta nao cadastrada");
            }
      }

      public function login(array $data): void
      {
            $emptyFields = array_keys($data, '');

            if ($emptyFields) {
                  echo json_encode(["emptyFields" => $emptyFields]);
                  return;
            }

            $data = filter_var_array($data, [
                  "email" => FILTER_VALIDATE_EMAIL,
                  "password" => FILTER_SANITIZE_STRIPPED,
            ]);

            $validateFields = [];

            $user = (new User())->find('email = :email', "email={$data['email']}")->fetch();

            if ($user && $user->password == password_verify($data['password'], $user->password)) {

                  $_SESSION['user_id'] = $user->id;
                  echo json_encode(["success" => "success"]);
                  return;
            } else {
                  $validateFields['password'] = 'Informações inválidas';
            }

            if ($validateFields) {
                  echo json_encode(['validateFields' => $validateFields]);
                  return;
            }
      }

      public function logout(): void
      {
            unset($_SESSION['user_id']);
            $this->route->redirect('web.home');
      }
}
