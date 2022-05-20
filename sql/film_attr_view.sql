CREATE VIEW attributes_films AS
SELECT film.name as film_name,
       film_attribute.name as attribute_name,
       film_attribute_type.type as type,
       concat_ws('', film_attribute_value.val_date, film_attribute_value.val_text, film_attribute_value.val_boolean) as value
FROM film,
     film_attribute_type,
     film_attribute,
     film_attribute_value
WHERE film_attribute_value.film_id = film.id
  AND film_attribute_value.film_attribute_id = film_attribute.id
  AND film_attribute.film_attribute_type_id = film_attribute_type.id;
