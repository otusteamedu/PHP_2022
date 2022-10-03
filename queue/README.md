# Домашнее задание на тему Очереди

## Описание
Проект - система docker контейнеров. Фреймворк - Lumen.
Запуск: docker-compose up (--build)

Вывод информации о выполняемых задачах или ошибках происходит в выходной поток контейнера consumer.
После запуска контейнеров все должно работать.

## Проверка задания
Доступен api метод 
POST: http://127.0.0.1:6080/api/v1/bank-statement-for-client/get
Тело запроса:
{
    "transferChannel": "email"||"telegram"
}
Пример успешного ответа:
{
	"success": true,
	"message": null,
	"payload": {
		"requestId": "01GECXWMNYZCHD2CXPB8CWTXN5" // id запроса в формате ulid
	}
}

Предполагается что пользователь в системе авторизован и объект User для текущей сесси будет найден на этапе обработки запроса, поэтому передавать userId или иной идентификатор не требуется.

## Описание схемы решения
Указанный маршрут обрабатывает запрос на формирование банковской выписки.
Контроллер в очередь добавляет GetBankStatementJob и сразу возвращает ответ. Эта задача выполняет GetBankStatementRequestAction, который посредством ClientBankStatementGateway отправляет запрос к условному api контрагента и при успешном получении получении ответа добавляет в очередь задачу на отправку оповещания с текстом ответа от банка, канал передачи зависит от параметра transferChannel(telegram, email). Адрес получателя (chat_id для telegram и электронная почта для email) получается из объекта User.

В качестве api контрагента использован фан апи по вселенной звездных войн swapi.dev

При успешной отработке в потоке вывода будет выведено сообщение вида:
otus_queue__queue-consumer    | Отправляем по email[login@domain.com]:
otus_queue__queue-consumer    | {"id":"1","data":{"name":"Luke Skywalker","height":"172","mass":"77","hair_color":"blond","skin_color":"fair","eye_color":"blue","birth_year":"19BBY","gender":"male","homeworld":"https:\/\/swapi.dev\/api\/planets\/1\/","films":["https:\/\/swapi.dev\/api\/films\/1\/","https:\/\/swapi.dev\/api\/films\/2\/","https:\/\/swapi.dev\/api\/films\/3\/","https:\/\/swapi.dev\/api\/films\/6\/"],"species":[],"vehicles":["https:\/\/swapi.dev\/api\/vehicles\/14\/","https:\/\/swapi.dev\/api\/vehicles\/30\/"],"starships":["https:\/\/swapi.dev\/api\/starships\/12\/","https:\/\/swapi.dev\/api\/starships\/22\/"],"created":"2014-12-09T13:50:51.644000Z","edited":"2014-12-20T21:17:56.891000Z","url":"https:\/\/swapi.dev\/api\/people\/1\/"}}


По id запроса можно отследить статус обработки запроса а также получить данные, полученные в результате:
POST: http://127.0.0.1:6080/api/v1/request-data/check
тело запроса:
{
	"requestId": "01GECXWMNYZCHD2CXPB8CWTXN5"
}

Если запрос обрабатывается:
{
	"success": true,
	"message": null,
	"payload": {
		"status": "processing",
		"data": null
	}
}

Если запрос обработан:
{
	"success": true,
	"message": null,
	"payload": {
		"status": "ready",
		"data": "{\"id\":\"1\",\"data\":{\"name\":\"Luke Skywalker\",\"height\":\"172\",\"mass\":\"77\",\"hair_color\":\"blond\",\"skin_color\":\"fair\",\"eye_color\":\"blue\",\"birth_year\":\"19BBY\",\"gender\":\"male\",\"homeworld\":\"https:\\\/\\\/swapi.dev\\\/api\\\/planets\\\/1\\\/\",\"films\":[\"https:\\\/\\\/swapi.dev\\\/api\\\/films\\\/1\\\/\",\"https:\\\/\\\/swapi.dev\\\/api\\\/films\\\/2\\\/\",\"https:\\\/\\\/swapi.dev\\\/api\\\/films\\\/3\\\/\",\"https:\\\/\\\/swapi.dev\\\/api\\\/films\\\/6\\\/\"],\"species\":[],\"vehicles\":[\"https:\\\/\\\/swapi.dev\\\/api\\\/vehicles\\\/14\\\/\",\"https:\\\/\\\/swapi.dev\\\/api\\\/vehicles\\\/30\\\/\"],\"starships\":[\"https:\\\/\\\/swapi.dev\\\/api\\\/starships\\\/12\\\/\",\"https:\\\/\\\/swapi.dev\\\/api\\\/starships\\\/22\\\/\"],\"created\":\"2014-12-09T13:50:51.644000Z\",\"edited\":\"2014-12-20T21:17:56.891000Z\",\"url\":\"https:\\\/\\\/swapi.dev\\\/api\\\/people\\\/1\\\/\"}}"
	}
}
