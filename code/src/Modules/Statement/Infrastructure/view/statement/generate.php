<?php if (isset($result)) { ?>
    <div style="display: flex; flex-direction: column; align-items: center;">
        <p>Банковская выписку за дату <b><?= $result["dateFrom"] . " - " . $result["dateTo"] ?></b> успешно отправлена на генерацию!</p>
        <p>Проверьте <a href="<?=$_ENV["TELEGRAM_INVITE_LINK"]?>" target="_blank">Telegram!</a></p>
    </div>
<?php } ?>