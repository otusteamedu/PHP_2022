-- Get all integer attributes

SELECT
    "attributes"."id",
    "attributes"."name"
FROM "attributes"
JOIN "attribute_types" ON "attribute_types"."id" = "attributes"."type_id"
WHERE "attribute_types"."name" = 'int'
