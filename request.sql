
-- Вывод фильма, типа аттрибута, аттрибута и значения
Select films.title, attr_types.name, attr.name,
       coalesce(attr_val.value_date::text, attr_val.value_float::text, attr_val.value_integer::text, attr_val.value_boolean::text, attr_val.value_text) as attr_val
from films
         join attribute_values as attr_val On (attr_val.film_id = films.id)
         join attributes as attr On (attr_val.attribute_id = attr.id)
         join attribute_types as attr_types On (attr_types.id = attr.attribute_type_id);

-- фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
Select f.title, attr.name as "actual_task", attr_val.value_date, attr2.name as "in 20 days", attr_val2.value_date
from films as f
         left join "attribute_values" attr_val on attr_val."film_id" = f."id"
    and attr_val."value_date" = current_date
    and attr_val."attribute_id" = 2
         left join "attributes" attr on attr."id" = attr_val."attribute_id"
         left join "attribute_values" attr_val2 on attr_val2."film_id" = f."id"
    and attr_val2."value_date" = current_date + interval '20 days'
    and attr_val2."attribute_id" = 2
         left join "attributes" attr2 on attr2."id" = attr_val2."attribute_id";
