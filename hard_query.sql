-- Запрос 1. Фильмы и их атрибуты
select f.film_name as "Фильм", at.type_name as "Тип", a.attr_name as "Аттрибут",
CASE
       WHEN v.text_val  IS NOT NULL THEN v.text_val::text
       WHEN v.bool_val  IS NOT NULL THEN v.bool_val::text
       WHEN v.date_val  IS NOT NULL THEN v.date_val::text
       WHEN v.int_val   IS NOT NULL THEN v.int_val::text
       WHEN v.float_val IS NOT NULL THEN v.float_val::text
END AS "Значение"
from attr_value v
join film f on f.film_id=v.film_id
join attribute a on a.attr_id=v.attr_id
join attr_type at on at.type_id=a.attr_type_id;

-- Запрос 2. Служебные данные о датах
SELECT f.film_name AS "Фильм",
   CASE
       WHEN v.date_val::date = CURRENT_DATE THEN a.attr_name::text
       ELSE NULL::text
       END AS "Задачи на сегодня",
   CASE
       WHEN v.date_val::date = (CURRENT_DATE + '20 days'::interval day) THEN a.attr_name::text
       ELSE NULL::text
       END AS "Задачи через 20 дней"
FROM attr_value v
         join film f on f.film_id=v.film_id
         join attribute a on a.attr_id=v.attr_id
         join attr_type at on at.type_id=a.attr_type_id
WHERE at.type_name::text = 'служебные даты'::text
   AND (v.date_val::date = CURRENT_DATE OR v.date_val::date = (CURRENT_DATE + '20 days'::interval day));
