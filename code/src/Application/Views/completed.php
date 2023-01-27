<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= $title; ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>

<form action="/" method="get" style="padding: 50px;">
    <div class="col col-xl-3 col-xxl-3" style="border: 1px solid #CCC; border-radius: 5px; background-color: #EEE; padding: 50px;">
        <h2>Cостояние заявки</h2>

        <p><b>Результат:</b> <?= $result; ?></p>

        <div style="padding-left: 100px; padding-top: 30px;">
            <button type="submit" name="created" value="created" class="btn btn-primary">Вернуться назад</button>
        </div>
    </div>
</form>

</body>
</html>
