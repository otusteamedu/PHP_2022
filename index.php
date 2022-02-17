<?php

use Queen\KinopoiskPackage\KinopoiskFilms;

require __DIR__ . ('/vendor/autoload.php');
$config = include('config.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Королева Юлия</title>

    <style>
        .film-container {
            display: flex;
            flex-wrap: wrap;
            column-gap: 10px;
            row-gap: 10px;
        }
        .card {
            width: 250px;
        }
        span {
            font-weight: 700;
            color: green;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">PHP PROF 2022</a>
</nav>
<div class="container text-center">
    <h1>Курс PHP Professional</h1>
    <h2>Студент: Королева Юлия</h2>
</div>
<div class="container film-container">
    <?php $filmApi = new KinopoiskFilms($config['api_key']);
    $top = $filmApi->getTop(KinopoiskFilms::TOP_250_BEST_FILMS, 1, true); ?>
    <?php foreach ($top['films'] as $item) { ?>
        <div class="card">
            <img src="<?php echo $item['posterUrlPreview']; ?>" class="img-fluid" alt="...">

            <div class="card-body">
                <h5 class="card-title"><?php echo $item['nameRu']; ?></h5>
                <p class="card-text"><?php echo $item['year']; ?> год,  <span>рейтинг <?php echo $item['rating']; ?></span></p>
                <a href="#" class="btn btn-primary">Смотреть</a>
            </div>
        </div>
    <?php } ?>
</div>
</body>
</html>
