-- фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
create view service_data as
(
select m.name as MovieName, ma.name as today, null as in_20_days
from movie as m
         join movie_attribute_value mav on m.id = mav.movie_id
         join movie_attribute ma on ma.id = mav.movie_attribute_id
         join movie_attribute_type mat on mat.id = ma.attribute_type_id
where mav.value_datetime::date = date 'today'
union all
select m.name as MovieName, null as today, ma.name as in_20_days
from movie as m
         join movie_attribute_value mav on m.id = mav.movie_id
         join movie_attribute ma on ma.id = mav.movie_attribute_id
         join movie_attribute_type mat on mat.id = ma.attribute_type_id
where mav.value_datetime::date = (now() + interval '20 days')::date
order by MovieName
    );

-- фильм, тип атрибута, атрибут, значение (значение выводим как текст)
create view marketing_data as
(
select movie.name                 as MovieName,
       mat.name                   as AttributeType,
       ma.name                    as AttributeName,
       concat(mav.value_string, mav.value_text, mav.value_integer, mav.value_float, mav.value_boolean,
              mav.value_datetime) as AttributeValue
from movie
         join movie_attribute_value mav on movie.id = mav.movie_id
         join movie_attribute ma on ma.id = mav.movie_attribute_id
         join movie_attribute_type mat on mat.id = ma.attribute_type_id
    );