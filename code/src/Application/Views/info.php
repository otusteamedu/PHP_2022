<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Запросить выписку</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <form action=/Send/startSend method="post" enctype="multipart/form-data">
        <div class="col col-xl-3 col-xxl-3">
            <label for="email">Email</label>
            <input type="email" name="email"  class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="email" class="form-text text-muted">Укажите на какой email выслать</small>
            <div class="row">
                <input type="text"  name="date_start" class="datepicker form-control" id="date_start" aria-describedby="dataStartHelp" placeholder="2022-01-01">
                <div id="data_start" class="form-text">Начальная дата</div>
                <input type="text" name="date_end" class="datepicker form-control" id="date_end" aria-describedby="dataEndHelp"placeholder="2022-12-31">
                <div id="data_end" class="form-text">Конечная дата</div>
            </div>
        </div>
        <button type="submit" name="created" value="created" class="btn btn-primary">Отправить запрос</button>
    </form>
</body>
</html>
