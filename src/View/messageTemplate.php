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
    <title>Получение банковской выписки</title>
</head>
<body>

<div class="container col-xl-5 col-xxl-5 px-4 py-5">
    <main class="form-signin w-100 m-auto">
        <h1>Получение выписки</h1>

        <?php if (isset($data["errors"]) && count($data["errors"])>0) {?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($data["errors"] as $err){?>
                <p class="error-text"><?=$err?></p>
                <?php }?>
            </div>
        <?php } else {?>
            <div class="alert alert-success" role="alert">
            Успешно
        </div>
        <?php }?>

        <a href="index.php" class="w-100 btn btn-info btn-lg">На главную</a>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>

