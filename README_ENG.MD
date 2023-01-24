# README #

### What is it? ###

* Quick summary:
Telegram chatbot @mishaikon_bot written on PHP.

* Version 2.0 (with imrovements added form **[Otus course](https://fas.st/wRyRs)** completion)

### Documents ###
* [Starting/deployment guide](http://nujensait.ru/10776/)
* [Making photos parser](http://nujensait.ru/10777/)
* [Running bot in telegram](http://nujensait.ru/10776/)
* [Article on Habr](https://habr.com/ru/company/netologyru/blog/326174/) (I started from here)

### Setup ###
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
 
### How do I use bot? ###

* Open telegram
* On search window, find: mishaikon_bot
* Type "/start" command, hot Enter
* Choose other menu items from menu

### Development history ###
* [Worklog (public)](/media/worklog.html)
* [Dev-wiki (private)](https://mishaikon.atlassian.net/wiki/spaces/WIKI/pages/225443841/)

### Who do I talk to? ###

* Author: Mishaikon [<mishaikon@gmail.com>](mailto:mishaikon@gmail.com)
* [Autor's site](http://nujensait.ru/)
