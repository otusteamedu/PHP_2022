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



    <div class="container">
        <h2>Проверка строки HW4</h2>
        <form action=/stringCheck/filterString method="post">
            <label for="filter_string">Введите строку:</label>
            <input type="text" name="filter_string" /><br>
            <input type="submit" value="Проверить">
            <p>Данные для проверки были:<?php echo $mystring; ?></p>
            <p>Результат: <?php echo $result_string; ?></p>
        </form>
    </div>
<hr>
    <div class="container">
        <h2>Проверка адреса email HW5</h2>
        <form action=/stringCheck/checkEmail method="post">
            <label for="check_email">Укажите email:</label>
            <input type="text" name="check_email" /><br>
            <input type="submit" value="Проверить">
            <p>Проверяли email: <?php echo $email; ?></p>
            <p>Результат: <?php echo $result_email; ?></p>
        </form>
    </div>

</body>
</html>
