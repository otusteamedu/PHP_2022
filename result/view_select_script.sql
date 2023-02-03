-- выборка значений атрибутов всех фильмов
SELECT * FROM marketing_attr_view;
-- выборка событий с текущей датой и через 20 дней
SELECT * FROM events_attr_view;
-- выборка атрибутов типа boolean с наибольшим количеством значений true
SELECT * FROM most_truthful_attribute;
-- вывод наименований всех атрибутов типа boolean
SELECT * FROM bool_attribute_title;
-- вывод id фильмов где есть id атрибуты типа datetime c сегодняшней датой
SELECT * FROM movie_date_attribute_today;
-- вывод фильмов с префиксом Film 5
SELECT * FROM movie_with_five_prefix;