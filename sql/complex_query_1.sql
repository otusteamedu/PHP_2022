EXPLAIN SELECT films.title, films.description FROM sessions
    INNER JOIN films on sessions.film_id = films.id
    WHERE session_type_id = 2;

-- 10 000 строк
-- +-----------------------------------------------------------------------+
-- |QUERY PLAN                                                             |
-- +-----------------------------------------------------------------------+
-- |Hash Join  (cost=250.84..555.81 rows=3347 width=66)                    |
-- |  Hash Cond: (films.id = sessions.film_id)                             |
-- |  ->  Seq Scan on films  (cost=0.00..234.00 rows=10000 width=70)       |
-- |  ->  Hash  (cost=209.00..209.00 rows=3347 width=4)                    |
-- |        ->  Seq Scan on sessions  (cost=0.00..209.00 rows=3347 width=4)|
-- |              Filter: (session_type_id = 2)                            |
-- +-----------------------------------------------------------------------+

-- 10 000 000 строк
-- +--------------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                                  |
-- +--------------------------------------------------------------------------------------------+
-- |Gather  (cost=159242.06..790878.91 rows=3318996 width=66)                                   |
-- |  Workers Planned: 2                                                                        |
-- |  ->  Parallel Hash Join  (cost=158242.06..457979.30 rows=1382915 width=66)                 |
-- |        Hash Cond: (films.id = sessions.film_id)                                            |
-- |        ->  Parallel Seq Scan on films  (cost=0.00..175175.44 rows=4170844 width=70)        |
-- |        ->  Parallel Hash  (cost=135552.62..135552.62 rows=1382915 width=4)                 |
-- |              ->  Parallel Seq Scan on sessions  (cost=0.00..135552.62 rows=1382915 width=4)|
-- |                    Filter: (session_type_id = 2)                                           |
-- +--------------------------------------------------------------------------------------------+

-- Оптимизация
CREATE INDEX sessions_type_film_index ON sessions(session_type_id, film_id);

-- 10 000 000 строк после оптимизации
-- +-------------------------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                                             |
-- +-------------------------------------------------------------------------------------------------------+
-- |Merge Join  (cost=11.31..556646.99 rows=3373704 width=66)                                              |
-- |  Merge Cond: (sessions.film_id = films.id)                                                            |
-- |  ->  Index Only Scan using sessions_type_index on sessions  (cost=0.43..96048.26 rows=3373704 width=4)|
-- |        Index Cond: (session_type_id = 2)                                                              |
-- |  ->  Index Scan using films_pkey on films  (cost=0.43..393412.81 rows=10010025 width=70)              |
-- +-------------------------------------------------------------------------------------------------------+
