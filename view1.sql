CREATE VIEW
    SELECT
        films.id as film_id,
        films.name as film_name,
        (
            SELECT
                string_agg (concat(attributes.name, ' (' , values.v_datetime::varchar, ')'), ' ; ') dates
            FROM values
            LEFT JOIN attributes ON values.attribute_id = attributes.id
            LEFT JOIN attribute_types ON attributes.type_id = attribute_types.id
            WHERE
                values.film_id = films.id
                and v_datetime is not null
                and v_datetime::date = now()::date
                and attribute_types.name = 'datetime'
        ) as today,
        (
            SELECT
                string_agg (concat(attributes.name, ' (' , values.v_datetime::varchar, ')'), ' ; ') dates
            FROM values
            LEFT JOIN attributes ON values.attribute_id = attributes.id
            LEFT JOIN attribute_types ON attributes.type_id = attribute_types.id
            WHERE
                values.film_id = films.id
                and v_datetime is not null
                and v_datetime::date = now()::date + interval '20 days'
                and attribute_types.name = 'datetime'
        ) as days_20
    FROM films
