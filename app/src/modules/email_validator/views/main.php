<div class="container">
    <h1 class="mt-5">Проверка адреса электронной почты</h1>
    <p class="lead">Введите email для проверки корректности: например "vasya@pupkin.com"</p>
    <p>Email проверяется на корректность строки и наличие записей MX DNS хоста</p>
    <div class="input-group mb-3">
        <input type="text" id="str-input" class="form-control" placeholder="Введите строку email" aria-label="email@mail.ru" aria-describedby="btn-check">
        <button class="btn btn-outline-primary" type="button" id="btn-check" onclick="check()">Проверить</button>
    </div>
    <div class="card" id="check-result" hidden="">
        <div class="card-body">
            <h5 class="card-title" id="check-result-title"></h5>
            <p class="card-text" id="check-result-text"></p>
        </div>
    </div>
</div>