DROP VIEW IF EXISTS film_marketing;
CREATE VIEW film_marketing AS
SELECT films.title as film,
       fa.title    as attribute,
       ft.title    as attribute_type,
       concat(fv.value, fv.value_date, fv.value_boolean, fv.value_float, fv.value_int) as value
FROM films
         JOIN film_values fv on films.id = fv.film_id
         JOIN film_attributes fa on fv.attribute_id = fa.id
         JOIN film_types ft on fa.film_type_id = ft.id
WHERE ft.is_staff = false;

DROP VIEW IF EXISTS film_staff_date;
CREATE VIEW film_staff_date AS
SELECT films.title as film, fa.title as attribute, ft.title as attribute_type, fv.value_date as date
FROM films
         JOIN film_values fv on films.id = fv.film_id
         JOIN film_attributes fa on fv.attribute_id = fa.id
         JOIN film_types ft on fa.film_type_id = ft.id
WHERE ft.is_staff = true AND (
            fv.value_date = current_date
        OR (fv.value_date >= current_date AND fv.value_date < current_date + interval '20 day')
    );