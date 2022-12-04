--
-- films
--
INSERT INTO films("name")
    SELECT
        random_string((1 + random()*50)::integer)
    FROM
        generate_series(1, 10000) as gs(id);

--
-- values
--
INSERT INTO values("attribute_id", "film_id", "v_int", "v_float", "v_boolean", "v_string", "v_datetime")
    SELECT
        "attributes"."id" as "attribute_id",
        "films"."id" as "film_id",
        CASE
            WHEN (SELECT exists(SELECT 1 FROM "attribute_types" WHERE "id" = "attributes"."type_id" AND "name" = 'int')) THEN round(random() * 1000)
            ELSE null
        END as "v_int",
        CASE
            WHEN (SELECT exists(SELECT 1 FROM "attribute_types" WHERE "id" = "attributes"."type_id" AND "name" = 'float')) THEN random() * 1000
            ELSE null
        END as "v_float",
        CASE
            WHEN (SELECT exists(SELECT 1 FROM "attribute_types" WHERE "id" = "attributes"."type_id" AND "name" = 'boolean')) THEN random() < 0.5
            ELSE null
        END as "v_boolean",
        CASE
            WHEN (SELECT exists(SELECT 1 FROM "attribute_types" WHERE "id" = "attributes"."type_id" AND "name" = 'string')) THEN random_string((1 + random()*100)::integer)
            ELSE null
        END as "v_string",
        CASE
            WHEN (SELECT exists(SELECT 1 FROM "attribute_types" WHERE "id" = "attributes"."type_id" AND "name" = 'datetime'))
                THEN CURRENT_DATE + CURRENT_TIME + trunc(random() * 1000000) * '1 second'::interval
            ELSE null
        END as "v_datetime"
    FROM
        "attributes",
        "films";

--
-- SELECT "id", "name" FROM "films";
--
Seq Scan on films  (cost=0.00..178.00 rows=10000 width=30)
