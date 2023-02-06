<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Запрос банковской выписки</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<div style="margin: 0 auto">
    <form action=/statement/get method="post" enctype="multipart/form-data" style="padding: 50px;">
    <div class="col col-xl-3 col-xxl-3"     style="border: 1px solid #CCC; border-radius: 5px; background-color: #EEE; padding: 50px;">

        <center><h2>Получить выписку за период</h2></center>
        <br />

        <label for="email">Email для получения выписки</label>
        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp"
               placeholder="Enter email" style="width:100%;" value="test@mail.ru"/>


        <div class="row">

            <label for="email" style="margin-top: 30px;">Начало периода</label>
            <input type="text" name="dateFrom" class="datepicker form-control" id="date_start"
                   aria-describedby="dataStartHelp" placeholder="2022-01-01"
                   value="<?= date("Y-m-d", time() - 3600 * 24 * 30) ?>"/>


            <label for="email" style="margin-top: 30px;">Конец периода</label>
            <input type="text" name="dateTill" class="datepicker form-control" id="date_end"
                   aria-describedby="dataEndHelp" placeholder="2022-12-31" value="<?= date("Y-m-d") ?>"/>


        </div>

        <div style="padding-left: 100px; padding-top: 30px;">
            <button type="submit" name="created" value="created" class="btn btn-primary">Получить выписку</button>
        </div>
    </div>

</form>
</div>

</body>
</html>