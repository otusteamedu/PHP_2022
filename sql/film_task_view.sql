CREATE VIEW date_attribute AS
(SELECT film.name, film_attribute.name as today, null as twenty_days
 FROM film,
      film_attribute_value,
      film_attribute
 WHERE film_attribute_value.film_id = film.id
   AND film_attribute_value.film_attribute_id = film_attribute.id
   AND film_attribute_value.val_date = now()::date)
UNION
        DISTINCT
        (SELECT film.name, null as today, film_attribute.name as days20
        FROM film,
        film_attribute_value,
        film_attribute
        WHERE film_attribute_value.film_id = film.id
        AND film_attribute_value.film_attribute_id = film_attribute.id
        AND film_attribute_value.val_date = (now() + interval '20 days')::date)
        ORDER BY name;