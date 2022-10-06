<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/js/datepicker/css/datepicker.material.css">
    <script src="/js/datepicker/datepicker.js"></script>
    <title>Получение банковской выписки</title>
</head>
<body>

<div class="container col-xl-5 col-xxl-5 px-4 py-5">
    <main class="form-signin w-100 m-auto">
        <h1>Получение выписки</h1>

        <form method="POST">
            <input type="hidden" name="action" value="make">
            <div class="mb-2">
                <label for="exampleInputEmail1" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Укажите email, куда выслать выписку</div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col col-xl-6 col-xxl-6">
                    <input type="text"  name="dateStart" class="datepicker form-control" id="dateStart" aria-describedby="dataStartHelp">
                    <div id="dataStartHelp" class="form-text">Начальная дата</div>
                </div>
                <div class="col col-xl-6 col-xxl-6">
                    <input type="text" name="dateEnd" class="datepicker form-control" id="dateEnd" aria-describedby="dataEndHelp">
                    <div id="dataEndHelp" class="form-text">Конечная дата</div>
                </div>
            </div>
            <hr class="my-4">
            <button type="submit" class="w-100 btn btn-success btn-lg">Запросить</button>
            <hr class="my-4">
            <a href="?action=startConsumers" class="w-100 btn btn-info btn-lg">Запустить еще слушателя</a>
            <hr class="my-4">
            <a href="?action=stopConsumers" class="w-100 btn btn-danger btn-lg">Остановить одного слушателя</a>
        </form>
    </main>
</div>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
-->
<script>
    var datepicker = new Datepicker('.datepicker');
</script>
</body>
</html>

