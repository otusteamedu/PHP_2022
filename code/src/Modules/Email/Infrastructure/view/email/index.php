<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Work 5 - Email</title>
</head>
<body>
<form action="/email/check/" method="post">
    <h3>Enter e-mail list:</h3>
    <p><textarea name="email" id="email" cols="30" rows="10"><?= $_POST["email"] ?></textarea></p>
    <p><i>Each e-mail on a new line</i></p>
    <button type="submit">Check</button>
</form>
</body>
</html>