INSERT INTO movie (title)
VALUES ('Ёлки');
INSERT INTO movie (title)
VALUES ('Ёлки 2');
INSERT INTO movie (title)
VALUES ('Ёлки 3');
INSERT INTO movie (title)
VALUES ('Ёлки 4');
INSERT INTO movie (title)
VALUES ('Ёлки 5');
INSERT INTO movie (title)
VALUES ('Ёлки 6');

INSERT INTO attribute_type (type)
VALUES ('integer');
INSERT INTO attribute_type (type)
VALUES ('numeric');
INSERT INTO attribute_type (type)
VALUES ('text');
INSERT INTO attribute_type (type)
VALUES ('bool');
INSERT INTO attribute_type (type)
VALUES ('date');

INSERT INTO movie_attribute (name, attribute_type_id)
VALUES ('Рецензии', 3);
INSERT INTO movie_attribute (name, attribute_type_id)
VALUES ('Премия Ника', 4);
INSERT INTO movie_attribute (name, attribute_type_id)
VALUES ('Премия Оскар', 4);
INSERT INTO movie_attribute (name, attribute_type_id)
VALUES ('Мировая премьера', 5);
INSERT INTO movie_attribute (name, attribute_type_id)
VALUES ('Премьера в РФ', 5);
INSERT INTO movie_attribute (name, attribute_type_id)
VALUES ('Дата начала продажи билетов', 5);
INSERT INTO movie_attribute (name, attribute_type_id)
VALUES ('Когда запускать рекламу на ТВ', 5);

INSERT INTO movie_attribute_values (movie_attribute_id, v_text, movie_id)
VALUES (1, 'Рецензия 1', 1);
INSERT INTO movie_attribute_values (movie_attribute_id, v_text, movie_id)
VALUES (1, 'Рецензия 2', 2);
INSERT INTO movie_attribute_values (movie_attribute_id, v_text, movie_id)
VALUES (1, 'Рецензия 3', 3);
INSERT INTO movie_attribute_values (movie_attribute_id, v_boolean, movie_id)
VALUES (2, TRUE, 4);
INSERT INTO movie_attribute_values (movie_attribute_id, v_boolean, movie_id)
VALUES (2, TRUE, 5);
INSERT INTO movie_attribute_values (movie_attribute_id, v_boolean, movie_id)
VALUES (2, TRUE, 6);
INSERT INTO movie_attribute_values (movie_attribute_id, v_boolean, movie_id)
VALUES (3, TRUE, 1);
INSERT INTO movie_attribute_values (movie_attribute_id, v_boolean, movie_id)
VALUES (3, TRUE, 3);
INSERT INTO movie_attribute_values (movie_attribute_id, v_boolean, movie_id)
VALUES (3, TRUE, 4);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (4, '2022-12-30', 1);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (5, '2022-12-30', 1);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (6, '2022-12-30', 1);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (7, '2022-12-30', 1);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (4, '2022-12-31', 2);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (5, '2022-12-31', 2);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (6, '2022-12-31', 2);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (7, '2022-12-31', 6);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (5, '2022-12-11', 3);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (6, '2022-12-11', 4);
INSERT INTO movie_attribute_values (movie_attribute_id, v_date, movie_id)
VALUES (7, '2022-12-11', 5);

CREATE VIEW today (movie_title, actual_today) as
SELECT m.title, ma.name
FROM movie_attribute_values mav
         INNER JOIN movie_attribute ma on ma.id = mav.movie_attribute_id
         INNER JOIN attribute_type at on at.id = ma.attribute_type_id
         INNER JOIN movie m on m.id = mav.movie_id
WHERE (mav.v_date = current_date)
  and mav.movie_attribute_id in (4, 5, 6, 7)
ORDER BY m.title, ma.name;

CREATE VIEW in_20_days (movie_title, actual_in_20_days) as
SELECT m.title, ma.name
FROM movie_attribute_values mav
         INNER JOIN movie_attribute ma on ma.id = mav.movie_attribute_id
         INNER JOIN attribute_type at on at.id = ma.attribute_type_id
         INNER JOIN movie m on m.id = mav.movie_id
WHERE (mav.v_date = (current_date + INTERVAL '20 day'))
  and mav.movie_attribute_id in (4, 5, 6, 7)
ORDER BY m.title, ma.name;

CREATE VIEW aggregate (movie_title, attribute_type, movie_attribute, movie_attribute_values)
SELECT m.title,
       at.type,
       ma.name,
       CASE
           WHEN mav.v_date IS NOT NULL THEN mav.v_date::text
           WHEN mav.v_text IS NOT NULL THEN mav.v_text
           WHEN mav.v_boolean IS NOT NULL THEN mav.v_boolean::text
           WHEN mav.v_int IS NOT NULL THEN mav.v_int::text
           WHEN mav.v_float IS NOT NULL THEN mav.v_float::text
           END "value"
FROM movie as m
         INNER JOIN movie_attribute_values mav on m.id = mav.movie_id
         INNER JOIN movie_attribute ma on ma.id = mav.movie_attribute_id
         INNER JOIN attribute_type at ON at.id = ma.attribute_type_id;


