<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTUS_hw4</title>
</head>

<body>
    <?php
    if (!empty($_POST['filter_string'])) {
        $string = $_POST['filter_string'];
        $counter = 0;
        $openBracket = ['('];
        $closedBracket = [')'];
        $length = strlen($string);
        for($i = 0; $i<$length; $i++) {
            $char = $string[$i];
            if(in_array($char, $openBracket)) {
                $counter ++;
            } elseif (in_array($char, $closedBracket)) {
                $counter --;
            }
        }
        if($counter != 0) {
            echo "Количество скобочек не верно";
        } else {
            echo "Количество скобочек верно";
        }
    } else {
        echo "Строка пустая: {$_POST['filter_string']}";
    }
    ?>

<hr>
<h3>Проверка входных данных</h3>
<form method="post">
    <label for="filter_string">Укажите название:</label>
    <input type="text" name="filter_string" /><br>
    <input type="submit" value="Проверить">
</form>
<hr>
</body>
</html>