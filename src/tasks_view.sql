create view tasks as
SELECT m.name AS "Фильм",
       CASE
           WHEN av.value_date::date = CURRENT_DATE THEN a.name::text
           ELSE NULL::text
           END AS "Задачи на сегодня",
       CASE
           WHEN av.value_date::date = (CURRENT_DATE + '20 days'::interval day) THEN a.name::text
           ELSE NULL::text
           END AS "Задачи через 20 дней"
FROM attribute_value av
         join movies m  on m.id = av.movie_id
         join attributes a on a.id = av.attribute_id
         join attribute_type at on at.id = a.attribute_type_id
WHERE a.name::text = 'Старт продаж'::text OR a.name::text = 'Старт рекламы'::text
    AND (av.value_date::date = CURRENT_DATE OR av.value_date::date = (CURRENT_DATE + '20 days'::interval day));