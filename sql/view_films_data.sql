CREATE OR REPLACE VIEW view_films_data as
    SELECT
        film.name || ' (' || film.year || ')' "Фильм",
        fat.name as "Тип атрибута",
        fa.name as "Атрибут",
        CASE
            WHEN fav.value_char IS NOT NULL THEN fav.value_char
            WHEN fav.value_text IS NOT NULL THEN fav.value_text
            WHEN fav.value_int IS NOT NULL THEN fav.value_int::text
            WHEN fav.value_float IS NOT NULL THEN fav.value_float::text
            WHEN fav.value_date IS NOT NULL THEN fav.value_date::text
            WHEN fav.value_boolean IS NOT NULL THEN fav.value_boolean::text
        END "Значение"
    FROM film_entity as film
         INNER JOIN film_attribute_value fav on film.id = fav.film_id
         INNER JOIN film_attribute fa on fav.attribute_id = fa.id
         INNER JOIN film_attribute_type fat on fa.type_id = fat.id
    ORDER BY film.year, fav.attribute_id;

SELECT * FROM view_films_data;