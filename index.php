<?php

use Queen\App\Validator;

require './vendor/autoload.php';
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>STRING VALIDATOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
        echo 'Session: ' . session_id() . ', ' . sprintf("Container ID: %s", $_SERVER['HOSTNAME']);
    ?>
    <form class="mt-5" action="index.php" method="post">
        <label for="inputPassword5" class="form-label">Enter a string containing brackets</label>
        <input type="text" name="string" class="form-control">
        <button class="btn btn-success mt-2" type="submit">Brackets validate</button>
    </form>
    <?php echo Validator::actionValidate('string'); ?>
</div>
</body>
</html>

