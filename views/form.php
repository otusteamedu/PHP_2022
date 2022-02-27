<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1 class="mb-5">Hello, {{name}}</h1>

    <form method="post" action="/form">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Validate brackets</label>
            <input type="text" name="string" class="form-control" value="{{#value}} {{.}} {{/value}}">
        </div>
        <button type="submit" class="btn btn-primary">Validate</button>
    </form>
    <span class="{{#class}} {{.}} {{/class}}">Result: {{result}} </span>
</div>
</body>
</html>
