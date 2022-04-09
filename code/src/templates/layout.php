<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Валидатор скобочек</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Валидатор скобочек приветствует Вас!</h1>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <h2>Ввод данных</h2>
                <br>
                <form action="" name="brackets_form" method="post">
                    <div class="mb-3">
                        <label for="stringInput" class="form-label">Введите скобочки</label>
                        <input type="text" class="form-control" id="stringInput" name="string">
                        <div id="string" class="form-text">Введите комбинацию скобочек, которую хотите проверить</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Проверить</button>
                </form>
                <br>
                <h2>Сервер запроса</h2>
                <br>
                <div class="server-data">
                    <div>Дата: <span class="date"><?= $obData->getDate();?></span></div>
                    <div>Сервер: <span class="host-name"><?= $obData->getHostName();?></span></div>
                    <div>ID сессии: <span class="session-id"><?= $obData->getSessionId();?></span></div>
                </div>
            </div>
            <div class="col-4 offset-2">
                <h2>Результат</h2>
                <br>
                <div id="result">
                    <div class="response">
                        <br>
                        <div class="validate-info alert alert-info"  role="alert">- нет данных -</div>
                        <br>
                        <br>
                        <br>
                        <h2>Сервер ответа</h2>
                        <br>
                        <div class="server-data">
                            <div>Дата: <span class="date">- нет данных -</span></div>
                            <div>Сервер: <span class="host-name">- нет данных -</span></div>
                            <div>ID сессии: <span class="session-id">- нет данных -</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/src/resources/js/script.js"></script>
</body>
</html>