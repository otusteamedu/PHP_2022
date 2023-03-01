<?php if (isset($result)) { ?>
    <h3>Order №<?= $result["orderId"] ?></h3>

    <p><b>Food:</b> <?= $result["foodName"] ?></p>

    <h4>Recipe:</h4>
    <ul>
        <?php foreach ($result["recipe"] as $item) { ?>
            <li><?= $item ?></li>
        <?php } ?>
    </ul>
<?php } ?>