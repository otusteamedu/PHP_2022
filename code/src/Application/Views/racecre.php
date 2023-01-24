<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?php echo $title; ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Assets/bootstrap/css/bootstrap.min.css" >
    <script defer src="/Assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/Assets/css/style.css">
    <link rel="shortcut icon" href="/Assets/img/favicon.ico" type="image/x-icon">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/raceviewer/allRaces">
                <img src="/Assets/img/favicon.ico" alt="HiRusSportsmen-logo" width="30" height="24" class="d-inline-block align-text-top">
                HiRusSportsmen
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="/raceviewer/allRaces">Главная</a>
                <a class="nav-link active" href='/racetypeviewer/viewAllRacetypes'>Категории гонок</a>
                <a class="nav-link active" href='/Raceviewer/personalRaces'>Мои гонки</a>
                <a class="nav-link disabled" href='/raceViewer/createRace'>Добавление новой гонки</a>
            </div>
            <form class="d-flex" action="/userauth/logoutUser" method="post" enctype="multipart/form-data">
                <button type="submit" class="btn btn-outline-success" name="logout"  value="logout">Выход</button>
            </form>
            </div>
        </div>
    </nav>


<?php if(isset($_SESSION['is_auth']) && $_SESSION['is_auth']): ?>


        <div class="container">
            <h3>Создать новую гонку</h3>
            <form action=/RaceRepo/createdRace method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="race_name" class="form-label">Название гонки:</label>
                    <input type="text" name="race_name" class="form-control">
                </div>

                <div class="input-group mb-3">
                    <label for="race_logo" class="input-group-text">Баннер</label>
                    <input type="file" name="race_logo" class="form-control">
                </div>

                <div class="input-group">
                    <span class="input-group-text" for="race_description">Описание гонки:</span>
                    <textarea class="form-control" name="race_description" aria-label="With textarea"></textarea>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Дата старта:</label>
                    <input type="date" name="race_date_start" class="form-control" placeholder="Дата" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Дата финиша:</label>
                    <input type="date" name="race_date_finish" class="form-control" placeholder="Дата" required>
                </div>
                
                <div class="mb-3">
                    <label for="race_venue" class="form-label">Место проведения:</label>
                    <input type="text" name="race_place" class="form-control">
                </div>

                <div class="input-group mb-3">
                    <label class="input-group-text" for="race_type_id">ID категории гонки:</label>
                    <select name="race_type_id" class="form-select" >
                        <option selected>Выберите...</option>
                        <option value="1">1 XCO</option>
                        <option value="2">2 Станок</option>
                        <option value="3">3 Шоссе</option>
                        <option value="3">4 Бег</option>
                    </select>
                </div>
                <button type="submit" name="created" value="created" class="btn btn-primary">Создать</button>
            </form>
        </div>


<?php else: ?>
<h3>Не авторизованный доступ</h3>
<?php endif; ?>


</body>
</html>
