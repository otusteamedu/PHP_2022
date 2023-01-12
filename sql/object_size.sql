SELECT pc.relname, pc.relpages FROM pg_class pc
    INNER JOIN pg_namespace pn on pc.relnamespace = pn.oid
    WHERE pn.nspname = 'public'
    ORDER BY relpages DESC
    LIMIT 15;

-- +------------------------+--------+
-- |relname                 |relpages|
-- +------------------------+--------+
-- |films                   |133467  |
-- |sessions                |83417   |
-- |tickets                 |73791   |
-- |films_title_index       |72158   |
-- |tickets_cost_index      |38544   |
-- |tickets_cost            |38544   |
-- |sessions_film_index     |27449   |
-- |sessions_type_film_index|27449   |
-- |tickets_pkey            |27448   |
-- |films_pkey              |27448   |
-- +------------------------+--------+
