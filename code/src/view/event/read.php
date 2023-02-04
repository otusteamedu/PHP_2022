<p>Score: <?=$res["score"]?></p>
<?php foreach ($res["param"] as $param => $value) { ?>
    <p><?=$param?> = <?=$value?></p>
<?php } ?>

<a href="/event/">GO TO EVENT HOME!</a>

<hr>