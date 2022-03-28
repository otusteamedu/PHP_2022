<br>
<div class="alert alert-<?=$obValidator->getStatus()?>" role="alert">
    <?=$obValidator->getTextStatus()?>
</div>
<br>
<br>
<br>
<h2>Сервер ответа</h2>
<br>
<div>
    Дата: <?= $obData->getDate();?><br>
    Сервер: <?= $obData->getHostName();?><br>
    ID сессии: <?= $obData->getSessionId();?><br>
</div>