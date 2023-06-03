CREATE VIEW market_data AS
SELECT films.title,
       attribute_types.name AS attribute_type,
       attributes.name,
       (CASE
            WHEN attribute_types.data_type = 'text' THEN attribute_values.value_text::text
            WHEN attribute_types.data_type = 'date' THEN attribute_values.value_date::text
            WHEN attribute_types.data_type = 'boolean' THEN attribute_values.value_boolean::text
            WHEN attribute_types.data_type = 'integer' THEN attribute_values.value_integer::text
        END) AS value
FROM films
LEFT JOIN attribute_values ON attribute_values.film_id = films.id
LEFT JOIN attributes ON attributes.id = attribute_values.attribute_id
LEFT JOIN attribute_types ON attribute_types.id = attributes.type_id
WHERE attribute_types.id in (2,3)
ORDER BY films.id, attribute_types.id;

SELECT *
FROM market_data;