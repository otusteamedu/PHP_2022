-- Запрос
analyse hall;
analyse session;
explain select h.name, start_time
from hall h
inner join session s on h.id = s.hall_id
where s.start_time between '2023-01-01 00:00:00' and '2023-01-05 23:59:59';

-- План при 10 000 строк
-- +-----------------------------------------------------------------------------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                                                                                                 |
-- +-----------------------------------------------------------------------------------------------------------------------------------------------------------+
-- |Hash Join  (cost=58.00..149.77 rows=473 width=19)                                                                                                          |
-- |  Hash Cond: (s.hall_id = h.id)                                                                                                                            |
-- |  ->  Seq Scan on session s  (cost=0.00..90.53 rows=473 width=12)                                                                                          |
-- |        Filter: ((start_time >= '2023-01-01 00:00:00'::timestamp without time zone) AND (start_time <= '2023-01-05 23:59:59'::timestamp without time zone))|
-- |  ->  Hash  (cost=33.00..33.00 rows=2000 width=15)                                                                                                         |
-- |        ->  Seq Scan on hall h  (cost=0.00..33.00 rows=2000 width=15)                                                                                      |
-- +-----------------------------------------------------------------------------------------------------------------------------------------------------------+

-- План при 10 000 000 строк
-- +-----------------------------------------------------------------------------------------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                                                                                                             |
-- +-----------------------------------------------------------------------------------------------------------------------------------------------------------------------+
-- |Gather  (cost=59012.09..142579.51 rows=493680 width=19)                                                                                                                |
-- |  Workers Planned: 2                                                                                                                                                   |
-- |  ->  Parallel Hash Join  (cost=58012.09..92211.51 rows=205700 width=19)                                                                                               |
-- |        Hash Cond: (h.id = s.hall_id)                                                                                                                                  |
-- |        ->  Parallel Seq Scan on hall h  (cost=0.00..21072.33 rows=833333 width=15)                                                                                    |
-- |        ->  Parallel Hash  (cost=54435.84..54435.84 rows=205700 width=12)                                                                                              |
-- |              ->  Parallel Seq Scan on session s  (cost=0.00..54435.84 rows=205700 width=12)                                                                           |
-- |                    Filter: ((start_time >= '2023-01-01 00:00:00'::timestamp without time zone) AND (start_time <= '2023-01-05 23:59:59'::timestamp without time zone))|
-- |JIT:                                                                                                                                                                   |
-- |  Functions: 12                                                                                                                                                        |
-- |  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                        |
-- +-----------------------------------------------------------------------------------------------------------------------------------------------------------------------+

-- Оптимизации
create index session_start_time_hall_id_index on session (start_time, hall_id);

-- План при 10 000 000 строк после оптимизаций
-- +---------------------------------------------------------------------------------------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                                                                                                           |
-- +---------------------------------------------------------------------------------------------------------------------------------------------------------------------+
-- |Hash Join  (cost=26342.02..98540.97 rows=499095 width=19)                                                                                                            |
-- |  Hash Cond: (h.id = s.hall_id)                                                                                                                                      |
-- |  ->  Seq Scan on hall h  (cost=0.00..32739.00 rows=2000000 width=15)                                                                                                |
-- |  ->  Hash  (cost=17666.33..17666.33 rows=499095 width=12)                                                                                                           |
-- |        ->  Index Only Scan using session_start_time_hall_id_index on session s  (cost=0.43..17666.33 rows=499095 width=12)                                          |
-- |              Index Cond: ((start_time >= '2023-01-01 00:00:00'::timestamp without time zone) AND (start_time <= '2023-01-05 23:59:59'::timestamp without time zone))|
-- +---------------------------------------------------------------------------------------------------------------------------------------------------------------------+
