<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Форма заказа</title>
</head>
<body>

<h1>Форма заказа фастфуда</h1>

<form action="processing.php" method="GET" name="order_form">

    <h3>Выберите товар</h3>
    <select name="product_id" id="">
        <option value="1">Бургер</option>
        <option value="2">Сэндвич</option>
        <option value="3">Хот-дог</option>
    </select>

    <h3>Дополнительные ингридиенты</h3>
    <input id="beef_label" type="checkbox" name="composition[]" value="beef">
    <label for="beef_label">Говядина</label><br>
    <input checked id="bun_label" type="checkbox" name="composition[]" value="bun">
    <label for="bun_label">Булочка</label><br>
    <input id="onion_label" type="checkbox" name="composition[]" value="onion">
    <label for="onion_label">Лук</label><br>
    <input id="pork_label" type="checkbox" name="composition[]" value="pork">
    <label for="pork_label">Свинина</label><br>
    <input id="sausage_label" type="checkbox" name="composition[]" value="sausage">
    <label for="sausage_label">Сосика</label><br>

    <h3>Соусы</h3>
    <input id="mayonnaise_label" type="checkbox" name="composition[]" value="mayonnaise">
    <label for="mayonnaise_label">Майонез</label><br>
    <input id="ketchup_label" type="checkbox" name="composition[]" value="ketchup">
    <label for="ketchup_label">Кетчуп</label><br>

    <br>
    <input type="submit" name="order_btn" value="Заказать">
</form>

</body>
</html>