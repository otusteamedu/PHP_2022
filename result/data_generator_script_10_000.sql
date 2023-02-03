SET session cinema.number_of_attribute_types = '6'; --//общее кол-во типов данных
-- plan to 10_000
-- 400 фильмов по 5 значений атрибута из 5 типов //400х5х5
SET session cinema.number_of_values = '5'; --//кол-во атрибутов оодного типа для фильма
SET session cinema.number_of_attributes = '500';--//общее кол-во атрибутов
SET session cinema.number_of_cinema = '400';--//общее кол-во фильмов

TRUNCATE attribute_value;
TRUNCATE cinema CASCADE;
TRUNCATE attribute CASCADE;
TRUNCATE attribute_type restart identity CASCADE;

-- фильмы
INSERT INTO cinema
select id, concat('Film ',MD5(random()::text),' ',id)
FROM GENERATE_SERIES(1, current_setting('cinema.number_of_cinema')::int) as id;

-- типы значений атрибутов
INSERT INTO attribute_type (at_type)
VALUES ('bool'),
       ('int'),
       ('varchar'),
       ('text'),
       ('datetime'),
       ('float');

-- значения атрибутов
INSERT INTO attribute
select id, concat('Attribute ', id), random()*(current_setting('cinema.number_of_attribute_types')::int-1)+1
FROM GENERATE_SERIES(1, current_setting('cinema.number_of_attributes')::int) as id;

-------------------------------
-- Заполнение атрибутов фильмов
-------------------------------
--  insert bool
INSERT INTO attribute_value (av_c_id,av_a_id,av_value_bool)
SELECT c_id,attr.a_id, random() > 0.5 as av_value_bool FROM cinema
     CROSS JOIN (SELECT * FROM attribute WHERE a_at_id = 1 ORDER BY random() LIMIT current_setting('cinema.number_of_values')::int) AS attr;

--  insert int
INSERT INTO attribute_value (av_c_id,av_a_id,av_value_int)
SELECT c_id,attr.a_id, floor(random()*(100000-1))+1 as av_value_int FROM cinema
     CROSS JOIN (SELECT * FROM attribute WHERE a_at_id = 2 ORDER BY random() LIMIT current_setting('cinema.number_of_values')::int) AS attr;

--  insert varchar
INSERT INTO attribute_value (av_c_id,av_a_id,av_value_varchar)
SELECT c_id,attr.a_id, MD5(random()::text) as av_value_varchar FROM cinema
     CROSS JOIN (SELECT * FROM attribute WHERE a_at_id = 3 ORDER BY random() LIMIT current_setting('cinema.number_of_values')::int) AS attr;

--  insert datetime
INSERT INTO attribute_value (av_c_id,av_a_id,av_value_datetime)
SELECT c_id,attr.a_id, now() + (random() * (now()+'90 days' - now())) as av_value_datetime FROM cinema
     CROSS JOIN (SELECT * FROM attribute WHERE a_at_id = 5 ORDER BY random() LIMIT current_setting('cinema.number_of_values')::int) AS attr;

--  insert float
INSERT INTO attribute_value (av_c_id,av_a_id,av_value_float)
SELECT c_id,attr.a_id, random() * 100000 + 1 as av_value_float FROM cinema
     CROSS JOIN (SELECT * FROM attribute WHERE a_at_id = 6 ORDER BY random() LIMIT current_setting('cinema.number_of_values')::int) AS attr;
