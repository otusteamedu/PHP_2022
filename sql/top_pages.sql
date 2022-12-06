SELECT pc.relname, pc.relpages
FROM pg_class pc
inner join pg_namespace pn on pc.relnamespace = pn.oid
WHERE pn.nspname = 'public'
ORDER BY relpages DESC
limit 15;

-- +-------------------------------------+--------+
-- |relname                              |relpages|
-- +-------------------------------------+--------+
-- |movie_attribute_value                |44118   |
-- |session                              |29397   |
-- |movie_attribute_value_pk             |16454   |
-- |session_start_time_hall_id_index     |15383   |
-- |hall                                 |12739   |
-- |session_pk                           |10964   |
-- |movie                                |10811   |
-- |hall_number_of_seats_name_index      |7703    |
-- |movie_name_index                     |7703    |
-- |hall_pk                              |5486    |
-- |movie_pk                             |5486    |
-- |movie_attribute_value_value_int_index|5078    |
-- |movie_unreal_index                   |1695    |
-- |movie_attribute_name_index           |2       |
-- |movie_attribute_name_uindex          |2       |
-- +-------------------------------------+--------+
