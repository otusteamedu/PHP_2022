-- Запрос
analyse hall;
analyse session;
analyse movie;
explain select m.name, max(number_of_seats)
from hall
inner join session s on hall.id = s.hall_id
inner join movie m on s.movie_id = m.id
group by m.name;

-- План при 10 000 строк
-- +------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                    |
-- +------------------------------------------------------------------------------+
-- |HashAggregate  (cost=225.75..245.75 rows=2000 width=15)                       |
-- |  Group Key: m.name                                                           |
-- |  ->  Hash Join  (cost=114.00..205.58 rows=4035 width=15)                     |
-- |        Hash Cond: (s.movie_id = m.id)                                        |
-- |        ->  Hash Join  (cost=58.00..138.96 rows=4035 width=8)                 |
-- |              Hash Cond: (s.hall_id = hall.id)                                |
-- |              ->  Seq Scan on session s  (cost=0.00..70.35 rows=4035 width=8) |
-- |              ->  Hash  (cost=33.00..33.00 rows=2000 width=8)                 |
-- |                    ->  Seq Scan on hall  (cost=0.00..33.00 rows=2000 width=8)|
-- |        ->  Hash  (cost=31.00..31.00 rows=2000 width=15)                      |
-- |              ->  Seq Scan on movie m  (cost=0.00..31.00 rows=2000 width=15)  |
-- +------------------------------------------------------------------------------+

-- План при 10 000 000 строк
-- +------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                          |
-- +------------------------------------------------------------------------------------+
-- |HashAggregate  (cost=558048.65..617128.10 rows=2000000 width=15)                    |
-- |  Group Key: m.name                                                                 |
-- |  Planned Partitions: 64                                                            |
-- |  ->  Hash Join  (cost=131129.00..301687.50 rows=4001735 width=15)                  |
-- |        Hash Cond: (s.movie_id = m.id)                                              |
-- |        ->  Hash Join  (cost=65552.00..184575.93 rows=4001735 width=8)              |
-- |              Hash Cond: (s.hall_id = hall.id)                                      |
-- |              ->  Seq Scan on session s  (cost=0.00..69442.35 rows=4001735 width=8) |
-- |              ->  Hash  (cost=32739.00..32739.00 rows=2000000 width=8)              |
-- |                    ->  Seq Scan on hall  (cost=0.00..32739.00 rows=2000000 width=8)|
-- |        ->  Hash  (cost=30811.00..30811.00 rows=2000000 width=15)                   |
-- |              ->  Seq Scan on movie m  (cost=0.00..30811.00 rows=2000000 width=15)  |
-- |JIT:                                                                                |
-- |  Functions: 20                                                                     |
-- |  Options: Inlining true, Optimization true, Expressions true, Deforming true       |
-- +------------------------------------------------------------------------------------+

-- Оптимизации



-- План при 10 000 000 строк после оптимизаций
