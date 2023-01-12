-- Самые популярные индексы
SELECT indexrelname, idx_tup_fetch FROM pg_stat_user_indexes
    ORDER BY idx_tup_fetch DESC
    LIMIT 5;

-- +------------------+-------------+
-- |indexrelname      |idx_tup_fetch|
-- +------------------+-------------+
-- |halls_pkey        |10010010     |
-- |films_pkey        |10010001     |
-- |sessions_type_pkey|10010000     |
-- |seats_pkey        |10010000     |
-- |sessions_pkey     |10010000     |
-- +------------------+-------------+


-- Самые не популярные индексы
SELECT indexrelname, idx_tup_fetch FROM pg_stat_user_indexes
    ORDER BY idx_tup_fetch ASC
    LIMIT 5;

-- +------------------------+-------------+
-- |indexrelname            |idx_tup_fetch|
-- +------------------------+-------------+
-- |sessions_hall_index     |0            |
-- |films_title_index       |0            |
-- |sessions_type_film_index|0            |
-- |tickets_cost_index      |0            |
-- |tickets_cost            |0            |
-- +------------------------+-------------+