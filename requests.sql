#общее число фильмов
SELECT COUNT(*) as film_count from films;

#список названий атрибутов имеющих строковый тип
SELECT `name` from attributes where attribute_type_id = 2;

#число фильмов с оскаром
SELECT COUNT(*) as films_with_oscar from attribute_film where attribute_id = 6 and val_bool = true;

#Список фильмов с оскаром
SELECT films.title AS "title"
FROM films
         JOIN attribute_film ON films.id = attribute_film.film_id
         JOIN attributes ON attribute_film.attribute_id = attributes.id
         JOIN attribute_types ON attributes.attribute_type_id = attribute_types.id
WHERE attributes.name = "Оскар" AND attribute_film.val_bool = true;

#сбор служебных данных в форме: фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
SELECT films.title AS "title",
       (SELECT attribute_film.val_date FROM attribute_film WHERE film_id = films.id AND DATE(attribute_film.val_date) = CURDATE()) AS "today",
       (SELECT attribute_film.val_date FROM attribute_film WHERE film_id = films.id AND DATE(attribute_film.val_date) = CURDATE() + 20) AS "at_20_days"
FROM films
         JOIN attribute_film ON films.id = attribute_film.film_id
         JOIN attributes ON attribute_film.attribute_id = attributes.id
         JOIN attribute_types ON attributes.attribute_type_id = attribute_types.id
WHERE DATE(attribute_film.val_date) = CURDATE() OR DATE(attribute_film.val_date) = CURDATE() + 20;


#сбор служебных данных  для маркетинга: фильм, тип атрибута, атрибут, значение
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