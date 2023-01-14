CREATE OR REPLACE VIEW `film_tasks` AS
SELECT films.title AS "title",
       (SELECT attribute_film.val_date FROM attribute_film WHERE film_id = films.id AND DATE(attribute_film.val_date) = CURDATE()) AS "today",
       (SELECT attribute_film.val_date FROM attribute_film WHERE film_id = films.id AND DATE(attribute_film.val_date) = CURDATE() + 20) AS "at_20_days"
FROM films
         JOIN attribute_film ON films.id = attribute_film.film_id
         JOIN attributes ON attribute_film.attribute_id = attributes.id
         JOIN attribute_types ON attributes.attribute_type_id = attribute_types.id
WHERE DATE(attribute_film.val_date) = CURDATE() OR DATE(attribute_film.val_date) = CURDATE() + 20;

CREATE OR REPLACE VIEW `marketing` AS
SELECT films.title AS "title",
       attribute_types.name AS "attr_type",
       attributes.name AS "attr_name",
       CASE
           WHEN attribute_types.field = "val_string" THEN attribute_film.val_string
           WHEN attribute_types.field = "val_int" THEN attribute_film.val_int
           WHEN attribute_types.field = "val_bool" THEN attribute_film.val_bool
           WHEN attribute_types.field = "val_date" THEN attribute_film.val_date
           WHEN attribute_types.field = "val_float" THEN attribute_film.val_float
       END  AS "value"
FROM films
         JOIN attribute_film ON films.id = attribute_film.film_id
         JOIN attributes ON attribute_film.attribute_id = attributes.id
         JOIN attribute_types ON attributes.attribute_type_id = attribute_types.id;