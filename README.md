# Валидация email-адресов из файла

Консольная команда для проверки списка email-адресов из любого файла
## Требования

- php >= 7.4
- symfony/console >= ^5.4

## Использование
```
$ php bin/console email-validate <name-file>
```
```<name-file>``` - полный путь до файла.

Разрешенные форматы файла: txt, log, err, text