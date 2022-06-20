create view movie_attributes as
select m.name  as "Фильм",
       at.type as "Тип",
       a.name  as "Аттрибут",
       CASE
           WHEN av.value_integer IS NOT NULL THEN av.value_integer::text
           WHEN av.value_text IS NOT NULL THEN av.value_text::text
           WHEN av.value_boolean IS NOT NULL THEN av.value_boolean::text
           WHEN av.value_date IS NOT NULL THEN av.value_date::text
           END AS "Значение"
from attribute_value av
         join movies m on m.id = av.movie_id
         join attributes a on a.id = av.attribute_id
         join attribute_type at on at.id = a.attribute_type_id;