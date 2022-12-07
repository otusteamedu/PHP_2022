CREATE OR REPLACE VIEW data_for_marketing as
SELECT films.name as film_name, fat.type as attribute_type, fa.label as attribute,
       CASE
           WHEN fv.value_boolean IS NOT NULL THEN fv.value_boolean::text
           WHEN fv.value_date IS NOT NULL THEN fv.value_date::text
           WHEN fv.value_num IS NOT NULL THEN fv.value_num::text
           WHEN fv.value_text IS NOT NULL THEN fv.value_text
           END as value
FROM films
         JOIN film_values fv on films.id = fv.film_id
         JOIN film_attributes fa on fv.attribute_id = fa.id
         JOIN film_attribute_types fat on fat.id = fa.film_attribute_type_id;


CREATE OR REPLACE VIEW service_data as
    SELECT films.name,
    (
        SELECT string_agg (film_attributes.label, ' | ')
        FROM film_values
            JOIN film_attributes ON film_values.attribute_id = film_attributes.id
        WHERE film_values.film_id = films.id and film_values.value_date = current_date
    ) as today,
    (
        SELECT
            string_agg (film_attributes.label, ' | ')
        FROM film_values
            JOIN film_attributes ON film_values.attribute_id = film_attributes.id
        WHERE film_values.film_id = films.id and film_values.value_date = current_date + Interval '20 days'
    ) as after_20_days

FROM films;