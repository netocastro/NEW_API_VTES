<?php $v->layout('_template'); ?>



<div class="container">
    <h1 class="my-3">Sua lista de decks:</h1>
    <?php

    $path = "cdn/media/files/decks/{$_SESSION['user_id']}";

    if (is_dir($path)) {
        $diretorio = dir($path);
        while ($arquivo = $diretorio->read()) {
            if ($arquivo != "." && $arquivo != "..") {
                echo "<a id='{$arquivo}' download href='" . $path . "/" . $arquivo . "'>" . $arquivo . "</a><br />";
            }
        }
        $diretorio->close();
    } else {
        echo "você ainda não possui decks salvos";
    }

    ?>

</div>
