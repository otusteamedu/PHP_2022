<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTUS_hw4</title>
</head>

<body>
    <?php
    if (!empty($_POST['filter_email'])) {
        $email=$_POST['filter_email'];
        $email_pattern = "/^([a-z0-9+_-]+)(.[a-z0-9+_-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/";
        $domain = substr(strrchr($email, "@"), 1);

        if (!preg_match($email_pattern, $email)) {
            echo "Адрес $email не соответствует шаблону";
        } else {
            if (!checkdnsrr($domain, 'MX')) {
                echo "Не верный домен $domain";
            } else {
                echo "Адрес $email корректный";
            }
        }
    }
    ?>


<hr>
<h3>Проверка входных данных</h3>
<form method="post">
    <label for="filter_string">Укажите название:</label>
    <input type="text" name="filter_email" /><br>
    <input type="submit" value="Проверить">
</form>
<hr>
</body>
</html>