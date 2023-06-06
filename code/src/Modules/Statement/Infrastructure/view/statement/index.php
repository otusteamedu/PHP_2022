<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Банковская выписка</title>
</head>
<body>
<form action="/statement/generate/" method="post" style="display: flex; flex-direction: column; align-items: center;">
    <h1>Банковская выписка</h1>

    <h3>Заполните форму для получения банковской выписки!</h3>

    <p>
        <label>
            Имя:<br>
            <input type="text" name="name" placeholder="Никита" value="Никита" style="margin-top:5px">
        </label>
    </p>

    <p>
        <label>
            Дата(от):<br>
            <input type="text" name="dateFrom" placeholder="01.01.2001" value="01.01.2001" style="margin-top:5px">
        </label>
    </p>

    <p>
        <label>
            Дата(до):<br>
            <input type="text" name="dateTo" placeholder="01.01.2002" value="01.01.2002" style="margin-top:5px">
        </label>
    </p>

    <button type="submit">Отправить</button>
</form>
<hr>
</body>
</html>