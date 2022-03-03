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
    <h1 class="mb-5">Email List</h1>
    <span class="badge bg-danger">{{error}}</span>

    <table class="table">
        <thead style="position: sticky; top: 0; background-color: white" class="thead-dark">
        <tr>
            <th class="header" scope="col">#</th>
            <th class="header" scope="col">Email</th>
            <th class="header" scope="col">Verify</th>
        </tr>
        </thead>
        <tbody>
            {{#emails}}
            <tr>
                <td>{{index}}</td>
                <td>{{email}}</td>
                <td> <span class="{{#class}} {{.}} {{/class}}">{{check}}</span></td>
            </tr>
            {{/emails}}
        </tbody>
    </table>
</div>
</body>
</html>
