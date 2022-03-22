-- Today's films
-- world_premiere attr id = 3
SELECT world_premiere, f.name FROM films f
LEFT JOIN (
    SELECT a.timestamp_value as world_premiere , af.film_id
    FROM attrs a
    LEFT JOIN attr_film af ON a.id = af.attr_id
    WHERE attr_name_id=3
    AND a.timestamp_value
    BETWEEN
        (to_char(now(), 'yyyy-mm-dd 00:00:00'))::timestamp
        AND
        (to_char(now(), 'yyyy-mm-dd 23:59:59'))::timestamp
) af ON f.id = af.film_id
WHERE world_premiere IS NOT NULL;


-- List attrs for film with id=1
SELECT
    an.value name,
    at.value type,
    coalesce(
       text_value::text,
       bool_value::text,
       decimal_value::text,
       timestamp_value::text
    ) as value
FROM attrs a
INNER JOIN attr_film af on a.id = af.attr_id
INNER JOIN attr_types at on at.id = a.attr_type_id
INNER JOIN attr_names an on an.id = a.attr_name_id
WHERE af.film_id=1;
