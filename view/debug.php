<?php $v->layout('_template'); ?>

<h1>debug</h1>

<?php var_dump($testes); ?>

<form action="<?= $route->route('request.debug') ?>" data-type="JSON" method="POST">
    <input type="text" name="name" id="name">
    <button type="submit">enviar</button>
</form>