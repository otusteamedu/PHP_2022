CREATE OR REPLACE VIEW view_actual_tasks as
    SELECT
        film.name || ' (' || film.year || ')' "Фильм",
        fa.name as "Задача",
        fav.value_date::text as "Дата выполнения"
    FROM film_entity as film
         INNER JOIN film_attribute_value fav on film.id = fav.film_id
         INNER JOIN film_attribute fa on fav.attribute_id = fa.id
         INNER JOIN film_attribute_type fat on fa.type_id = fat.id
    WHERE
        fav.value_date = current_date OR fav.value_date = current_date + interval '20 days'
        AND fat.id = 7
    ORDER BY fav.value_date, film.id;

SELECT * FROM view_actual_tasks;