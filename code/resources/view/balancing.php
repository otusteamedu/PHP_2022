<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home work #5 - OTUS</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light" cz-shortcut-listen="true">
<div class="container">
    <main class="mt-4">
        <div class="row g-5">
            <div class="col-md-12">
                <div>OTUS - Home work #5</div>
                <div><?= date('H:i:s d-m-Y') ?></div>
                <div>Запрос обработки контейнера: <?= $server ?? '' ?></div>
                <div>Счетчик кеша: <?= $counter ?? 0 ?></div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
