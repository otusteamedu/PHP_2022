-- Запрос
analyse movie;
explain select name from movie where name = 'Terminator';

-- План при 10 000 строк
-- +-----------------------------------------------------+
-- |QUERY PLAN                                           |
-- +-----------------------------------------------------+
-- |Seq Scan on movie  (cost=0.00..36.00 rows=1 width=11)|
-- |  Filter: ((name)::text = 'Terminator'::text)        |
-- +-----------------------------------------------------+


-- План при 10 000 000 строк
-- +-----------------------------------------------------------------------+
-- |QUERY PLAN                                                             |
-- +-----------------------------------------------------------------------+
-- |Gather  (cost=1000.00..22227.77 rows=1 width=11)                       |
-- |  Workers Planned: 2                                                   |
-- |  ->  Parallel Seq Scan on movie  (cost=0.00..21227.67 rows=1 width=11)|
-- |        Filter: ((name)::text = 'Terminator'::text)                    |
-- +-----------------------------------------------------------------------+

-- Оптимизации
create index movie_name_index on movie (name);


-- План при 10 000 000 строк после оптимизаций
-- +----------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                        |
-- +----------------------------------------------------------------------------------+
-- |Index Only Scan using movie_name_index on movie  (cost=0.43..4.45 rows=1 width=11)|
-- |  Index Cond: (name = 'Terminator'::text)                                         |
-- +----------------------------------------------------------------------------------+
