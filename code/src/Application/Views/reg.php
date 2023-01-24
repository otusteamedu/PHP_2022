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
<body class="big-banner">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index/index">
                <img src="/Assets/img/favicon.ico" alt="HiRusSportsmen-logo" width="30" height="24" class="d-inline-block align-text-top">
                HiRusSportsmen
            </a>
        </div>
    </nav>


    <div class="services">
        <div class="container">
            <h3><?php echo $result; ?></h3>
            <?php if(isset($_SESSION['is_auth']) && $_SESSION['is_auth']): ?>
                <h3><a href='/raceviewer/allRaces'>Можешь посмотреть гонки!</a></h3>
            <?php else: ?>
                <h3>Не авторизованный доступ</h3>
            <?php endif; ?>

            <form action="/userauth/logoutUser"  method="post" enctype="multipart/form-data">
                <button type="submit" name="logout" value="logout" class="btn btn-secondary">Выйти</button>
            </form>
        </div>
    </div>

</body>
</html>
