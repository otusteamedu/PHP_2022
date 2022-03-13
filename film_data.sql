select f.film_name as "Фильм", at.type_name as "Тип", a.attr_name as "Аттрибут",
CASE
       WHEN v.text_val IS NOT NULL THEN v.text_val::text
       WHEN v.bool_val IS NOT NULL THEN v.bool_val::text
       WHEN v.date_val IS NOT NULL THEN v.date_val::text
END AS "Значение"
from attr_value v
join film f on f.film_id=v.film_id
join attribute a on a.attr_id=v.attr_id
join attr_type at on at.type_id=a.attr_type_id;
