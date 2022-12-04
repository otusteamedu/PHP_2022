-- Get all attributes by film 'Cinema 1'

SELECT
    "attributes"."name",
    CASE
        WHEN ("attribute_types"."name" = 'int') THEN "values"."v_int"::varchar
        WHEN ("attribute_types"."name" = 'string') THEN "values"."v_string"
        WHEN ("attribute_types"."name" = 'float') THEN "values"."v_float"::varchar
        WHEN ("attribute_types"."name" = 'datetime') THEN "values"."v_datetime"::varchar
        WHEN ("attribute_types"."name" = 'boolean') THEN "values"."v_boolean"::varchar
    END AS value
FROM "values"
JOIN "films" ON "values"."film_id" = "films"."id"
JOIN "attributes" ON "attributes"."id" = "values"."attribute_id"
JOIN "attribute_types" ON "attribute_types"."id" = "attributes"."type_id"
WHERE "films"."name" = 'Cinema 1'
