<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Work 4 - Check</title>
</head>
<body>
<form action="/string/check/" method="POST">
    <h2>Enter string</h2>
    <p><input type="text" name="string" id="string" value="<?= $_POST["string"] ?>"></p>

    <button type="submit">Check</button>
</form>
</body>
</html>
