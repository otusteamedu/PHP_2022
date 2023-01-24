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
            <a class="navbar-brand" href="/index/index">
                <img src="/Assets/img/favicon.ico" alt="HiRusSportsmen-logo" width="30" height="24" class="d-inline-block align-text-top">
                HiRusSportsmen
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="/raceViewer/allRaces">Главная</a>
                    <a class="nav-link active" href='/raceTypeViewer/viewAllRaceTypes'>Категории гонок</a>
                    <a class="nav-link active" href='/raceViewer/personalRaces'>Мои гонки</a>
                    <?php if(!empty($_SESSION['is_admin']) && $_SESSION['is_admin'])
                    {
                        echo "<a class='nav-link active' href='/raceViewer/createRace'>Добавление новой гонки</a>";
                    } ?>
                </div>
                <form class="d-flex" action="/userauth/logoutUser" method="post" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-outline-success" name="logout"  value="logout">Выход</button>
                </form>
            </div>
        </div>
    </nav>


    <div class="position-absolute top-50 start-50 translate-middle">
        <h3><?php echo $error_code; ?></h3>
        <p><?php echo $result; ?></p>
    </div>

</body>
</html>
