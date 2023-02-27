<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Hw16</title>
</head>
<style>
    .ok {
        color: darkgreen;
    }
</style>

<body>
<div>Привет. Это домашняя работа по Очередям из курса PHP 2022 Professional</div>

<?php if ($response) {
    echo '<div class="ok">' . $response['message'] . '</div>';
} ?>

<form method="post" action="">

    <div>
        <div>
            <label>Выберете дату
                <input name="date" type="date" required/>
            </label>
        </div>
        <div>
            <label>Укажите email
                <input name="email" type="email" required/>
            </label>
        </div>
        <div>
            <button type="submit">Сгенерировать выписку</button>
        </div>
    </div>
</form>
</body>
</html>