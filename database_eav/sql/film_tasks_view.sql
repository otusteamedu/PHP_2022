CREATE VIEW date_attributes AS
(SELECT film.name, film_attribute.name as today, null as forward_20_days
 FROM film,
      film_value,
      film_attribute
 WHERE film_value.film_id = film.id
   AND film_value.film_attribute_id = film_attribute.id
   AND film_value.value_date = now()::date)
UNION
DISTINCT
(SELECT film.name, null as today, film_attribute.name as days20
 FROM film,
      film_value,
      film_attribute
 WHERE film_value.film_id = film.id
   AND film_value.film_attribute_id = film_attribute.id
   AND film_value.value_date = (now() + interval '20 days')::date)

ORDER BY name;