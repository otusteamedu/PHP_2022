# Transliterator from ru to en

Пакет позволяет осуществлять транслитерацию слов с русского на английский язык.

## Requirements

- php7.4

## Insatallation

```bash
$ composer require mapaxa/translit-rus-eng
```

## Usage

```php
<?php 
$transliterator = new TranslitService('мама мыла раму');
echo $transliterator->run();
```