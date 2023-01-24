# README #

### Что это? ###

* Чат-бот для Telegram, написанный на языке PHP.
* Версия: 2.0 (доработанная после прохождения **[курса Отуса](https://fas.st/wRyRs)**, с использованием БД)

### Документация ###
* [Описание начала разработки по шагам, с нуля](http://nujensait.ru/10776/) 
* [Доработка чат-бота для телеграм (mishaikon_bot): отображение фотографий из архива](http://nujensait.ru/10777/)
* [Пишем/запускаем своего чат-бота для Телеграм](http://nujensait.ru/10776/)
* [Статья на Хабре: "Пишем простого чат-бота для Telegram на PHP"](https://habr.com/ru/company/netologyru/blog/326174/) (начинал с нее)

### Установка ###
```
# clone project
git clone https://github.com/<repository_path>.git
git checkout main

# setup libs
composer update

# run migrations
php vendor/bin/phinx migrate

# enable config
cd config
mv mishaikon_bot.ini.example mishaikon_bot.ini
# <register bot in telegram via @BotFather bot: get token, paste in config below>
# <make release chgs in mishaikon_bot.ini>

# set webhook (for telegram), call from browser:
https://<your_domain>/<bot_path>/index.php?action=webhook

# start use bot in telegram
```

### Как пользоваться ботом? ###

* Открыть приложение Telegram (на компьютере ли смартфоне)
* В окне поиска найдите: [mishaikon_bot](http://t.me/mishaikon_bot)
* Введите команду «/start», нажмите Enter
* Выберите нужную команду из предложенных

### История разработки ###
* [Worklog (публичный)](/media/worklog.html)
* [Dev-wiki (заркытый доступ)](https://mishaikon.atlassian.net/wiki/spaces/WIKI/pages/225443841/)

### Вопросы? Замечания? ###
* Автор: Иконников Михаил [<mishaikon@gmail.com>](mailto:mishaikon@gmail.com)
* [Блог разработчика](http://nujensait.ru/)
