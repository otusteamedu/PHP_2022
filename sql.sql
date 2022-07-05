CREATE TABLE IF NOT EXISTS film(
       id serial PRIMARY KEY NOT NULL,
       name varchar(255) NOT NULL
    );

CREATE TABLE IF NOT EXISTS attributes_type(
      id serial PRIMARY KEY NOT NULL,
      name varchar(255) NOT NULL
    );

CREATE TABLE IF NOT EXISTS attributes(
     id serial PRIMARY KEY NOT NULL,
     id_type integer REFERENCES attributes_type,
     name varchar(255) NOT NULL
    );

CREATE TABLE IF NOT EXISTS attributes_values(
    id serial PRIMARY KEY NOT NULL,
    attribute_id integer REFERENCES attributes,
    film_id integer REFERENCES film,
    value_text text DEFAULT NULL,
    value_varchar varchar(255) DEFAULT NULL,
    value_integer integer DEFAULT NULL,
    value_bool boolean DEFAULT NULL,
    value_float float DEFAULT NULL,
    value_date date DEFAULT NULL
    );


INSERT INTO film(name) VALUES
   ('Властелин колец: Возвращение короля'),
   ('Властелин колец: Две крепости'),
   ('Властелин колец: Братство Кольца')
;

INSERT INTO attributes_type(name) VALUES
  ('Рецензии'),
  ('Премия'),
  ('Важные даты'),
  ('Служебные даты'),
  ('Задачи')
;

INSERT INTO attributes(id_type, name) VALUES
  (1,'Рецензия критиков'),
  (1,'Отзыв неизвестной киноакадемии'),
  (2,'Оскар'),
  (2,'Ника'),
  (3,'Премьера в мире'),
  (3,'Премьера в России'),
  (4,'Дата начала продажи билетов'),
  (4,'Когда запускать рекламу на ТВ'),
  (5,'Задачи актуальные сегодня'),
  (5,'Задачи актуальные через 20 дней')
;


INSERT INTO attributes_values(attribute_id, film_id, value_text) VALUES
     (1,1,'В любом случае, независимо от благосклонности академиков, «Властелин колец» будет самым значимым событием в мире кино за последние годы, а имя Питера Джексона будет навсегда вписано в голливудские скрижали рядом с именами Лукаса и Спилберга.'),
     (1,2,'По части активных действий «Две крепости» несомненно превосходят «Братство Колца». Особое место в фильме занимают масштабные баталии, на которых статисты из новозеландской армии бились, не щадя друг друга. В целом же, вторая лента трилогии закрепляет сказочные ощущения от киноповествования о Кольце.'),
     (1,3,'Джексон перенес на экран одну из величайших книг ХХ века. Фильм и не претендует на большее, оставаясь почти дословной экранизацией. В этом и его плюсы, и минусы. Минусов меньше.');

INSERT INTO attributes_values(attribute_id, film_id, value_text) VALUES
     (2,1,'Это творение вне времени и пространства, оно стоит особняком – ничто даже близко не приблизилось к этой трилогии.'),
     (2,2,'Не фильм, а шедевр мирового кино! Лучше может быть только третья часть.'),
     (2,3,'Этому фильму мы обязаны тем, что по всему миру к жанру фэнтези вспыхнул живой интерес.');

INSERT INTO attributes_values(attribute_id, film_id, value_bool) VALUES
     (3,1,true),
     (3,2,false),
     (3,3,true);

INSERT INTO attributes_values(attribute_id, film_id, value_bool) VALUES
     (4,1,false),
     (4,2,true),
     (4,3,false);

INSERT INTO attributes_values(attribute_id, film_id, value_date) VALUES
     (5,1,'2003-12-01'),
     (5,2,'2002-12-05'),
     (5,3,'2001-12-10');

INSERT INTO attributes_values(attribute_id, film_id, value_date) VALUES
     (6,1,'2004-01-01'),
     (6,2,'2003-01-05'),
     (6,3,'2002-02-10');

INSERT INTO attributes_values(attribute_id, film_id, value_date) VALUES
     (7,1,date '2004-01-01' + INTERVAL '7 days'),
     (7,2,date '2003-01-05' + INTERVAL '7 days'),
     (7,3,date '2002-02-10' + INTERVAL '7 days');

INSERT INTO attributes_values(attribute_id, film_id, value_date) VALUES
     (8,1,date '2004-01-01' + INTERVAL '20 day'),
     (8,2,date '2003-01-05' + INTERVAL '20 day'),
     (8,3,date '2002-02-10' + INTERVAL '20 day');

INSERT INTO attributes_values(attribute_id, film_id, value_varchar, value_date) VALUES
    (9,1,'Задача 1', current_date),
    (9,2,'Задача 2', current_date),
    (9,3,'Задача 3', current_date);

INSERT INTO attributes_values(attribute_id, film_id, value_varchar, value_date) VALUES
    (10,1,'Задача 4', current_date + INTERVAL '20 day'),
    (10,2,'Задача 5', current_date + INTERVAL '20 day'),
    (10,3,'Задача 6', current_date + INTERVAL '20 day');


CREATE OR REPLACE VIEW view_marketing as
SELECT film.name as film_name,
       av.value_varchar as value,
           a.name as task
FROM film
    JOIN attributes_values av on film.id = av.film_id
    JOIN attributes a on av.attribute_id = a.id
    JOIN attributes_type t on t.id = a.id_type
WHERE
    t.id=5 AND
    av.value_date=current_date OR av.value_date=current_date + INTERVAL '20 day'
ORDER BY film.id
;

select * from view_marketing;

CREATE OR REPLACE VIEW view_data as
SELECT film.name as film_name,
       av.value_date::text as date,
       a.name as task
FROM film
    JOIN attributes_values av on film.id = av.film_id
    JOIN attributes a on av.attribute_id = a.id
    JOIN attributes_type t on t.id = a.id_type
WHERE
    t.id=4
ORDER BY film.id;

select * from view_data;

CREATE OR REPLACE VIEW view_all as
SELECT film.name as film_name,
       a.name as a_name,
       t.name as at_type,
       CASE
           WHEN av.value_text IS NOT NULL THEN av.value_text
           WHEN av.value_varchar IS NOT NULL THEN av.value_varchar
           WHEN av.value_date IS NOT NULL THEN av.value_date::text
           WHEN av.value_bool IS NOT NULL THEN av.value_bool::text
           WHEN av.value_float IS NOT NULL THEN av.value_float::text
           WHEN av.value_integer IS NOT NULL THEN av.value_integer::text
           END
FROM film
         JOIN attributes_values av on film.id = av.film_id
         JOIN attributes a on av.attribute_id = a.id
         JOIN attributes_type t on t.id = a.id_type
ORDER BY t.id, film.id;