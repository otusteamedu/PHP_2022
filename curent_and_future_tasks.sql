WITH films_with_date_attributes AS (
    select f.id as film_id, f.name as film_name, a.name as attribute_name, v.value as value
    from films_entity as f
    inner join values v on f.id = v.entity_id
    inner join attributes a on a.id = v.attribute_id
    inner join attributes_types t on a.type = t.id
    where t.type = 'date'
), current_task AS (
    select attribute_name as current_task, film_id
    from films_with_date_attributes
    where to_date(value, 'YYYY-MM-DD') = CURRENT_DATE
), future_task AS (
    select attribute_name as future_task, film_id
    from films_with_date_attributes
    where to_date(value, 'YYYY-MM-DD') = CURRENT_DATE + INTERVAL '20 days'
)

select fe.name, ct.current_task, ft.future_task
from films_entity as fe
         left join current_task as ct on ct.film_id = fe.id
         left join future_task as ft on ft.film_id = fe.id

