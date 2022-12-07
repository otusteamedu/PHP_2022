CREATE
OR REPLACE VIEW "tickets_sales_start_date" as
WITH films_with_date_attributes AS (SELECT f.id             AS film_id,
                                           f.name           AS film_name,
                                           a.attribute_type AS attribute_type,
                                           v.date           AS val
                                    FROM movies AS f
                                             INNER JOIN movie_attributes a on a.movie = f.id
                                             INNER JOIN attribute_type_value v on v.movie_attribute = a.id),
     current_task AS (SELECT attribute_type AS current_task, film_id
                      FROM films_with_date_attributes
                      WHERE val = CURRENT_DATE),
     future_task AS (SELECT attribute_type as future_task, film_id
                     FROM films_with_date_attributes
                     WHERE val = CURRENT_DATE + INTERVAL '20 days')

SELECT fe.name, ct.current_task, ft.future_task
FROM movies as fe
         LEFT JOIN current_task AS ct ON ct.film_id = fe.id
         LEFT JOIN future_task AS ft ON ft.film_id = fe.id;

SELECT * FROM "tickets_sales_start_date";


CREATE
OR REPLACE VIEW "sevices_data" AS
SELECT f.name           AS film_name,
       t.type           AS attribute_name,
       a.attribute_type AS attribute_type,
       CASE
           WHEN v.date IS NOT NULL THEN v.date::text
           WHEN v.text IS NOT NULL THEN v.text
           WHEN v.decimal IS NOT NULL THEN v.decimal::text
           WHEN v.int IS NOT NULL THEN v.int::text
           END             "value"
FROM movies AS f
         INNER JOIN movie_attributes a on a.movie = f.id
         INNER JOIN attribute_type_value v on v.movie_attribute = a.id
         INNER JOIN attribute_types t on a.attribute_type = t.id

SELECT * FROM "sevices_data";