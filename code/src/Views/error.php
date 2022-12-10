<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?php echo $title; ?></title>
    <style>
        body {text-align: center;}
        h1 {margin-top: 20%;}
    </style>
</head>
<body>
    <div class="position-absolute top-50 start-50 translate-middle">
        <h3><?php echo $error_code; ?></h3>
        <p><?php echo $result; ?></p>
    </div>
</body>
</html>
