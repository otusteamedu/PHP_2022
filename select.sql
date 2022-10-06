SELECT film_name 
FROM film
WHERE film_name like 'b%';


SELECT count(*) 
FROM film_values
WHERE val_date is not null 
      and id_attr=3 
      and val_char = 'ну такое';


SELECT id_type_attr as "Тип атрибута", 
       count(id_type_attr) as "Сколько атрибутов такого типа" 
FROM film_attr
GROUP BY id_type_attr
ORDER BY id_type_attr ASC;


SELECT film_attr.id_type_attr as "Тип атрибута",
	   film_attr_type.attr_type_name as "Название атрибута",
	   count(film_attr.id_type_attr) as "Сколько атрибутов такого типа" 
FROM film_attr
    JOIN film_attr_type ON film_attr.id_type_attr = film_attr_type.id_type_attr
GROUP BY film_attr.id_type_attr, film_attr_type.attr_type_name
ORDER BY film_attr.id_type_attr ASC; 



SELECT film.film_name AS "Фильм",
film_attr_type.attr_type_name AS "Тип атрибута",
film_attr.attr_name AS "Атрибут",
    CASE
        WHEN film_values.val_int IS NOT NULL THEN film_values.val_int::text
        WHEN film_values.val_char IS NOT NULL THEN film_values.val_char::text
        WHEN film_values.val_date IS NOT NULL THEN film_values.val_date::text
        WHEN film_values.val_boolean IS NOT NULL THEN film_values.val_boolean::text
        WHEN film_values.val_float IS NOT NULL THEN film_values.val_float::text
        ELSE NULL::text
    END AS "Значение"
FROM film
    JOIN film_values ON film.id_film = film_values.id_film
    JOIN film_attr ON film_attr.id_attr = film_values.id_attr
    JOIN film_attr_type ON film_attr_type.id_type_attr = film_attr.id_type_attr
WHERE film_values.val_char != 'ну такое' and film.film_name like 'c%3%'
ORDER BY film.film_name, film_attr_type.attr_type_name, film_attr.attr_name;


SELECT film.film_name AS "Фильм",
film_attr_type.attr_type_name AS "Задача",
film_values.val_date AS "Дата задачи"
FROM film
    JOIN film_values ON film.id_film = film_values.id_film
    JOIN film_attr ON film_attr.id_attr = film_values.id_attr
    JOIN film_attr_type ON film_attr_type.id_type_attr = film_attr.id_type_attr
WHERE film_values.val_date >= to_date('2014', 'YYYY') and film_values.val_date <  to_date('2023', 'YYYY')
ORDER BY film_values.val_date, film.film_name;