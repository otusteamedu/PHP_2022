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

/*

При 10000 фильмах:
Nested Loop  (cost=203.31..1744.73 rows=8 width=548)
  ->  Nested Loop  (cost=203.16..1740.41 rows=8 width=596)
        ->  Hash Join  (cost=203.01..1739.10 rows=8 width=80)
              Hash Cond: ("values".film_id = films.id)
              ->  Seq Scan on "values"  (cost=0.00..1326.00 rows=80000 width=84)
              ->  Hash  (cost=203.00..203.00 rows=1 width=4)
                    ->  Seq Scan on films  (cost=0.00..203.00 rows=1 width=4)
                          Filter: ((name)::text = 'Cinema 1'::text)
        ->  Index Scan using attributes_pkey on attributes  (cost=0.14..0.16 rows=1 width=524)
              Index Cond: (id = "values".attribute_id)
  ->  Index Scan using attribute_types_pkey on attribute_types  (cost=0.15..0.51 rows=1 width=62)
        Index Cond: (id = attributes.type_id)
 */
