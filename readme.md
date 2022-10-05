# Учебное приложение по теме "Очереди. Часть 2"

Приложение, используя брокер сообщений RabbitMQ, эмулирует формирование банковской выписки за указнный период времени и отсылает результат на указанный пользователем email. Фактически идет отсылка пустого письма с указанием дат, которые выбрал пользователь.

Для функционирования отсылки писем нужно в файле /src/config.ini в секции [smtp] указать реальные параметры сервера.

    [rabbit-mq]
    host = rabbit-mq
    port = 5672
    user = user
    password = password
    
    [queue]
    queue = BankReport
    routing_key = BankReport
    number-of-consumers = 10
    
    [smtp]
    host = smtp.mail.ru
    port = 25
    user = testsender@ail.ru
    password = ******
    sender = testsender@ail.ru

## Запуск приложения

1) Запустить docker контейнеры 
2) Установить зависимости composer
3) Открыть стартовую страницу приложения (в моем окружении это 127.0.0.1, так как docker работает на отдельной вируталке под Windows 7)

Стартова страница выглядит следующим образом:

![img.png](img.png)

Для управления слушателями внизу имеются две кнопку. Перед формированием выписки нужно запустить хотя бы одного консьюмера. Далее переходим к формированию выписки:

![img_1.png](img_1.png)

и получаем на email письмо с "выпиской":

![img_2.png](img_2.png)
