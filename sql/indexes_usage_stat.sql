-- Самые популярные индексы
select indexrelname, idx_tup_fetch
from pg_stat_user_indexes
order by idx_tup_fetch DESC
limit 5;

-- +-----------------------+-------------+
-- |indexrelname           |idx_tup_fetch|
-- +-----------------------+-------------+
-- |movie_pk               |137602246    |
-- |movie_attribute_pk     |122485692    |
-- |hall_pk                |15116710     |
-- |movie_unreal_index     |501          |
-- |movie_attribute_type_pk|132          |
-- +-----------------------+-------------+


-- Самые непопулярные индексы
select indexrelname, idx_tup_fetch
from pg_stat_user_indexes
order by idx_tup_fetch ASC
limit 5;

-- +---------------------------+-------------+
-- |indexrelname               |idx_tup_fetch|
-- +---------------------------+-------------+
-- |session_pk                 |0            |
-- |viewer_pk                  |0            |
-- |movie_attribute_value_pk   |0            |
-- |movie_attribute_name_uindex|0            |
-- |order_pk                   |0            |
-- +---------------------------+-------------+
