<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order</title>
</head>
<body>
<form action="/order/create/" method="post">
    <h1>Order</h1>

    <h3>Choose food:</h3>

    <p>
        <label>
            <input type="checkbox" name="food" value="Burger">
            Burger
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" name="food" value="HotDog">
            Hot dog
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" name="food" value="Sandwich">
            Sandwich
        </label>
    </p>

    <h3>Choose additional ingredients:</h3>

    <?php foreach ($result as $elem) { ?>
        <p>
            <label>
                <input type="checkbox" name="ingredients[]" value="<?= $elem->value ?>">
                <?= $elem->value ?>
            </label>
        </p>
    <?php } ?>

    <button type="submit">Submit</button>
</form>
<hr>
</body>
</html>