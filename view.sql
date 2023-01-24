create view film_current as
select films.name as film,
       fa.name as attr_name,
       fv.value as attr_value
from films
         join film_attributes fa on films.id = fa.film_id
         join film_values fv on fa.id = fv.attr_id
where fv.date = current_date or fv.date = current_date + interval '20 day';

create view film_marketing as
select films.name as film,
       fa.name as attr,
       fv.value as value,
	fat.type as type
from films
	join film_attributes fa on films.id = fa.film_id
	join film_attribute_type fat on fa.id = fat.attr_id
	join film_values fv on fv.attr_type_id = fat.id;