<!doctype html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Projeto CSS -->
  <link href="<?= url('view/css/style.css') ?>" rel="stylesheet">

  <!-- Fontawesome CSS CDN -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

  <!-- Favico -->
  <link rel="shortcut icon" href="<?= url('cdn/media/images/clans/lasombra.svg') ?>" type="image/x-icon" />

  <!-- Titulo da pagina -->
  <title><?= $title ?></title>
</head>

<body>

  <?php if (isset($_SESSION['user_id'])) : ?>

    <?= $v->insert('fragments/navbar-logado'); ?>

  <?php else : ?>

    <?= $v->insert('fragments/navbar'); ?>
    
  <?php endif; ?>

  <?= $v->section('content'); ?>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->

  <!-- Jquery JS -->
  <script src="<?= url('cdn/libs/jquery/jquery-3.5.1.js'); ?>"></script>

  <!-- Jquery JS -->

  <!--<script src="<?= url('cdn/js/modernizr.js'); ?>"></script> -->

  <!-- Bootstrap JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  
  <!-- Fontawesome JS CDN -->
  <script src="https://kit.fontawesome.com/741a398699.js" crossorigin="anonymous"></script>

  <!-- Funçoes globais para JS -->
  <script src="<?= url('cdn/js/functions.js'); ?>"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

  <?= $v->section('js'); ?>
</body>

</html>