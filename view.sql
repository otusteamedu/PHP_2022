create view film_current as
select f.name, fa.name, fv.value_date from films f
       join film_values fv on f.id = fv.film_id
       join film_attributes fa on fv.attr_id = fa.id
       join film_type ft on fa.type_id = ft.id
where fv.value_date = current_date or fv.value_date = current_date + interval '20 day';

create view film_marketing as
select
    f.name as film,
    ft.name as type,
    fa.name as attribute,
    concat(fv.value, fv.value_date, fv.value_int, fv.value_float, fv.value_bool) as value
from films f
	join film_values fv on f.id = fv.film_id
	join film_attributes fa on fv.attr_id = fa.id
	join film_type ft on fa.type_id = ft.id;