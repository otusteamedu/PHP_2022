CREATE VIEW
    SELECT
        films.name,
        attributes.name as attribute_name,
        attribute_types.name as attribute_type,
        CASE
            WHEN (attribute_types.name = 'int') THEN values.v_int::varchar
            WHEN (attribute_types.name = 'string') THEN values.v_string
            WHEN (attribute_types.name = 'float') THEN values.v_float::varchar
            WHEN (attribute_types.name = 'datetime') THEN values.v_datetime::varchar
            WHEN (attribute_types.name = 'boolean') THEN values.v_boolean::varchar
        END AS value
    FROM films
    LEFT JOIN values on values.film_id = films.id
    JOIN attributes ON attributes.id = values.attribute_id
    JOIN attribute_types ON attributes.type_id = attribute_types.id