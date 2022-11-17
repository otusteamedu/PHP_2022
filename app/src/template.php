<html lang="ru">
<head>
    <title>Валидатор Email</title>

    <style>
        .error {
            color: darkred;
        }
        .ok {
            color: darkgreen;
        }
    </style>
</head>
<body>
<main>
    <?php
    if (!empty($response['errors'])) {
        foreach ($response['errors'] as $error) {
            echo "<div class='error'>{$error}</div>";
        }
    }
    if (empty($response['errors']) && $response['emails']) {
        echo '<div class="ok">Все email адреса корректны.</div>';
    } ?>
    <form method="post" action="">
        <div>
            <p>Введите список email</p>
            <label>
                <textarea rows="10" cols="37" name="emails"><?= implode("\n", $response['emails']) ?></textarea>
            </label>
        </div>
        <div>
            <button type="submit">Проверить</button>
        </div>
    </form>
</main>
</body>
</html>
