# Домашнее задание:

1. Создать структуру/структуры хранения информации о канале и видео канала в ElasticSearch, 
   описать в виде JSON с указанием типов полей. Описать, какие индексы понадобятся в данной структуре?

Структура хранения данных о канале
```json
{
  "type": "object",
  "properties": {
	"id": {
	  "type": "string"
	},
	"chanel_title": {
	  "type": "string"
	},
	"description": {
	  "type": "string"
	}
  },
  "required": [
	"id",
	"chanel_title",
	"description"
  ]
}
```
### Какие индексы понадобятся в данной структуре?

Нужны были ключи:
- id - ключ для создания уникальности каждой записи
- chanel_title - название видеоканала - т.к. будем искать по этому имени канал
- description - ключ для описания, возможно в будущем понадобится поиск в описании. Схему можно создать только в начале, до заполнения данными.

Структура хранения данных о видео
```json
{
  "type": "object",
  "properties": {
	"id": {
	  "type": "string"
	},
	"video_chanel": {
	  "type": "string"
	},
	"video_title": {
	  "type": "string"
	},
	"description": {
	  "type": "string"
	},
	"video_seconds": {
	  "type": "integer"
	},
	"like": {
	  "type": "integer"
	},
	"dislike": {
	  "type": "integer"
	}
  },
  "required": [
	"id",
	"video_chanel",
	"video_title",
	"description",
	"video_seconds",
    "like",
    "dislike"
  ]
}
```

Нужны были ключи:

- id - ключ для создания уникальности каждой записи
- video_chanel - название видеоканала - т.к. будем сортировать по этому имени канал
- video_title - название видео - т.к. будем искать по этому имени видео
- description / video_seconds - ключ для описания, возможно в будущем понадобится поиск в описании. Схему можно создать только в начале, до заполнения данными.
- like - будем сортировать по этому полю
- dislike - будем сортировать по этому полю

2. Создать необходимые модели для добавления и удаления данных из коллекций
    - Создан репозиторий (необходимые модели для ДЗ) `App\Repositories\VideoElasticsearchSearchRepository` - для видео - метод создания индексов, поиск и добавление данных
    - Создан репозиторий (необходимые модели для ДЗ) `App\Repositories\VideoChanelElasticsearchSearchRepository` - для видеоканала.
    - Консольные команды:
      - `el:chanel:generate` - создание данных по каналу в эластике
      - `el:chanel:find` - поиск канала по полному названию
      - `el:video:generate` - создание данных по видео в эластике
      - `el:video:find` - поиск видеофайла по полному названию
      - `el:chanel:crete:index` - создание индекса канала файлов канала
      - `el:video:crete:index` - создание индекса видео файлов канал

4. Реализовать класс статистики, который может возвращать:
  - Консольные команды:
      - `el:video:max` - Суммарное кол-во лайков/дизлайков для канала по всем его видео
      - `el:video:top` - Топ N каналов с лучшим соотношением кол-во лайков/дизлайков


```shell
# Создание индексов
php artisan el:chanel:crete:index
php artisan el:video:crete:index

# Создание данных
php artisan el:chanel:generate
php artisan el:video:generate

# запросы на поиск видеофайла и видеоканала
php artisan el:video:find
php artisan el:chanel:find

# запросы на статистику
php artisan el:video:max
php artisan el:video:top
```



# INFO:
## !!!
**Ребятам, которые будут выполнять данное ДЗ, на момент апреля 2022 года, 
Elastic Search заблокировал доступ к скачиванию своих докер образов из России. 
Поэтому качайте образы через VPN, но запускайте docker-compose с выключенным VPN.**
## !!!


Работал по гайду, гайд не описывает некоторые тонкости и завел лишь в заблуждения
- https://laravel.demiart.ru/configuring-elasticsearch-in-laravel/

взял пример - https://github.com/yehorherasymchuk/otus-php-elasticsearch

Он не работает под php8.0 переделал, чтобы работал.
Минус в .env - нет настроек нужных для Эластика, добавил в .env и .env.example

Кроме документации, на русском есть: https://www.youtube.com/watch?v=T3-t0180VC4&list=PLdpb__6uY73kCu4eG9IolmhkBmNgyRL-i&index=5

Помогло для понимания поиска в эластике и общую концепцию работы с ним.
