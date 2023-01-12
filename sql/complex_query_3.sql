EXPLAIN SELECT sessions.id, sessions.created_at FROM sessions
    INNER JOIN films on sessions.film_id = films.id
    WHERE films.title = 'test';

-- 10 000 строк
-- +-------------------------------------------------------------------+
-- |QUERY PLAN                                                         |
-- +-------------------------------------------------------------------+
-- |Hash Join  (cost=259.01..469.27 rows=1 width=12)                   |
-- |  Hash Cond: (sessions.film_id = films.id)                         |
-- |  ->  Seq Scan on sessions  (cost=0.00..184.00 rows=10000 width=16)|
-- |  ->  Hash  (cost=259.00..259.00 rows=1 width=4)                   |
-- |        ->  Seq Scan on films  (cost=0.00..259.00 rows=1 width=4)  |
-- |              Filter: ((title)::text = 'test'::text)               |
-- +-------------------------------------------------------------------+

-- 10 000 000 строк
-- +---------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                             |
-- +---------------------------------------------------------------------------------------+
-- |Gather  (cost=186602.43..322676.30 rows=1 width=12)                                    |
-- |  Workers Planned: 2                                                                   |
-- |  ->  Parallel Hash Join  (cost=185602.43..321676.20 rows=1 width=12)                  |
-- |        Hash Cond: (sessions.film_id = films.id)                                       |
-- |        ->  Parallel Seq Scan on sessions  (cost=0.00..125125.33 rows=4170833 width=16)|
-- |        ->  Parallel Hash  (cost=185602.42..185602.42 rows=1 width=4)                  |
-- |              ->  Parallel Seq Scan on films  (cost=0.00..185602.42 rows=1 width=4)    |
-- |                    Filter: ((title)::text = 'test'::text)                             |
-- +---------------------------------------------------------------------------------------+

-- Оптимизация
CREATE INDEX films_title_index ON films(title);
CREATE INDEX sessions_film_index ON sessions(film_id);

-- 10 000 000 строк после оптимизации
-- +-----------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                               |
-- +-----------------------------------------------------------------------------------------+
-- |Nested Loop  (cost=1.00..17.04 rows=1 width=12)                                          |
-- |  ->  Index Scan using films_index on films  (cost=0.56..8.58 rows=1 width=4)            |
-- |        Index Cond: ((title)::text = 'test'::text)                                       |
-- |  ->  Index Scan using sessions_film_index on sessions  (cost=0.43..8.45 rows=1 width=16)|
-- |        Index Cond: (film_id = films.id)                                                 |
-- +-----------------------------------------------------------------------------------------+
